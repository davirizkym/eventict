<?php

namespace App\Services;

use App\Models\Registration;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    public function createSnapToken(Registration $registration): ?string
    {
        $serverKey = config('midtrans.server_key');
        if (empty($serverKey)) {
            Log::warning('Midtrans server key is empty.');
            return null;
        }

        $price = (int) ($registration->amount_paid > 0 ? $registration->amount_paid : $registration->event->price);
        if ($price <= 0) {
            return null;
        }

        $orderId = $registration->midtrans_order_id ?: ($registration->registration_code . '-' . time());
        $registration->update(['midtrans_order_id' => $orderId]);

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $price,
            ],
            'customer_details' => [
                'first_name' => $registration->user->name,
                'email' => $registration->user->email,
                'phone' => $registration->user->phone ?? '',
            ],
            'item_details' => [
                [
                    'id' => 'EVT-' . $registration->event->id,
                    'price' => $price,
                    'quantity' => 1,
                    'name' => mb_substr($registration->event->title, 0, 50),
                ],
            ],
            'callbacks' => [
                'finish' => route('peserta.dashboard', ['tab' => 'tiket']),
            ],
            'expiry' => [
                'unit' => 'minute',
                'duration' => 10,
            ],
        ];

        try {
            $httpClient = app()->isLocal() ? Http::withoutVerifying() : Http::asJson();
            $response = $httpClient->withBasicAuth($serverKey, '')
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post(config('midtrans.api_url'), $payload);

            if ($response->successful()) {
                $token = $response->json('token');
                if (!empty($token)) {
                    $registration->update(['snap_token' => $token]);
                    return $token;
                }
            }

            Log::error('Midtrans Snap Error: ' . $response->body());
            return null;
        } catch (\Throwable $e) {
            Log::error('Midtrans Exception: ' . $e->getMessage());
            return null;
        }
    }

    public function createSnapTokenForEvent(\App\Models\Event $event, \App\Models\User $user, string $orderId): ?string
    {
        $serverKey = config('midtrans.server_key');
        if (empty($serverKey)) {
            Log::warning('Midtrans server key is empty.');
            return null;
        }

        $price = (int) $event->price;
        if ($price <= 0) {
            return null;
        }

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '',
            ],
            'item_details' => [
                [
                    'id' => 'EVT-' . $event->id,
                    'price' => $price,
                    'quantity' => 1,
                    'name' => mb_substr($event->title, 0, 50),
                ],
            ],
            'callbacks' => [
                'finish' => route('peserta.dashboard', ['tab' => 'tiket']),
            ],
            'expiry' => [
                'unit' => 'minute',
                'duration' => 10,
            ],
        ];

        try {
            $httpClient = app()->isLocal() ? Http::withoutVerifying() : Http::asJson();
            $response = $httpClient->withBasicAuth($serverKey, '')
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post(config('midtrans.api_url'), $payload);

            if ($response->successful()) {
                return $response->json('token');
            }

            Log::error('Midtrans Snap Error: ' . $response->body());
            return null;
        } catch (\Throwable $e) {
            Log::error('Midtrans Exception: ' . $e->getMessage());
            return null;
        }
    }

    public function verifySignature(string $orderId, string $statusCode, string $grossAmount, string $signatureKey): bool
    {
        $serverKey = config('midtrans.server_key');
        if (empty($serverKey)) {
            return false;
        }

        $calculated = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        return hash_equals($calculated, $signatureKey);
    }

    public function handleNotification(array $payload): bool
    {
        $orderId = $payload['order_id'] ?? '';
        $statusCode = $payload['status_code'] ?? '';
        $grossAmount = $payload['gross_amount'] ?? '';
        $signatureKey = $payload['signature_key'] ?? '';

        if (!$this->verifySignature($orderId, $statusCode, $grossAmount, $signatureKey)) {
            Log::warning('Midtrans Notification: Signature verification failed for order ' . $orderId);
            return false;
        }

        $cleanCode = preg_replace('/-\d+$/', '', $orderId);
        $registration = Registration::where('registration_code', $cleanCode)
            ->orWhere('registration_code', $orderId)
            ->first();

        if (!$registration) {
            Log::warning('Midtrans Notification: Registration not found for order ' . $orderId);
            return false;
        }

        $transactionStatus = $payload['transaction_status'] ?? '';
        $fraudStatus = $payload['fraud_status'] ?? '';
        $paymentType = $payload['payment_type'] ?? null;

        if ($transactionStatus === 'capture') {
            if ($fraudStatus === 'accept') {
                $registration->update([
                    'payment_status' => 'paid',
                    'paid_at' => now(),
                    'payment_method' => $paymentType,
                    'amount_paid' => (int) $grossAmount,
                ]);
                try {
                    $registration->user->notify(new \App\Notifications\TicketIssuedNotification($registration));
                } catch (\Throwable $e) {
                    Log::warning('Ticket notification error: ' . $e->getMessage());
                }
            }
        } elseif ($transactionStatus === 'settlement') {
            $registration->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
                'payment_method' => $paymentType,
                'amount_paid' => (int) $grossAmount,
            ]);
            try {
                $registration->user->notify(new \App\Notifications\TicketIssuedNotification($registration));
            } catch (\Throwable $e) {
                Log::warning('Ticket notification error: ' . $e->getMessage());
            }
        } elseif (in_array($transactionStatus, ['pending'])) {
            $registration->update([
                'payment_status' => 'pending',
                'payment_method' => $paymentType,
            ]);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $registration->update([
                'payment_status' => 'pending',
            ]);
        }

        return true;
    }

    public function checkStatus(Registration $registration): bool
    {
        $serverKey = config('midtrans.server_key');
        if (empty($serverKey)) {
            return false;
        }

        $orderCandidates = array_values(array_unique(array_filter([
            $registration->midtrans_order_id,
            $registration->registration_code,
        ])));

        $httpClient = app()->isLocal() ? Http::withoutVerifying() : Http::asJson();
        $isProd = config('midtrans.is_production', true);

        foreach ($orderCandidates as $candidate) {
            $apiUrl = $isProd
                ? "https://api.midtrans.com/v2/{$candidate}/status"
                : "https://api.sandbox.midtrans.com/v2/{$candidate}/status";

            try {
                $response = $httpClient->withBasicAuth($serverKey, '')->get($apiUrl);
                if ($response->successful()) {
                    $data = $response->json();
                    $statusCode = (string) ($data['status_code'] ?? '');
                    if ($statusCode === '404') {
                        continue;
                    }

                    $transactionStatus = $data['transaction_status'] ?? '';
                    $fraudStatus = $data['fraud_status'] ?? '';
                    $paymentType = $data['payment_type'] ?? null;
                    $grossAmount = (int) ($data['gross_amount'] ?? 0);

                    if ($transactionStatus === 'settlement' || ($transactionStatus === 'capture' && $fraudStatus === 'accept')) {
                        $registration->update([
                            'payment_status' => 'paid',
                            'paid_at' => now(),
                            'payment_method' => $paymentType,
                            'amount_paid' => $grossAmount > 0 ? $grossAmount : $registration->amount_paid,
                            'midtrans_order_id' => $candidate,
                        ]);
                        try {
                            $registration->user->notify(new \App\Notifications\TicketIssuedNotification($registration));
                        } catch (\Throwable $e) {
                            Log::warning('Ticket notification error: ' . $e->getMessage());
                        }
                        return true;
                    }
                }
            } catch (\Throwable $e) {
                Log::error('Midtrans checkStatus exception: ' . $e->getMessage());
            }
        }

        return false;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function showInvoice(Request $request, string $registrationCode, MidtransService $midtrans)
    {
        $registration = Registration::with(['event', 'user'])
            ->where('registration_code', $registrationCode)
            ->orWhere('id', $registrationCode)
            ->firstOrFail();

        if (Auth::id() !== $registration->user_id && Auth::user()->role !== 'penyelenggara') {
            abort(403);
        }

        $expiresAt = $registration->created_at ? $registration->created_at->copy()->addHours(24) : now()->addHours(24);

        if ($registration->payment_status === 'pending' && empty($registration->snap_token)) {
            try {
                $token = $midtrans->createSnapToken($registration);
                if ($token) {
                    $registration->update(['snap_token' => $token]);
                }
            } catch (\Throwable $e) {
                Log::error('Invoice Snap Token Error: ' . $e->getMessage());
            }
        }

        return view('payment.invoice', compact('registration', 'expiresAt'));
    }

    public function getSnapToken(Request $request, Registration $registration, MidtransService $midtrans)
    {
        if (Auth::id() !== $registration->user_id && Auth::user()->role !== 'penyelenggara') {
            abort(403);
        }

        if (in_array($registration->payment_status, ['paid', 'free'])) {
            return response()->json([
                'status' => 'already_paid',
                'message' => 'Tiket sudah lunas atau gratis.',
            ]);
        }

        $token = $registration->snap_token;
        if (empty($token)) {
            $token = $midtrans->createSnapToken($registration);
        }

        if (empty($token)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat sesi pembayaran. Silakan coba sesaat lagi.',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'snap_token' => $token,
        ]);
    }

    public function handleNotification(Request $request, MidtransService $midtrans)
    {
        $payload = $request->all();
        $handled = $midtrans->handleNotification($payload);

        if ($handled) {
            return response()->json(['status' => 'success'], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid notification signature or payload'], 400);
    }

    public function checkStatus(Request $request, Registration $registration, MidtransService $midtrans)
    {
        if (Auth::id() !== $registration->user_id && Auth::user()->role !== 'penyelenggara') {
            abort(403);
        }

        if ($request->filled('order_id')) {
            $registration->update(['midtrans_order_id' => $request->input('order_id')]);
        }

        if (in_array($registration->payment_status, ['paid', 'free'])) {
            return response()->json([
                'status' => 'paid',
                'message' => 'Tiket sudah lunas atau gratis.',
            ]);
        }

        $paid = $midtrans->checkStatus($registration);

        if ($paid) {
            return response()->json([
                'status' => 'paid',
                'message' => 'Pembayaran berhasil dikonfirmasi! E-Tiket Anda telah aktif.',
            ]);
        }

        return response()->json([
            'status' => 'pending',
            'message' => 'Status pembayaran belum terkonfirmasi atau masih menunggu pembayaran.',
        ]);
    }
}

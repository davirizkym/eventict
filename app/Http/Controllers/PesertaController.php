<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PesertaController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab', 'dashboard');

        $registrations = Registration::with(['event.speakers'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $today = Carbon::today()->toDateString();

        $todayRegistration = $registrations->first(function ($reg) use ($today) {
            return $reg->event && $reg->event->start_date && $reg->event->start_date->toDateString() === $today;
        }) ?? $registrations->first();

        $certificates = Certificate::with('event')
            ->where('user_id', $user->id)
            ->whereHas('registration', function ($rq) {
                $rq->where('attendance_status', 'attended');
            })
            ->latest('issued_at')
            ->get();

        $registeredEventIds = $registrations->pluck('event_id')->toArray();

        $eventsQuery = Event::with('speakers')
            ->withCount(['registrations' => function ($q) {
                $q->where(function ($sub) {
                    $sub->whereIn('payment_status', ['paid', 'free'])
                        ->orWhere(function ($pq) {
                            $pq->where('payment_status', 'pending')
                               ->where('created_at', '>=', now()->subMinutes(10));
                        });
                });
            }])
            ->where('status', '!=', 'draft')
            ->whereNotIn('id', $registeredEventIds);

        if ($request->filled('q')) {
            $keyword = trim($request->query('q'));
            $eventsQuery->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('category', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('category')) {
            $eventsQuery->where('category', $request->query('category'));
        }

        $allAvailable = $eventsQuery->get();

        $availableEvents = $allAvailable->sortBy(function ($event) {
            $isPassed = $event->isPassed();
            $dateTimestamp = $event->start_date ? $event->start_date->timestamp : 0;
            return [
                $isPassed ? 1 : 0,
                $isPassed ? -$dateTimestamp : $dateTimestamp,
            ];
        })->values();

        return view('peserta.index', compact('user', 'registrations', 'todayRegistration', 'certificates', 'availableEvents', 'tab'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:25',
            'institution' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'nik.max' => 'NIM / NIP / NIS maksimal 20 karakter.',
            'password.min' => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $updates = [
            'name' => trim($validated['name']),
            'nik' => !empty($validated['nik']) ? trim($validated['nik']) : null,
            'phone' => !empty($validated['phone']) ? trim($validated['phone']) : null,
            'institution' => !empty($validated['institution']) ? trim($validated['institution']) : null,
        ];

        if (!empty($validated['password'])) {
            $updates['password'] = $validated['password'];
        }

        $user->update($updates);

        return redirect()->route('peserta.dashboard', ['tab' => 'profil'])
            ->with('success', 'Profil Anda berhasil diperbarui.');
    }

    public function cancelRegistration(Registration $registration)
    {
        $user = Auth::user();

        if ($registration->user_id !== $user->id) {
            abort(403);
        }

        $canCancel = $registration->payment_status === 'pending' || (
            $registration->payment_status === 'free' &&
            !$registration->is_checked_in &&
            $registration->attendance_status !== 'attended' &&
            (!$registration->event->start_date || $registration->event->start_date->toDateString() >= now()->toDateString())
        );

        if (!$canCancel) {
            return back()->with('error', 'Pendaftaran tidak dapat dibatalkan.');
        }

        $eventTitle = $registration->event->title ?? 'kegiatan';
        $registration->delete();

        return redirect()->route('peserta.dashboard', ['tab' => 'tiket'])
            ->with('success', "Pendaftaran untuk {$eventTitle} berhasil dibatalkan.");
    }

    public function scanPresence(Request $request)
    {
        $request->validate([
            'qr_data' => ['required', 'string', 'max:1000'],
        ]);

        $user = Auth::user();
        $qrData = trim($request->input('qr_data'));

        $event = null;

        if (preg_match('#/kegiatan/([^/?\#]+)(?:/presensi)?#i', $qrData, $matches)) {
            $slug = $matches[1];
            $event = Event::where('slug', $slug)->first();
        }

        if (!$event) {
            $event = Event::where('slug', $qrData)->first();
        }

        if (!$event) {
            $event = Event::where('presence_token', $qrData)->first();
        }

        if (!$event) {
            return response()->json([
                'status' => 'error',
                'message' => 'QR Code tidak dikenali sebagai QR Presensi kegiatan Eventict yang valid.',
            ], 404);
        }

        if (!$event->is_presence_open) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gerbang presensi mandiri untuk "' . $event->title . '" saat ini sedang ditutup oleh panitia.',
            ], 422);
        }

        $scannedToken = null;
        if (preg_match('/[?&]token=([^&#]+)/', $qrData, $tokenMatches)) {
            $scannedToken = $tokenMatches[1];
        }

        if (!empty($event->presence_token) && !empty($scannedToken) && $scannedToken !== $event->presence_token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token QR Presensi sudah kedaluwarsa atau tidak valid.',
            ], 422);
        }

        $registration = Registration::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->first();

        if (!$registration) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda belum terdaftar dalam kegiatan "' . $event->title . '". Silakan mendaftar terlebih dahulu.',
            ], 422);
        }

        if ($registration->payment_status === 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => 'Tiket Anda untuk kegiatan "' . $event->title . '" belum aktif karena pembayaran belum diselesaikan.',
            ], 422);
        }

        if ($event->format === 'offline' && !$registration->is_checked_in) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda belum melakukan registrasi ulang (check-in) di lokasi kegiatan. Silakan tunjukkan QR Pass Anda ke panitia di meja registrasi terlebih dahulu.',
            ], 422);
        }

        if ($registration->attendance_status === 'attended') {
            $time = $registration->attended_at ? $registration->attended_at->format('H:i') . ' WIB' : ($registration->checked_in_at ? $registration->checked_in_at->format('H:i') . ' WIB' : 'hari ini');
            return response()->json([
                'status' => 'already_attended',
                'message' => 'Presensi Anda pada "' . $event->title . '" sudah terkonfirmasi sebelumnya pada pukul ' . $time . '.',
                'event_title' => $event->title,
                'attended_at' => $time,
            ], 200);
        }

        $gateMethod = match ($event->format) {
            'online' => 'Presensi Mandiri Online',
            default => 'Scan QR Sesi Aula',
        };

        $now = now();
        $registration->update([
            'attendance_status' => 'attended',
            'attended_at' => $now,
            'attendance_gate' => $gateMethod,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Presensi berhasil! Kehadiran Anda pada sesi "' . $event->title . '" telah diverifikasi dan status Anda kini Hadir.',
            'event_title' => $event->title,
            'attended_at' => $now->format('H:i') . ' WIB',
            'registration_code' => $registration->registration_code,
        ], 200);
    }
}

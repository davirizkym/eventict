<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Registration;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('speakers')
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
            ->where('status', '!=', 'completed');

        if ($request->filled('q')) {
            $keyword = $request->query('q');
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhereHas('speakers', function ($sq) use ($keyword) {
                        $sq->where('name', 'like', "%{$keyword}%")
                            ->orWhere('institution', 'like', "%{$keyword}%");
                    });
            });
        }

        if ($request->filled('format')) {
            $query->where('format', $request->query('format'));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        $events = $query->orderBy('start_date', 'asc')->get()->reject(fn($e) => $e->isPassed())->values();

        $allCategories = Category::orderBy('name', 'asc')->pluck('name');
        if ($allCategories->isEmpty()) {
            $allCategories = Event::where('status', '!=', 'draft')
                ->whereNotNull('category')
                ->where('category', '!=', '')
                ->distinct()
                ->pluck('category');
        }

        $categories = Category::withCount(['events' => function ($q) {
            $q->where('status', '!=', 'draft');
        }])
        ->orderBy('events_count', 'desc')
        ->orderBy('name', 'asc')
        ->get();

        return view('landing', compact('events', 'categories', 'allCategories'));
    }

    public function catalog(Request $request)
    {
        $query = Event::with('speakers')
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
            ->where('status', '!=', 'completed');

        if ($request->filled('q')) {
            $keyword = $request->query('q');
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhereHas('speakers', function ($sq) use ($keyword) {
                        $sq->where('name', 'like', "%{$keyword}%")
                            ->orWhere('institution', 'like', "%{$keyword}%");
                    });
            });
        }

        if ($request->filled('format')) {
            $query->where('format', $request->query('format'));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        $events = $query->orderBy('start_date', 'asc')->get()->reject(fn($e) => $e->isPassed())->values();

        $allCategories = Category::orderBy('name', 'asc')->pluck('name');
        if ($allCategories->isEmpty()) {
            $allCategories = Event::where('status', '!=', 'draft')
                ->whereNotNull('category')
                ->where('category', '!=', '')
                ->distinct()
                ->pluck('category');
        }

        return view('events.catalog', compact('events', 'allCategories'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function show(string $slug)
    {
        $event = Event::with(['speakers', 'mediaPartners'])->where('slug', $slug)->firstOrFail();

        $isRegistered = false;
        $userRegistration = null;

        if (Auth::check() && Auth::user()->role === 'peserta') {
            $userRegistration = Registration::where('user_id', Auth::id())
                ->where('event_id', $event->id)
                ->first();
            $isRegistered = $userRegistration !== null;
        }

        $isPassed = $event->isPassed();

        $registeredCount = $event->registrations()
            ->where(function ($q) {
                $q->whereIn('payment_status', ['paid', 'free'])
                  ->orWhere(function ($pq) {
                      $pq->where('payment_status', 'pending')
                         ->where('created_at', '>=', now()->subMinutes(10));
                  });
            })
            ->count();
        $isFull = $registeredCount >= $event->quota;

        return view('events.show', compact('event', 'isRegistered', 'userRegistration', 'registeredCount', 'isFull', 'isPassed'));
    }

    public function showRegistrationForm(string $slug)
    {
        $event = Event::with('speakers')->where('slug', $slug)->where('status', '!=', 'draft')->firstOrFail();

        if ($event->isExternal() && !empty($event->registration_url)) {
            return redirect()->away($event->registration_url);
        }

        $user = Auth::user();

        if ($event->isPassed()) {
            return redirect()->route('events.show', $slug)->with('error', 'Pendaftaran untuk kegiatan ini telah ditutup karena kegiatan telah selesai.');
        }

        $existing = Registration::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->first();

        if ($existing) {
            if ($existing->payment_status === 'pending' && $existing->created_at && $existing->created_at->lt(now()->subMinutes(10))) {
                $existing->delete();
            } else {
                return redirect()->route('peserta.dashboard')->with('info', 'Anda sudah terdaftar pada kegiatan ini.');
            }
        }

        $registeredCount = $event->registrations()
            ->where(function ($q) {
                $q->whereIn('payment_status', ['paid', 'free'])
                  ->orWhere(function ($pq) {
                      $pq->where('payment_status', 'pending')
                         ->where('created_at', '>=', now()->subMinutes(10));
                  });
            })
            ->count();
        if ($registeredCount >= $event->quota) {
            return redirect()->route('events.show', $slug)->with('error', 'Mohon maaf, kuota peserta untuk kegiatan ini telah penuh.');
        }

        return view('events.register', compact('event', 'user', 'registeredCount'));
    }

    public function registerEvent(Request $request, string $slug)
    {
        $event = Event::where('slug', $slug)->where('status', '!=', 'draft')->firstOrFail();

        if ($event->isExternal() && !empty($event->registration_url)) {
            return redirect()->away($event->registration_url);
        }

        $user = Auth::user();

        if ($event->isPassed()) {
            return redirect()->route('events.show', $slug)->with('error', 'Pendaftaran untuk kegiatan ini telah ditutup karena kegiatan telah selesai.');
        }

        $existing = Registration::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->first();

        if ($existing) {
            if ($existing->payment_status === 'pending' && $existing->created_at && $existing->created_at->lt(now()->subMinutes(10))) {
                $existing->delete();
            } else {
                return redirect()->route('peserta.dashboard')->with('info', 'Anda sudah terdaftar pada kegiatan ini.');
            }
        }

        $activeRegistrationsCount = $event->registrations()
            ->where(function ($q) {
                $q->whereIn('payment_status', ['paid', 'free'])
                  ->orWhere(function ($pq) {
                      $pq->where('payment_status', 'pending')
                         ->where('created_at', '>=', now()->subMinutes(10));
                  });
            })
            ->count();

        if ($activeRegistrationsCount >= $event->quota) {
            return redirect()->route('events.show', $slug)->with('error', 'Mohon maaf, kuota peserta untuk kegiatan ini telah penuh.');
        }

        $request->validate([
            'nik' => ['nullable', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:25'],
            'institution' => ['nullable', 'string', 'max:255'],
            'attendance_mode' => ['nullable', 'string', 'in:offline,online'],
            'payment_method' => ['nullable', 'string', 'max:50'],
            'agree_terms' => ['required', 'accepted'],
        ], [
            'agree_terms.accepted' => 'Anda wajib menyetujui syarat & ketentuan kehadiran kegiatan.',
            'nik.max' => 'NIM / NIP / NIS maksimal 20 karakter.',
        ]);

        $userUpdates = [];
        if ($request->filled('nik') && empty($user->nik)) {
            $userUpdates['nik'] = $request->nik;
        }
        if ($request->filled('phone') && empty($user->phone)) {
            $userUpdates['phone'] = $request->phone;
        }
        if ($request->filled('institution') && empty($user->institution)) {
            $userUpdates['institution'] = $request->institution;
        }
        if (!empty($userUpdates)) {
            $user->update($userUpdates);
        }

        $latestId = (Registration::max('id') ?? 0) + 1;
        do {
            $regCode = 'REG-' . date('Y') . '-' . str_pad($latestId, 4, '0', STR_PAD_LEFT);
            $latestId++;
        } while (Registration::where('registration_code', $regCode)->exists());

        $qrPass = null;
        if ($event->format === 'offline') {
            do {
                $cleanName = strtoupper(preg_replace('/[^A-Z]/', '', $user->name));
                $cleanName = substr($cleanName, 0, 8) ?: 'USER';
                $qrPass = 'PASS-' . rand(1000, 9999) . '-' . $cleanName;
            } while (Registration::where('qr_pass', $qrPass)->exists());
        }

        $isFree = ((int) $event->price) === 0;
        $orderId = !$isFree ? ($regCode . '-' . time()) : null;

        $registration = Registration::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'registration_code' => $regCode,
            'qr_pass' => $qrPass,
            'payment_status' => $isFree ? 'free' : 'pending',
            'midtrans_order_id' => $orderId,
            'amount_paid' => $isFree ? 0 : (int) $event->price,
            'paid_at' => $isFree ? now() : null,
            'payment_method' => null,
            'snap_token' => null,
            'attendance_status' => 'unattended',
            'evaluation_status' => 'pending',
        ]);

        if (!$isFree) {
            try {
                $snapToken = app(MidtransService::class)->createSnapToken($registration);
                if ($snapToken) {
                    $registration->update(['snap_token' => $snapToken]);
                }
            } catch (\Throwable $e) {
                Log::error('Snap token error: ' . $e->getMessage());
            }

            return redirect()->route('payment.invoice', $registration->registration_code)
                ->with('success', 'Pendaftaran berhasil disimpan! Silakan selesaikan pembayaran tiket Anda.');
        }

        return redirect()->route('peserta.dashboard', ['tab' => 'tiket'])
            ->with('success', 'Pendaftaran berhasil! E-Tiket Anda (' . $regCode . ') telah terbit.');
    }

    public function presence(Request $request, string $slug)
    {
        $event = Event::with(['speakers', 'mediaPartners'])->where('slug', $slug)->firstOrFail();

        $registration = null;
        if (Auth::check()) {
            $registration = Registration::where('user_id', Auth::id())
                ->where('event_id', $event->id)
                ->first();
        }

        return view('events.presence', compact('event', 'registration'));
    }

    public function presenceSubmit(Request $request, string $slug)
    {
        if (!Auth::check()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['status' => 'unauthenticated', 'message' => 'Silakan masuk terlebih dahulu untuk melakukan presensi.'], 401);
            }
            return redirect()->route('login')->with('warning', 'Silakan masuk terlebih dahulu untuk melakukan presensi.');
        }

        $event = Event::where('slug', $slug)->firstOrFail();

        if (!$event->is_presence_open) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Gerbang presensi mandiri saat ini sedang ditutup oleh panitia.'], 422);
            }
            return back()->with('error', 'Gerbang presensi mandiri saat ini sedang ditutup oleh panitia.');
        }

        $registration = Registration::where('user_id', Auth::id())
            ->where('event_id', $event->id)
            ->first();

        if (!$registration) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Anda belum terdaftar dalam kegiatan ini. Silakan mendaftar terlebih dahulu.'], 422);
            }
            return back()->with('error', 'Anda belum terdaftar dalam kegiatan ini. Silakan mendaftar terlebih dahulu.');
        }

        if ($registration->payment_status === 'pending') {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Tiket Anda belum aktif karena pembayaran belum diselesaikan. Silakan selesaikan pembayaran terlebih dahulu.'], 422);
            }
            return back()->with('error', 'Tiket Anda belum aktif karena pembayaran belum diselesaikan. Silakan selesaikan pembayaran terlebih dahulu.');
        }

        if ($event->format === 'offline' && !$registration->is_checked_in) {
            $msg = 'Anda belum melakukan registrasi ulang (check-in) di lokasi kegiatan. Silakan tunjukkan QR Pass Anda ke panitia di meja registrasi terlebih dahulu.';
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['status' => 'error', 'message' => $msg], 422);
            }
            return back()->with('error', $msg);
        }

        $submittedToken = $request->query('token') ?: $request->input('token');
        if (!empty($event->presence_token) && !empty($submittedToken) && $submittedToken !== $event->presence_token) {
            $msg = 'Token QR Presensi sudah kedaluwarsa atau tidak valid.';
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['status' => 'error', 'message' => $msg], 422);
            }
            return back()->with('error', $msg);
        }

        if ($registration->attendance_status === 'attended') {
            $msg = 'Presensi Anda sudah terkonfirmasi sebelumnya pada ' . ($registration->attended_at ? $registration->attended_at->format('H:i') . ' WIB' : 'hari ini') . '.';
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status' => 'already_attended',
                    'message' => $msg,
                    'event_title' => $event->title,
                    'attended_at' => $registration->attended_at ? $registration->attended_at->format('H:i') . ' WIB' : null,
                ], 200);
            }
            return back()->with('info', $msg);
        }

        $gateMethod = match ($event->format) {
            'online' => 'Presensi Mandiri Online',
            default => 'Presensi Mandiri Sesi',
        };

        $now = now();
        $registration->update([
            'attendance_status' => 'attended',
            'attended_at' => $now,
            'attendance_gate' => $gateMethod,
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Presensi kehadiran Anda berhasil dikonfirmasi! Terima kasih atas partisipasi Anda.',
                'event_title' => $event->title,
                'attended_at' => $now->format('H:i') . ' WIB',
            ], 200);
        }

        return redirect()->route('events.presence', $event->slug)
            ->with('success', 'Presensi kehadiran Anda berhasil dikonfirmasi! Terima kasih atas partisipasi Anda.');
    }
}

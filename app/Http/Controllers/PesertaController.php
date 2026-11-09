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
            ->latest('issued_at')
            ->get();

        $registeredEventIds = $registrations->pluck('event_id')->toArray();

        $eventsQuery = Event::with('speakers')
            ->withCount('registrations')
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

        $availableEvents = $allAvailable->sortBy(function ($event) use ($today) {
            $isPassed = $event->status === 'completed' || ($event->end_date ? $event->end_date->toDateString() < $today : ($event->start_date ? $event->start_date->toDateString() < $today : false));
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
            'nik.max' => 'NIM / NIP maksimal 20 karakter.',
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

        if ($registration->payment_status !== 'pending') {
            return back()->with('error', 'Hanya pendaftaran yang berstatus belum dibayar yang dapat dibatalkan.');
        }

        $eventTitle = $registration->event->title ?? 'kegiatan';
        $registration->delete();

        return redirect()->route('peserta.dashboard', ['tab' => 'tiket'])
            ->with('success', "Pendaftaran untuk {$eventTitle} berhasil dibatalkan.");
    }
}

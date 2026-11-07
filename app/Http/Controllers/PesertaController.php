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
        $availableEvents = Event::with('speakers')
            ->withCount('registrations')
            ->where('status', '!=', 'draft')
            ->whereNotIn('id', $registeredEventIds)
            ->orderBy('start_date', 'asc')
            ->get();

        return view('peserta.index', compact('user', 'registrations', 'todayRegistration', 'certificates', 'availableEvents', 'tab'));
    }
}

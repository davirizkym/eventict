@extends('layouts.app')

@section('title', $event->title . ' — Ruang Kerja Penyelenggara Eventict')

@section('content')
<div class="min-h-screen bg-slate-50 text-slate-800 antialiased font-['Poppins'] flex flex-col">
  <header class="bg-blue-950 text-white border-b border-blue-900 sticky top-0 z-40 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-4">
      <div class="flex items-center gap-3 sm:gap-4 min-w-0">
        <a href="{{ route('organizer.dashboard') }}" class="px-2.5 py-1.5 rounded-lg border border-white/20 text-xs font-semibold text-slate-200 hover:bg-white/10 hover:text-white transition flex items-center gap-1.5 shrink-0" title="Kembali ke Semua Kegiatan">
          <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="15 18 9 12 15 6"/>
          </svg>
          <span class="hidden sm:inline">Semua Kegiatan</span>
        </a>

        <div class="h-6 w-px bg-white/20 hidden sm:block shrink-0"></div>

        <div class="flex items-center gap-2 min-w-0">
          <span class="text-xs text-blue-200 hidden lg:inline shrink-0">Ruang Kerja:</span>
          <select onchange="window.location.href='/penyelenggara/event/' + this.value + '?tab={{ $tab }}'" class="bg-blue-900 border border-blue-800 rounded-lg px-2.5 py-1.5 text-xs font-semibold text-white outline-none cursor-pointer max-w-[220px] sm:max-w-[340px] truncate">
            <option value="{{ $event->id }}" selected>{{ $event->title }}</option>
            @if($otherActiveEvents->isNotEmpty())
              <optgroup label="Pindah ke Acara Lain">
                @foreach($otherActiveEvents as $oe)
                  <option value="{{ $oe->id }}">{{ $oe->title }}</option>
                @endforeach
              </optgroup>
            @endif
          </select>

          @php
            $isPast = \Carbon\Carbon::parse($event->end_date)->isPast();
          @endphp
          @if($isPast)
            <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-white/10 text-slate-300 border border-white/15 shrink-0 hidden md:inline">
              Selesai
            </span>
          @else
            <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 shrink-0 hidden md:inline">
              Aktif
            </span>
          @endif
        </div>
      </div>

      <div class="flex items-center gap-3 shrink-0">
        <a href="{{ route('events.show', $event->slug) }}" target="_blank" class="px-3 py-1.5 rounded-lg border border-white/20 text-xs font-medium text-slate-200 hover:bg-white/10 hover:text-white transition hidden md:inline-flex items-center gap-1.5">
          <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
            <polyline points="15 3 21 3 21 9"/>
            <line x1="10" y1="14" x2="21" y2="3"/>
          </svg>
          <span>Halaman Publik</span>
        </a>

        <div class="flex items-center gap-2.5 pl-2 sm:border-l sm:border-white/15">
          <div class="size-8 rounded-lg bg-blue-900 text-white font-semibold text-xs flex items-center justify-center shrink-0">
            {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 2)) }}
          </div>
          <form method="POST" action="{{ route('logout') }}" class="shrink-0">
            @csrf
            <button type="submit" title="Keluar" class="p-1.5 text-rose-300 hover:text-white hover:bg-rose-500/20 rounded-lg transition cursor-pointer">
              <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                <polyline points="16 17 21 12 16 7"/>
                <line x1="21" x2="9" y1="12" y2="12"/>
              </svg>
            </button>
          </form>
        </div>
      </div>
    </div>
  </header>

  <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 flex-1 flex flex-col md:flex-row gap-6">
    <aside class="w-full md:w-64 shrink-0 flex flex-col gap-4">
      <div class="bg-white rounded-2xl border border-slate-200 p-4 flex flex-col gap-2 shadow-2xs">
        <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Kegiatan Terpilih</span>
        <h2 class="text-xs sm:text-sm font-bold text-slate-900 leading-snug">{{ $event->title }}</h2>
        <div class="flex items-center gap-1.5 mt-1 flex-wrap">
          <span class="px-2 py-0.5 rounded text-[10px] font-medium uppercase bg-slate-100 text-slate-700">
            {{ $event->category }}
          </span>
          <span class="px-2 py-0.5 rounded text-[10px] font-medium uppercase bg-blue-50 text-blue-900 border border-blue-100">
            {{ $event->format }}
          </span>
        </div>
      </div>

      <nav class="bg-white rounded-2xl border border-slate-200 p-2 flex flex-row md:flex-col gap-1 shadow-2xs overflow-x-auto">
        <a href="{{ route('organizer.workspace', ['event' => $event->id, 'tab' => 'dashboard']) }}" class="px-3 py-2.5 rounded-xl text-xs font-semibold transition flex items-center justify-between shrink-0 {{ $tab === 'dashboard' ? 'bg-blue-950 text-white shadow-2xs' : 'text-slate-600 hover:bg-slate-50' }}">
          <div class="flex items-center gap-2.5">
            <svg class="size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect width="18" height="18" x="3" y="3" rx="2"/>
              <path d="M3 9h18"/>
              <path d="M9 21V9"/>
            </svg>
            <span>Dashboard</span>
          </div>
        </a>

        <a href="{{ route('organizer.workspace', ['event' => $event->id, 'tab' => 'peserta']) }}" class="px-3 py-2.5 rounded-xl text-xs font-semibold transition flex items-center justify-between shrink-0 {{ $tab === 'peserta' ? 'bg-blue-950 text-white shadow-2xs' : 'text-slate-600 hover:bg-slate-50' }}">
          <div class="flex items-center gap-2.5">
            <svg class="size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <span>Data Peserta</span>
          </div>
          <span class="px-2 py-0.5 rounded-md text-[10px] {{ $tab === 'peserta' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $totalRegistrations }}</span>
        </a>

        <a href="{{ route('organizer.workspace', ['event' => $event->id, 'tab' => 'sertifikat']) }}" class="px-3 py-2.5 rounded-xl text-xs font-semibold transition flex items-center justify-between shrink-0 {{ $tab === 'sertifikat' ? 'bg-blue-950 text-white shadow-2xs' : 'text-slate-600 hover:bg-slate-50' }}">
          <div class="flex items-center gap-2.5">
            <svg class="size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="8" r="6"/>
              <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
            </svg>
            <span>E-Sertifikat</span>
          </div>
          <span class="px-2 py-0.5 rounded-md text-[10px] {{ $tab === 'sertifikat' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $certificatesCount }}</span>
        </a>

        <a href="{{ route('organizer.workspace', ['event' => $event->id, 'tab' => 'narasumber']) }}" class="px-3 py-2.5 rounded-xl text-xs font-semibold transition flex items-center justify-between shrink-0 {{ $tab === 'narasumber' ? 'bg-blue-950 text-white shadow-2xs' : 'text-slate-600 hover:bg-slate-50' }}">
          <div class="flex items-center gap-2.5">
            <svg class="size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"/>
              <path d="M19 10v2a7 7 0 0 1-14 0v-2"/>
              <line x1="12" x2="12" y1="19" y2="22"/>
            </svg>
            <span>Pengisi Acara</span>
          </div>
          <span class="px-2 py-0.5 rounded-md text-[10px] {{ $tab === 'narasumber' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $event->speakers->count() }}</span>
        </a>

        <a href="{{ route('organizer.workspace', ['event' => $event->id, 'tab' => 'pengaturan']) }}" class="px-3 py-2.5 rounded-xl text-xs font-semibold transition flex items-center gap-2.5 shrink-0 {{ $tab === 'pengaturan' ? 'bg-blue-950 text-white shadow-2xs' : 'text-slate-600 hover:bg-slate-50' }}">
          <svg class="size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="3"/>
            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1Z"/>
          </svg>
          <span>Pengaturan Acara</span>
        </a>
      </nav>

      <div class="bg-blue-950 text-white rounded-2xl p-4 flex flex-col gap-2 shadow-2xs">
        <div class="flex items-center gap-2">
          <svg class="size-4 text-blue-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
          </svg>
          <span class="text-xs font-semibold">Sekretariat Lab ICT</span>
        </div>
        <p class="text-[11px] text-slate-300 leading-relaxed">
          Laboratorium ICT, Unit 7 Lantai 4, Universitas Budi Luhur.
        </p>
      </div>
    </aside>

    <main class="flex-1 flex flex-col gap-6 min-w-0">
      @if (session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start gap-3 text-xs text-emerald-800">
          <svg class="size-4 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="20 6 9 17 4 12"/>
          </svg>
          <div class="font-medium">{{ session('success') }}</div>
        </div>
      @endif

      @if (session('warning'))
        <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl flex items-start gap-3 text-xs text-amber-800">
          <svg class="size-4 text-amber-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
          </svg>
          <div class="font-medium">{{ session('warning') }}</div>
        </div>
      @endif

      @if (session('error'))
        <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl flex items-start gap-3 text-xs text-rose-800">
          <svg class="size-4 text-rose-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="15" y1="9" x2="9" y2="15"/>
            <line x1="9" y1="9" x2="15" y2="15"/>
          </svg>
          <div class="font-medium">{{ session('error') }}</div>
        </div>
      @endif

      @if($tab === 'dashboard')
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-2xs flex flex-col justify-between">
            <span class="text-xs text-slate-500 font-medium">Total Peserta Terdaftar</span>
            <div class="flex items-baseline justify-between mt-2">
              <span class="text-xl sm:text-2xl font-bold text-slate-900">{{ $totalRegistrations }}</span>
              <span class="text-xs text-slate-500 font-medium">/ {{ $event->quota }} Kuota</span>
            </div>
            <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden mt-3">
              <div class="h-full bg-blue-950 rounded-full" style="width: {{ $event->quota > 0 ? min(100, round(($totalRegistrations / $event->quota) * 100)) : 0 }}%"></div>
            </div>
          </div>

          <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-2xs flex flex-col justify-between">
            <span class="text-xs text-slate-500 font-medium">Kehadiran Hari-H</span>
            <div class="flex items-baseline justify-between mt-2">
              <span class="text-xl sm:text-2xl font-bold text-slate-900">{{ $attendedRegistrations }}</span>
              <span class="text-xs text-emerald-700 font-semibold">{{ $attendancePercentage }}% Hadir</span>
            </div>
            <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden mt-3">
              <div class="h-full bg-emerald-600 rounded-full" style="width: {{ $attendancePercentage }}%"></div>
            </div>
          </div>

          <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-2xs flex flex-col justify-between">
            <span class="text-xs text-slate-500 font-medium">E-Sertifikat Terbit</span>
            <div class="flex items-baseline justify-between mt-2">
              <span class="text-xl sm:text-2xl font-bold text-slate-900">{{ $certificatesCount }}</span>
              <span class="text-xs text-blue-950 font-semibold">{{ $totalRegistrations > 0 ? round(($certificatesCount / $totalRegistrations) * 100) : 0 }}% Terbit</span>
            </div>
            <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden mt-3">
              <div class="h-full bg-blue-900 rounded-full" style="width: {{ $totalRegistrations > 0 ? round(($certificatesCount / $totalRegistrations) * 100) : 0 }}%"></div>
            </div>
          </div>

          <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-2xs flex flex-col justify-between">
            <span class="text-xs text-slate-500 font-medium">Pemasukan Tiket</span>
            <div class="flex items-baseline justify-between mt-2">
              <span class="text-xl sm:text-2xl font-bold text-slate-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
              <span class="text-xs text-slate-500 font-medium">{{ $event->price == 0 ? 'Gratis' : 'Berbayar' }}</span>
            </div>
            <span class="text-[11px] text-slate-400 mt-3">Registrasi lunas</span>
          </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-4 shadow-2xs">
          <h3 class="text-sm font-bold text-slate-900">Informasi Pelaksanaan Kegiatan</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-xs">
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 flex flex-col gap-1">
              <span class="text-slate-400 font-medium">Jadwal Tanggal</span>
              <span class="font-semibold text-slate-900">{{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($event->end_date)->translatedFormat('d M Y') }}</span>
            </div>
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 flex flex-col gap-1">
              <span class="text-slate-400 font-medium">Waktu Sesi</span>
              <span class="font-semibold text-slate-900">{{ substr($event->start_time, 0, 5) }} - {{ substr($event->end_time, 0, 5) }} WIB</span>
            </div>
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 flex flex-col gap-1">
              <span class="text-slate-400 font-medium">Lokasi / Lab</span>
              <span class="font-semibold text-slate-900 truncate">{{ $event->location }}</span>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-4 shadow-2xs">
          <div class="flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">Pengisi Acara Sesi Ini ({{ $event->speakers->count() }})</h3>
            <a href="{{ route('organizer.workspace', ['event' => $event->id, 'tab' => 'narasumber']) }}" class="text-xs font-semibold text-blue-950 hover:underline">Kelola Pengisi Acara →</a>
          </div>
          @if($event->speakers->isEmpty())
            <p class="text-xs text-slate-500">Belum ada pengisi acara yang ditugaskan ke sesi ini.</p>
          @else
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              @foreach($event->speakers as $spk)
                <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-3">
                  <div class="size-10 rounded-lg bg-blue-50 border border-blue-100 text-blue-950 font-bold text-xs flex items-center justify-center shrink-0">
                    {{ strtoupper(substr($spk->name, 0, 2)) }}
                  </div>
                  <div class="flex flex-col min-w-0">
                    <div class="flex items-center gap-1.5">
                      <span class="text-xs font-semibold text-slate-900 truncate">{{ $spk->name }}</span>
                      @php
                        $spkRole = $spk->pivot->role ?? 'Pembicara';
                        $roleBadgeColor = match($spkRole) {
                          'Moderator' => 'bg-amber-100 text-amber-800',
                          'MC' => 'bg-purple-100 text-purple-800',
                          default => 'bg-blue-100 text-blue-900',
                        };
                      @endphp
                      <span class="px-1.5 py-0.5 rounded text-[9px] font-medium {{ $roleBadgeColor }}">
                        {{ $spkRole }}
                      </span>
                    </div>
                    <span class="text-[11px] text-slate-500 truncate">{{ $spk->pivot->topic ?? $spk->institution }}</span>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>

      @elseif($tab === 'peserta')
        <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-2xs flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
          <form action="{{ route('organizer.workspace.quick_checkin', ['event' => $event->id]) }}" method="POST" class="flex-1 flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
            @csrf
            <div class="flex-1 flex items-center gap-2 px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs">
              <svg class="size-4 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 7V5a2 2 0 0 1 2-2h2"/>
                <path d="M17 3h2a2 2 0 0 1 2 2v2"/>
                <path d="M21 17v2a2 2 0 0 1-2 2h-2"/>
                <path d="M7 21H5a2 2 0 0 1-2-2v-2"/>
                <line x1="7" x2="17" y1="12" y2="12"/>
              </svg>
              <input type="text" name="code" placeholder="Scan QR Pass atau ketik No. Registrasi / Email peserta untuk presensi cepat..." required class="w-full bg-transparent border-none outline-none text-xs text-slate-900 placeholder:text-slate-400">
            </div>
            <button type="submit" class="px-5 py-2.5 bg-blue-950 hover:bg-blue-900 text-white text-xs font-semibold rounded-xl transition flex items-center justify-center gap-2 shadow-xs cursor-pointer">
              <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12"/>
              </svg>
              <span>Check-in Hadir</span>
            </button>
          </form>

          <a href="{{ route('organizer.workspace.export', ['event' => $event->id]) }}" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50 transition flex items-center justify-center gap-2 shadow-2xs shrink-0">
            <svg class="size-3.5 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
              <polyline points="7 10 12 15 17 10"/>
              <line x1="12" x2="12" y1="15" y2="3"/>
            </svg>
            <span>Ekspor CSV</span>
          </a>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs flex flex-col">
          <div class="p-4 border-b border-slate-100 flex flex-col lg:flex-row lg:items-center justify-between gap-3">
            <form method="GET" action="{{ route('organizer.workspace', ['event' => $event->id]) }}" class="flex-1 flex flex-col sm:flex-row items-center gap-2.5">
              <input type="hidden" name="tab" value="peserta">
              <div class="relative w-full sm:w-72">
                <svg class="size-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="11" cy="11" r="8"/>
                  <path d="m21 21-4.3-4.3"/>
                </svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, email, no reg..." class="w-full pl-9 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs outline-none focus:border-blue-950">
              </div>

              <select name="attendance" onchange="this.form.submit()" class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium text-slate-700 outline-none cursor-pointer">
                <option value="">Semua Presensi</option>
                <option value="attended" {{ request('attendance') === 'attended' ? 'selected' : '' }}>Hadir</option>
                <option value="unattended" {{ request('attendance') === 'unattended' ? 'selected' : '' }}>Belum Hadir</option>
              </select>

              <select name="certificate" onchange="this.form.submit()" class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium text-slate-700 outline-none cursor-pointer">
                <option value="">Semua Sertifikat</option>
                <option value="has_cert" {{ request('certificate') === 'has_cert' ? 'selected' : '' }}>Sudah Terbit</option>
                <option value="no_cert" {{ request('certificate') === 'no_cert' ? 'selected' : '' }}>Belum Terbit</option>
              </select>

              <button type="submit" class="px-3 py-1.5 bg-slate-900 text-white rounded-lg text-xs font-semibold hover:bg-slate-800 transition">Filter</button>
            </form>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
              <thead>
                <tr class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200">
                  <th class="px-4 py-3">No. Registrasi</th>
                  <th class="px-4 py-3">Nama Peserta</th>
                  <th class="px-4 py-3">Instansi / Kampus</th>
                  <th class="px-4 py-3">Status Presensi</th>
                  <th class="px-4 py-3">Status Tiket</th>
                  <th class="px-4 py-3">Status Sertifikat</th>
                  <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                @forelse($registrations as $reg)
                  <tr class="hover:bg-slate-50/80 transition">
                    <td class="px-4 py-3 font-semibold text-blue-950 whitespace-nowrap">
                      {{ $reg->registration_code }}
                    </td>
                    <td class="px-4 py-3">
                      <div class="flex flex-col">
                        <span class="font-semibold text-slate-900">{{ $reg->user->name ?? '-' }}</span>
                        <span class="text-slate-400 text-[11px]">{{ $reg->user->email ?? '-' }}</span>
                      </div>
                    </td>
                    <td class="px-4 py-3 text-slate-600">
                      {{ $reg->user->institution ?? '-' }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                      @if($reg->attendance_status === 'attended')
                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                          Hadir ({{ $reg->checked_in_at ? $reg->checked_in_at->format('H:i') : '' }})
                        </span>
                      @else
                        <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600">
                          Belum Hadir
                        </span>
                      @endif
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                      <span class="px-2 py-0.5 rounded text-[10px] font-semibold uppercase bg-slate-100 text-slate-700">
                        {{ $reg->payment_status }}
                      </span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                      @if($reg->certificate)
                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-blue-950 border border-blue-200">
                          Terbit
                        </span>
                      @else
                        <span class="text-slate-400 text-[11px]">Belum</span>
                      @endif
                    </td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                      <div class="inline-flex items-center gap-1.5">
                        <form method="POST" action="{{ route('organizer.attendance.toggle', $reg->id) }}">
                          @csrf
                          <button type="submit" class="px-2 py-1 rounded text-[11px] font-semibold {{ $reg->attendance_status === 'attended' ? 'bg-slate-100 text-slate-700 hover:bg-slate-200' : 'bg-emerald-600 text-white hover:bg-emerald-700' }} transition">
                            {{ $reg->attendance_status === 'attended' ? 'Batal Hadir' : 'Tandai Hadir' }}
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="p-8 text-center text-slate-400">Tidak ada peserta yang cocok dengan kriteria pencarian.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

      @elseif($tab === 'sertifikat')
        <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-6 shadow-2xs">
          <div class="flex flex-col gap-1">
            <h3 class="text-sm font-bold text-slate-900">Upload Sertifikat Massal untuk Kegiatan Ini</h3>
            <p class="text-xs text-slate-500 leading-relaxed">
              Pilih satu atau banyak file PDF sertifikat secara bersamaan. Sistem otomatis mencocokkan nama file dengan No. Registrasi atau Email peserta.
            </p>
          </div>

          <form action="{{ route('organizer.workspace.certificate.batch', ['event' => $event->id]) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
            @csrf
            <div class="p-6 border-2 border-dashed border-slate-200 hover:border-blue-950 rounded-2xl bg-slate-50 flex flex-col items-center justify-center gap-2 text-center transition">
              <svg class="size-8 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="8" r="6"/>
                <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
              </svg>
              <label class="text-xs font-semibold text-blue-950 cursor-pointer hover:underline">
                Pilih Berkas PDF Sertifikat
                <input type="file" name="certificate_files[]" multiple required accept=".pdf,image/*" class="hidden">
              </label>
              <span class="text-[11px] text-slate-400">Format PDF, JPG, PNG maksimal 10MB per file</span>
            </div>

            <div class="p-4 bg-blue-50 border border-blue-100 rounded-xl flex flex-col gap-2 text-xs">
              <span class="font-semibold text-blue-950">Aturan Penamaan Berkas Otomatis:</span>
              <ul class="text-slate-600 flex flex-col gap-1 list-disc list-inside">
                <li>Berdasarkan Nomor Registrasi: <code class="bg-white px-1.5 py-0.5 rounded text-blue-950 font-mono">REG-2026-0001.pdf</code></li>
                <li>Berdasarkan Email Peserta: <code class="bg-white px-1.5 py-0.5 rounded text-blue-950 font-mono">peserta@budi-luhur.ac.id.pdf</code></li>
              </ul>
            </div>

            <div class="flex justify-end">
              <button type="submit" class="px-5 py-2.5 bg-blue-950 text-white rounded-xl text-xs font-semibold hover:bg-blue-900 transition shadow-xs cursor-pointer">
                Mulai Unggah & Cocokkan Sertifikat
              </button>
            </div>
          </form>
        </div>

      @elseif($tab === 'narasumber')
        <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-6 shadow-2xs">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex flex-col gap-1">
              <h3 class="text-sm font-bold text-slate-900">Pengisi Acara Sesi Kegiatan</h3>
              <p class="text-xs text-slate-500 leading-relaxed">
                Pilih pengisi acara untuk ditugaskan pada kegiatan ini, lalu tentukan topik materi dan jam sesinya.
              </p>
            </div>

            <button type="button" onclick="openAssignSpeakerModal()" class="px-4 py-2 bg-blue-950 text-white rounded-xl text-xs font-semibold hover:bg-blue-900 transition flex items-center gap-1.5 shadow-2xs cursor-pointer shrink-0">
              <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
              </svg>
              <span>Tambah Pengisi Acara</span>
            </button>
          </div>

          @if($event->speakers->isEmpty())
            <div class="p-8 border border-slate-200 rounded-xl text-center flex flex-col items-center justify-center gap-2">
              <span class="text-xs font-semibold text-slate-800">Belum Ada Pengisi Acara yang Ditugaskan</span>
              <p class="text-[11px] text-slate-400 max-w-sm">Tekan tombol di atas untuk memilih pengisi acara Lab ICT.</p>
            </div>
          @else
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              @foreach($event->speakers as $spk)
                <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl flex flex-col justify-between gap-3">
                  <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                      <div class="size-11 rounded-xl bg-blue-50 border border-blue-100 text-blue-950 font-bold text-xs flex items-center justify-center shrink-0">
                        {{ strtoupper(substr($spk->name, 0, 2)) }}
                      </div>
                      <div class="flex flex-col min-w-0">
                        <div class="flex items-center gap-2">
                          <span class="text-xs font-bold text-slate-900 truncate">{{ $spk->name }}</span>
                          @php
                            $spkRole = $spk->pivot->role ?? 'Pembicara';
                            $roleBadgeColor = match($spkRole) {
                              'Moderator' => 'bg-amber-100 text-amber-800',
                              'MC' => 'bg-purple-100 text-purple-800',
                              default => 'bg-blue-100 text-blue-900',
                            };
                          @endphp
                          <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $roleBadgeColor }}">
                            {{ $spkRole }}
                          </span>
                        </div>
                        <span class="text-[11px] text-slate-500 truncate">{{ $spk->institution }}</span>
                      </div>
                    </div>

                    <form method="POST" action="{{ route('organizer.event.speaker.remove', ['event' => $event->id, 'speaker' => $spk->id]) }}" onsubmit="return confirm('Lepaskan pengisi acara ini dari kegiatan?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="p-1 rounded-md text-rose-500 hover:bg-rose-50 transition cursor-pointer" title="Lepaskan">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <line x1="18" y1="6" x2="6" y2="18"/>
                          <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                      </button>
                    </form>
                  </div>

                  <div class="pt-2.5 border-t border-slate-200/80 flex flex-col gap-1 text-xs">
                    <div class="flex items-center gap-1.5 text-slate-700">
                      <span class="font-semibold text-slate-500 text-[11px]">Topik:</span>
                      <span class="truncate">{{ $spk->pivot->topic ?? 'Sesi Pemaparan' }}</span>
                    </div>
                    <div class="flex items-center gap-1.5 text-slate-500 text-[11px]">
                      <span>Waktu Sesi:</span>
                      <span class="font-medium text-slate-800">{{ $spk->pivot->session_time ?? '09:00 - 12:00 WIB' }}</span>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>

      @elseif($tab === 'pengaturan')
        <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-6 shadow-2xs">
          <div class="flex flex-col gap-1">
            <h3 class="text-sm font-bold text-slate-900">Pengaturan & Informasi Kegiatan</h3>
            <p class="text-xs text-slate-500 leading-relaxed">
              Perbarui judul, kuota, jadwal, dan status publikasi kegiatan ini.
            </p>
          </div>

          <form action="{{ route('organizer.event.update', $event->id) }}" method="POST" class="flex flex-col gap-4 text-xs">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-1.5">
              <label class="font-semibold text-slate-700">Judul Kegiatan</label>
              <input type="text" name="title" value="{{ $event->title }}" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
              <div class="flex flex-col gap-1.5">
                <label class="font-semibold text-slate-700">Kategori</label>
                <input type="text" name="category" value="{{ $event->category }}" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
              </div>
              <div class="flex flex-col gap-1.5">
                <label class="font-semibold text-slate-700">Format Pelaksanaan</label>
                <select name="format" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
                  <option value="offline" {{ $event->format === 'offline' ? 'selected' : '' }}>Offline (Tatap Muka di Lab)</option>
                  <option value="hybrid" {{ $event->format === 'hybrid' ? 'selected' : '' }}>Hybrid (Lab & Online)</option>
                  <option value="online" {{ $event->format === 'online' ? 'selected' : '' }}>Online</option>
                </select>
              </div>
              <div class="flex flex-col gap-1.5">
                <label class="font-semibold text-slate-700">Status Acara</label>
                <select name="status" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
                  <option value="published" {{ $event->status === 'published' ? 'selected' : '' }}>Dipublikasikan (Buka)</option>
                  <option value="draft" {{ $event->status === 'draft' ? 'selected' : '' }}>Draft (Sembunyikan)</option>
                  <option value="completed" {{ $event->status === 'completed' ? 'selected' : '' }}>Selesai Diselenggarakan</option>
                </select>
              </div>
            </div>

            <div class="flex flex-col gap-1.5">
              <label class="font-semibold text-slate-700">Lokasi / Ruang Lab</label>
              <input type="text" name="location" value="{{ $event->location }}" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="flex flex-col gap-1.5">
                <label class="font-semibold text-slate-700">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ \Carbon\Carbon::parse($event->start_date)->format('Y-m-d') }}" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
              </div>
              <div class="flex flex-col gap-1.5">
                <label class="font-semibold text-slate-700">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ \Carbon\Carbon::parse($event->end_date)->format('Y-m-d') }}" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="flex flex-col gap-1.5">
                <label class="font-semibold text-slate-700">Jam Mulai</label>
                <input type="time" name="start_time" value="{{ substr($event->start_time, 0, 5) }}" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
              </div>
              <div class="flex flex-col gap-1.5">
                <label class="font-semibold text-slate-700">Jam Selesai</label>
                <input type="time" name="end_time" value="{{ substr($event->end_time, 0, 5) }}" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="flex flex-col gap-1.5">
                <label class="font-semibold text-slate-700">Target Kuota Peserta</label>
                <input type="number" name="quota" value="{{ $event->quota }}" min="1" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
              </div>
              <div class="flex flex-col gap-1.5">
                <label class="font-semibold text-slate-700">Biaya Pendaftaran (Rp)</label>
                <input type="number" name="price" value="{{ $event->price }}" min="0" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
              </div>
            </div>

            <div class="flex flex-col gap-1.5">
              <label class="font-semibold text-slate-700">Tautan Pertemuan Virtual (Jika Online/Hybrid)</label>
              <input type="url" name="virtual_meeting_url" value="{{ $event->virtual_meeting_url }}" placeholder="https://meet.google.com/..." class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
            </div>

            <div class="flex flex-col gap-1.5">
              <label class="font-semibold text-slate-700">Deskripsi Lengkap</label>
              <textarea name="description" rows="4" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 leading-relaxed">{{ $event->description }}</textarea>
            </div>

            <div class="flex justify-end pt-3 border-t border-slate-100">
              <button type="submit" class="px-5 py-2.5 bg-blue-950 text-white rounded-xl text-xs font-semibold hover:bg-blue-900 transition shadow-xs cursor-pointer">
                Simpan Perubahan Pengaturan
              </button>
            </div>
          </form>
        </div>
      @endif
    </main>
  </div>

  <div id="modal-assign-speaker" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 sm:p-8 flex flex-col gap-6 shadow-2xl">
      <div class="flex items-start justify-between gap-4 pb-4 border-b border-slate-100">
        <div class="flex flex-col">
          <h2 class="text-base sm:text-lg font-bold text-slate-900">Tugaskan Pengisi Acara</h2>
          <p class="text-xs text-slate-500 mt-0.5">Pilih pengisi acara terdaftar dan tentukan materi sesi untuk acara ini.</p>
        </div>
        <button type="button" onclick="closeAssignSpeakerModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 cursor-pointer">
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>

      <form action="{{ route('organizer.event.speaker.assign', ['event' => $event->id]) }}" method="POST" class="flex flex-col gap-4 text-xs">
        @csrf
        <div class="flex flex-col gap-1.5">
          <div class="flex items-center justify-between">
            <label class="font-semibold text-slate-700">Pilih Pengisi Acara</label>
            <a href="{{ route('organizer.speakers.index') }}" target="_blank" class="text-[11px] text-blue-950 font-semibold hover:underline">+ Tambah Pengisi Acara Baru ↗</a>
          </div>
          <select name="speaker_id" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 cursor-pointer">
            <option value="">-- Pilih Pengisi Acara --</option>
            @foreach($allMasterSpeakers as $mspk)
              <option value="{{ $mspk->id }}">{{ $mspk->name }} — {{ $mspk->institution ?? 'Lab ICT' }}</option>
            @endforeach
          </select>
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Peran</label>
          <select name="role" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 cursor-pointer">
            <option value="Pembicara">Pembicara</option>
            <option value="Moderator">Moderator</option>
            <option value="MC">MC</option>
          </select>
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Waktu Sesi</label>
          <input type="text" name="session_time" value="{{ substr($event->start_time, 0, 5) }} - {{ substr($event->end_time, 0, 5) }} WIB" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
        </div>

        <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
          <button type="button" onclick="closeAssignSpeakerModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 cursor-pointer">
            Batal
          </button>
          <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-950 hover:bg-blue-900 text-white font-semibold shadow-xs cursor-pointer">
            Tugaskan ke Acara
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openAssignSpeakerModal() {
  const m = document.getElementById('modal-assign-speaker');
  m.classList.remove('hidden');
  m.classList.add('flex');
}

function closeAssignSpeakerModal() {
  const m = document.getElementById('modal-assign-speaker');
  m.classList.add('hidden');
  m.classList.remove('flex');
}
</script>
@endsection

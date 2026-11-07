@extends('layouts.app')

@section('title', 'Ruang Peserta — ' . $user->name . ' — Eventict')

@section('content')
<div class="min-h-screen bg-slate-50 text-slate-800 antialiased font-['Poppins'] flex flex-col">
  <header class="bg-blue-950 text-white border-b border-blue-900 sticky top-0 z-40 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-4">
      <div class="flex items-center gap-3 sm:gap-4 min-w-0">
        <a href="{{ route('home') }}" class="px-2.5 py-1.5 rounded-lg border border-white/20 text-xs font-semibold text-slate-200 hover:bg-white/10 hover:text-white transition flex items-center gap-1.5 shrink-0" title="Kembali ke Beranda">
          <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="15 18 9 12 15 6"/>
          </svg>
          <span class="hidden sm:inline">Beranda</span>
        </a>

        <div class="h-6 w-px bg-white/20 hidden sm:block shrink-0"></div>

        <div class="flex items-center gap-2 min-w-0">
          <span class="text-xs text-blue-200 hidden lg:inline shrink-0">Ruang Peserta:</span>
          <div class="bg-blue-900 border border-blue-800 rounded-lg px-2.5 py-1.5 text-xs font-semibold text-white truncate max-w-[200px] sm:max-w-[320px]">
            {{ $user->name }}
          </div>
          <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 shrink-0 hidden md:inline">
            Aktif
          </span>
        </div>
      </div>

      <div class="flex items-center gap-3 shrink-0">
        <a href="{{ route('events.index_public') }}" class="px-3 py-1.5 rounded-lg border border-white/20 text-xs font-medium text-slate-200 hover:bg-white/10 hover:text-white transition hidden md:inline-flex items-center gap-1.5">
          <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/>
            <path d="m21 21-4.35-4.35"/>
          </svg>
          <span>Katalog Kegiatan</span>
        </a>

        <div class="flex items-center gap-2.5 pl-2 sm:border-l sm:border-white/15">
          <div class="size-8 rounded-lg bg-blue-900 text-white font-semibold text-xs flex items-center justify-center shrink-0">
            {{ strtoupper(substr($user->name ?? 'P', 0, 2)) }}
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
        <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Akun Peserta</span>
        <h2 class="text-xs sm:text-sm font-bold text-slate-900 leading-snug">{{ $user->name }}</h2>
        <div class="text-[11px] text-slate-500 truncate">{{ $user->email }}</div>
        <div class="flex items-center gap-1.5 mt-1 flex-wrap">
          <span class="px-2 py-0.5 rounded text-[10px] font-medium uppercase bg-slate-100 text-slate-700">
            {{ $user->institution ?? 'Peserta Terdaftar' }}
          </span>
          @if($user->nik)
            <span class="px-2 py-0.5 rounded text-[10px] font-medium uppercase bg-blue-50 text-blue-900 border border-blue-100">
              NIK: {{ $user->nik }}
            </span>
          @endif
        </div>
      </div>

      <nav class="bg-white rounded-2xl border border-slate-200 p-2 flex flex-row md:flex-col gap-1 shadow-2xs overflow-x-auto">
        <a href="{{ route('peserta.dashboard', ['tab' => 'dashboard']) }}" class="px-3 py-2.5 rounded-xl text-xs font-semibold transition flex items-center justify-between shrink-0 {{ $tab === 'dashboard' ? 'bg-blue-950 text-white shadow-2xs' : 'text-slate-600 hover:bg-slate-50' }}">
          <div class="flex items-center gap-2.5">
            <svg class="size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect width="18" height="18" x="3" y="3" rx="2"/>
              <path d="M3 9h18"/>
              <path d="M9 21V9"/>
            </svg>
            <span>Dashboard</span>
          </div>
        </a>

        <a href="{{ route('peserta.dashboard', ['tab' => 'tiket']) }}" class="px-3 py-2.5 rounded-xl text-xs font-semibold transition flex items-center justify-between shrink-0 {{ $tab === 'tiket' ? 'bg-blue-950 text-white shadow-2xs' : 'text-slate-600 hover:bg-slate-50' }}">
          <div class="flex items-center gap-2.5">
            <svg class="size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/>
              <path d="M13 5v2"/>
              <path d="M13 17v2"/>
              <path d="M13 11v2"/>
            </svg>
            <span>Tiket Saya</span>
          </div>
          <span class="px-2 py-0.5 rounded-md text-[10px] {{ $tab === 'tiket' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $registrations->count() }}</span>
        </a>

        <a href="{{ route('peserta.dashboard', ['tab' => 'sertifikat']) }}" class="px-3 py-2.5 rounded-xl text-xs font-semibold transition flex items-center justify-between shrink-0 {{ $tab === 'sertifikat' ? 'bg-blue-950 text-white shadow-2xs' : 'text-slate-600 hover:bg-slate-50' }}">
          <div class="flex items-center gap-2.5">
            <svg class="size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="8" r="6"/>
              <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
            </svg>
            <span>E-Sertifikat</span>
          </div>
          <span class="px-2 py-0.5 rounded-md text-[10px] {{ $tab === 'sertifikat' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $certificates->count() }}</span>
        </a>

        <a href="{{ route('peserta.dashboard', ['tab' => 'kegiatan']) }}" class="px-3 py-2.5 rounded-xl text-xs font-semibold transition flex items-center justify-between shrink-0 {{ $tab === 'kegiatan' ? 'bg-blue-950 text-white shadow-2xs' : 'text-slate-600 hover:bg-slate-50' }}">
          <div class="flex items-center gap-2.5">
            <svg class="size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="11" r="8"/>
              <path d="m21 21-4.35-4.35"/>
            </svg>
            <span>Katalog Kegiatan</span>
          </div>
          <span class="px-2 py-0.5 rounded-md text-[10px] {{ $tab === 'kegiatan' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $availableEvents->count() }}</span>
        </a>
      </nav>

      <div class="bg-blue-950 text-white rounded-2xl p-4 flex flex-col gap-2 shadow-2xs">
        <div class="flex items-center gap-2">
          <svg class="size-4 text-blue-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
          </svg>
          <span class="text-xs font-semibold">Pusat Layanan Peserta</span>
        </div>
        <p class="text-[11px] text-slate-300 leading-relaxed">
          Laboratorium ICT, Unit 7 Lantai 4, Universitas Budi Luhur.
        </p>
        <div class="text-[11px] text-blue-200 font-medium">help@eventict.id</div>
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

      @if (session('info'))
        <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl flex items-start gap-3 text-xs text-blue-800">
          <svg class="size-4 text-blue-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="16" x2="12" y2="12"/>
            <line x1="12" y1="8" x2="12.01" y2="8"/>
          </svg>
          <div class="font-medium">{{ session('info') }}</div>
        </div>
      @endif

      @if($tab === 'dashboard')
        @php
          $attendedCount = $registrations->where('attendance_status', 'attended')->count();
          $attendPercent = $registrations->count() > 0 ? round(($attendedCount / $registrations->count()) * 100) : 0;
          $totalSkp = $registrations->filter(fn($r) => $r->attendance_status === 'attended')->sum(fn($r) => $r->event->skp_points ?? 0);
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-2xs flex flex-col justify-between">
            <span class="text-xs text-slate-500 font-medium">Kegiatan Terdaftar</span>
            <div class="flex items-baseline justify-between mt-2">
              <span class="text-xl sm:text-2xl font-bold text-slate-900">{{ $registrations->count() }}</span>
              <span class="text-xs text-slate-500 font-medium">Tiket Terverifikasi</span>
            </div>
            <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden mt-3">
              <div class="h-full bg-blue-950 rounded-full" style="width: 100%"></div>
            </div>
          </div>

          <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-2xs flex flex-col justify-between">
            <span class="text-xs text-slate-500 font-medium">Kehadiran Sesi</span>
            <div class="flex items-baseline justify-between mt-2">
              <span class="text-xl sm:text-2xl font-bold text-slate-900">{{ $attendedCount }}</span>
              <span class="text-xs text-emerald-700 font-semibold">{{ $attendPercent }}% Hadir</span>
            </div>
            <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden mt-3">
              <div class="h-full bg-emerald-600 rounded-full" style="width: {{ $attendPercent }}%"></div>
            </div>
          </div>

          <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-2xs flex flex-col justify-between">
            <span class="text-xs text-slate-500 font-medium">E-Sertifikat Terbit</span>
            <div class="flex items-baseline justify-between mt-2">
              <span class="text-xl sm:text-2xl font-bold text-slate-900">{{ $certificates->count() }}</span>
              <span class="text-xs text-blue-950 font-semibold">Siap Unduh</span>
            </div>
            <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden mt-3">
              <div class="h-full bg-blue-900 rounded-full" style="width: {{ $registrations->count() > 0 ? min(100, round(($certificates->count() / $registrations->count()) * 100)) : 0 }}%"></div>
            </div>
          </div>

          <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-2xs flex flex-col justify-between">
            <span class="text-xs text-slate-500 font-medium">Poin SKP / Kompetensi</span>
            <div class="flex items-baseline justify-between mt-2">
              <span class="text-xl sm:text-2xl font-bold text-slate-900">{{ $totalSkp }}</span>
              <span class="text-xs text-slate-500 font-medium">Poin Terkumpul</span>
            </div>
            <span class="text-[11px] text-slate-400 mt-3">Sertifikasi tervalidasi</span>
          </div>
        </div>

        @if($todayRegistration && $todayRegistration->event)
          <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 shadow-2xs">
            <div class="flex-1 flex flex-col gap-3">
              <div class="flex items-center gap-2 flex-wrap">
                <span class="text-xs font-semibold text-blue-950 uppercase tracking-wider">
                  Agenda Hari Ini &bull; {{ substr($todayRegistration->event->start_time, 0, 5) }} WIB
                </span>
                @if($todayRegistration->attendance_status === 'attended')
                  <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-semibold rounded-md">
                    Presensi Berhasil ({{ $todayRegistration->checked_in_at ? $todayRegistration->checked_in_at->format('H:i') : '' }} WIB)
                  </span>
                @else
                  <span class="px-2 py-0.5 bg-amber-100 text-amber-800 text-[10px] font-semibold rounded-md">
                    Siap Check-In
                  </span>
                @endif
              </div>

              <h2 class="text-slate-900 text-lg sm:text-xl font-bold leading-snug">
                {{ $todayRegistration->event->title }}
              </h2>

              <div class="flex items-center gap-2 text-slate-600 text-xs">
                <svg class="size-4 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                  <circle cx="12" cy="10" r="3"/>
                </svg>
                <span>{{ $todayRegistration->event->location ?? 'Online via Eventict Platform' }}</span>
              </div>

              <div class="flex flex-wrap items-center gap-2.5 pt-2">
                @if($todayRegistration->event->virtual_meeting_url)
                  <a href="{{ $todayRegistration->event->virtual_meeting_url }}" target="_blank" class="px-3.5 py-2 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-medium transition flex items-center gap-2 shadow-2xs">
                    <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="12" cy="12" r="10"/>
                      <polygon points="10 8 16 12 10 16 10 8"/>
                    </svg>
                    <span>Masuk Ruang Virtual</span>
                  </a>
                @endif
                <a href="{{ route('events.show', $todayRegistration->event->slug) }}" class="px-3.5 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-medium transition flex items-center gap-1.5 shadow-2xs">
                  <span>Lihat Detail Sesi</span>
                </a>
              </div>
            </div>

            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex flex-col items-center gap-2 text-center shrink-0 w-full sm:w-auto">
              <div class="size-24 bg-white p-2 rounded-lg border border-slate-300 flex items-center justify-center shadow-2xs">
                <svg class="size-full text-blue-950" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                  <rect width="6" height="6" x="2" y="2" rx="1"/>
                  <rect width="6" height="6" x="16" y="2" rx="1"/>
                  <rect width="6" height="6" x="2" y="16" rx="1"/>
                  <path d="M10 2h4"/>
                  <path d="M2 10v4"/>
                  <path d="M10 6h4"/>
                  <path d="M14 10h4"/>
                  <path d="M10 14h4"/>
                  <path d="M16 14v4"/>
                  <path d="M16 20h4"/>
                  <path d="M20 16v4"/>
                </svg>
              </div>
              <div class="text-[11px] text-slate-500 font-medium">QR Pass Presensi</div>
              <div class="text-blue-950 font-bold text-xs tracking-wider font-mono">#{{ $todayRegistration->qr_pass }}</div>
            </div>
          </div>
        @else
          <div class="bg-white rounded-2xl border border-slate-200 p-6 text-center flex flex-col items-center gap-3 shadow-2xs">
            <div class="size-12 rounded-full bg-blue-50 text-blue-950 flex items-center justify-center">
              <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                <line x1="16" x2="16" y1="2" y2="6"/>
                <line x1="8" x2="8" y1="2" y2="6"/>
                <line x1="3" x2="21" y1="10" y2="10"/>
              </svg>
            </div>
            <h3 class="text-slate-900 font-semibold text-base">Belum Ada Agenda Hari Ini</h3>
            <p class="text-slate-500 text-xs max-w-md">Jelajahi berbagai seminar dan workshop untuk menambah kompetensi keahlian Anda.</p>
            <a href="{{ route('peserta.dashboard', ['tab' => 'kegiatan']) }}" class="mt-1 px-4 py-2 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold transition shadow-2xs">
              Jelajahi Kegiatan
            </a>
          </div>
        @endif

        <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-4 shadow-2xs">
          <div class="flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">Tiket Kegiatan Terdaftar</h3>
            <a href="{{ route('peserta.dashboard', ['tab' => 'tiket']) }}" class="text-xs font-semibold text-blue-950 hover:underline">
              Lihat Semua Tiket ({{ $registrations->count() }}) →
            </a>
          </div>

          <div class="flex flex-col gap-3">
            @forelse($registrations->take(3) as $reg)
              <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                  <div class="size-9 rounded-lg bg-blue-100 text-blue-950 flex items-center justify-center shrink-0 font-mono font-bold text-[10px]">
                    PASS
                  </div>
                  <div class="min-w-0">
                    <div class="text-slate-400 text-[11px]">
                      {{ $reg->event->start_date ? $reg->event->start_date->format('d M Y') : '' }} &bull; {{ substr($reg->event->start_time ?? '', 0, 5) }} WIB
                    </div>
                    <a href="{{ route('events.show', $reg->event->slug) }}" class="text-slate-900 text-xs sm:text-sm font-semibold hover:text-blue-950 transition truncate block">
                      {{ $reg->event->title }}
                    </a>
                    <div class="text-[10px] text-slate-500 font-mono">
                      No: {{ $reg->registration_code }} &bull; Pass: #{{ $reg->qr_pass }}
                    </div>
                  </div>
                </div>

                <div class="flex items-center gap-2 self-start sm:self-auto shrink-0">
                  @if($reg->attendance_status === 'attended')
                    <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-semibold rounded-md">
                      Hadir
                    </span>
                  @else
                    <span class="px-2 py-0.5 bg-slate-200 text-slate-700 text-[10px] font-semibold rounded-md">
                      Belum Check-In
                    </span>
                  @endif
                  <a href="{{ route('events.show', $reg->event->slug) }}" class="px-2.5 py-1.5 bg-white border border-slate-300 rounded-lg text-[11px] font-medium text-slate-700 hover:bg-slate-100 transition shadow-2xs">
                    Detail
                  </a>
                </div>
              </div>
            @empty
              <div class="p-6 bg-slate-50 rounded-xl text-center text-xs text-slate-500">
                Belum ada tiket terdaftar. Silakan pilih kegiatan di tab Katalog Kegiatan.
              </div>
            @endforelse
          </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-4 shadow-2xs">
          <div class="flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">E-Sertifikat Resmi Terbaru</h3>
            <a href="{{ route('peserta.dashboard', ['tab' => 'sertifikat']) }}" class="text-xs font-semibold text-blue-950 hover:underline">
              Buka Lemari Sertifikat ({{ $certificates->count() }}) →
            </a>
          </div>

          <div class="flex flex-col gap-3">
            @forelse($certificates->take(2) as $cert)
              <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                  <div class="w-16 h-12 bg-white border border-slate-300 rounded flex flex-col items-center justify-center p-1 text-center shrink-0 shadow-2xs">
                    <div class="text-[7px] font-bold text-slate-700 uppercase">SERTIFIKAT</div>
                    <div class="px-1 bg-blue-950 text-white text-[6px] font-bold rounded mt-0.5">VERIFIED</div>
                  </div>
                  <div class="min-w-0">
                    <div class="text-slate-900 text-xs sm:text-sm font-semibold truncate">{{ $cert->event->title ?? 'Kegiatan Ilmiah' }}</div>
                    <div class="text-slate-500 text-[11px]">No: {{ $cert->certificate_number }}</div>
                    <div class="text-slate-400 text-[10px] font-mono truncate">Hash: {{ $cert->verify_hash }}</div>
                  </div>
                </div>

                <div class="flex items-center gap-2 self-start sm:self-auto shrink-0">
                  <a href="{{ $cert->download_url ? asset($cert->download_url) : '#' }}" target="_blank" download class="px-3 py-1.5 bg-blue-950 hover:bg-blue-900 text-white text-xs font-medium rounded-lg transition flex items-center gap-1.5 shadow-2xs">
                    <svg class="size-3.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                      <polyline points="7 10 12 15 17 10"/>
                      <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    <span>Unduh PDF</span>
                  </a>
                </div>
              </div>
            @empty
              <div class="p-6 bg-slate-50 rounded-xl text-center text-xs text-slate-500">
                Belum ada e-sertifikat yang diterbitkan. Sertifikat diterbitkan otomatis setelah kehadiran tervalidasi.
              </div>
            @endforelse
          </div>
        </div>
      @endif

      @if($tab === 'tiket')
        <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-5 shadow-2xs">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
              <h3 class="text-sm sm:text-base font-bold text-slate-900">Tiket & Pendaftaran Saya ({{ $registrations->count() }})</h3>
              <p class="text-xs text-slate-500">Kelola tiket kegiatan, status kehadiran sesi, dan kode pass presensi resmi.</p>
            </div>
            <a href="{{ route('peserta.dashboard', ['tab' => 'kegiatan']) }}" class="px-4 py-2 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold transition flex items-center gap-1.5 self-start sm:self-auto shadow-2xs">
              <span>+ Cari Kegiatan Baru</span>
            </a>
          </div>

          <div class="flex flex-col gap-3">
            @forelse($registrations as $reg)
              <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4 min-w-0">
                  <div class="size-11 rounded-xl bg-blue-100 text-blue-950 flex items-center justify-center shrink-0 font-mono font-bold text-xs">
                    PASS
                  </div>
                  <div class="min-w-0">
                    <div class="text-slate-500 text-xs">
                      {{ $reg->event->start_date ? $reg->event->start_date->format('d M Y') : '' }} &bull; {{ substr($reg->event->start_time ?? '', 0, 5) }} WIB
                    </div>
                    <a href="{{ route('events.show', $reg->event->slug) }}" class="text-slate-900 text-sm font-semibold hover:text-blue-950 transition block truncate">
                      {{ $reg->event->title }}
                    </a>
                    <div class="text-[11px] text-slate-500 font-mono mt-0.5">
                      No. Tiket: {{ $reg->registration_code }} &bull; Pass: <strong class="text-blue-950">#{{ $reg->qr_pass }}</strong>
                    </div>
                  </div>
                </div>

                <div class="flex items-center gap-2 self-start sm:self-auto shrink-0 flex-wrap">
                  @if($reg->attendance_status === 'attended')
                    <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-xs font-semibold rounded-md">
                      Hadir ({{ $reg->checked_in_at ? $reg->checked_in_at->format('H:i') : '' }} WIB)
                    </span>
                  @else
                    <span class="px-2.5 py-1 bg-slate-200 text-slate-700 text-xs font-semibold rounded-md">
                      Belum Check-In
                    </span>
                  @endif

                  @if($reg->event->virtual_meeting_url)
                    <a href="{{ $reg->event->virtual_meeting_url }}" target="_blank" class="px-3 py-1.5 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-medium transition flex items-center gap-1 shadow-2xs">
                      <span>Ruang Virtual</span>
                    </a>
                  @endif

                  <a href="{{ route('events.show', $reg->event->slug) }}" class="px-3 py-1.5 bg-white border border-slate-300 rounded-lg text-xs font-medium text-slate-700 hover:bg-slate-100 transition shadow-2xs">
                    Detail Sesi
                  </a>
                </div>
              </div>
            @empty
              <div class="p-8 bg-slate-50 rounded-xl text-center text-xs text-slate-500">
                Anda belum mendaftar kegiatan apapun. Klik tombol di atas untuk melihat katalog kegiatan yang dibuka.
              </div>
            @endforelse
          </div>
        </div>
      @endif

      @if($tab === 'sertifikat')
        <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-5 shadow-2xs">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
              <h3 class="text-sm sm:text-base font-bold text-slate-900">Lemari E-Sertifikat Resmi ({{ $certificates->count() }})</h3>
              <p class="text-xs text-slate-500">Dokumen digital resmi bertanda tangan dan ber-hash verifikasi integritas Laboratorium ICT.</p>
            </div>
            <span class="px-2.5 py-1 bg-blue-50 text-blue-900 border border-blue-200 text-xs font-semibold rounded-md self-start sm:self-auto">
              Terverifikasi Digital
            </span>
          </div>

          <div class="flex flex-col gap-4">
            @forelse($certificates as $cert)
              <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4 min-w-0">
                  <div class="w-20 h-14 bg-white border border-slate-300 rounded-lg flex flex-col items-center justify-center p-1 text-center shrink-0 shadow-2xs">
                    <div class="text-[8px] font-bold text-slate-700 uppercase tracking-widest">SERTIFIKAT</div>
                    <div class="text-[7px] text-slate-500 truncate max-w-[70px]">{{ $user->name }}</div>
                    <div class="px-1 bg-blue-950 text-white text-[7px] font-bold rounded mt-0.5">VERIFIED</div>
                  </div>
                  <div class="min-w-0">
                    <div class="text-slate-900 text-sm font-semibold truncate">{{ $cert->event->title ?? 'Kegiatan Ilmiah' }}</div>
                    <div class="text-slate-500 text-xs">No. Sertifikat: <span class="font-mono">{{ $cert->certificate_number }}</span></div>
                    <div class="text-slate-400 text-[11px] font-mono truncate mt-0.5">Hash Verifikasi: {{ $cert->verify_hash }}</div>
                    <span class="inline-block px-2 py-0.5 bg-blue-100 text-blue-950 font-semibold text-[10px] rounded mt-1">
                      Sertifikat Resmi Terbit
                    </span>
                  </div>
                </div>

                <div class="flex items-center gap-2 self-start sm:self-auto shrink-0">
                  <a href="{{ $cert->download_url ? asset($cert->download_url) : '#' }}" target="_blank" download class="px-3.5 py-2 bg-blue-950 hover:bg-blue-900 text-white text-xs font-medium rounded-xl transition flex items-center gap-1.5 shadow-2xs">
                    <svg class="size-3.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                      <polyline points="7 10 12 15 17 10"/>
                      <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    <span>Unduh Dokumen PDF</span>
                  </a>
                </div>
              </div>
            @empty
              <div class="p-8 bg-slate-50 rounded-xl text-center text-xs text-slate-500">
                Belum ada e-sertifikat yang terbit. Sertifikat akan terbit otomatis setelah panitia memvalidasi presensi kegiatan Anda.
              </div>
            @endforelse
          </div>
        </div>
      @endif

      @if($tab === 'kegiatan')
        <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-5 shadow-2xs">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
              <h3 class="text-sm sm:text-base font-bold text-slate-900">Katalog Kegiatan Tersedia ({{ $availableEvents->count() }})</h3>
              <p class="text-xs text-slate-500">Pilih seminar, workshop teknologi, atau pelatihan praktikum untuk mengasah keahlian Anda.</p>
            </div>
            <a href="{{ route('events.index_public') }}" class="text-xs font-semibold text-blue-950 hover:underline self-start sm:self-auto">
              Katalog Lengkap Website →
            </a>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($availableEvents as $avEvent)
              <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex flex-col justify-between gap-4 hover:border-blue-950 transition">
                <div class="flex flex-col gap-2">
                  <div class="flex items-center justify-between gap-2">
                    <div class="flex items-center gap-1.5">
                      @if($avEvent->skp_points > 0)
                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-bold rounded">
                          {{ $avEvent->skp_points }} SKP
                        </span>
                      @endif
                      <span class="px-2 py-0.5 bg-slate-200 text-slate-700 text-[10px] font-medium rounded uppercase">
                        {{ $avEvent->format }}
                      </span>
                    </div>
                    <span class="text-xs font-bold text-blue-950">
                      {{ $avEvent->price == 0 ? 'Gratis' : 'Rp ' . number_format($avEvent->price, 0, ',', '.') }}
                    </span>
                  </div>

                  <a href="{{ route('events.show', $avEvent->slug) }}" class="text-slate-900 text-sm font-semibold hover:text-blue-950 transition line-clamp-2">
                    {{ $avEvent->title }}
                  </a>

                  <div class="flex items-center gap-2 text-slate-500 text-[11px]">
                    <svg class="size-3.5 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                      <line x1="16" x2="16" y1="2" y2="6"/>
                      <line x1="8" x2="8" y1="2" y2="6"/>
                      <line x1="3" x2="21" y1="10" y2="10"/>
                    </svg>
                    <span>{{ $avEvent->start_date ? $avEvent->start_date->format('d M Y') : 'Segera' }} &bull; {{ substr($avEvent->start_time ?? '', 0, 5) }} WIB</span>
                  </div>
                </div>

                <div class="pt-3 border-t border-slate-200 flex items-center justify-between">
                  <span class="text-[11px] text-slate-500">
                    Sisa {{ max(0, $avEvent->quota - $avEvent->registrations_count) }} kursi
                  </span>
                  <a href="{{ route('events.register.form', $avEvent->slug) }}" class="px-3.5 py-1.5 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold transition flex items-center gap-1 shadow-2xs">
                    <span>Daftar Sesi</span>
                    <span class="text-sm">&rarr;</span>
                  </a>
                </div>
              </div>
            @empty
              <div class="col-span-full p-8 bg-slate-50 rounded-xl text-center text-xs text-slate-500">
                Anda telah terdaftar pada seluruh kegiatan yang sedang aktif saat ini.
              </div>
            @endforelse
          </div>
        </div>
      @endif
    </main>
  </div>
</div>
@endsection

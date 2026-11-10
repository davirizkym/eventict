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
        <div class="flex items-center gap-2.5">
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
              NIM/NIP: {{ $user->nik }}
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

        <a href="{{ route('peserta.dashboard', ['tab' => 'acara']) }}" class="px-3 py-2.5 rounded-xl text-xs font-semibold transition flex items-center justify-between shrink-0 {{ $tab === 'acara' ? 'bg-blue-950 text-white shadow-2xs' : 'text-slate-600 hover:bg-slate-50' }}">
          <div class="flex items-center gap-2.5">
            <svg class="size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
              <line x1="16" x2="16" y1="2" y2="6"/>
              <line x1="8" x2="8" y1="2" y2="6"/>
              <line x1="3" x2="21" y1="10" y2="10"/>
            </svg>
            <span>Acara Saya</span>
          </div>
          <span class="px-2 py-0.5 rounded-md text-[10px] {{ $tab === 'acara' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $registrations->count() }}</span>
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
            <span>Jelajahi Kegiatan</span>
          </div>
          <span class="px-2 py-0.5 rounded-md text-[10px] {{ $tab === 'kegiatan' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $availableEvents->count() }}</span>
        </a>

        <a href="{{ route('peserta.dashboard', ['tab' => 'profil']) }}" class="px-3 py-2.5 rounded-xl text-xs font-semibold transition flex items-center justify-between shrink-0 {{ $tab === 'profil' ? 'bg-blue-950 text-white shadow-2xs' : 'text-slate-600 hover:bg-slate-50' }}">
          <div class="flex items-center gap-2.5">
            <svg class="size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
            <span>Profil Saya</span>
          </div>
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

      @if (isset($errors) && $errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl flex items-start gap-3 text-xs text-rose-800">
          <svg class="size-4 text-rose-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
          </svg>
          <div>
            <div class="font-semibold mb-1">Periksa kembali data Anda:</div>
            <ul class="list-disc pl-4 space-y-0.5">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
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
                @if($todayRegistration->payment_status === 'pending')
                  <span class="px-2 py-0.5 bg-amber-100 text-amber-800 text-[10px] font-semibold rounded-md">
                    Menunggu Pembayaran
                  </span>
                @elseif($todayRegistration->attendance_status === 'attended')
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
                @if($todayRegistration->payment_status === 'pending')
                  <button type="button" onclick="payWithSnap('{{ $todayRegistration->id }}', '{{ $todayRegistration->snap_token }}')" class="px-3.5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-semibold transition flex items-center gap-1.5 shadow-2xs cursor-pointer">
                    <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <rect width="20" height="14" x="2" y="5" rx="2"/>
                      <line x1="2" x2="22" y1="10" y2="10"/>
                    </svg>
                    <span>Bayar (Rp {{ number_format($todayRegistration->amount_paid > 0 ? $todayRegistration->amount_paid : $todayRegistration->event->price, 0, ',', '.') }})</span>
                  </button>
                  <button type="button" onclick="checkPaymentStatus('{{ $todayRegistration->id }}')" title="Cek Status Pembayaran" class="px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-950 border border-blue-200 rounded-xl text-xs font-semibold transition flex items-center gap-1 shadow-2xs cursor-pointer">
                    <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                      <path d="M3 3v5h5"/>
                      <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/>
                      <path d="M16 21h5v-5"/>
                    </svg>
                    <span>Cek</span>
                  </button>
                  <form method="POST" action="{{ route('peserta.registration.cancel', $todayRegistration->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran kegiatan ini?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-2 bg-white hover:bg-rose-50 text-rose-700 border border-rose-200 rounded-xl text-xs font-semibold transition cursor-pointer">
                      Batal
                    </button>
                  </form>
                @else
                  @if($todayRegistration->event->virtual_meeting_url)
                    <a href="{{ $todayRegistration->event->virtual_meeting_url }}" target="_blank" class="px-3.5 py-2 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-medium transition flex items-center gap-2 shadow-2xs">
                      <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polygon points="10 8 16 12 10 16 10 8"/>
                      </svg>
                      <span>Masuk Ruang Virtual</span>
                    </a>
                  @endif
                  @if($todayRegistration->attendance_status !== 'attended' && $todayRegistration->event->is_presence_open)
                    <a href="{{ route('events.presence', $todayRegistration->event->slug) }}" class="px-3.5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-semibold transition flex items-center gap-1.5 shadow-2xs">
                      <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <polyline points="9 12 11 14 15 10"/>
                      </svg>
                      <span>Isi Presensi Sesi</span>
                    </a>
                  @endif
                @endif
                <a href="{{ route('events.show', $todayRegistration->event->slug) }}" class="px-3.5 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-medium transition flex items-center gap-1.5 shadow-2xs">
                  <span>Lihat Detail Sesi</span>
                </a>
              </div>
            </div>

            @if($todayRegistration->payment_status === 'pending')
              <div class="p-4 bg-amber-50/80 rounded-xl border border-amber-200 flex flex-col items-center justify-center gap-2 text-center shrink-0 w-full sm:w-56">
                <div class="size-11 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center">
                  <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                  </svg>
                </div>
                <div>
                  <div class="text-xs font-bold text-amber-900">Tiket Belum Aktif</div>
                  <div class="text-[11px] text-amber-700 mt-0.5 leading-tight">
                    Selesaikan pembayaran untuk mengaktifkan tiket dan QR Pass.
                  </div>
                </div>
                <button type="button" onclick="payWithSnap('{{ $todayRegistration->id }}', '{{ $todayRegistration->snap_token }}')" class="w-full px-3 py-1.5 bg-amber-800 hover:bg-amber-900 text-white rounded-lg text-xs font-semibold transition text-center shadow-2xs cursor-pointer">
                  Bayar Sekarang
                </button>
              </div>
            @elseif($todayRegistration->attendance_status === 'attended')
              <div class="p-4 bg-emerald-50/70 rounded-xl border border-emerald-200 flex flex-col items-center justify-center gap-2 text-center shrink-0 w-full sm:w-52">
                <div class="size-11 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center">
                  <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"/>
                  </svg>
                </div>
                <div>
                  <div class="text-xs font-bold text-emerald-900">Kehadiran Terverifikasi</div>
                  <div class="text-[11px] text-emerald-700 mt-0.5">
                    {{ $todayRegistration->checked_in_at ? $todayRegistration->checked_in_at->format('H:i') . ' WIB' : 'Tercatat' }}
                    @if($todayRegistration->check_in_gate)
                      &bull; {{ $todayRegistration->check_in_gate }}
                    @endif
                  </div>
                </div>
              </div>
            @elseif($todayRegistration->event->format === 'online')
              <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex flex-col items-center justify-center gap-2.5 text-center shrink-0 w-full sm:w-56">
                <div class="size-11 rounded-full bg-blue-100 text-blue-950 flex items-center justify-center">
                  <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect width="20" height="14" x="2" y="3" rx="2"/>
                    <line x1="8" x2="16" y1="21" y2="21"/>
                    <line x1="12" x2="12" y1="17" y2="21"/>
                  </svg>
                </div>
                <div>
                  <div class="text-xs font-semibold text-slate-800">Sesi Daring / Online</div>
                  <div class="text-[11px] text-slate-500 mt-0.5 leading-relaxed">
                    @if($todayRegistration->event->is_presence_open)
                      <span class="text-emerald-700 font-semibold">Gerbang presensi dibuka.</span>
                    @else
                      Presensi dibuka saat sesi berlangsung.
                    @endif
                  </div>
                </div>
                @if($todayRegistration->event->is_presence_open)
                  <a href="{{ route('events.presence', $todayRegistration->event->slug) }}" class="w-full px-3 py-1.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg text-xs font-semibold transition text-center shadow-2xs">
                    Konfirmasi Hadir
                  </a>
                @endif
              </div>
            @else
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
                <div class="text-[11px] text-slate-500 font-medium">Tunjukkan ke Panitia</div>
                <div class="text-blue-950 font-bold text-xs tracking-wider font-mono">#{{ $todayRegistration->qr_pass }}</div>
              </div>
            @endif
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
                  @if($reg->payment_status === 'pending')
                    <div class="size-9 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center shrink-0">
                      <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                      </svg>
                    </div>
                  @else
                    <div class="size-9 rounded-lg bg-blue-100 text-blue-950 flex items-center justify-center shrink-0 font-mono font-bold text-[10px]">
                      PASS
                    </div>
                  @endif
                  <div class="min-w-0">
                    <div class="text-slate-400 text-[11px]">
                      {{ $reg->event->start_date ? $reg->event->start_date->format('d M Y') : '' }} &bull; {{ substr($reg->event->start_time ?? '', 0, 5) }} WIB
                    </div>
                    <a href="{{ route('events.show', $reg->event->slug) }}" class="text-slate-900 text-xs sm:text-sm font-semibold hover:text-blue-950 transition truncate block">
                      {{ $reg->event->title }}
                    </a>
                    <div class="text-[10px] text-slate-500 font-mono">
                      @if($reg->payment_status === 'pending')
                        No: {{ $reg->registration_code }} &bull; Rp {{ number_format($reg->amount_paid > 0 ? $reg->amount_paid : $reg->event->price, 0, ',', '.') }} &bull; <span class="text-amber-700 font-medium">Tiket Terkunci</span>
                      @else
                        No: {{ $reg->registration_code }} &bull; Pass: #{{ $reg->qr_pass }}
                      @endif
                    </div>
                  </div>
                </div>

                <div class="flex items-center gap-1.5 self-start sm:self-auto shrink-0 flex-wrap">
                  @if($reg->payment_status === 'pending')
                    <a href="{{ route('payment.invoice', $reg->registration_code) }}" class="px-2 py-0.5 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 text-[10px] font-semibold rounded-md transition" title="Buka Halaman Invoice">
                      Invoice
                    </a>
                    <button type="button" onclick="payWithSnap('{{ $reg->id }}', '{{ $reg->snap_token }}')" class="px-2.5 py-1 bg-emerald-700 hover:bg-emerald-800 text-white rounded-md text-[10px] font-semibold transition cursor-pointer">
                      Bayar
                    </button>
                    <button type="button" onclick="checkPaymentStatus('{{ $reg->id }}')" title="Cek Status Pembayaran" class="px-2 py-1 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 rounded-md text-[10px] font-medium transition flex items-center gap-1 shadow-2xs cursor-pointer">
                      <svg class="size-3 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                        <path d="M3 3v5h5"/>
                        <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/>
                        <path d="M16 21h5v-5"/>
                      </svg>
                      <span>Cek</span>
                    </button>
                    <form method="POST" action="{{ route('peserta.registration.cancel', $reg->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran ini?');" class="inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="px-2 py-1 bg-white hover:bg-rose-50 text-rose-600 border border-rose-200 rounded-md text-[10px] font-medium transition cursor-pointer">
                        Batal
                      </button>
                    </form>
                  @else
                    @if($reg->attendance_status === 'attended')
                      <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-semibold rounded-md">
                        Hadir
                      </span>
                    @else
                      <span class="px-2 py-0.5 bg-slate-200 text-slate-700 text-[10px] font-semibold rounded-md">
                        Belum Check-In
                      </span>
                    @endif
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
              <div class="p-3.5 bg-white rounded-xl border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-2xs">
                <div class="flex items-center gap-3 min-w-0">
                  <div class="size-10 rounded-lg bg-blue-50 border border-blue-100 text-blue-950 flex items-center justify-center shrink-0">
                    <svg class="size-5 text-blue-950" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                      <circle cx="12" cy="8" r="6"/>
                      <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
                    </svg>
                  </div>
                  <div class="min-w-0">
                    <div class="text-slate-900 text-xs sm:text-sm font-semibold truncate">{{ $cert->event->title ?? 'Kegiatan Laboratorium ICT' }}</div>
                    <div class="text-slate-500 text-[11px] mt-0.5">No: <span class="font-mono font-medium text-slate-700">{{ $cert->certificate_number }}</span> &bull; <span class="text-slate-400 font-mono text-[10px]">ID: {{ $cert->verify_hash }}</span></div>
                  </div>
                </div>

                <div class="flex items-center gap-2 self-start sm:self-auto shrink-0">
                  <a href="{{ $cert->download_url ? asset($cert->download_url) : '#' }}" target="_blank" download class="px-3.5 py-1.5 bg-blue-950 hover:bg-blue-900 text-white text-xs font-semibold rounded-lg transition flex items-center gap-1.5 shadow-2xs">
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

      @if($tab === 'acara')
        <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-6 shadow-2xs">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
            <div>
              <h3 class="text-base font-bold text-slate-900">Acara Saya</h3>
              <p class="text-xs text-slate-500 mt-0.5">Daftar kegiatan seminar, workshop, dan pelatihan yang telah Anda ikuti dan terdaftar resmi.</p>
            </div>
            <div class="flex items-center gap-2 self-start sm:self-auto">
              <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-900 border border-blue-100">
                {{ $registrations->count() }} Acara Terdaftar
              </span>
              <a href="{{ route('peserta.dashboard', ['tab' => 'kegiatan']) }}" class="px-3.5 py-1.5 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold transition flex items-center gap-1.5 shadow-2xs">
                <span>+ Cari Acara Baru</span>
              </a>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($registrations as $reg)
              @php
                $todayDate = \Carbon\Carbon::today()->toDateString();
                $eventDate = $reg->event->start_date ? $reg->event->start_date->toDateString() : null;
                $isToday = $eventDate === $todayDate;
                $isPassed = $reg->event->status === 'completed' || ($reg->event->end_date ? $reg->event->end_date->toDateString() < $todayDate : ($eventDate ? $eventDate < $todayDate : false));
              @endphp
              <div class="p-4.5 rounded-xl border border-slate-200 bg-white hover:border-blue-950 hover:shadow-xs transition flex flex-col justify-between gap-4">
                <div class="flex flex-col gap-2.5">
                  <div class="flex items-center justify-between gap-2 flex-wrap">
                    <div class="flex items-center gap-1.5 flex-wrap">
                      @if($reg->attendance_status === 'attended')
                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-bold rounded">
                          Hadir &bull; {{ $reg->checked_in_at ? $reg->checked_in_at->format('H:i') . ' WIB' : 'Tercatat' }}
                        </span>
                      @elseif($isToday)
                        <span class="px-2 py-0.5 bg-blue-100 text-blue-950 text-[10px] font-bold rounded">
                          Hari Ini
                        </span>
                      @elseif(!$isPassed)
                        <span class="px-2 py-0.5 bg-slate-100 text-slate-700 text-[10px] font-semibold rounded">
                          Mendatang
                        </span>
                      @else
                        <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[10px] font-medium rounded">
                          Selesai
                        </span>
                      @endif

                      <span class="px-2 py-0.5 bg-slate-100 text-slate-700 text-[10px] font-medium rounded uppercase">
                        {{ $reg->event->format }}
                      </span>

                      @if($reg->event->category)
                        <span class="px-2 py-0.5 bg-blue-50 text-blue-900 text-[10px] font-medium rounded">
                          {{ $reg->event->category }}
                        </span>
                      @endif
                    </div>

                    <span class="text-[11px] font-mono text-slate-400">
                      {{ $reg->registration_code }}
                    </span>
                  </div>

                  <a href="{{ route('events.show', $reg->event->slug) }}" class="text-slate-900 text-sm font-semibold hover:text-blue-950 transition line-clamp-2">
                    {{ $reg->event->title }}
                  </a>

                  <div class="flex flex-col gap-1 text-[11px] text-slate-500">
                    <div class="flex items-center gap-2">
                      <svg class="size-3.5 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                        <line x1="16" x2="16" y1="2" y2="6"/>
                        <line x1="8" x2="8" y1="2" y2="6"/>
                        <line x1="3" x2="21" y1="10" y2="10"/>
                      </svg>
                      <span>{{ $reg->event->start_date ? $reg->event->start_date->format('d M Y') : 'Segera' }} &bull; {{ substr($reg->event->start_time ?? '', 0, 5) }} WIB</span>
                    </div>

                    <div class="flex items-center gap-2">
                      <svg class="size-3.5 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                        <circle cx="12" cy="10" r="3"/>
                      </svg>
                      <span class="truncate">{{ $reg->event->location ?? 'Online via Eventict Platform' }}</span>
                    </div>
                  </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2 flex-wrap">
                  <div class="text-[11px] text-slate-500 font-mono">
                    @if($reg->payment_status === 'pending')
                      Status: <span class="text-amber-700 font-medium">Belum Bayar (Rp {{ number_format($reg->amount_paid > 0 ? $reg->amount_paid : $reg->event->price, 0, ',', '.') }})</span>
                    @else
                      Pass: <strong class="text-blue-950">#{{ $reg->qr_pass }}</strong>
                    @endif
                  </div>

                  <div class="flex items-center gap-1.5 flex-wrap">
                    @if($reg->payment_status === 'pending')
                      <button type="button" onclick="payWithSnap('{{ $reg->id }}', '{{ $reg->snap_token }}')" class="px-2.5 py-1 bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg text-xs font-semibold transition cursor-pointer">
                        Bayar
                      </button>
                      <button type="button" onclick="checkPaymentStatus('{{ $reg->id }}')" title="Cek Status Pembayaran" class="px-2 py-1 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 rounded-lg text-xs font-medium transition flex items-center gap-1 shadow-2xs cursor-pointer">
                        <svg class="size-3 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                          <path d="M3 3v5h5"/>
                          <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/>
                          <path d="M16 21h5v-5"/>
                        </svg>
                        <span>Cek</span>
                      </button>
                      <form method="POST" action="{{ route('peserta.registration.cancel', $reg->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran ini?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2 py-1 bg-white hover:bg-rose-50 text-rose-600 border border-rose-200 rounded-lg text-xs font-medium transition cursor-pointer">
                          Batal
                        </button>
                      </form>
                    @else
                      @if($reg->event->virtual_meeting_url)
                        <a href="{{ $reg->event->virtual_meeting_url }}" target="_blank" class="px-2.5 py-1 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-semibold transition flex items-center gap-1.5 shadow-2xs">
                          <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polygon points="10 8 16 12 10 16 10 8"/>
                          </svg>
                          <span>Ruang Virtual</span>
                        </a>
                      @endif
                    @endif
                    <a href="{{ route('events.show', $reg->event->slug) }}" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition flex items-center gap-1">
                      <span>Detail</span>
                      <span class="text-sm">&rarr;</span>
                    </a>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-span-full p-8 bg-slate-50 rounded-xl text-center text-xs text-slate-500">
                Anda belum terdaftar pada acara apa pun. Silakan buka menu <strong>Jelajahi Kegiatan</strong> untuk menemukan workshop dan seminar menarik.
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
                  @if($reg->payment_status === 'pending')
                    <div class="size-11 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0">
                      <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                      </svg>
                    </div>
                  @else
                    <div class="size-11 rounded-xl bg-blue-100 text-blue-950 flex items-center justify-center shrink-0 font-mono font-bold text-xs">
                      PASS
                    </div>
                  @endif
                  <div class="min-w-0">
                    <div class="text-slate-500 text-xs">
                      {{ $reg->event->start_date ? $reg->event->start_date->format('d M Y') : '' }} &bull; {{ substr($reg->event->start_time ?? '', 0, 5) }} WIB
                    </div>
                    <a href="{{ route('events.show', $reg->event->slug) }}" class="text-slate-900 text-sm font-semibold hover:text-blue-950 transition block truncate">
                      {{ $reg->event->title }}
                    </a>
                    <div class="text-[11px] text-slate-500 font-mono mt-0.5">
                      @if($reg->payment_status === 'pending')
                        No. Tiket: {{ $reg->registration_code }} &bull; Rp {{ number_format($reg->amount_paid > 0 ? $reg->amount_paid : $reg->event->price, 0, ',', '.') }} &bull; <span class="text-amber-700 font-medium">Tiket Terkunci</span>
                      @else
                        No. Tiket: {{ $reg->registration_code }} &bull; Pass: <strong class="text-blue-950">#{{ $reg->qr_pass }}</strong>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="flex items-center gap-1.5 self-start sm:self-auto shrink-0 flex-wrap">
                  @if($reg->payment_status === 'pending')
                    <a href="{{ route('payment.invoice', $reg->registration_code) }}" class="px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 rounded-lg text-xs font-semibold transition" title="Buka Halaman Invoice">
                      Invoice
                    </a>
                    <button type="button" id="pay-btn-{{ $reg->id }}" onclick="payWithSnap('{{ $reg->id }}', '{{ $reg->snap_token }}')" class="px-3 py-1 bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg text-xs font-semibold transition cursor-pointer">
                      Bayar
                    </button>
                    <button type="button" onclick="checkPaymentStatus('{{ $reg->id }}')" title="Cek Status Pembayaran" class="px-2 py-1 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 rounded-lg text-xs font-medium transition flex items-center gap-1 shadow-2xs cursor-pointer">
                      <svg class="size-3 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                        <path d="M3 3v5h5"/>
                        <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/>
                        <path d="M16 21h5v-5"/>
                      </svg>
                      <span>Cek</span>
                    </button>
                    <form method="POST" action="{{ route('peserta.registration.cancel', $reg->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran kegiatan ini?');" class="inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="px-2.5 py-1 bg-white hover:bg-rose-50 text-rose-600 border border-rose-200 rounded-lg text-xs font-medium transition cursor-pointer">
                        Batal
                      </button>
                    </form>
                  @else
                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-semibold rounded-md">
                      {{ $reg->payment_status === 'free' ? 'Gratis' : 'Lunas' }}
                    </span>
                    @if($reg->attendance_status === 'attended')
                      <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-xs font-semibold rounded-md">
                        Hadir ({{ $reg->checked_in_at ? $reg->checked_in_at->format('H:i') : '' }} WIB)
                      </span>
                    @else
                      <span class="px-2 py-0.5 bg-slate-200 text-slate-700 text-xs font-semibold rounded-md">
                        Belum Check-In
                      </span>
                    @endif
                  @endif

                  @if($reg->event->virtual_meeting_url && $reg->payment_status !== 'pending')
                    <a href="{{ $reg->event->virtual_meeting_url }}" target="_blank" class="px-2.5 py-1 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-medium transition flex items-center gap-1 shadow-2xs">
                      <span>Ruang Virtual</span>
                    </a>
                  @endif

                  <a href="{{ route('events.show', $reg->event->slug) }}" class="px-2.5 py-1 bg-white border border-slate-300 rounded-lg text-xs font-medium text-slate-700 hover:bg-slate-100 transition shadow-2xs">
                    Detail
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
              <div class="p-4 bg-white rounded-xl border border-slate-200 hover:border-blue-900 transition flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-2xs">
                <div class="flex items-start sm:items-center gap-3.5 min-w-0">
                  <div class="size-12 rounded-xl bg-blue-50 border border-blue-100 text-blue-950 flex items-center justify-center shrink-0">
                    <svg class="size-6 text-blue-950" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                      <circle cx="12" cy="8" r="6"/>
                      <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
                    </svg>
                  </div>
                  <div class="min-w-0 flex flex-col gap-1">
                    <div class="flex items-center gap-2 flex-wrap">
                      <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-semibold rounded-md">
                        Terverifikasi Sah
                      </span>
                      @if($cert->event && $cert->event->start_date)
                        <span class="text-[11px] text-slate-400">
                          {{ $cert->event->start_date->format('d M Y') }}
                        </span>
                      @endif
                    </div>
                    <h4 class="text-slate-900 text-sm font-semibold truncate">
                      {{ $cert->event->title ?? 'Kegiatan Laboratorium ICT' }}
                    </h4>
                    <div class="flex items-center gap-2 text-xs text-slate-500 flex-wrap">
                      <span>No. Sertifikat: <strong class="font-mono text-slate-800 font-semibold">{{ $cert->certificate_number }}</strong></span>
                      <span class="text-slate-300 hidden sm:inline">&bull;</span>
                      <span class="text-slate-400 text-[11px] font-mono" title="ID unik untuk verifikasi keabsahan dokumen">ID Keabsahan: {{ $cert->verify_hash }}</span>
                    </div>
                  </div>
                </div>

                <div class="flex items-center gap-2 self-start sm:self-auto shrink-0">
                  <a href="{{ $cert->download_url ? asset($cert->download_url) : '#' }}" target="_blank" download class="px-4 py-2 bg-blue-950 hover:bg-blue-900 text-white text-xs font-semibold rounded-xl transition flex items-center gap-2 shadow-2xs">
                    <svg class="size-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                      <polyline points="7 10 12 15 17 10"/>
                      <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    <span>Unduh PDF</span>
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
        <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-6 shadow-2xs">
          <div class="flex flex-col gap-4 pb-4 border-b border-slate-100">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
              <div>
                <h3 class="text-base font-bold text-slate-900">Jelajahi Kegiatan</h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar seminar, workshop teknologi, dan pelatihan praktikum Laboratorium ICT yang belum Anda ikuti.</p>
              </div>
              <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-900 border border-blue-100 self-start sm:self-auto">
                {{ $availableEvents->count() }} Kegiatan Tersedia
              </span>
            </div>

            <form action="{{ route('peserta.dashboard') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2 pt-1">
              <input type="hidden" name="tab" value="kegiatan">
              <div class="relative flex-1 w-full">
                <input
                  type="text"
                  name="q"
                  value="{{ request('q') }}"
                  placeholder="Cari topik kegiatan atau rumpun ilmu..."
                  class="w-full pl-9 pr-3.5 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-950 focus:bg-white transition"
                >
                <svg class="size-4 text-slate-400 absolute left-3 top-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="11" cy="11" r="8"/>
                  <path d="m21 21-4.35-4.35"/>
                </svg>
              </div>
              <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-semibold transition cursor-pointer shadow-2xs shrink-0">
                Cari
              </button>
              @if(request('q'))
                <a href="{{ route('peserta.dashboard', ['tab' => 'kegiatan']) }}" class="px-3 py-2 text-xs font-semibold text-rose-600 hover:underline shrink-0">
                  Reset
                </a>
              @endif
            </form>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($availableEvents as $avEvent)
              @php
                $todayDate = \Carbon\Carbon::today()->toDateString();
                $isPassed = $avEvent->status === 'completed' || ($avEvent->end_date ? $avEvent->end_date->toDateString() < $todayDate : ($avEvent->start_date ? $avEvent->start_date->toDateString() < $todayDate : false));
                $avRemaining = max(0, $avEvent->quota - ($avEvent->registrations_count ?? 0));
                $isAvFull = $avEvent->quota > 0 && ($avEvent->registrations_count ?? 0) >= $avEvent->quota;
              @endphp
              <div class="p-4.5 rounded-xl border flex flex-col justify-between gap-4 transition {{ $isPassed ? 'bg-slate-50/70 border-slate-200 opacity-80 hover:opacity-100' : 'bg-white border-slate-200 hover:border-blue-950 hover:shadow-xs' }}">
                <div class="flex flex-col gap-2.5">
                  <div class="flex items-center justify-between gap-2 flex-wrap">
                    <div class="flex items-center gap-1.5 flex-wrap">
                      @if($isPassed)
                        <span class="px-2 py-0.5 bg-slate-200 text-slate-700 text-[10px] font-bold rounded">
                          Kegiatan Telah Terlewat
                        </span>
                      @elseif($isAvFull)
                        <span class="px-2 py-0.5 bg-rose-50 text-rose-700 text-[10px] font-bold rounded border border-rose-200">
                          Penuh
                        </span>
                      @elseif($avRemaining <= 5 && $avRemaining > 0)
                        <span class="px-2 py-0.5 bg-amber-50 text-amber-800 text-[10px] font-bold rounded border border-amber-200">
                          Sisa {{ $avRemaining }} Kuota
                        </span>
                      @else
                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded border border-emerald-200">
                          Dibuka
                        </span>
                      @endif
                      <span class="px-2 py-0.5 bg-slate-100 text-slate-700 text-[10px] font-medium rounded uppercase">
                        {{ $avEvent->format }}
                      </span>
                      @if($avEvent->category)
                        <span class="px-2 py-0.5 bg-blue-50 text-blue-900 text-[10px] font-medium rounded">
                          {{ $avEvent->category }}
                        </span>
                      @endif
                      @if(($avEvent->organizer_type ?? 'internal') === 'partner')
                        <span class="px-2 py-0.5 bg-purple-50 text-purple-700 text-[10px] font-semibold rounded">
                          Partner: {{ $avEvent->organizer_name }}
                        </span>
                      @endif
                    </div>
                    <span class="text-xs font-bold {{ $isPassed ? 'text-slate-400' : 'text-blue-950' }}">
                      {{ $avEvent->price == 0 ? 'Gratis' : 'Rp ' . number_format($avEvent->price, 0, ',', '.') }}
                    </span>
                  </div>

                  <a href="{{ route('events.show', $avEvent->slug) }}" class="text-sm font-semibold transition line-clamp-2 {{ $isPassed ? 'text-slate-600 hover:text-slate-900' : 'text-slate-900 hover:text-blue-950' }}">
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

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                  @if($isPassed)
                    <span class="text-[11px] text-slate-400 font-medium">
                      Pendaftaran Ditutup
                    </span>
                    <a href="{{ route('events.show', $avEvent->slug) }}" class="px-3.5 py-1.5 bg-white border border-slate-200 hover:bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold transition flex items-center gap-1 shadow-2xs">
                      <span>Lihat Detail Sesi</span>
                      <span class="text-sm">&rarr;</span>
                    </a>
                  @elseif($isAvFull)
                    <span class="text-[11px] font-semibold text-rose-700">
                      Kuota Penuh
                    </span>
                    <a href="{{ route('events.show', $avEvent->slug) }}" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition flex items-center gap-1">
                      <span>Lihat Sesi</span>
                      <span class="text-sm">&rarr;</span>
                    </a>
                  @elseif($avRemaining <= 5 && $avRemaining > 0)
                    <span class="text-[11px] font-semibold text-amber-700">
                      Sisa {{ $avRemaining }} kuota
                    </span>
                    <a href="{{ route('events.register.form', $avEvent->slug) }}" class="px-3.5 py-1.5 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-semibold transition flex items-center gap-1 shadow-2xs">
                      <span>Daftar Sesi</span>
                      <span class="text-sm">&rarr;</span>
                    </a>
                  @else
                    <span class="text-[11px] text-emerald-700 font-medium">
                      Pendaftaran Terbuka
                    </span>
                    <a href="{{ route('events.register.form', $avEvent->slug) }}" class="px-3.5 py-1.5 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-semibold transition flex items-center gap-1 shadow-2xs">
                      <span>Daftar Sesi</span>
                      <span class="text-sm">&rarr;</span>
                    </a>
                  @endif
                </div>
              </div>
            @empty
              <div class="col-span-full p-8 bg-slate-50 rounded-xl text-center text-xs text-slate-500">
                @if(request('q'))
                  Tidak ada kegiatan yang sesuai dengan pencarian "{{ request('q') }}". Silakan gunakan kata kunci lain.
                @else
                  Anda telah terdaftar pada seluruh kegiatan yang sedang aktif saat ini.
                @endif
              </div>
            @endforelse
          </div>
        </div>
      @endif

      @if($tab === 'profil')
        <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-6 shadow-2xs">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-3">
            <div>
              <h3 class="text-base font-bold text-slate-900">Profil Peserta</h3>
              <p class="text-xs text-slate-500 mt-0.5">Kelola data profil, NIM/NIP, asal instansi, dan keamanan kata sandi akun Anda.</p>
            </div>
            <div class="flex items-center gap-2 text-xs">
              <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-900 border border-blue-100">
                Role: Peserta
              </span>
            </div>
          </div>

          <form action="{{ route('peserta.profile.update') }}" method="POST" class="flex flex-col gap-6">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-4">
              <h4 class="text-xs font-semibold text-slate-900 uppercase tracking-wider">Informasi Pribadi & Kontak</h4>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex flex-col gap-1.5">
                  <label for="name" class="text-xs font-semibold text-slate-700">Nama Lengkap <span class="text-rose-500">*</span></label>
                  <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required
                    class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-950 focus:ring-1 focus:ring-blue-950"
                  >
                </div>

                <div class="flex flex-col gap-1.5">
                  <label for="nik" class="text-xs font-semibold text-slate-700">NIM / NIP</label>
                  <input
                    type="text"
                    id="nik"
                    name="nik"
                    value="{{ old('nik', $user->nik) }}"
                    maxlength="20"
                    placeholder="Contoh: 2210511001"
                    class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-950 focus:ring-1 focus:ring-blue-950 font-mono"
                  >
                  <span class="text-[10px] text-slate-400">Nomor Induk Mahasiswa atau Pegawai untuk kebutuhan sertifikat resmi.</span>
                </div>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex flex-col gap-1.5">
                  <label for="email" class="text-xs font-semibold text-slate-700">Alamat Email</label>
                  <input
                    type="email"
                    id="email"
                    value="{{ $user->email }}"
                    disabled
                    class="w-full px-3.5 py-2.5 bg-slate-100 border border-slate-200 rounded-lg text-xs text-slate-500 cursor-not-allowed font-mono"
                  >
                  <span class="text-[10px] text-slate-400">Alamat email terdaftar tidak dapat diubah secara mandiri.</span>
                </div>

                <div class="flex flex-col gap-1.5">
                  <label for="phone" class="text-xs font-semibold text-slate-700">Nomor WhatsApp / HP</label>
                  <input
                    type="text"
                    id="phone"
                    name="phone"
                    value="{{ old('phone', $user->phone) }}"
                    placeholder="Contoh: 081234567890"
                    class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-950 focus:ring-1 focus:ring-blue-950 font-mono"
                  >
                </div>
              </div>

              <div class="flex flex-col gap-1.5">
                <label for="institution" class="text-xs font-semibold text-slate-700">Asal Instansi</label>
                <input
                  type="text"
                  id="institution"
                  name="institution"
                  value="{{ old('institution', $user->institution) }}"
                  placeholder="Contoh: Universitas Budi Luhur"
                  class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-950 focus:ring-1 focus:ring-blue-950"
                >
              </div>
            </div>

            <div class="pt-4 border-t border-slate-200 flex flex-col gap-4">
              <div>
                <h4 class="text-xs font-semibold text-slate-900 uppercase tracking-wider">Keamanan & Ubah Kata Sandi</h4>
                <p class="text-[11px] text-slate-500 mt-0.5">Biarkan kosong jika Anda tidak ingin mengganti kata sandi akun.</p>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex flex-col gap-1.5">
                  <label for="password" class="text-xs font-semibold text-slate-700">Kata Sandi Baru</label>
                  <input
                    type="password"
                    id="password"
                    name="password"
                    autocomplete="new-password"
                    placeholder="Minimal 8 karakter"
                    class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-950 focus:ring-1 focus:ring-blue-950"
                  >
                </div>

                <div class="flex flex-col gap-1.5">
                  <label for="password_confirmation" class="text-xs font-semibold text-slate-700">Ulangi Kata Sandi Baru</label>
                  <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    autocomplete="new-password"
                    placeholder="Konfirmasi kata sandi baru"
                    class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-950 focus:ring-1 focus:ring-blue-950"
                  >
                </div>
              </div>
            </div>

            <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
              <a href="{{ route('peserta.dashboard', ['tab' => 'dashboard']) }}" class="px-4 py-2 border border-slate-300 rounded-lg text-xs font-medium text-slate-700 hover:bg-slate-50 transition">
                Batal
              </a>
              <button
                type="submit"
                class="px-5 py-2.5 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-semibold transition cursor-pointer shadow-2xs"
              >
                Simpan Perubahan Profil
              </button>
            </div>
          </form>
        </div>
      @endif
    </main>
  </div>
</div>

<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
function payWithSnap(registrationId, existingToken) {
  if (existingToken && existingToken !== '') {
    triggerSnapPay(existingToken, registrationId);
    return;
  }

  const btn = document.getElementById('pay-btn-' + registrationId);
  const originalText = btn ? btn.innerHTML : '';
  if (btn) {
    btn.disabled = true;
    btn.innerHTML = '<span>Memuat...</span>';
  }

  fetch('/pembayaran/' + registrationId + '/snap-token', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json'
    }
  })
  .then(res => res.json())
  .then(data => {
    if (btn) {
      btn.disabled = false;
      btn.innerHTML = originalText;
    }
    if (data.status === 'already_paid') {
      window.location.reload();
      return;
    }
    if (data.status === 'success' && data.snap_token) {
      triggerSnapPay(data.snap_token, registrationId);
    } else {
      alert(data.message || 'Gagal memuat sesi pembayaran.');
    }
  })
  .catch(err => {
    if (btn) {
      btn.disabled = false;
      btn.innerHTML = originalText;
    }
  });
}

function triggerSnapPay(snapToken, registrationId) {
  if (typeof window.snap === 'undefined') {
    alert('Sistem pembayaran sedang disiapkan. Silakan muat ulang halaman.');
    return;
  }

  window.snap.pay(snapToken, {
    onSuccess: function(result) {
      if (registrationId) {
        checkPaymentStatus(registrationId, result.order_id, true);
      } else {
        window.location.reload();
      }
    },
    onPending: function(result) {
      if (registrationId) {
        checkPaymentStatus(registrationId, result.order_id, true);
      } else {
        window.location.reload();
      }
    },
    onError: function(result) {
      alert('Pembayaran gagal atau dibatalkan.');
    },
    onClose: function() {
    }
  });
}

function checkPaymentStatus(registrationId, orderId, showAlert) {
  fetch('/pembayaran/' + registrationId + '/check-status', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json'
    },
    body: JSON.stringify({ order_id: orderId || null })
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'paid') {
      alert(data.message || 'Pembayaran berhasil dikonfirmasi! E-Tiket Anda telah aktif.');
      window.location.reload();
    } else {
      if (showAlert !== false && showAlert !== undefined) {
        alert(data.message || 'Status pembayaran belum terkonfirmasi.');
      }
    }
  })
  .catch(err => {
    if (showAlert !== false && showAlert !== undefined) {
      alert('Gagal mengecek status pembayaran.');
    }
  });
}

document.addEventListener('DOMContentLoaded', function() {
  const urlParams = new URLSearchParams(window.location.search);
  const autoPayId = urlParams.get('pay');
  if (autoPayId) {
    const cleanUrl = new URL(window.location.href);
    cleanUrl.searchParams.delete('pay');
    window.history.replaceState({}, document.title, cleanUrl.toString());

    const payBtn = document.getElementById('pay-btn-' + autoPayId);
    if (payBtn) {
      setTimeout(function() { payBtn.click(); }, 350);
    }
  }
});
</script>
@endsection

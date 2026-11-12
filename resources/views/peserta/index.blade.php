@extends('layouts.app')

@section('title', 'Ruang Peserta — ' . $user->name . ' — Eventict')

@section('content')
<div class="min-h-screen bg-slate-50 text-slate-800 antialiased font-['Poppins'] flex flex-col">
  <header class="bg-blue-950 text-white border-b border-blue-900 sticky top-0 z-40 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-4">
      <div class="flex items-center gap-3 sm:gap-4 min-w-0">
        <a href="{{ route('home') }}" class="flex items-center shrink-0">
          <img src="{{ asset('logo_white.svg') }}" alt="Eventict" class="h-7 sm:h-8 w-auto">
        </a>

        <div class="h-6 w-px bg-white/20 hidden sm:block shrink-0"></div>

        <span class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-white/10 text-slate-200">
          Portal Peserta
        </span>
      </div>

      <div class="flex items-center gap-3 shrink-0">
        <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-lg border border-white/20 text-xs font-medium text-slate-200 hover:bg-white/10 hover:text-white transition hidden sm:inline-flex items-center gap-1.5">
          <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
            <polyline points="15 3 21 3 21 9"/>
            <line x1="10" y1="14" x2="21" y2="3"/>
          </svg>
          <span>Lihat Website</span>
        </a>

        <div class="flex items-center gap-2.5 pl-2 sm:border-l sm:border-white/15">
          <div class="size-8 rounded-lg bg-blue-900 text-white font-semibold text-xs flex items-center justify-center shrink-0">
            {{ strtoupper(substr($user->name ?? 'P', 0, 2)) }}
          </div>
          <div class="hidden lg:flex flex-col min-w-0">
            <span class="text-white text-xs font-semibold truncate max-w-[180px]">{{ $user->name }}</span>
            <span class="text-slate-400 text-[11px] truncate max-w-[180px]">{{ $user->institution ?? 'Peserta Terdaftar' }}</span>
          </div>
          <form id="logout-form-peserta" method="POST" action="{{ route('logout') }}" class="shrink-0">
            @csrf
            <button type="button" onclick="confirmLogout('logout-form-peserta')" title="Keluar" class="p-1.5 text-rose-300 hover:text-white hover:bg-rose-500/20 rounded-lg transition cursor-pointer">
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
          @if($user->identity_no)
            <span class="px-2 py-0.5 rounded text-[10px] font-medium uppercase bg-blue-50 text-blue-900 border border-blue-100">
              NIM/NIP/NIS: {{ $user->identity_no }}
            </span>
          @endif
        </div>
      </div>

      <nav class="bg-white rounded-2xl border border-slate-200 p-2 hidden md:flex flex-col gap-1 shadow-2xs">
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
    </aside>

    <main class="flex-1 flex flex-col gap-6 min-w-0 pb-24 md:pb-8">
      @if (!$user->hasVerifiedEmail())
        <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-amber-900">
          <div class="flex items-start gap-3">
            <svg class="size-4 text-amber-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <line x1="12" y1="8" x2="12" y2="12"/>
              <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div>
              <span class="font-semibold">Email Belum Diverifikasi:</span>
              <span class="text-amber-800 ml-1">Silakan verifikasi alamat email Anda (<span class="font-medium">{{ $user->email }}</span>) untuk menjamin keamanan akses akun.</span>
            </div>
          </div>
          <form method="POST" action="{{ route('verification.send') }}" class="shrink-0">
            @csrf
            <button type="submit" class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-xs font-semibold transition cursor-pointer">
              Kirim Ulang Link
            </button>
          </form>
        </div>
      @endif

      @if (session('status'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start gap-3 text-xs text-emerald-800">
          <svg class="size-4 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="20 6 9 17 4 12"/>
          </svg>
          <div class="font-medium">{{ session('status') }}</div>
        </div>
      @endif

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
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
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
        </div>

        @if($todayRegistration && $todayRegistration->event)
          <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 shadow-2xs">
            <div class="flex-1 flex flex-col gap-3">
              <div class="flex items-center gap-2 flex-wrap">
                <span class="text-xs font-semibold text-blue-950 uppercase tracking-wider">
                  Agenda Hari Ini &bull; {{ substr($todayRegistration->event->start_time, 0, 5) }} WIB
                </span>
                @php
                  $isTodayPendingExpired = $todayRegistration->payment_status === 'pending' && $todayRegistration->created_at && $todayRegistration->created_at->lt(now()->subMinutes(10));
                @endphp
                @if($todayRegistration->payment_status === 'pending')
                  @if($isTodayPendingExpired)
                    <span class="px-2 py-0.5 bg-rose-100 text-rose-800 text-[10px] font-semibold rounded-md">
                      Kedaluwarsa
                    </span>
                  @else
                    <span class="px-2 py-0.5 bg-amber-100 text-amber-800 text-[10px] font-semibold rounded-md">
                      Menunggu Pembayaran
                    </span>
                  @endif
                @elseif($todayRegistration->attendance_status === 'attended')
                  <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-semibold rounded-md">
                    Presensi Berhasil ({{ $todayRegistration->checked_in_at ? $todayRegistration->checked_in_at->format('H:i') : '' }} WIB)
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
                  @if($isTodayPendingExpired)
                    <a href="{{ route('events.register.form', $todayRegistration->event->slug) }}" class="px-3.5 py-2 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold transition flex items-center gap-1.5 shadow-2xs">
                      <span>Daftar Ulang Kegiatan &rarr;</span>
                    </a>
                    <form method="POST" action="{{ route('peserta.registration.cancel', $todayRegistration->id) }}" class="inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="px-3 py-2 bg-white hover:bg-rose-50 text-rose-700 border border-rose-200 rounded-xl text-xs font-semibold transition cursor-pointer">
                        Hapus
                      </button>
                    </form>
                  @else
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
                  @endif
                    </button>
                  </form>
                @else
                  @if($todayRegistration->event->format === 'online' && !$todayRegistration->event->isPassed())
                    @if($todayRegistration->event->virtual_meeting_url)
                      <a href="{{ $todayRegistration->event->virtual_meeting_url }}" target="_blank" class="px-3.5 py-2 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-medium transition flex items-center gap-2 shadow-2xs">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <circle cx="12" cy="12" r="10"/>
                          <polygon points="10 8 16 12 10 16 10 8"/>
                        </svg>
                        <span>Masuk Ruang Virtual</span>
                      </a>
                    @else
                      <button type="button" onclick="alert('Tautan Belum Tersedia')" class="px-3.5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-medium transition flex items-center gap-2 shadow-2xs cursor-pointer" title="Tautan Belum Tersedia">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <circle cx="12" cy="12" r="10"/>
                          <polygon points="10 8 16 12 10 16 10 8"/>
                        </svg>
                        <span>Ruang Virtual</span>
                      </button>
                    @endif
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
              @if($isTodayPendingExpired)
                <div class="p-4 bg-rose-50/80 rounded-xl border border-rose-200 flex flex-col items-center justify-center gap-2 text-center shrink-0 w-full sm:w-56">
                  <div class="size-11 rounded-full bg-rose-100 text-rose-800 flex items-center justify-center">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="12" cy="12" r="10"/>
                      <polyline points="12 6 12 12 16 14"/>
                    </svg>
                  </div>
                  <div>
                    <div class="text-xs font-bold text-rose-900">Batas Waktu Habis</div>
                    <div class="text-[11px] text-rose-700 mt-0.5 leading-tight">
                      Sesi 10 menit kedaluwarsa. Silakan daftar ulang kegiatan.
                    </div>
                  </div>
                  <a href="{{ route('events.register.form', $todayRegistration->event->slug) }}" class="w-full px-3 py-1.5 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-semibold transition text-center shadow-2xs">
                    Daftar Ulang
                  </a>
                </div>
              @else
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
                      @if($todayRegistration->event->format === 'offline')
                        Selesaikan pembayaran untuk mengaktifkan tiket dan QR Pass.
                      @else
                        Selesaikan pembayaran untuk mengaktifkan tiket kegiatan online.
                      @endif
                    </div>
                  </div>
                  <button type="button" onclick="payWithSnap('{{ $todayRegistration->id }}', '{{ $todayRegistration->snap_token }}')" class="w-full px-3 py-1.5 bg-amber-800 hover:bg-amber-900 text-white rounded-lg text-xs font-semibold transition text-center shadow-2xs cursor-pointer">
                    Bayar Sekarang
                  </button>
                </div>
              @endif
            @elseif($todayRegistration->attendance_status === 'attended')
              <div class="p-4 bg-emerald-50/70 rounded-xl border border-emerald-200 flex flex-col items-center justify-center gap-2 text-center shrink-0 w-full sm:w-52">
                <div class="size-11 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center">
                  <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"/>
                  </svg>
                </div>
                <div>
                  <div class="text-xs font-bold text-emerald-900">Presensi Terverifikasi</div>
                  <div class="text-[11px] text-emerald-700 mt-0.5">
                    {{ $todayRegistration->attended_at ? $todayRegistration->attended_at->format('H:i') . ' WIB' : 'Hadir' }}
                    @if($todayRegistration->attendance_gate)
                      &bull; {{ $todayRegistration->attendance_gate }}
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
            @elseif($todayRegistration->event->format === 'offline' && $todayRegistration->qr_pass)
              <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex flex-col items-center gap-2 text-center shrink-0 w-full sm:w-auto">
                <div class="size-28 bg-white p-2 rounded-lg border border-slate-300 flex items-center justify-center shadow-2xs">
                  <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&amp;margin=4&amp;data={{ urlencode($todayRegistration->qr_pass) }}" alt="QR Pass #{{ $todayRegistration->qr_pass }}" class="size-full object-contain rounded-md">
                </div>
                <div class="text-[11px] text-slate-500 font-medium">QR Pass Registrasi Ulang</div>
                <div class="text-blue-950 font-bold text-xs tracking-wider font-mono">#{{ $todayRegistration->qr_pass }}</div>
                <span class="text-[10px] text-slate-400">Tunjukkan ke panitia saat tiba di lokasi</span>
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
              @php
                $isOverviewPendingExpired = $reg->payment_status === 'pending' && $reg->created_at && $reg->created_at->lt(now()->subMinutes(10));
              @endphp
              <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                  @if($reg->payment_status === 'pending')
                    @if($isOverviewPendingExpired)
                      <div class="size-9 rounded-lg bg-rose-100 text-rose-800 flex items-center justify-center shrink-0">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <circle cx="12" cy="12" r="10"/>
                          <polyline points="12 6 12 12 16 14"/>
                        </svg>
                      </div>
                    @else
                      <div class="size-9 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center shrink-0">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                          <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                      </div>
                    @endif
                  @elseif($reg->event->format === 'offline')
                    <div class="size-9 rounded-lg bg-blue-100 text-blue-950 flex items-center justify-center shrink-0 font-mono font-bold text-[10px]">
                      PASS
                    </div>
                  @else
                    <div class="size-9 rounded-lg bg-blue-50 text-blue-900 flex items-center justify-center shrink-0">
                      <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="20" height="14" x="2" y="3" rx="2"/>
                        <line x1="8" x2="16" y1="21" y2="21"/>
                        <line x1="12" x2="12" y1="17" y2="21"/>
                      </svg>
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
                        @if($isOverviewPendingExpired)
                          No: {{ $reg->registration_code }} &bull; <span class="text-rose-600 font-medium">Batas Waktu Habis (Kedaluwarsa)</span>
                        @else
                          No: {{ $reg->registration_code }} &bull; Rp {{ number_format($reg->amount_paid > 0 ? $reg->amount_paid : $reg->event->price, 0, ',', '.') }} &bull; <span class="text-amber-700 font-medium">Tiket Terkunci</span>
                        @endif
                      @elseif($reg->event->format === 'offline' && $reg->qr_pass)
                        No: {{ $reg->registration_code }} &bull; Pass: #{{ $reg->qr_pass }}
                      @else
                        No: {{ $reg->registration_code }} &bull; <span class="text-slate-600 font-sans">Akses Online</span>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="flex items-center gap-1.5 self-start sm:self-auto shrink-0 flex-wrap">
                  @if($reg->payment_status === 'pending')
                    @if($isOverviewPendingExpired)
                      <a href="{{ route('events.register.form', $reg->event->slug) }}" class="px-2.5 py-1 bg-blue-950 hover:bg-blue-900 text-white rounded-md text-[10px] font-semibold transition">
                        Daftar Ulang
                      </a>
                      <form method="POST" action="{{ route('peserta.registration.cancel', $reg->id) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2 py-1 bg-white hover:bg-rose-50 text-rose-600 border border-rose-200 rounded-md text-[10px] font-medium transition cursor-pointer">
                          Hapus
                        </button>
                      </form>
                    @else
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
                    @endif
                  @else
                    @if($reg->event->format === 'offline')
                      @if($reg->is_checked_in)
                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-semibold rounded-md">
                          Check-in: Masuk
                        </span>
                      @else
                        <span class="px-2 py-0.5 bg-slate-200 text-slate-700 text-[10px] font-semibold rounded-md">
                          Check-in: Belum
                        </span>
                      @endif
                    @endif

                    @if($reg->attendance_status === 'attended')
                      <span class="px-2 py-0.5 bg-blue-100 text-blue-900 text-[10px] font-semibold rounded-md">
                        Presensi: Hadir
                      </span>
                    @else
                      <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-semibold rounded-md">
                        Presensi: Belum
                      </span>
                    @endif

                    @if($reg->payment_status === 'free' && !$reg->is_checked_in && $reg->attendance_status !== 'attended' && (!$reg->event->start_date || $reg->event->start_date->toDateString() >= now()->toDateString()))
                      <form method="POST" action="{{ route('peserta.registration.cancel', $reg->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan keikutsertaan kegiatan gratis ini? Kuota akan dialihkan ke peserta lain.');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2 py-1 bg-white hover:bg-rose-50 text-rose-600 border border-rose-200 rounded-md text-[10px] font-medium transition cursor-pointer">
                          Batal
                        </button>
                      </form>
                    @endif
                  @endif
                  @if($reg->event->format === 'offline' && $reg->qr_pass && $reg->payment_status !== 'pending')
                    <button type="button" onclick="openQrPassModal('{{ $reg->qr_pass }}', '{{ addslashes($reg->event->title) }}', '{{ $reg->registration_code }}', {{ $reg->is_checked_in ? 'true' : 'false' }})" class="px-2.5 py-1.5 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-[11px] font-medium transition flex items-center gap-1 shadow-2xs cursor-pointer" title="Tampilkan QR Pass Registrasi Ulang">
                      <svg class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="6" height="6" x="2" y="2" rx="1"/>
                        <rect width="6" height="6" x="16" y="2" rx="1"/>
                        <rect width="6" height="6" x="2" y="16" rx="1"/>
                        <path d="M10 2h4M2 10v4M10 6h4M14 10h4M10 14h4M16 14v4M16 20h4M20 16v4"/>
                      </svg>
                      <span>QR Pass</span>
                    </button>
                  @endif
                  @if($reg->event->format === 'online' && $reg->payment_status !== 'pending' && !$reg->event->isPassed())
                    @if($reg->event->virtual_meeting_url)
                      <a href="{{ $reg->event->virtual_meeting_url }}" target="_blank" class="px-2.5 py-1.5 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-[11px] font-medium transition flex items-center gap-1 shadow-2xs" title="Masuk Ruang Virtual">
                        <span>Ruang Virtual</span>
                      </a>
                    @else
                      <button type="button" onclick="alert('Tautan Belum Tersedia')" class="px-2.5 py-1.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-[11px] font-medium transition flex items-center gap-1 shadow-2xs cursor-pointer" title="Tautan Belum Tersedia">
                        <span>Ruang Virtual</span>
                      </button>
                    @endif
                  @endif
                  @if($reg->payment_status !== 'pending' && $reg->event->format === 'offline' && $reg->qr_pass)
                    <button type="button" onclick="openPrintTicketModal({{ json_encode([
                        'registration_code' => $reg->registration_code,
                        'qr_pass' => $reg->qr_pass,
                        'event_title' => $reg->event->title,
                        'event_date' => $reg->event->start_date ? $reg->event->start_date->translatedFormat('d F Y') : '—',
                        'event_time' => substr($reg->event->start_time ?? '', 0, 5) . ' - ' . substr($reg->event->end_time ?? '', 0, 5) . ' WIB',
                        'event_location' => $reg->event->location ?? 'Gedung Laboratorium ICT',
                        'event_format' => strtoupper($reg->event->format),
                        'participant_name' => $user->name,
                        'participant_nik' => $user->identity_no ?? '-',
                        'participant_institution' => $user->institution ?? 'Peserta Umum',
                        'attendance_status' => $reg->attendance_status,
                        'checked_in_at' => $reg->checked_in_at ? $reg->checked_in_at->format('d M Y, H:i') . ' WIB' : null,
                        'presence_url' => route('events.presence', $reg->event->slug),
                        'qr_url' => 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&margin=4&data=' . urlencode($reg->qr_pass),
                    ]) }})" class="px-2.5 py-1.5 bg-white border border-slate-300 rounded-lg text-[11px] font-medium text-slate-700 hover:bg-slate-100 transition shadow-2xs flex items-center gap-1 cursor-pointer" title="Cetak / Simpan Tiket PDF">
                      <svg class="size-3 text-slate-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 6 2 18 2 18 9"/>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                        <rect width="12" height="8" x="6" y="14"/>
                      </svg>
                      <span>Tiket</span>
                    </button>
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
              <a href="{{ route('peserta.dashboard', ['tab' => 'kegiatan']) }}" class="px-3.5 py-1.5 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold transition flex items-center gap-1.5 shadow-2xs">
                <span>+ Cari Acara Baru</span>
              </a>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($registrations as $reg)
              @php
                $isPassed = $reg->event->isPassed();
                $isToday = $reg->event->start_date && $reg->event->start_date->isToday();
                $isRegPendingExpired = $reg->payment_status === 'pending' && $reg->created_at && $reg->created_at->lt(now()->subMinutes(10));
              @endphp
              <div class="p-4.5 rounded-xl border border-slate-200 bg-white hover:border-blue-950 hover:shadow-xs transition flex flex-col justify-between gap-4">
                <div class="flex flex-col gap-2.5">
                  <div class="flex items-center justify-between gap-2 flex-wrap">
                    <div class="flex items-center gap-1.5 flex-wrap">
                      @if($reg->event->format === 'offline' && $reg->is_checked_in)
                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-bold rounded">
                          Check-in Masuk
                        </span>
                      @endif

                      @if($reg->payment_status === 'pending')
                        @if($isRegPendingExpired)
                          <span class="px-2 py-0.5 bg-rose-100 text-rose-800 text-[10px] font-bold rounded">
                            Kedaluwarsa
                          </span>
                        @else
                          <span class="px-2 py-0.5 bg-amber-100 text-amber-800 text-[10px] font-bold rounded">
                            Menunggu Pembayaran
                          </span>
                        @endif
                      @elseif($reg->attendance_status === 'attended')
                        <span class="px-2 py-0.5 bg-blue-100 text-blue-950 text-[10px] font-bold rounded">
                          Hadir Sesi
                        </span>
                      @elseif($isToday)
                        <span class="px-2 py-0.5 bg-slate-100 text-slate-800 text-[10px] font-bold rounded">
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

                      <span class="px-2 py-0.5 bg-slate-100 text-slate-700 text-[10px] font-medium rounded">
                        {{ $reg->event->format === 'offline' ? 'Luring' : 'Daring' }}
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
                  @if($reg->payment_status === 'pending')
                    <div class="text-[11px] text-slate-500 font-mono">
                      @if($isRegPendingExpired)
                        <span class="text-rose-600 font-medium">Batas bayar habis (10 mnt)</span>
                      @else
                        Status: <span class="text-amber-700 font-medium">Belum Bayar (Rp {{ number_format($reg->amount_paid > 0 ? $reg->amount_paid : $reg->event->price, 0, ',', '.') }})</span>
                      @endif
                    </div>
                  @elseif($reg->event->format === 'offline' && $reg->qr_pass)
                    <div class="text-[11px] text-slate-500 font-mono">
                      Pass: <strong class="text-blue-950">#{{ $reg->qr_pass }}</strong>
                    </div>
                  @endif

                  <div class="flex items-center gap-1.5 flex-wrap ml-auto">
                    @if($reg->payment_status === 'pending')
                      @if($isRegPendingExpired)
                        <a href="{{ route('events.register.form', $reg->event->slug) }}" class="px-2.5 py-1 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-semibold transition">
                          Daftar Ulang
                        </a>
                        <form method="POST" action="{{ route('peserta.registration.cancel', $reg->id) }}" class="inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="px-2 py-1 bg-white hover:bg-rose-50 text-rose-600 border border-rose-200 rounded-lg text-xs font-medium transition cursor-pointer">
                            Hapus
                          </button>
                        </form>
                      @else
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
                      @endif
                    @else
                      @if($reg->event->format === 'online' && !$reg->event->isPassed())
                        @if($reg->event->virtual_meeting_url)
                          <a href="{{ $reg->event->virtual_meeting_url }}" target="_blank" class="px-2.5 py-1 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-semibold transition flex items-center gap-1.5 shadow-2xs">
                            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                              <circle cx="12" cy="12" r="10"/>
                              <polygon points="10 8 16 12 10 16 10 8"/>
                            </svg>
                            <span>Ruang Virtual</span>
                          </a>
                        @else
                          <button type="button" onclick="alert('Tautan Belum Tersedia')" class="px-2.5 py-1 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-xs font-semibold transition flex items-center gap-1.5 shadow-2xs cursor-pointer" title="Tautan Belum Tersedia">
                            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                              <circle cx="12" cy="12" r="10"/>
                              <polygon points="10 8 16 12 10 16 10 8"/>
                            </svg>
                            <span>Ruang Virtual</span>
                          </button>
                        @endif
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
            <div class="flex items-center gap-2 self-start sm:self-auto flex-wrap">
              <button type="button" onclick="openQrScannerModal()" class="px-3.5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-semibold transition flex items-center gap-1.5 shadow-2xs cursor-pointer">
                <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect width="6" height="6" x="2" y="2" rx="1"/>
                  <rect width="6" height="6" x="16" y="2" rx="1"/>
                  <rect width="6" height="6" x="2" y="16" rx="1"/>
                  <path d="M10 2h4M2 10v4M10 6h4M14 10h4M10 14h4M16 14v4M16 20h4M20 16v4"/>
                </svg>
                <span>Scan QR Presensi</span>
              </button>
              <a href="{{ route('peserta.dashboard', ['tab' => 'kegiatan']) }}" class="px-3.5 py-2 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold transition flex items-center gap-1.5 shadow-2xs">
                <span>+ Cari Kegiatan</span>
              </a>
            </div>
          </div>

          <!-- Filter Cepat Tiket -->
          @php
            $totalCount = $registrations->count();
            $attendedCount = $registrations->where('attendance_status', 'attended')->count();
            $unattendedCount = $registrations->where('attendance_status', '!=', 'attended')->count();
          @endphp
          <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0 pt-1 border-b border-slate-100 pb-3">
            <button type="button" onclick="filterTickets('all')" id="btn-filter-all" class="ticket-filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-950 text-white transition cursor-pointer shadow-2xs flex items-center gap-1.5">
              <span>Semua</span>
              <span class="px-1.5 py-0.5 rounded-full text-[10px] bg-white/20 text-white">{{ $totalCount }}</span>
            </button>
            <button type="button" onclick="filterTickets('unattended')" id="btn-filter-unattended" class="ticket-filter-btn px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 transition cursor-pointer flex items-center gap-1.5">
              <span>Belum Hadir</span>
              <span class="px-1.5 py-0.5 rounded-full text-[10px] bg-slate-200 text-slate-700">{{ $unattendedCount }}</span>
            </button>
            <button type="button" onclick="filterTickets('attended')" id="btn-filter-attended" class="ticket-filter-btn px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 transition cursor-pointer flex items-center gap-1.5">
              <span>Sudah Presensi</span>
              <span class="px-1.5 py-0.5 rounded-full text-[10px] bg-slate-200 text-slate-700">{{ $attendedCount }}</span>
            </button>
          </div>

          <div class="flex flex-col gap-3">
            @forelse($registrations as $reg)
              @php
                $isRegPendingExpired = $reg->payment_status === 'pending' && $reg->created_at && $reg->created_at->lt(now()->subMinutes(10));
              @endphp
              <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4 min-w-0">
                  @if($reg->payment_status === 'pending')
                    @if($isRegPendingExpired)
                      <div class="size-11 rounded-xl bg-rose-100 text-rose-800 flex items-center justify-center shrink-0">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <circle cx="12" cy="12" r="10"/>
                          <polyline points="12 6 12 12 16 14"/>
                        </svg>
                      </div>
                    @else
                      <div class="size-11 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                          <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                      </div>
                    @endif
                  @elseif($reg->event->format === 'offline')
                    <div class="size-11 rounded-xl bg-blue-100 text-blue-950 flex items-center justify-center shrink-0 font-mono font-bold text-xs">
                      PASS
                    </div>
                  @else
                    <div class="size-11 rounded-xl bg-blue-50 text-blue-900 flex items-center justify-center shrink-0">
                      <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="20" height="14" x="2" y="3" rx="2"/>
                        <line x1="8" x2="16" y1="21" y2="21"/>
                        <line x1="12" x2="12" y1="17" y2="21"/>
                      </svg>
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
                        @if($isRegPendingExpired)
                          No. Tiket: {{ $reg->registration_code }} &bull; <span class="text-rose-600 font-medium">Batas Waktu Habis (Kedaluwarsa)</span>
                        @else
                          No. Tiket: {{ $reg->registration_code }} &bull; Rp {{ number_format($reg->amount_paid > 0 ? $reg->amount_paid : $reg->event->price, 0, ',', '.') }} &bull; <span class="text-amber-700 font-medium">Tiket Terkunci</span>
                        @endif
                      @elseif($reg->event->format === 'offline' && $reg->qr_pass)
                        No. Tiket: {{ $reg->registration_code }} &bull; Pass: <strong class="text-blue-950">#{{ $reg->qr_pass }}</strong>
                      @else
                        No. Tiket: {{ $reg->registration_code }} &bull; <span class="text-slate-600 font-sans">Akses Webinar Online</span>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="flex items-center gap-1.5 self-start sm:self-auto shrink-0 flex-wrap">
                  @if($reg->payment_status === 'pending')
                    @if($isRegPendingExpired)
                      <a href="{{ route('events.register.form', $reg->event->slug) }}" class="px-3 py-1 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-semibold transition">
                        Daftar Ulang
                      </a>
                      <form method="POST" action="{{ route('peserta.registration.cancel', $reg->id) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2.5 py-1 bg-white hover:bg-rose-50 text-rose-600 border border-rose-200 rounded-lg text-xs font-medium transition cursor-pointer">
                          Hapus
                        </button>
                      </form>
                    @else
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
                    @endif
                  @else
                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-semibold rounded-md">
                      {{ $reg->payment_status === 'free' ? 'Gratis' : 'Lunas' }}
                    </span>
                    @if($reg->event->format === 'offline')
                      @if($reg->is_checked_in)
                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-xs font-semibold rounded-md">
                          Check-in: Masuk
                        </span>
                      @else
                        <span class="px-2 py-0.5 bg-slate-200 text-slate-700 text-xs font-semibold rounded-md">
                          Check-in: Belum
                        </span>
                      @endif
                    @endif

                    @if($reg->attendance_status === 'attended')
                      <span class="px-2 py-0.5 bg-blue-100 text-blue-900 text-xs font-semibold rounded-md">
                        Presensi: Hadir ({{ $reg->attended_at ? $reg->attended_at->format('H:i') : '' }} WIB)
                      </span>
                    @else
                      <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-xs font-semibold rounded-md">
                        Presensi: Belum
                      </span>
                    @endif

                    @if($reg->payment_status === 'free' && !$reg->is_checked_in && $reg->attendance_status !== 'attended' && (!$reg->event->start_date || $reg->event->start_date->toDateString() >= now()->toDateString()))
                      <form method="POST" action="{{ route('peserta.registration.cancel', $reg->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan keikutsertaan kegiatan gratis ini? Kuota akan dialihkan ke peserta lain.');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2.5 py-1 bg-white hover:bg-rose-50 text-rose-600 border border-rose-200 rounded-lg text-xs font-medium transition cursor-pointer">
                          Batal
                        </button>
                      </form>
                    @endif
                  @endif

                  @if($reg->event->format === 'offline' && $reg->qr_pass && $reg->payment_status !== 'pending')
                    <button type="button" onclick="openQrPassModal('{{ $reg->qr_pass }}', '{{ addslashes($reg->event->title) }}', '{{ $reg->registration_code }}', {{ $reg->is_checked_in ? 'true' : 'false' }})" class="px-2.5 py-1 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-medium transition flex items-center gap-1 shadow-2xs cursor-pointer" title="Tampilkan QR Pass Registrasi Ulang">
                      <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="6" height="6" x="2" y="2" rx="1"/>
                        <rect width="6" height="6" x="16" y="2" rx="1"/>
                        <rect width="6" height="6" x="2" y="16" rx="1"/>
                        <path d="M10 2h4M2 10v4M10 6h4M14 10h4M10 14h4M16 14v4M16 20h4M20 16v4"/>
                      </svg>
                      <span>QR Pass</span>
                    </button>
                  @endif

                  @if($reg->event->format === 'online' && $reg->payment_status !== 'pending' && !$reg->event->isPassed())
                    @if($reg->event->virtual_meeting_url)
                      <a href="{{ $reg->event->virtual_meeting_url }}" target="_blank" class="px-2.5 py-1 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-medium transition flex items-center gap-1 shadow-2xs">
                        <span>Ruang Virtual</span>
                      </a>
                    @else
                      <button type="button" onclick="alert('Tautan Belum Tersedia')" class="px-2.5 py-1 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-xs font-medium transition flex items-center gap-1 shadow-2xs cursor-pointer" title="Tautan Belum Tersedia">
                        <span>Ruang Virtual</span>
                      </button>
                    @endif
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

            <div id="ticket-empty-filter" class="hidden p-8 bg-slate-50 rounded-xl text-center text-xs text-slate-500">
              Tidak ada tiket yang sesuai dengan filter yang dipilih.
            </div>
          </div>
        </div>
      @endif

      @if($tab === 'sertifikat')
        <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-5 shadow-2xs">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
              <h3 class="text-sm sm:text-base font-bold text-slate-900">E-Sertifikat</h3>
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
                $isPassed = $avEvent->isPassed();
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
                      <span class="px-2 py-0.5 bg-slate-100 text-slate-700 text-[10px] font-medium rounded">
                        {{ $avEvent->format === 'offline' ? 'Luring' : 'Daring' }}
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
              <p class="text-xs text-slate-500 mt-0.5">Kelola data profil, NIM/NIP/NIS, asal instansi, dan keamanan kata sandi akun Anda.</p>
            </div>
          </div>

          @if($user->pending_email)
            <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-amber-900 shadow-2xs">
              <div class="flex items-start gap-3">
                <svg class="size-4 text-amber-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="12" cy="12" r="10"/>
                  <line x1="12" y1="8" x2="12" y2="12"/>
                  <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <div class="flex flex-col gap-0.5">
                  <span class="font-bold">Permintaan Perubahan Email Menunggu Verifikasi</span>
                  <p class="text-amber-800 text-[11px] leading-relaxed">
                    Tautan verifikasi telah dikirimkan ke <strong class="font-mono">{{ $user->pending_email }}</strong>. Alamat email login aktif Anda tetap <strong class="font-mono">{{ $user->email }}</strong> sampai email baru berhasil diverifikasi.
                  </p>
                </div>
              </div>
              <div class="flex items-center gap-2 shrink-0">
                <form method="POST" action="{{ route('peserta.profile.email.resend') }}" class="inline">
                  @csrf
                  <button type="submit" class="px-3 py-1.5 bg-amber-700 hover:bg-amber-800 text-white rounded-lg text-xs font-semibold transition cursor-pointer">
                    Kirim Ulang
                  </button>
                </form>
                <form method="POST" action="{{ route('peserta.profile.email.cancel') }}" onsubmit="return confirm('Batalkan permintaan perubahan alamat email ini?');" class="inline">
                  @csrf
                  <button type="submit" class="px-3 py-1.5 bg-white border border-amber-300 hover:bg-amber-100 text-amber-900 rounded-lg text-xs font-semibold transition cursor-pointer">
                    Batalkan
                  </button>
                </form>
              </div>
            </div>
          @endif

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
                  <label for="identity_no" class="text-xs font-semibold text-slate-700">NIM / NIP / NIS <span class="text-rose-500">*</span></label>
                  <input
                    type="text"
                    id="identity_no"
                    name="identity_no"
                    value="{{ old('identity_no', $user->identity_no) }}"
                    required
                    maxlength="20"
                    placeholder="Contoh: 2210511001"
                    class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-950 focus:ring-1 focus:ring-blue-950 font-mono"
                  >
                  <span class="text-[10px] text-slate-400">Nomor Induk Mahasiswa, Pegawai, atau Siswa untuk kebutuhan sertifikat resmi.</span>
                </div>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex flex-col gap-1.5">
                  <label for="email" class="text-xs font-semibold text-slate-700">Alamat Email <span class="text-rose-500">*</span></label>
                  <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email', $user->pending_email ?? $user->email) }}"
                    required
                    placeholder="nama@email.com"
                    class="w-full px-3.5 py-2.5 bg-white border @error('email') border-rose-300 focus:border-rose-500 @else border-slate-300 focus:border-blue-950 focus:ring-1 focus:ring-blue-950 @enderror rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none font-mono transition"
                  >
                  <span class="text-[10px] text-slate-400">Email baru hanya akan aktif dan menggantikan email login setelah tautan verifikasi pada email baru diklik.</span>
                  @error('email')
                    <span class="text-[10px] text-rose-600 font-medium">{{ $message }}</span>
                  @enderror
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

<div id="modal-qr-scanner" class="fixed inset-0 z-50 bg-black/75 backdrop-blur-xs hidden items-center justify-center p-3 sm:p-4 overflow-y-auto">
  <div class="bg-white rounded-3xl max-w-md w-full p-5 sm:p-6 flex flex-col gap-4 shadow-2xl my-auto">
    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
      <h2 class="text-base font-bold text-slate-900">Scan QR Presensi Kegiatan</h2>
      <button type="button" onclick="closeQrScannerModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 cursor-pointer">
        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"/>
          <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>

    <div id="scanner-view-container" class="flex flex-col gap-3">
      <div class="relative w-full aspect-square bg-slate-950 rounded-2xl overflow-hidden border border-slate-200 flex items-center justify-center">
        <div id="qr-reader" class="w-full h-full"></div>
        <div id="scanner-loading" class="absolute inset-0 flex flex-col items-center justify-center gap-2 bg-slate-900 text-white text-xs p-4 text-center">
          <svg class="size-6 text-slate-400 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
          </svg>
          <span id="scanner-loading-text" class="text-slate-300 text-[11px]">Menyiapkan kamera...</span>
        </div>
      </div>
    </div>

    <div id="scanner-processing" class="hidden flex-col items-center justify-center gap-3 py-8 text-center">
      <svg class="size-8 text-blue-950 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
      </svg>
      <div class="text-xs font-bold text-slate-900">Memverifikasi Presensi Kehadiran...</div>
      <div class="text-[11px] text-slate-500">Mohon tunggu sebentar selagi kehadiran Anda divalidasi.</div>
    </div>

    <div id="scanner-result" class="hidden flex-col items-center gap-4 text-center py-2">
      <div id="scanner-result-icon" class="size-16 rounded-full flex items-center justify-center"></div>
      <div class="flex flex-col gap-1">
        <h3 id="scanner-result-title" class="text-base font-bold text-slate-900"></h3>
        <p id="scanner-result-message" class="text-xs text-slate-600 leading-relaxed"></p>
      </div>
      <div id="scanner-result-details" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 hidden"></div>
      <div class="w-full flex items-center gap-2 pt-2">
        <button type="button" id="scanner-action-btn" onclick="closeQrScannerModal(true)" class="flex-1 py-2.5 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold transition cursor-pointer">
          Tutup & Muat Ulang
        </button>
        <button type="button" id="scanner-retry-btn" onclick="restartQrScanner()" class="hidden py-2.5 px-4 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 rounded-xl text-xs font-semibold transition cursor-pointer">
          Scan Ulang
        </button>
      </div>
    </div>
  </div>
</div>

@if($registrations->contains(fn($r) => $r->event && $r->event->format === 'offline' && $r->qr_pass))
<div id="modal-qr-pass-viewer" onclick="if(event.target === this) closeQrPassModal()" class="fixed inset-0 z-50 bg-black/75 backdrop-blur-xs hidden items-center justify-center p-3 sm:p-4 overflow-y-auto">
  <div class="bg-white rounded-3xl max-w-sm w-full p-6 flex flex-col items-center gap-4 shadow-2xl my-auto text-center">
    <div class="flex items-center justify-between w-full pb-3 border-b border-slate-100">
      <div class="text-left">
        <h2 class="text-base font-bold text-slate-900">QR Pass Peserta</h2>
        <p class="text-xs text-slate-500">Tiket Masuk Acara Offline</p>
      </div>
      <button type="button" onclick="closeQrPassModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 cursor-pointer">
        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"/>
          <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>

    <div class="w-full text-left">
      <div id="qrpass-event-title" class="text-sm font-bold text-slate-900 truncate"></div>
      <div class="text-xs text-slate-500 font-mono mt-0.5" id="qrpass-reg-code"></div>
    </div>

    <div class="size-52 bg-white p-3 rounded-2xl border-2 border-dashed border-slate-200 flex items-center justify-center shadow-inner">
      <img id="qrpass-img" src="" alt="QR Pass" class="size-full object-contain rounded-lg">
    </div>

    <div>
      <div class="text-blue-950 font-bold text-base tracking-wider font-mono" id="qrpass-code"></div>
      <div id="qrpass-status-badge" class="mt-1"></div>
    </div>

    <p class="text-[11px] text-slate-500 leading-relaxed max-w-xs">
      Tunjukkan kode QR ini kepada panitia saat tiba di lokasi kegiatan untuk check-in masuk.
    </p>

    <button type="button" onclick="closeQrPassModal()" class="w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition cursor-pointer">
      Tutup
    </button>
  </div>
</div>

<div id="modal-print-ticket" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-3 sm:p-4 overflow-y-auto">
  <div class="bg-white rounded-3xl max-w-xl w-full flex flex-col shadow-2xl my-auto overflow-hidden">
    <div class="no-print p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/80">
      <div class="flex items-center gap-2">
        <div class="size-8 rounded-lg bg-blue-950 text-white flex items-center justify-center font-bold text-xs">
          PASS
        </div>
        <div>
          <h3 class="text-sm font-bold text-slate-900">E-Tiket & Boarding Pass</h3>
          <p class="text-[11px] text-slate-500">Pratinjau tiket digital resmi kegiatan</p>
        </div>
      </div>
      <button type="button" onclick="closePrintTicketModal()" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-200/60 transition cursor-pointer">
        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"/>
          <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>

    <div id="printable-ticket-content" class="p-6 sm:p-8 flex flex-col gap-5 bg-white text-slate-900">
      <div class="flex items-center justify-between pb-4 border-b-2 border-dashed border-slate-200">
        <div class="flex items-center gap-2.5">
          <img src="{{ asset('logo_blue.svg') }}" alt="Eventict" class="h-8 w-auto">
        </div>
        <div class="text-right">
          <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-blue-950 border border-blue-200 block">
            E-Tiket Resmi
          </span>
          <span id="ticket-modal-format" class="text-[10px] font-semibold text-slate-500 uppercase mt-1 block"></span>
        </div>
      </div>

      <div class="flex flex-col gap-1.5">
        <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Kegiatan Terdaftar</span>
        <h2 id="ticket-modal-title" class="text-base sm:text-lg font-bold text-slate-900 leading-snug"></h2>
      </div>

      <div class="grid grid-cols-2 gap-3 p-3.5 bg-slate-50 rounded-xl border border-slate-200 text-xs">
        <div class="flex flex-col">
          <span class="text-[10px] text-slate-500 uppercase font-medium">Tanggal Pelaksanaan</span>
          <span id="ticket-modal-date" class="font-semibold text-slate-900 mt-0.5"></span>
        </div>
        <div class="flex flex-col">
          <span class="text-[10px] text-slate-500 uppercase font-medium">Waktu Sesi</span>
          <span id="ticket-modal-time" class="font-semibold text-slate-900 mt-0.5"></span>
        </div>
        <div class="col-span-2 flex flex-col pt-2 border-t border-slate-200">
          <span class="text-[10px] text-slate-500 uppercase font-medium">Lokasi / Ruang</span>
          <span id="ticket-modal-location" class="font-semibold text-slate-900 mt-0.5 truncate"></span>
        </div>
      </div>

      <div class="grid grid-cols-3 gap-2 py-2 text-xs border-y border-slate-100">
        <div class="flex flex-col">
          <span class="text-[10px] text-slate-400 font-medium">Nama Peserta</span>
          <span id="ticket-modal-name" class="font-semibold text-slate-900 truncate"></span>
        </div>
        <div class="flex flex-col">
          <span class="text-[10px] text-slate-400 font-medium">NIM / NIP / NIS</span>
          <span id="ticket-modal-nik" class="font-mono text-slate-800 text-[11px] truncate"></span>
        </div>
        <div class="flex flex-col">
          <span class="text-[10px] text-slate-400 font-medium">Instansi</span>
          <span id="ticket-modal-institution" class="font-medium text-slate-800 truncate"></span>
        </div>
      </div>

      <div class="rounded-2xl text-white shadow-md overflow-hidden flex flex-col" style="background-color: #03194a !important; color: #ffffff !important; font-family: 'Poppins', sans-serif !important;">
        <div class="px-4 sm:px-5 py-3 flex items-center justify-between gap-3" style="background-color: rgba(255, 255, 255, 0.06); border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
          <div class="flex items-center gap-2">
            <svg class="size-4 text-blue-300 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            <span class="text-xs font-semibold text-blue-100 uppercase tracking-wider font-['Poppins']">Pass Presensi Resmi</span>
          </div>
          <div id="ticket-modal-status"></div>
        </div>

        <div class="p-4 sm:p-5 flex items-center gap-4">
          <div class="bg-white p-1.5 rounded-xl flex items-center justify-center shrink-0 shadow-sm" style="width: 76px; height: 76px; min-width: 76px; max-width: 76px; background-color: #ffffff !important;">
            <img id="ticket-modal-qr" src="" alt="QR Code Presensi Acara" width="68" height="68" style="width: 68px; height: 68px; object-fit: contain;">
          </div>

          <div class="flex-1 min-w-0 flex flex-col justify-center gap-0.5">
            <span class="text-[10px] text-blue-200/80 font-semibold uppercase tracking-wider font-['Poppins']">KODE PASS PESERTA</span>
            <div id="ticket-modal-pass" class="text-base sm:text-xl font-bold font-['Poppins'] text-white tracking-wide truncate"></div>
            <div id="ticket-modal-code" class="text-xs text-blue-200/90 font-['Poppins'] mt-0.5"></div>
            <div class="flex flex-wrap items-center gap-2 mt-1 pt-1.5 border-t border-white/10 text-[11px] text-blue-200/80 font-['Poppins']">
              <span>Tunjukkan saat tiba di lokasi</span>
            </div>
          </div>
        </div>
      </div>

      <div class="text-[10px] text-slate-400 text-center leading-relaxed">
        Tiket elektronik ini sah dan terhubung ke sistem registrasi Laboratorium ICT. Tunjukkan kode QR Pass ini kepada panitia untuk presensi check-in.
      </div>
    </div>

    <div class="no-print p-4 sm:p-5 border-t border-slate-100 flex items-center justify-end gap-3 bg-slate-50/80">
      <button type="button" onclick="closePrintTicketModal()" class="px-4 py-2 border border-slate-300 hover:bg-slate-100 text-slate-700 rounded-xl text-xs font-semibold transition cursor-pointer">
        Tutup
      </button>
      <button type="button" onclick="window.print()" class="px-5 py-2 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold transition flex items-center gap-2 cursor-pointer shadow-xs">
        <svg class="size-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="6 9 6 2 18 2 18 9"/>
          <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
          <rect width="12" height="8" x="6" y="14"/>
        </svg>
        <span>Cetak / Simpan PDF</span>
      </button>
    </div>
  </div>
</div>
@endif

<style>
#qr-reader {
  width: 100% !important;
  border: none !important;
}
#qr-reader video {
  width: 100% !important;
  height: 100% !important;
  object-fit: cover !important;
  border-radius: 1rem !important;
}
#qr-reader__scan_region {
  border-radius: 1rem !important;
}
</style>

<script src="{{ asset('vendor/html5-qrcode/html5-qrcode.min.js') }}"></script>
<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
function filterTickets(status) {
  const cards = document.querySelectorAll('.ticket-card');
  const emptyNotice = document.getElementById('ticket-empty-filter');
  let visibleCount = 0;

  document.querySelectorAll('.ticket-filter-btn').forEach(btn => {
    btn.className = 'ticket-filter-btn px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 transition cursor-pointer flex items-center gap-1.5';
    const badge = btn.querySelector('span:last-child');
    if (badge) badge.className = 'px-1.5 py-0.5 rounded-full text-[10px] bg-slate-200 text-slate-700';
  });

  const activeBtn = document.getElementById('btn-filter-' + status);
  if (activeBtn) {
    activeBtn.className = 'ticket-filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-950 text-white transition cursor-pointer shadow-2xs flex items-center gap-1.5';
    const badge = activeBtn.querySelector('span:last-child');
    if (badge) badge.className = 'px-1.5 py-0.5 rounded-full text-[10px] bg-white/20 text-white';
  }

  cards.forEach(card => {
    const cardStatus = card.getAttribute('data-status');
    if (status === 'all' || cardStatus === status) {
      card.style.display = 'flex';
      visibleCount++;
    } else {
      card.style.display = 'none';
    }
  });

  if (emptyNotice) {
    emptyNotice.style.display = visibleCount === 0 ? 'block' : 'none';
  }
}

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
    } else if (data.status === 'expired') {
      if (showAlert !== false && showAlert !== undefined) {
        alert(data.message || 'Batas waktu pembayaran (10 menit) telah kedaluwarsa. Silakan lakukan pendaftaran ulang.');
      }
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

let html5QrCode = null;
let isScanning = false;

function openQrScannerModal() {
  const modal = document.getElementById('modal-qr-scanner');
  if (!modal) return;
  modal.classList.remove('hidden');
  modal.classList.add('flex');
  resetScannerUI();
  startCameraScanner();
}

function closeQrScannerModal(shouldReload) {
  stopCameraScanner().then(() => {
    const modal = document.getElementById('modal-qr-scanner');
    if (modal) {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }
    if (shouldReload === true) {
      window.location.reload();
    }
  });
}

function resetScannerUI() {
  document.getElementById('scanner-view-container').classList.remove('hidden');
  document.getElementById('scanner-processing').classList.add('hidden');
  document.getElementById('scanner-processing').classList.remove('flex');
  document.getElementById('scanner-result').classList.add('hidden');
  document.getElementById('scanner-result').classList.remove('flex');
  document.getElementById('scanner-loading').classList.remove('hidden');
  document.getElementById('scanner-retry-btn').classList.add('hidden');
  document.getElementById('scanner-loading-text').textContent = 'Menyiapkan kamera...';
}

function startCameraScanner() {
  if (typeof Html5Qrcode === 'undefined') {
    document.getElementById('scanner-loading-text').textContent = 'Pustaka pemindai belum siap. Silakan muat ulang halaman.';
    return;
  }

  if (html5QrCode) {
    try {
      html5QrCode.stop().then(() => initAndStartScanner()).catch(() => initAndStartScanner());
      return;
    } catch(e) {}
  }
  initAndStartScanner();
}

function initAndStartScanner() {
  html5QrCode = new Html5Qrcode("qr-reader");
  const config = {
    fps: 10,
    qrbox: { width: 250, height: 250 }
  };

  html5QrCode.start(
    { facingMode: "environment" },
    config,
    onQrCodeSuccess,
    onQrCodeError
  ).then(() => {
    isScanning = true;
    const loadingElem = document.getElementById('scanner-loading');
    if (loadingElem) loadingElem.classList.add('hidden');
  }).catch(err => {
    const loadingText = document.getElementById('scanner-loading-text');
    if (loadingText) {
      loadingText.textContent = 'Akses kamera tidak tersedia atau izin belum diberikan.';
    }
  });
}

function stopCameraScanner() {
  if (html5QrCode && isScanning) {
    isScanning = false;
    return html5QrCode.stop().then(() => {
      try { html5QrCode.clear(); } catch(e) {}
    }).catch(() => {});
  }
  return Promise.resolve();
}

function onQrCodeSuccess(decodedText) {
  if (!isScanning) return;
  isScanning = false;

  stopCameraScanner().then(() => {
    processQrPresence(decodedText);
  });
}

function onQrCodeError(error) {
}

function processQrPresence(qrData) {
  document.getElementById('scanner-view-container').classList.add('hidden');
  document.getElementById('scanner-processing').classList.remove('hidden');
  document.getElementById('scanner-processing').classList.add('flex');

  fetch('{{ route('peserta.presence.scan') }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json'
    },
    body: JSON.stringify({ qr_data: qrData })
  })
  .then(res => res.json().then(data => ({ status: res.status, ok: res.ok, data })))
  .then(result => {
    document.getElementById('scanner-processing').classList.add('hidden');
    document.getElementById('scanner-processing').classList.remove('flex');
    showScannerResult(result.ok, result.data);
  })
  .catch(err => {
    document.getElementById('scanner-processing').classList.add('hidden');
    document.getElementById('scanner-processing').classList.remove('flex');
    showScannerResult(false, {
      status: 'error',
      message: 'Terjadi kesalahan jaringan saat memproses presensi.'
    });
  });
}

function showScannerResult(isSuccess, data) {
  const resultContainer = document.getElementById('scanner-result');
  const icon = document.getElementById('scanner-result-icon');
  const title = document.getElementById('scanner-result-title');
  const message = document.getElementById('scanner-result-message');
  const details = document.getElementById('scanner-result-details');
  const actionBtn = document.getElementById('scanner-action-btn');
  const retryBtn = document.getElementById('scanner-retry-btn');

  resultContainer.classList.remove('hidden');
  resultContainer.classList.add('flex');

  if (isSuccess && (data.status === 'success' || data.status === 'already_attended')) {
    icon.className = 'size-16 rounded-full flex items-center justify-center bg-emerald-100 text-emerald-700';
    icon.innerHTML = '<svg class="size-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>';
    title.textContent = data.status === 'already_attended' ? 'Kehadiran Sudah Tercatat' : 'Presensi Berhasil!';
    message.textContent = data.message;

    if (data.event_title) {
      details.classList.remove('hidden');
      details.innerHTML = '<div class="font-bold text-slate-900">' + data.event_title + '</div>' + 
        (data.checked_in_at ? '<div class="text-[11px] text-emerald-800 mt-1">Status: <strong>Hadir</strong> (' + data.checked_in_at + ')</div>' : '');
    }

    actionBtn.textContent = 'Selesai & Perbarui Halaman';
    actionBtn.onclick = function() { closeQrScannerModal(true); };
    retryBtn.classList.add('hidden');

    setTimeout(() => {
      closeQrScannerModal(true);
    }, 2500);
  } else {
    icon.className = 'size-16 rounded-full flex items-center justify-center bg-rose-100 text-rose-700';
    icon.innerHTML = '<svg class="size-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>';
    title.textContent = 'Presensi Belum Berhasil';
    message.textContent = data.message || 'QR Code tidak valid atau gerbang presensi ditutup.';
    details.classList.add('hidden');

    actionBtn.textContent = 'Tutup';
    actionBtn.onclick = function() { closeQrScannerModal(false); };
    retryBtn.classList.remove('hidden');
  }
}

function restartQrScanner() {
  resetScannerUI();
  startCameraScanner();
}

@if($registrations->contains(fn($r) => $r->event && $r->event->format === 'offline' && $r->qr_pass))
function openQrPassModal(qrPass, eventTitle, regCode, isCheckedIn) {
  const modal = document.getElementById('modal-qr-pass-viewer');
  if (!modal) return;
  document.getElementById('qrpass-event-title').textContent = eventTitle || 'Tiket Kegiatan Offline';
  document.getElementById('qrpass-reg-code').textContent = 'No. Registrasi: ' + (regCode || '-');
  document.getElementById('qrpass-code').textContent = '#' + qrPass;
  document.getElementById('qrpass-img').src = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&margin=4&data=' + encodeURIComponent(qrPass);

  const statusBadge = document.getElementById('qrpass-status-badge');
  if (isCheckedIn) {
    statusBadge.innerHTML = '<span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Check-in: Terverifikasi Masuk</span>';
  } else {
    statusBadge.innerHTML = '<span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">Check-in: Belum Registrasi Ulang</span>';
  }

  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closeQrPassModal() {
  const modal = document.getElementById('modal-qr-pass-viewer');
  if (!modal) return;
  modal.classList.add('hidden');
  modal.classList.remove('flex');
}

function openPrintTicketModal(data) {
  const modal = document.getElementById('modal-print-ticket');
  if (!modal) return;
  document.getElementById('ticket-modal-title').textContent = data.event_title;
  document.getElementById('ticket-modal-date').textContent = data.event_date;
  document.getElementById('ticket-modal-time').textContent = data.event_time;
  document.getElementById('ticket-modal-location').textContent = data.event_location;
  document.getElementById('ticket-modal-format').textContent = data.event_format;
  document.getElementById('ticket-modal-name').textContent = data.participant_name;
  document.getElementById('ticket-modal-nik').textContent = data.participant_nik;
  document.getElementById('ticket-modal-institution').textContent = data.participant_institution;
  document.getElementById('ticket-modal-code').textContent = 'No. Tiket: ' + data.registration_code;
  document.getElementById('ticket-modal-pass').textContent = '#' + data.qr_pass;

  const qrImg = document.getElementById('ticket-modal-qr');
  if (qrImg) {
    qrImg.src = data.qr_url || ('https://api.qrserver.com/v1/create-qr-code/?size=150x150&margin=4&data=' + encodeURIComponent(data.qr_pass));
  }

  const statusBadge = document.getElementById('ticket-modal-status');
  if (statusBadge) {
    if (data.attendance_status === 'attended') {
      statusBadge.className = 'px-3 py-1 bg-emerald-100 text-emerald-900 text-xs font-bold rounded-full whitespace-nowrap font-[\'Poppins\'] shadow-2xs';
      statusBadge.textContent = 'Sudah Presensi' + (data.checked_in_at ? ' (' + data.checked_in_at + ')' : '');
    } else {
      statusBadge.className = 'px-3 py-1 bg-blue-100 text-blue-950 text-xs font-bold rounded-full whitespace-nowrap font-[\'Poppins\'] shadow-2xs';
      statusBadge.textContent = 'Belum Presensi';
    }
  }

  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closePrintTicketModal() {
  const modal = document.getElementById('modal-print-ticket');
  if (!modal) return;
  modal.classList.add('hidden');
  modal.classList.remove('flex');
}

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeQrPassModal();
    closePrintTicketModal();
  }
});
@endif
</script>

@include('partials.peserta-bottom-nav')
@endsection

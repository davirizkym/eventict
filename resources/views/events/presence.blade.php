@extends('layouts.app')

@section('title', 'Presensi Sesi: ' . $event->title . ' — Eventict')

@section('content')
<div class="min-h-screen bg-slate-50 text-slate-800 antialiased font-['Poppins'] flex flex-col justify-between">
  @include('partials.navbar')

  <main class="flex-1 max-w-3xl w-full mx-auto px-4 sm:px-6 py-8 sm:py-12 flex flex-col gap-6">
    <div class="flex items-center gap-2 text-xs text-slate-500">
      <a href="{{ route('home') }}" class="hover:text-blue-950 font-medium">Beranda</a>
      <span>/</span>
      <a href="{{ route('events.show', $event->slug) }}" class="hover:text-blue-950 font-medium truncate max-w-xs">{{ $event->title }}</a>
      <span>/</span>
      <span class="text-slate-900 font-semibold">Presensi Sesi</span>
    </div>

    @if (session('success'))
      <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-start gap-3 text-xs text-emerald-800 shadow-2xs">
        <svg class="size-4 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="20 6 9 17 4 12"/>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
      </div>
    @endif

    @if (session('warning'))
      <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-start gap-3 text-xs text-amber-800 shadow-2xs">
        <svg class="size-4 text-amber-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/>
          <line x1="12" y1="8" x2="12" y2="12"/>
          <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <span class="font-medium">{{ session('warning') }}</span>
      </div>
    @endif

    @if (session('error'))
      <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl flex items-start gap-3 text-xs text-rose-800 shadow-2xs">
        <svg class="size-4 text-rose-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/>
          <line x1="15" y1="9" x2="9" y2="15"/>
          <line x1="9" y1="9" x2="15" y2="15"/>
        </svg>
        <span class="font-medium">{{ session('error') }}</span>
      </div>
    @endif

    <div class="bg-blue-950 text-white rounded-3xl p-6 sm:p-8 shadow-md relative overflow-hidden flex flex-col gap-4">
      <div class="flex flex-wrap items-center gap-2">
        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold uppercase tracking-wider bg-white/10 text-blue-200 border border-white/15">
          {{ $event->format }} Event
        </span>
        @if($event->category)
          <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-blue-500/20 text-blue-100 border border-blue-400/30">
            {{ $event->category }}
          </span>
        @endif
        @if($event->is_presence_open)
          <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 flex items-center gap-1.5">
            <span class="size-1.5 rounded-full bg-emerald-400"></span>
            <span>Gerbang Presensi Terbuka</span>
          </span>
        @else
          <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-500/20 text-slate-300 border border-slate-400/30">
            Gerbang Presensi Ditutup
          </span>
        @endif
      </div>

      <div>
        <h1 class="text-xl sm:text-2xl font-bold font-['Poppins'] leading-snug">{{ $event->title }}</h1>
        <p class="text-slate-300 text-xs sm:text-sm mt-1 leading-relaxed">
          Laboratorium ICT &bull; {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('l, d F Y') }} &bull; {{ substr($event->start_time, 0, 5) }} - {{ substr($event->end_time, 0, 5) }} WIB
        </p>
      </div>

      <div class="pt-3 border-t border-white/10 flex flex-wrap items-center gap-4 text-xs text-slate-300">
        <div class="flex items-center gap-1.5">
          <svg class="size-4 text-blue-300 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
            <circle cx="12" cy="10" r="3"/>
          </svg>
          <span>{{ $event->location }}</span>
        </div>
        @if($event->speakers->isNotEmpty())
          <div class="flex items-center gap-1.5">
            <svg class="size-4 text-blue-300 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
            </svg>
            <span>Narasumber: {{ $event->speakers->pluck('name')->join(', ') }}</span>
          </div>
        @endif
      </div>
    </div>

    @guest
      <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 flex flex-col items-center text-center gap-4 shadow-2xs">
        <div class="size-14 rounded-2xl bg-blue-50 text-blue-950 flex items-center justify-center">
          <svg class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
          </svg>
        </div>

        <div class="max-w-md flex flex-col gap-1">
          <h2 class="text-base sm:text-lg font-bold text-slate-900">Masuk Terlebih Dahulu</h2>
          <p class="text-xs text-slate-500 leading-relaxed">
            Untuk mengonfirmasi kehadiran mandiri pada sesi ini, silakan masuk menggunakan akun terdaftar Anda.
          </p>
        </div>

        <a href="{{ route('login') }}" class="px-6 py-3 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold shadow-xs transition flex items-center gap-2">
          <span>Masuk & Lakukan Presensi</span>
          <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14M12 5l7 7-7 7"/>
          </svg>
        </a>
      </div>
    @else
      @if(!$registration)
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 flex flex-col items-center text-center gap-4 shadow-2xs">
          <div class="size-14 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center">
            <svg class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <line x1="12" y1="8" x2="12" y2="12"/>
              <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
          </div>

          <div class="max-w-md flex flex-col gap-1">
            <h2 class="text-base sm:text-lg font-bold text-slate-900">Anda Belum Terdaftar</h2>
            <p class="text-xs text-slate-500 leading-relaxed">
              Akun <strong>{{ Auth::user()->email }}</strong> belum tercatat dalam daftar peserta kegiatan ini.
            </p>
          </div>

          <div class="flex items-center gap-3">
            <a href="{{ route('events.show', $event->slug) }}" class="px-5 py-2.5 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold shadow-xs transition">
              Lihat Informasi & Daftar
            </a>
            <a href="{{ route('peserta.dashboard') }}" class="px-4 py-2.5 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold transition">
              Portal Peserta
            </a>
          </div>
        </div>
      @elseif($registration->attendance_status === 'attended')
        <div class="bg-white rounded-3xl border border-emerald-200 p-6 sm:p-8 flex flex-col items-center text-center gap-4 shadow-2xs">
          <div class="size-16 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center">
            <svg class="size-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
          </div>

          <div class="max-w-md flex flex-col gap-1">
            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200 mx-auto">
              ✓ Kehadiran Terverifikasi
            </span>
            <h2 class="text-base sm:text-lg font-bold text-slate-900 mt-2">Presensi Selesai</h2>
            <p class="text-xs text-slate-500 leading-relaxed">
              Kehadiran atas nama <strong>{{ Auth::user()->name }}</strong> telah tercatat pada sistem pada pukul <strong>{{ $registration->checked_in_at ? $registration->checked_in_at->format('H:i') . ' WIB' : 'Hari ini' }}</strong>.
            </p>
          </div>

          <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-[11px] text-slate-600 font-mono">
            No. Tiket: {{ $registration->registration_code }} &bull; Metode: {{ $registration->check_in_gate ?: 'Presensi Mandiri' }}
          </div>

          <a href="{{ route('peserta.dashboard') }}" class="px-5 py-2.5 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold shadow-xs transition">
            Buka Portal Peserta
          </a>
        </div>
      @elseif($registration->payment_status === 'pending')
        <div class="bg-white rounded-3xl border border-amber-200 p-6 sm:p-8 flex flex-col items-center text-center gap-4 shadow-2xs">
          <div class="size-16 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center">
            <svg class="size-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
          </div>

          <div class="max-w-md flex flex-col gap-1">
            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-100 text-amber-800 border border-amber-200 mx-auto">
              Tiket Belum Aktif
            </span>
            <h2 class="text-base sm:text-lg font-bold text-slate-900 mt-2">Menunggu Pembayaran</h2>
            <p class="text-xs text-slate-500 leading-relaxed">
              Anda belum dapat melakukan presensi kehadiran karena pembayaran tiket kegiatan ini belum diselesaikan. Selesaikan pembayaran terlebih dahulu untuk mengaktifkan tiket.
            </p>
          </div>

          <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-[11px] text-slate-600 font-mono">
            No. Registrasi: {{ $registration->registration_code }} &bull; Total: Rp {{ number_format($registration->amount_paid > 0 ? $registration->amount_paid : $registration->event->price, 0, ',', '.') }}
          </div>

          <div class="flex items-center gap-3">
            <a href="{{ route('peserta.dashboard', ['tab' => 'tiket', 'pay' => $registration->id]) }}" class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-semibold shadow-xs transition">
              Selesaikan Pembayaran Sekarang
            </a>
            <a href="{{ route('peserta.dashboard') }}" class="px-4 py-2.5 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold transition">
              Portal Peserta
            </a>
          </div>
        </div>
      @elseif(!$event->is_presence_open)
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 flex flex-col items-center text-center gap-4 shadow-2xs">
          <div class="size-14 rounded-2xl bg-slate-100 text-slate-500 flex items-center justify-center">
            <svg class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
          </div>

          <div class="max-w-md flex flex-col gap-1">
            <h2 class="text-base sm:text-lg font-bold text-slate-900">Gerbang Presensi Sedang Ditutup</h2>
            <p class="text-xs text-slate-500 leading-relaxed">
              Panitia belum membuka sesi presensi mandiri atau waktu presensi telah selesai. Nantikan instruksi dari panitia/moderator pada saat sesi berlangsung, lalu muat ulang halaman ini.
            </p>
          </div>

          <div class="flex items-center gap-3">
            <button type="button" onclick="window.location.reload()" class="px-5 py-2.5 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold shadow-xs transition cursor-pointer">
              Muat Ulang Halaman
            </button>
            <a href="{{ route('peserta.dashboard') }}" class="px-4 py-2.5 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold transition">
              Kembali ke Dashboard
            </a>
          </div>
        </div>
      @else
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 flex flex-col gap-6 shadow-2xs">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
            <div>
              <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                Sesi Presensi Aktif
              </span>
              <h2 class="text-base sm:text-lg font-bold text-slate-900 mt-2">Konfirmasi Kehadiran Peserta</h2>
              <p class="text-xs text-slate-500">Pastikan data pendaftaran di bawah ini sudah sesuai sebelum menekan tombol konfirmasi.</p>
            </div>
            <div class="size-11 rounded-xl bg-blue-50 text-blue-950 flex items-center justify-center shrink-0">
              <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <polyline points="16 11 18 13 22 9"/>
              </svg>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 flex flex-col gap-0.5">
              <span class="text-[11px] text-slate-400">Nama Lengkap</span>
              <span class="font-semibold text-slate-900 text-sm">{{ Auth::user()->name }}</span>
            </div>
            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 flex flex-col gap-0.5">
              <span class="text-[11px] text-slate-400">Alamat Email</span>
              <span class="font-semibold text-slate-900 text-sm">{{ Auth::user()->email }}</span>
            </div>
            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 flex flex-col gap-0.5">
              <span class="text-[11px] text-slate-400">Nomor Registrasi / Tiket</span>
              <span class="font-semibold text-blue-950 font-mono text-sm">{{ $registration->registration_code }}</span>
            </div>
            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 flex flex-col gap-0.5">
              <span class="text-[11px] text-slate-400">Institusi / Afiliasi</span>
              <span class="font-semibold text-slate-900 text-sm">{{ Auth::user()->institution ?: '-' }}</span>
            </div>
          </div>

          <form action="{{ route('events.presence_submit', $event->slug) }}" method="POST" class="flex flex-col gap-3 pt-2">
            @csrf
            <button type="submit" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-2xl text-xs sm:text-sm font-semibold shadow-xs transition flex items-center justify-center gap-2 cursor-pointer">
              <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12"/>
              </svg>
              <span>Konfirmasi Kehadiran Saya Sekarang</span>
            </button>
            <p class="text-[11px] text-slate-400 text-center">
              Waktu presensi akan otomatis direkam dan status pendaftaran Anda berubah menjadi Hadir.
            </p>
          </form>
        </div>
      @endif
    @endguest
  </main>

  @include('partials.footer')
</div>
@endsection

@extends('layouts.app')

@section('title', $event->title . ' — Ruang Kerja Penyelenggara Eventict')

@section('content')
<div class="min-h-screen bg-slate-50 text-slate-800 antialiased font-['Poppins'] flex flex-col">
  <header class="bg-blue-950 text-white border-b border-blue-900 sticky top-0 z-40 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-4">
      <div class="flex items-center gap-6 sm:gap-8">
        <a href="{{ route('organizer.dashboard') }}" class="flex items-center gap-3 group">
          <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-blue-950 font-bold shadow-xs">
            <svg class="w-5 h-5 text-blue-950" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
              <path d="M6 6h10"/>
              <path d="M6 10h7"/>
            </svg>
          </div>
          <div class="flex flex-col">
            <span class="text-white text-base font-semibold leading-tight tracking-tight">Eventict</span>
            <span class="text-blue-200 text-xs font-normal">Organizer Hub</span>
          </div>
        </a>

        <nav class="hidden md:flex items-center gap-2">
          <a href="{{ route('organizer.dashboard') }}" class="px-3.5 py-2 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-white/5 transition flex items-center gap-2">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect width="18" height="18" x="3" y="3" rx="2"/>
              <path d="M3 9h18"/>
              <path d="M9 21V9"/>
            </svg>
            <span>Semua Kegiatan</span>
          </a>
          <a href="{{ route('organizer.categories.index') }}" class="px-3.5 py-2 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-white/5 transition flex items-center gap-2">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M4 6h16M4 12h16M4 18h7"/>
            </svg>
            <span>Kategori</span>
          </a>
          <a href="{{ route('organizer.speakers.index') }}" class="px-3.5 py-2 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-white/5 transition flex items-center gap-2">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <span>Pengisi Acara</span>
          </a>
          <a href="{{ route('organizer.media_partners.index') }}" class="px-3.5 py-2 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-white/5 transition flex items-center gap-2">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="m3 11 18-5v12L3 14v-3z"/>
              <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>
            </svg>
            <span>Media Partner</span>
          </a>
        </nav>
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

  <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-2">
    <div class="flex items-center gap-2 text-xs text-slate-500">
      <a href="{{ route('organizer.dashboard') }}" class="hover:text-blue-950 font-medium">Portal Pengelola</a>
      <span>/</span>
      <a href="{{ route('organizer.dashboard') }}" class="hover:text-blue-950 font-medium">Semua Kegiatan</a>
      <span>/</span>
      <span class="text-slate-900 font-semibold truncate">{{ $event->title }}</span>
    </div>
  </div>

  <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 pb-8 flex-1 flex flex-col md:flex-row gap-6">
    <aside class="w-full md:w-64 shrink-0 flex flex-col gap-4">
      <div class="bg-white rounded-2xl border border-slate-200 p-4 flex flex-col gap-2 shadow-2xs">
        <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Kegiatan Terpilih</span>
        <h2 class="text-xs sm:text-sm font-bold text-slate-900 leading-snug">{{ $event->title }}</h2>
        <div class="flex items-center gap-1.5 mt-1 flex-wrap">
          @if(!empty($event->type))
            <span class="px-2 py-0.5 rounded text-[10px] font-semibold uppercase bg-blue-100 text-blue-900 border border-blue-200">
              {{ $event->type }}
            </span>
          @endif
          @if(!empty($event->category))
            <span class="px-2 py-0.5 rounded text-[10px] font-medium uppercase bg-slate-100 text-slate-700">
              {{ $event->category }}
            </span>
          @endif
          <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-blue-50 text-blue-900 border border-blue-100">
            {{ $event->format === 'offline' ? 'Luring' : 'Daring' }}
          </span>
          @if(($event->organizer_type ?? 'internal') === 'partner')
            <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-purple-50 text-purple-700 border border-purple-200">
              Penyelenggara: {{ $event->organizer_name }}
            </span>
          @else
            <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-50 text-slate-700 border border-slate-200">
              Penyelenggara: Laboratorium ICT
            </span>
          @endif
          @if($event->quota > 0 && $totalRegistrations >= $event->quota)
            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
              Kuota Penuh
            </span>
          @endif
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
        <div class="px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center justify-between gap-3 text-xs text-emerald-800 shadow-2xs">
          <div class="flex items-center gap-2.5">
            <svg class="size-4 text-emerald-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
          </div>
          <button type="button" onclick="this.closest('div').remove()" class="text-emerald-600 hover:text-emerald-900 cursor-pointer p-0.5">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="18" y1="6" x2="6" y2="18"/>
              <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
          </button>
        </div>
      @endif

      @if (session('warning'))
        <div class="px-4 py-3 bg-amber-50 border border-amber-200 rounded-xl flex items-center justify-between gap-3 text-xs text-amber-800 shadow-2xs">
          <div class="flex items-center gap-2.5">
            <svg class="size-4 text-amber-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <line x1="12" y1="8" x2="12" y2="12"/>
              <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span class="font-medium">{{ session('warning') }}</span>
          </div>
          <button type="button" onclick="this.closest('div').remove()" class="text-amber-600 hover:text-amber-900 cursor-pointer p-0.5">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="18" y1="6" x2="6" y2="18"/>
              <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
          </button>
        </div>
      @endif

      @if (session('error'))
        <div class="px-4 py-3 bg-rose-50 border border-rose-200 rounded-xl flex items-center justify-between gap-3 text-xs text-rose-800 shadow-2xs">
          <div class="flex items-center gap-2.5">
            <svg class="size-4 text-rose-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <line x1="15" y1="9" x2="9" y2="15"/>
              <line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
            <span class="font-medium">{{ session('error') }}</span>
          </div>
          <button type="button" onclick="this.closest('div').remove()" class="text-rose-600 hover:text-rose-900 cursor-pointer p-0.5">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="18" y1="6" x2="6" y2="18"/>
              <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
          </button>
        </div>
      @endif

      @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl flex items-start gap-3 text-xs text-rose-800">
          <svg class="size-4 text-rose-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="15" y1="9" x2="9" y2="15"/>
            <line x1="9" y1="9" x2="15" y2="15"/>
          </svg>
          <div class="flex flex-col gap-1">
            <span class="font-bold">Perhatian:</span>
            <ul class="list-disc list-inside">
              @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      @endif

      @if($tab === 'dashboard')
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between">
              <span class="text-xs text-slate-500 font-medium">Total Peserta Terdaftar</span>
              @if($event->quota > 0 && $totalRegistrations >= $event->quota)
                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                  Penuh
                </span>
              @endif
            </div>
            <div class="flex items-baseline justify-between mt-2">
              <span class="text-xl sm:text-2xl font-bold text-slate-900">{{ $totalRegistrations }}</span>
              <span class="text-xs text-slate-500 font-medium">/ {{ $event->quota }} Kuota</span>
            </div>
            <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden mt-3">
              <div class="h-full {{ $event->quota > 0 && $totalRegistrations >= $event->quota ? 'bg-rose-600' : 'bg-blue-950' }} rounded-full" style="width: {{ $event->quota > 0 ? min(100, round(($totalRegistrations / $event->quota) * 100)) : 0 }}%"></div>
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
            <p class="text-xs text-slate-500">Belum ada pengisi acara yang ditugaskan ke sesi ini. Silakan pilih dari daftar Pengisi Acara.</p>
          @else
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              @foreach($event->speakers as $spk)
                <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-3">
                  <div class="size-10 rounded-lg bg-blue-50 border border-blue-100 text-blue-950 font-bold text-xs flex items-center justify-center shrink-0">
                    {{ strtoupper(substr($spk->name, 0, 2)) }}
                  </div>
                  <div class="flex flex-col min-w-0 flex-1">
                    <div class="flex items-center justify-between gap-2">
                      <span class="text-xs font-semibold text-slate-900 truncate" title="{{ $spk->name }}">{{ $spk->name }}</span>
                      @php
                        $spkRole = $spk->pivot->role ?? 'Pemateri';
                        $roleBadgeColor = match(true) {
                          str_starts_with($spkRole, 'Moderator') => 'bg-amber-50 text-amber-700 border-amber-200',
                          str_starts_with($spkRole, 'MC') => 'bg-purple-50 text-purple-700 border-purple-200',
                          default => 'bg-blue-50 text-blue-950 border-blue-100',
                        };
                      @endphp
                      <span class="px-1.5 py-0.5 rounded text-[9px] font-medium border shrink-0 {{ $roleBadgeColor }}">
                        {{ $spkRole }}
                      </span>
                    </div>
                    <span class="text-[11px] text-slate-500 truncate mt-0.5" title="{{ $spk->pivot->topic ?? $spk->institution }}">{{ $spk->pivot->topic ?? $spk->institution }}</span>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>

      @elseif($tab === 'peserta')
        <div class="bg-white rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-2xs flex flex-col gap-4">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
              <div class="size-9 rounded-xl {{ $event->is_presence_open ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' }} flex items-center justify-center shrink-0">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect width="18" height="18" x="3" y="3" rx="2"/>
                  <path d="M7 7h.01M17 7h.01M7 17h.01M17 17h.01"/>
                  <path d="M10 10h4v4h-4z"/>
                </svg>
              </div>
              <div>
                <h3 class="text-sm font-bold text-slate-900">Gerbang Presensi Sesi (Online & Self Check-in)</h3>
                <p class="text-xs text-slate-500">Kendalikan absensi mandiri untuk peserta online (Zoom/Meet) dan peserta offline (standing banner).</p>
              </div>
            </div>

            <div class="flex items-center gap-2.5 shrink-0">
              <form action="{{ route('organizer.workspace.presence.toggle', ['event' => $event->id]) }}" method="POST">
                @csrf
                @if($event->is_presence_open)
                  <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-semibold transition flex items-center gap-1.5 shadow-xs cursor-pointer">
                    <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <rect width="18" height="18" x="3" y="3" rx="2"/>
                      <line x1="9" y1="9" x2="15" y2="15"/>
                      <line x1="15" y1="9" x2="9" y2="15"/>
                    </svg>
                    <span>Tutup Presensi Sesi</span>
                  </button>
                @else
                  <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold transition flex items-center gap-1.5 shadow-xs cursor-pointer">
                    <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                      <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Buka Presensi Sesi</span>
                  </button>
                @endif
              </form>

              @if($event->is_presence_open)
                <a href="{{ route('organizer.workspace.stage', ['event' => $event->id]) }}" target="_blank" class="px-4 py-2 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold transition flex items-center gap-1.5 shadow-xs cursor-pointer">
                  <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M8 3H5a2 2 0 0 0-2 2v3M21 8V5a2 2 0 0 0-2-2h-3M3 16v3a2 2 0 0 0 2 2h3M16 21h3a2 2 0 0 0 2-2v-3"/>
                  </svg>
                  <span>Tampilkan QR Presensi</span>
                </a>
              @else
                <button type="button" disabled title="Buka presensi sesi terlebih dahulu untuk menampilkan QR" class="px-4 py-2 bg-slate-200 text-slate-400 rounded-xl text-xs font-semibold flex items-center gap-1.5 cursor-not-allowed">
                  <svg class="size-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M8 3H5a2 2 0 0 0-2 2v3M21 8V5a2 2 0 0 0-2-2h-3M3 16v3a2 2 0 0 0 2 2h3M16 21h3a2 2 0 0 0 2-2v-3"/>
                  </svg>
                  <span>Tampilkan QR Presensi</span>
                </button>
              @endif
            </div>
          </div>

          <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
            <div class="flex items-center gap-2 min-w-0">
              <span class="text-slate-500 font-medium shrink-0">Tautan Presensi Peserta:</span>
              <span id="session-presence-url" class="font-mono text-blue-950 font-semibold truncate">{{ $event->presence_token ? route('events.presence', ['slug' => $event->slug, 'token' => $event->presence_token]) : route('events.presence', $event->slug) }}</span>
            </div>
            <button type="button" onclick="copySessionUrl()" id="btn-copy-url" class="px-3 py-1.5 bg-white border border-slate-300 hover:bg-slate-100 text-slate-700 rounded-lg text-xs font-medium transition flex items-center gap-1.5 shrink-0 cursor-pointer shadow-2xs">
              <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
              </svg>
              <span id="copy-text">Salin Tautan</span>
            </button>
          </div>
        </div>

        @if($event->format === 'offline')
          <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-2xs flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
            <form action="{{ route('organizer.workspace.quick_checkin', ['event' => $event->id]) }}" method="POST" id="form-quick-checkin" class="flex-1 flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
              @csrf
              <div class="flex-1 flex items-center gap-2 px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs">
                <svg class="size-4 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M3 7V5a2 2 0 0 1 2-2h2"/>
                  <path d="M17 3h2a2 2 0 0 1 2 2v2"/>
                  <path d="M21 17v2a2 2 0 0 1-2 2h-2"/>
                  <path d="M7 21H5a2 2 0 0 1-2-2v-2"/>
                  <line x1="7" x2="17" y1="12" y2="12"/>
                </svg>
                <input type="text" id="quick-checkin-code" name="code" placeholder="Scan QR Pass atau ketik No. Registrasi / Email peserta untuk registrasi ulang (check-in)..." required class="w-full bg-transparent border-none outline-none text-xs text-slate-900 placeholder:text-slate-400">
              </div>
              <div class="flex items-center gap-2">
                <button type="submit" class="px-5 py-2.5 bg-blue-950 hover:bg-blue-900 text-white text-xs font-semibold rounded-xl transition flex items-center justify-center gap-2 shadow-xs cursor-pointer">
                  <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="20 6 9 17 4 12"/>
                  </svg>
                  <span>Check-in Masuk</span>
                </button>

                <button type="button" onclick="openOrganizerScannerModal()" class="px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold rounded-xl transition flex items-center justify-center gap-2 shadow-xs cursor-pointer shrink-0">
                  <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 7V5a2 2 0 0 1 2-2h2M17 3h2a2 2 0 0 1 2 2v2M21 17v2a2 2 0 0 1-2 2h-2M7 21H5a2 2 0 0 1-2-2v-2"/>
                    <rect width="6" height="6" x="9" y="9" rx="1"/>
                  </svg>
                  <span>Pindai QR Pass</span>
                </button>
              </div>
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
        @else
          <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-2xs flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
            <div class="flex items-center gap-2.5 text-xs text-slate-600">
              <div class="size-8 rounded-lg bg-blue-50 text-blue-900 flex items-center justify-center shrink-0">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect width="20" height="14" x="2" y="3" rx="2"/>
                  <line x1="8" x2="16" y1="21" y2="21"/>
                  <line x1="12" x2="12" y1="17" y2="21"/>
                </svg>
              </div>
              <div>
                <span class="font-semibold text-slate-800 block">Acara Berformat Online / Webinar</span>
                <span class="text-slate-500 text-[11px]">Tidak memerlukan check-in pintu masuk. Presensi kehadiran sesi dilakukan mandiri oleh peserta saat gerbang presensi dibuka.</span>
              </div>
            </div>
            <a href="{{ route('organizer.workspace.export', ['event' => $event->id]) }}" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50 transition flex items-center justify-center gap-2 shadow-2xs shrink-0 self-end sm:self-auto">
              <svg class="size-3.5 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="7 10 12 15 17 10"/>
                <line x1="12" x2="12" y1="15" y2="3"/>
              </svg>
              <span>Ekspor CSV</span>
            </a>
          </div>
        @endif

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

              @if($event->format === 'offline')
                <select name="checkin" onchange="this.form.submit()" class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium text-slate-700 outline-none cursor-pointer">
                  <option value="">Semua Check-in</option>
                  <option value="checked_in" {{ request('checkin') === 'checked_in' ? 'selected' : '' }}>Sudah Check-in</option>
                  <option value="not_checked_in" {{ request('checkin') === 'not_checked_in' ? 'selected' : '' }}>Belum Check-in</option>
                </select>
              @endif

              <select name="attendance" onchange="this.form.submit()" class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium text-slate-700 outline-none cursor-pointer">
                <option value="">Semua Presensi Sesi</option>
                <option value="attended" {{ request('attendance') === 'attended' ? 'selected' : '' }}>Hadir Sesi</option>
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
                  @if($event->format === 'offline')
                    <th class="px-4 py-3">Check-in (Pintu Masuk)</th>
                  @endif
                  <th class="px-4 py-3">Presensi Sesi</th>
                  <th class="px-4 py-3">Status Tiket</th>
                  <th class="px-4 py-3">Status Sertifikat</th>
                  <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                @forelse($registrations as $reg)
                  <tr class="hover:bg-slate-50/80 transition" id="reg-row-{{ $reg->id }}">
                    <td class="px-4 py-3 whitespace-nowrap">
                      <div class="font-semibold text-blue-950">{{ $reg->registration_code }}</div>
                      @if($event->format === 'offline' && $reg->qr_pass)
                        <div class="text-[10px] font-mono text-slate-500 font-medium">Pass: #{{ $reg->qr_pass }}</div>
                      @endif
                    </td>
                    <td class="px-4 py-3">
                      <div class="flex flex-col">
                        <span class="font-semibold text-slate-900">{{ $reg->user->name ?? '-' }}</span>
                        <span class="text-slate-400 text-[11px]">{{ $reg->user->email ?? '-' }}</span>
                        @if(!empty($reg->user->nik))
                          <span class="text-slate-500 font-mono text-[10px]">NIM/NIP/NIS: {{ $reg->user->nik }}</span>
                        @endif
                      </div>
                    </td>
                    <td class="px-4 py-3 text-slate-600">
                      {{ $reg->user->institution ?? '-' }}
                    </td>
                    @if($event->format === 'offline')
                      <td class="px-4 py-3 whitespace-nowrap" id="checkin-cell-{{ $reg->id }}">
                        @if($reg->is_checked_in)
                          <div class="flex flex-col gap-0.5">
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 w-fit">
                              <svg class="size-3 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12"/>
                              </svg>
                              <span>Sudah Check-in ({{ $reg->checked_in_at ? $reg->checked_in_at->format('H:i') : '' }})</span>
                            </span>
                            @if($reg->check_in_gate)
                              <span class="text-[10px] text-slate-400 font-mono">{{ $reg->check_in_gate }}</span>
                            @endif
                          </div>
                        @else
                          <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600">
                            Belum Check-in
                          </span>
                        @endif
                      </td>
                    @endif
                    <td class="px-4 py-3 whitespace-nowrap" id="attendance-cell-{{ $reg->id }}">
                      @if($reg->attendance_status === 'attended')
                        <div class="flex flex-col gap-0.5">
                          <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-blue-900 border border-blue-200 w-fit">
                            <svg class="size-3 text-blue-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                              <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            <span>Hadir Sesi ({{ $reg->attended_at ? $reg->attended_at->format('H:i') : ($reg->checked_in_at ? $reg->checked_in_at->format('H:i') : '') }})</span>
                          </span>
                          @if($reg->attendance_gate)
                            <span class="text-[10px] text-slate-400 font-mono">{{ $reg->attendance_gate }}</span>
                          @endif
                        </div>
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
                        @if($event->format === 'offline')
                          <form method="POST" action="{{ route('organizer.checkin.toggle', $reg->id) }}">
                            @csrf
                            <button type="submit" class="px-2 py-1 rounded text-[11px] font-semibold {{ $reg->is_checked_in ? 'bg-slate-100 text-slate-700 hover:bg-slate-200' : 'bg-emerald-600 text-white hover:bg-emerald-700' }} transition cursor-pointer">
                              {{ $reg->is_checked_in ? 'Batal Check-in' : 'Check-in' }}
                            </button>
                          </form>
                        @endif
                        <form method="POST" action="{{ route('organizer.attendance.toggle', $reg->id) }}">
                          @csrf
                          <button type="submit" class="px-2 py-1 rounded text-[11px] font-semibold {{ $reg->attendance_status === 'attended' ? 'bg-slate-100 text-slate-700 hover:bg-slate-200' : 'bg-blue-950 text-white hover:bg-blue-900' }} transition cursor-pointer">
                            {{ $reg->attendance_status === 'attended' ? 'Batal Hadir' : 'Tandai Hadir' }}
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="{{ $event->format === 'offline' ? 8 : 7 }}" class="p-8 text-center text-slate-400">Tidak ada peserta yang cocok dengan kriteria pencarian.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

      @elseif($tab === 'sertifikat')
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
          <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-2xs flex flex-col justify-between">
            <span class="text-slate-500 text-xs font-medium">Total Pendaftar</span>
            <div class="flex items-baseline gap-2 mt-2">
              <span class="text-xl sm:text-2xl font-bold text-slate-900">{{ $totalRegistrations }}</span>
              <span class="text-[11px] text-slate-400">Peserta</span>
            </div>
          </div>
          <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-2xs flex flex-col justify-between">
            <span class="text-slate-500 text-xs font-medium">Hadir (Berhak Sertifikat)</span>
            <div class="flex items-baseline gap-2 mt-2">
              <span class="text-xl sm:text-2xl font-bold text-emerald-700">{{ $attendedRegistrations }}</span>
              <span class="text-[11px] text-slate-400 font-semibold">{{ $attendancePercentage }}%</span>
            </div>
          </div>
          <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-2xs flex flex-col justify-between">
            <span class="text-slate-500 text-xs font-medium">Sertifikat Terbit</span>
            <div class="flex items-baseline gap-2 mt-2">
              <span class="text-xl sm:text-2xl font-bold text-blue-950">{{ $certificatesCount }}</span>
              <span class="text-[11px] text-blue-800 font-semibold">
                {{ $attendedRegistrations > 0 ? round(($certificatesCount / $attendedRegistrations) * 100) : 0 }}%
              </span>
            </div>
          </div>
          <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-2xs flex flex-col justify-between">
            <span class="text-slate-500 text-xs font-medium">Belum Diterbitkan</span>
            <div class="flex items-baseline gap-2 mt-2">
              <span class="text-xl sm:text-2xl font-bold text-amber-700">
                {{ max(0, $attendedRegistrations - $certificatesCount) }}
              </span>
              <span class="text-[11px] text-slate-400">Peserta</span>
            </div>
          </div>
        </div>

        @if($totalRegistrations === 0)
          <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-start gap-3 text-xs text-amber-900 shadow-2xs">
            <svg class="size-5 text-amber-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <line x1="12" y1="8" x2="12" y2="12"/>
              <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div class="flex flex-col gap-1">
              <span class="font-bold text-amber-950">Kegiatan ini belum memiliki peserta terdaftar</span>
              <p class="text-amber-800 leading-relaxed">
                Penerbitan e-sertifikat ditujukan untuk peserta yang terdaftar pada kegiatan ini. Karena belum ada peserta yang terdaftar, berkas PDF yang diunggah belum dapat dicocokkan ke siapa pun. Anda dapat mendaftarkan peserta terlebih dahulu, atau mencoba fitur sertifikat pada kegiatan yang sudah memiliki peserta (seperti <a href="{{ route('organizer.workspace', ['event' => 1, 'tab' => 'sertifikat']) }}" class="underline font-bold text-amber-950 hover:text-blue-950">Kegiatan ID 1</a>).
              </p>
            </div>
          </div>
        @endif

        <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-6 shadow-2xs">
          <div class="flex flex-col gap-1">
            <h3 class="text-sm font-bold text-slate-900">Upload Sertifikat Massal untuk Kegiatan Ini</h3>
            <p class="text-xs text-slate-500 leading-relaxed">
              Pilih satu atau banyak berkas PDF sertifikat secara bersamaan. Sistem otomatis mencocokkan nama berkas dengan NIM/NIP/NIS, No. Registrasi, Email, atau QR Pass peserta.
            </p>
          </div>

          <form action="{{ route('organizer.workspace.certificate.batch', ['event' => $event->id]) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
            @csrf
            <div id="batch-dropzone-box" onclick="document.getElementById('batch-cert-input').click()" class="p-6 border-2 border-dashed border-slate-300 hover:border-blue-950 rounded-2xl bg-slate-50 flex flex-col items-center justify-center gap-2 text-center transition cursor-pointer">
              <svg class="size-8 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="8" r="6"/>
                <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
              </svg>
              <div class="text-xs font-semibold text-blue-950 hover:underline">
                Pilih atau Tarik Berkas PDF Sertifikat ke Sini
              </div>
              <input type="file" id="batch-cert-input" name="certificate_files[]" multiple required accept=".pdf,image/*" onchange="handleBatchFileChange(this)" class="hidden">
              <span class="text-[11px] text-slate-400">Format PDF, JPG, PNG maksimal 10MB per berkas (Bisa pilih banyak sekaligus)</span>

              <div id="batch-file-feedback" class="w-full max-w-lg mt-3 p-3 bg-white border border-blue-200 rounded-xl flex items-center justify-between text-left hidden shadow-2xs" onclick="event.stopPropagation()">
                <div class="min-w-0 pr-2">
                  <div id="batch-file-count" class="text-xs font-bold text-blue-950 truncate"></div>
                  <div id="batch-file-list" class="text-[10px] text-slate-500 truncate mt-0.5"></div>
                </div>
                <button type="button" onclick="event.stopPropagation(); resetBatchFileInput()" class="px-2.5 py-1 text-[11px] text-slate-600 hover:text-rose-600 border border-slate-200 hover:border-rose-200 rounded-lg shrink-0 cursor-pointer transition">
                  Ganti
                </button>
              </div>
            </div>

            <div class="flex justify-end">
              <button type="submit" class="px-5 py-2.5 bg-blue-950 text-white rounded-xl text-xs font-semibold hover:bg-blue-900 transition shadow-xs cursor-pointer">
                Mulai Unggah &amp; Cocokkan Sertifikat
              </button>
            </div>
          </form>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-5 shadow-2xs">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
              <h3 class="text-sm font-bold text-slate-900">Manajemen &amp; Status Sertifikat Peserta</h3>
              <p class="text-xs text-slate-500">Pantau dokumen yang telah terbit, unduh PDF berkas, atau unggah sertifikat per orang.</p>
            </div>
            <div class="flex items-center gap-2">
              <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700">
                Total {{ $registrations->count() }} Peserta
              </span>
              @if($registrations->isNotEmpty())
                <button type="button" onclick="openSingleCertModal('', '', '')" class="px-3 py-1.5 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-semibold transition flex items-center gap-1.5 shadow-2xs cursor-pointer">
                  <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                  </svg>
                  <span>Unggah Satuan Manual</span>
                </button>
              @endif
            </div>
          </div>

          <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="w-full text-left border-collapse text-xs">
              <thead>
                <tr class="bg-slate-50 text-slate-500 border-b border-slate-200">
                  <th class="px-4 py-3 font-semibold">Peserta &amp; Institusi</th>
                  <th class="px-4 py-3 font-semibold">No. Registrasi</th>
                  <th class="px-4 py-3 font-semibold">Kehadiran</th>
                  <th class="px-4 py-3 font-semibold">No. Sertifikat &amp; ID Keabsahan</th>
                  <th class="px-4 py-3 font-semibold">Status Dokumen</th>
                  <th class="px-4 py-3 font-semibold text-right">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($registrations as $reg)
                  <tr class="hover:bg-slate-50/60 transition">
                    <td class="px-4 py-3">
                      <div class="font-bold text-slate-900">{{ $reg->user->name }}</div>
                      <div class="text-[11px] text-slate-500">{{ $reg->user->email }}</div>
                      @if(!empty($reg->user->nik))
                        <div class="text-[10px] text-slate-500 font-mono">NIM/NIP/NIS: {{ $reg->user->nik }}</div>
                      @endif
                      @if($reg->user->institution)
                        <div class="text-[10px] text-slate-400 mt-0.5 truncate max-w-xs">{{ $reg->user->institution }}</div>
                      @endif
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap font-mono text-xs text-blue-950 font-semibold">
                      {{ $reg->registration_code }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                      @if($reg->attendance_status === 'attended')
                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                          Hadir
                        </span>
                      @else
                        <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600">
                          Belum Hadir
                        </span>
                      @endif
                    </td>
                    <td class="px-4 py-3">
                      @if($reg->certificate)
                        <div class="font-mono text-xs font-semibold text-slate-800">{{ $reg->certificate->certificate_number }}</div>
                        <div class="font-mono text-[10px] text-slate-400 mt-0.5">ID: {{ $reg->certificate->verify_hash }}</div>
                      @else
                        <span class="text-slate-400 text-xs italic">Belum dibuat</span>
                      @endif
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                      @if($reg->certificate)
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-blue-50 text-blue-950 border border-blue-200 inline-block">
                          Terbit
                        </span>
                        @if($reg->certificate->issued_at)
                          <span class="text-[10px] text-slate-400 block mt-0.5">{{ $reg->certificate->issued_at->format('d M Y') }}</span>
                        @endif
                      @else
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-medium bg-slate-100 text-slate-500 inline-block">
                          Belum Terbit
                        </span>
                      @endif
                    </td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                      <div class="inline-flex items-center gap-1.5">
                        @if($reg->certificate)
                          <a href="{{ $reg->certificate->download_url ? asset($reg->certificate->download_url) : '#' }}" target="_blank" class="px-2.5 py-1.5 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-semibold transition flex items-center gap-1.5 shadow-2xs">
                            <svg class="size-3.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                              <polyline points="7 10 12 15 17 10"/>
                              <line x1="12" y1="15" x2="12" y2="3"/>
                            </svg>
                            <span>Lihat PDF</span>
                          </a>

                          <form method="POST" action="{{ route('organizer.certificate.delete', $reg->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sertifikat untuk {{ $reg->user->name }}?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-rose-600 hover:text-white hover:bg-rose-600 border border-rose-200 rounded-lg transition cursor-pointer" title="Hapus Sertifikat">
                              <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 6h18"/>
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                              </svg>
                            </button>
                          </form>
                        @else
                          <button type="button" onclick="openSingleCertModal('{{ $reg->id }}', '{{ addslashes($reg->user->name) }}', '{{ $reg->registration_code }}')" class="px-2.5 py-1.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 rounded-lg text-xs font-semibold transition flex items-center gap-1.5 shadow-2xs cursor-pointer">
                            <svg class="size-3.5 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                              <polyline points="17 8 12 3 7 8"/>
                              <line x1="12" y1="3" x2="12" y2="15"/>
                            </svg>
                            <span>Unggah Satuan</span>
                          </button>
                        @endif
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="p-8 text-center text-slate-400">Belum ada peserta terdaftar dalam kegiatan ini.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
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
                    <div class="flex items-center gap-3 min-w-0 flex-1">
                      <div class="size-11 rounded-xl bg-blue-50 border border-blue-100 text-blue-950 font-bold text-xs flex items-center justify-center shrink-0">
                        {{ strtoupper(substr($spk->name, 0, 2)) }}
                      </div>
                      <div class="flex flex-col min-w-0 flex-1">
                        <div class="flex items-center justify-between gap-2">
                          <span class="text-xs font-bold text-slate-900 truncate" title="{{ $spk->name }}">{{ $spk->name }}</span>
                          @php
                            $spkRole = $spk->pivot->role ?? 'Pemateri';
                            $roleBadgeColor = match(true) {
                              str_starts_with($spkRole, 'Moderator') => 'bg-amber-100 text-amber-800 border-amber-200',
                              str_starts_with($spkRole, 'MC') => 'bg-purple-100 text-purple-800 border-purple-200',
                              default => 'bg-blue-100 text-blue-900 border-blue-200',
                            };
                          @endphp
                          <span class="px-2 py-0.5 rounded text-[10px] font-semibold border shrink-0 {{ $roleBadgeColor }}">
                            {{ $spkRole }}
                          </span>
                        </div>
                        <span class="text-[11px] text-slate-500 truncate mt-0.5" title="{{ $spk->institution }}">{{ $spk->institution }}</span>
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

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="flex flex-col gap-1.5">
                <label class="font-semibold text-slate-700">Jenis Kegiatan</label>
                <select name="type" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 cursor-pointer">
                  <option value="Workshop" {{ ($event->type ?? $event->category) === 'Workshop' ? 'selected' : '' }}>Workshop</option>
                  <option value="Seminar" {{ ($event->type ?? $event->category) === 'Seminar' ? 'selected' : '' }}>Seminar</option>
                  <option value="Webinar" {{ ($event->type ?? $event->category) === 'Webinar' ? 'selected' : '' }}>Webinar</option>
                  <option value="Sertifikasi" {{ ($event->type ?? $event->category) === 'Sertifikasi' ? 'selected' : '' }}>Sertifikasi</option>
                </select>
              </div>
              <div class="flex flex-col gap-1.5">
                <div class="flex items-center justify-between">
                  <label class="font-semibold text-slate-700">Kategori Acara</label>
                  <a href="{{ route('organizer.categories.index') }}" target="_blank" class="text-[11px] text-blue-900 font-semibold hover:underline">
                    Kelola
                  </a>
                </div>
                <select name="category_id" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 cursor-pointer">
                  <option value="">-- Pilih Kategori --</option>
                  @foreach($allCategories as $cat)
                    <option value="{{ $cat->id }}" {{ ($event->category_id == $cat->id || $event->category === $cat->name) ? 'selected' : '' }}>
                      {{ $cat->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="flex flex-col gap-1.5">
                <label class="font-semibold text-slate-700">Format Pelaksanaan</label>
                <select name="format" onchange="toggleVirtualMeetingUrl(this.value)" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 cursor-pointer">
                  <option value="offline" {{ $event->format === 'offline' ? 'selected' : '' }}>Offline</option>
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

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="flex flex-col gap-1.5">
                <label class="font-semibold text-slate-700">Penyelenggara Kegiatan</label>
                <select name="organizer_type" onchange="toggleEditPartnerName(this.value)" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 cursor-pointer">
                  <option value="internal" {{ ($event->organizer_type ?? 'internal') === 'internal' ? 'selected' : '' }}>Internal (Laboratorium ICT)</option>
                  <option value="partner" {{ ($event->organizer_type ?? 'internal') === 'partner' ? 'selected' : '' }}>Mitra Penyelenggara (Himpunan / BEM / Eksternal)</option>
                </select>
              </div>
              <div id="edit-partner-name-container" class="{{ ($event->organizer_type ?? 'internal') === 'partner' ? '' : 'hidden' }} flex flex-col gap-1.5">
                <div class="flex items-center justify-between">
                  <label class="font-semibold text-slate-700">Pilih Mitra Penyelenggara</label>
                  <a href="{{ route('organizer.media_partners.index') }}" target="_blank" class="text-[10px] text-blue-900 font-semibold hover:underline">Kelola Data</a>
                </div>
                <select name="media_partner_id" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 cursor-pointer">
                  <option value="" disabled {{ empty($event->media_partner_id) ? 'selected' : '' }}>-- Pilih Mitra Penyelenggara --</option>
                  @foreach($allMediaPartners as $mp)
                    <option value="{{ $mp->id }}" {{ $event->media_partner_id == $mp->id || $event->organizer_name === $mp->name ? 'selected' : '' }}>
                      {{ $mp->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="flex flex-col gap-2">
              <div class="flex items-center justify-between">
                <label class="font-semibold text-slate-700">Media Partner Pendukung Acara</label>
                <a href="{{ route('organizer.media_partners.index') }}" target="_blank" class="text-[10px] text-blue-900 font-semibold hover:underline">Kelola Master Media Partner</a>
              </div>
              @if($allMediaPartners->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 max-h-48 overflow-y-auto p-2.5 bg-slate-50 border border-slate-200 rounded-xl">
                  @foreach($allMediaPartners as $mp)
                    <label class="flex items-center gap-2.5 p-2 bg-white rounded-lg border border-slate-200/80 hover:border-blue-900 cursor-pointer transition text-xs">
                      <input type="checkbox" name="media_partner_ids[]" value="{{ $mp->id }}" {{ $event->mediaPartners->contains($mp->id) ? 'checked' : '' }} class="size-4 rounded text-blue-950 focus:ring-blue-950 border-slate-300">
                      <div class="size-7 rounded-md bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center shrink-0">
                        @if($mp->logo)
                          <img src="{{ asset($mp->logo) }}" alt="{{ $mp->name }}" class="size-full object-contain p-0.5">
                        @else
                          <span class="text-[10px] font-bold text-slate-400 uppercase">{{ substr($mp->name, 0, 2) }}</span>
                        @endif
                      </div>
                      <span class="font-medium text-slate-800 truncate">{{ $mp->name }}</span>
                    </label>
                  @endforeach
                </div>
              @else
                <p class="text-xs text-slate-400">Belum ada master media partner terdaftar.</p>
              @endif
            </div>

            <div class="flex flex-col gap-1.5">
              <label class="font-semibold text-slate-700">Lokasi / Ruang Lab</label>
              <input type="text" name="location" value="{{ $event->location }}" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="flex flex-col gap-1.5">
                <label class="font-semibold text-slate-700">Tanggal Mulai</label>
                <input type="date" name="start_date" min="{{ date('Y-m-d') }}" value="{{ \Carbon\Carbon::parse($event->start_date)->format('Y-m-d') }}" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
              </div>
              <div class="flex flex-col gap-1.5">
                <label class="font-semibold text-slate-700">Tanggal Selesai</label>
                <input type="date" name="end_date" min="{{ date('Y-m-d') }}" value="{{ \Carbon\Carbon::parse($event->end_date)->format('Y-m-d') }}" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
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

            <div id="virtual-meeting-container" class="flex flex-col gap-1.5 {{ $event->format === 'online' ? '' : 'hidden' }}">
              <label class="font-semibold text-slate-700">Tautan Pertemuan Virtual</label>
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

  @if($event->format === 'offline')
  <div id="modal-organizer-scanner" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 flex flex-col gap-4 shadow-2xl">
      <div class="flex items-start justify-between gap-4 pb-3 border-b border-slate-100">
        <div class="flex flex-col">
          <h2 class="text-base font-bold text-slate-900">Pindai QR Pass Peserta</h2>
          <p class="text-xs text-slate-500 mt-0.5">Arahkan kamera ke QR Pass di tiket atau ponsel peserta untuk registrasi ulang.</p>
        </div>
        <button type="button" onclick="closeOrganizerScannerModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 cursor-pointer">
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>

      <div class="relative w-full aspect-square bg-slate-950 rounded-xl overflow-hidden flex items-center justify-center border border-slate-200">
        <div id="organizer-qr-reader" class="size-full"></div>
        <div id="organizer-scanner-loading" class="absolute inset-0 flex flex-col items-center justify-center text-white gap-2 bg-slate-950/80">
          <svg class="size-8 animate-spin text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10" stroke-opacity="0.25"/>
            <path d="M12 2a10 10 0 0 1 10 10" stroke-opacity="1"/>
          </svg>
          <span class="text-xs font-medium">Mengaktifkan kamera...</span>
        </div>
      </div>

      <div id="organizer-scan-feedback" class="hidden p-3.5 rounded-xl border text-xs flex flex-col gap-1">
        <div class="flex items-center gap-2">
          <span id="organizer-scan-status-icon" class="shrink-0"></span>
          <span id="organizer-scan-status-title" class="font-bold"></span>
        </div>
        <p id="organizer-scan-status-desc" class="text-[11px] leading-relaxed"></p>
        <div id="organizer-scan-details" class="hidden mt-1 pt-1.5 border-t border-slate-200/60 flex items-center justify-between text-[10px] font-mono">
          <span id="organizer-scan-detail-code"></span>
          <span id="organizer-scan-detail-time"></span>
        </div>
      </div>

      <div class="flex items-center gap-2 pt-2 border-t border-slate-100">
        <button type="button" onclick="closeOrganizerScannerModal()" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition cursor-pointer text-center">
          Tutup
        </button>
      </div>
    </div>
  </div>
  @endif

  <div id="modal-assign-speaker" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 sm:p-8 flex flex-col gap-6 shadow-2xl">
      <div class="flex items-start justify-between gap-4 pb-4 border-b border-slate-100">
        <div class="flex flex-col">
          <h2 class="text-base sm:text-lg font-bold text-slate-900">Tugaskan Pengisi Acara</h2>
          <p class="text-xs text-slate-500 mt-0.5">Pilih pengisi acara terdaftar dan tentukan perannya untuk acara ini.</p>
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
            <a href="{{ route('organizer.speakers.index') }}" target="_blank" class="text-[11px] text-blue-950 font-semibold hover:underline inline-flex items-center gap-1">
              <span>Kelola Master Pengisi Acara</span>
              <svg class="size-3 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                <polyline points="15 3 21 3 21 9"/>
                <line x1="10" y1="14" x2="21" y2="3"/>
              </svg>
            </a>
          </div>
          @php
            $assignedSpeakerIds = $event->speakers->pluck('id')->toArray();
          @endphp
          <select id="assign-speaker-select" name="speaker_id" onchange="onAssignSpeakerChange(this)" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:border-blue-950 focus:bg-white cursor-pointer transition">
            <option value="" disabled selected>-- Pilih Pengisi Acara --</option>
            @foreach($allMasterSpeakers as $mspk)
              @php
                $alreadyAssigned = in_array($mspk->id, $assignedSpeakerIds);
              @endphp
              <option value="{{ $mspk->id }}" data-institution="{{ $mspk->institution ?? 'Lab ICT' }}" {{ $alreadyAssigned ? 'disabled class=text-slate-400' : '' }}>
                {{ $mspk->name }}{{ $alreadyAssigned ? ' — (Sudah Ditugaskan)' : '' }}
              </option>
            @endforeach
          </select>
          <div id="assign-speaker-inst-badge" class="hidden text-[11px] text-slate-500 font-normal truncate px-1 items-center gap-1.5 mt-0.5">
            <svg class="size-3 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/>
              <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/>
              <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/>
              <path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/>
            </svg>
            <span id="assign-speaker-inst-text" class="truncate font-medium text-slate-600"></span>
          </div>
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Peran Pengisi Acara</label>
          <select name="role" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 cursor-pointer">
            <option value="Pemateri" selected>Pemateri</option>
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

  <div id="modal-session-qr" class="fixed inset-0 z-50 bg-black/75 backdrop-blur-xs hidden items-center justify-center p-3 sm:p-4 overflow-y-auto">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 flex flex-col items-center gap-5 shadow-2xl my-auto text-center">
      <div class="w-full flex items-start justify-between pb-3 border-b border-slate-100">
        <div class="text-left">
          <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wider bg-blue-50 text-blue-950 border border-blue-200">
            QR Presensi Sesi Resmi
          </span>
          <h2 class="text-base font-bold text-slate-900 mt-1 truncate max-w-xs sm:max-w-sm">{{ $event->title }}</h2>
        </div>
        <button type="button" onclick="closeSessionQrModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 cursor-pointer">
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>

      <div class="p-4 bg-white rounded-2xl border-2 border-slate-200 shadow-sm flex flex-col items-center justify-center">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=320x320&data={{ urlencode(route('events.presence', $event->slug)) }}" alt="QR Presensi Sesi" class="size-64 object-contain" onerror="this.classList.add('hidden'); document.getElementById('qr-modal-fallback').classList.remove('hidden');">
        <div id="qr-modal-fallback" class="hidden size-64 flex flex-col items-center justify-center p-4 bg-slate-50 text-slate-600 rounded-xl">
          <svg class="size-16 text-blue-950 mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <rect width="6" height="6" x="2" y="2" rx="1"/>
            <rect width="6" height="6" x="16" y="2" rx="1"/>
            <rect width="6" height="6" x="2" y="16" rx="1"/>
            <path d="M10 2h4M2 10v4M10 6h4M14 10h4M10 14h4M16 14v4M16 20h4M20 16v4"/>
          </svg>
          <span class="text-xs font-semibold">Tautan Langsung Presensi</span>
          <span class="text-[10px] text-slate-500 break-all mt-1">{{ route('events.presence', $event->slug) }}</span>
        </div>
      </div>

      <div class="flex flex-col gap-1 text-center">
        <span class="text-xs font-bold text-slate-900">Scan QR Code dengan Kamera Ponsel Anda</span>
        <span class="text-[11px] text-slate-500 max-w-sm">
          Atau gunakan tautan langsung di chat: <strong class="text-blue-950">{{ route('events.presence', $event->slug) }}</strong>
        </span>
      </div>

      <div class="w-full flex items-center justify-center gap-3 pt-3 border-t border-slate-100">
        <button type="button" onclick="window.print()" class="px-4 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold transition cursor-pointer">
          Cetak Lembar QR
        </button>
        <button type="button" onclick="closeSessionQrModal()" class="px-5 py-2 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold transition cursor-pointer shadow-xs">
          Tutup
        </button>
      </div>
    </div>
  </div>

  <div id="modal-upload-single-cert" class="fixed inset-0 z-50 bg-black/75 backdrop-blur-xs hidden items-center justify-center p-3 sm:p-4 overflow-y-auto">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 flex flex-col gap-5 shadow-2xl my-auto">
      <div class="w-full flex items-start justify-between pb-3 border-b border-slate-100">
        <div>
          <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wider bg-blue-50 text-blue-950 border border-blue-200">
            Unggah Satuan
          </span>
          <h2 class="text-base font-bold text-slate-900 mt-1">Unggah Sertifikat Peserta</h2>
        </div>
        <button type="button" onclick="closeSingleCertModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 cursor-pointer">
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>

      <form id="form-upload-single-cert" method="POST" action="" enctype="multipart/form-data" class="flex flex-col gap-4 text-xs">
        @csrf
        <div id="single-cert-specific-block" class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex flex-col gap-1">
          <span class="text-slate-500 text-[11px]">Nama Peserta:</span>
          <span id="single-cert-user-name" class="font-bold text-slate-900 text-sm"></span>
          <span id="single-cert-reg-code" class="font-mono text-xs text-blue-950 font-semibold mt-0.5"></span>
        </div>

        <div id="single-cert-select-block" class="flex flex-col gap-1.5 hidden">
          <label class="font-semibold text-slate-700">Pilih Peserta Penerima Sertifikat <span class="text-rose-500">*</span></label>
          <select id="single-cert-select-reg" onchange="onSingleCertSelectChange(this)" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 text-xs font-medium text-slate-800 cursor-pointer">
            <option value="">-- Pilih Peserta --</option>
            @foreach($registrations as $r)
              <option value="{{ $r->id }}">{{ $r->user->name }}@if(!empty($r->user->nik)) - {{ $r->user->nik }}@endif ({{ $r->registration_code }}) - {{ $r->attendance_status === 'attended' ? 'Hadir' : 'Belum Hadir' }}</option>
            @endforeach
          </select>
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Nomor Sertifikat (Opsional)</label>
          <input type="text" name="certificate_number" placeholder="Contoh: ICT-CERT/2026/00001 (Kosongkan untuk otomatis)" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 text-xs">
          <span class="text-[10px] text-slate-400">Jika dikosongkan, sistem akan membuat nomor secara otomatis.</span>
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Berkas Sertifikat (PDF / Gambar) <span class="text-rose-500">*</span></label>
          <input type="file" name="certificate_file" required accept=".pdf,image/*" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-950 file:text-white hover:file:bg-blue-900 cursor-pointer">
          <span class="text-[10px] text-slate-400">Ukuran maksimal berkas 10MB.</span>
        </div>

        <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
          <button type="button" onclick="closeSingleCertModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 cursor-pointer">
            Batal
          </button>
          <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-950 hover:bg-blue-900 text-white font-semibold shadow-xs cursor-pointer">
            Simpan Sertifikat
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openSessionQrModal() {
  const m = document.getElementById('modal-session-qr');
  if (m) {
    m.classList.remove('hidden');
    m.classList.add('flex');
  }
}

function closeSessionQrModal() {
  const m = document.getElementById('modal-session-qr');
  if (m) {
    m.classList.add('hidden');
    m.classList.remove('flex');
  }
}

function copySessionUrl() {
  const urlEl = document.getElementById('session-presence-url');
  if (!urlEl) return;
  const url = urlEl.textContent || urlEl.innerText;
  navigator.clipboard.writeText(url).then(() => {
    const textEl = document.getElementById('copy-text');
    if (textEl) {
      const orig = textEl.textContent;
      textEl.textContent = 'Tersalin!';
      setTimeout(() => { textEl.textContent = orig; }, 2000);
    }
  });
}
function onAssignSpeakerChange(selectEl) {
  const badge = document.getElementById('assign-speaker-inst-badge');
  const textEl = document.getElementById('assign-speaker-inst-text');
  if (!badge || !textEl) return;
  const opt = selectEl.options[selectEl.selectedIndex];
  const inst = opt ? opt.getAttribute('data-institution') : '';
  if (inst) {
    textEl.textContent = inst;
    badge.classList.remove('hidden');
    badge.classList.add('flex');
  } else {
    badge.classList.add('hidden');
    badge.classList.remove('flex');
  }
}

function toggleEditPartnerName(val) {
  const container = document.getElementById('edit-partner-name-container');
  if (!container) return;
  if (val === 'partner') {
    container.classList.remove('hidden');
  } else {
    container.classList.add('hidden');
  }
}

function toggleVirtualMeetingUrl(format) {
  const container = document.getElementById('virtual-meeting-container');
  if (!container) return;
  if (format === 'online') {
    container.classList.remove('hidden');
  } else {
    container.classList.add('hidden');
  }
}

function openAssignSpeakerModal() {
  const m = document.getElementById('modal-assign-speaker');
  m.classList.remove('hidden');
  m.classList.add('flex');
}

function closeAssignSpeakerModal() {
  const m = document.getElementById('modal-assign-speaker');
  m.classList.add('hidden');
  m.classList.remove('flex');
  const selectEl = document.getElementById('assign-speaker-select');
  if (selectEl) {
    selectEl.selectedIndex = 0;
    onAssignSpeakerChange(selectEl);
  }
}

function openSingleCertModal(regId, userName, regCode) {
  const m = document.getElementById('modal-upload-single-cert');
  const form = document.getElementById('form-upload-single-cert');
  const specificBlock = document.getElementById('single-cert-specific-block');
  const selectBlock = document.getElementById('single-cert-select-block');
  const nameEl = document.getElementById('single-cert-user-name');
  const codeEl = document.getElementById('single-cert-reg-code');
  const selectEl = document.getElementById('single-cert-select-reg');
  if (!m || !form) return;

  if (regId) {
    form.action = '/penyelenggara/registrasi/' + regId + '/upload-sertifikat';
    if (specificBlock) specificBlock.classList.remove('hidden');
    if (selectBlock) selectBlock.classList.add('hidden');
    if (nameEl) nameEl.textContent = userName;
    if (codeEl) codeEl.textContent = 'Kode: ' + regCode;
  } else {
    form.action = '';
    if (specificBlock) specificBlock.classList.add('hidden');
    if (selectBlock) selectBlock.classList.remove('hidden');
    if (selectEl) {
      selectEl.selectedIndex = 0;
      onSingleCertSelectChange(selectEl);
    }
  }

  m.classList.remove('hidden');
  m.classList.add('flex');
}

function onSingleCertSelectChange(selectEl) {
  const form = document.getElementById('form-upload-single-cert');
  if (!form) return;
  if (selectEl.value) {
    form.action = '/penyelenggara/registrasi/' + selectEl.value + '/upload-sertifikat';
  } else {
    form.action = '';
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const formSingle = document.getElementById('form-upload-single-cert');
  if (formSingle) {
    formSingle.addEventListener('submit', (e) => {
      if (!formSingle.action || formSingle.action.endsWith('/upload-sertifikat') && formSingle.action.includes('//upload-sertifikat')) {
        e.preventDefault();
        alert('Silakan pilih peserta penerima sertifikat terlebih dahulu.');
      }
    });
  }

  const dropzone = document.getElementById('batch-dropzone-box');
  if (dropzone) {
    ['dragenter', 'dragover'].forEach(eventName => {
      dropzone.addEventListener(eventName, (e) => {
        e.preventDefault();
        e.stopPropagation();
        dropzone.classList.add('border-blue-950', 'bg-blue-50/60');
      });
    });
    ['dragleave', 'drop'].forEach(eventName => {
      dropzone.addEventListener(eventName, (e) => {
        e.preventDefault();
        e.stopPropagation();
        dropzone.classList.remove('border-blue-950', 'bg-blue-50/60');
      });
    });
    dropzone.addEventListener('drop', (e) => {
      const dt = e.dataTransfer;
      const files = dt.files;
      const input = document.getElementById('batch-cert-input');
      if (input && files.length > 0) {
        input.files = files;
        handleBatchFileChange(input);
      }
    });
  }
});

function closeSingleCertModal() {
  const m = document.getElementById('modal-upload-single-cert');
  if (m) {
    m.classList.add('hidden');
    m.classList.remove('flex');
  }
}

function handleBatchFileChange(input) {
  const feedback = document.getElementById('batch-file-feedback');
  const countEl = document.getElementById('batch-file-count');
  const listEl = document.getElementById('batch-file-list');
  if (!feedback || !countEl || !listEl) return;

  if (input.files && input.files.length > 0) {
    feedback.classList.remove('hidden');
    feedback.classList.add('flex');
    countEl.textContent = input.files.length + ' Berkas Dipilih';
    const names = Array.from(input.files).map(f => f.name).slice(0, 3).join(', ');
    const more = input.files.length > 3 ? ' dan ' + (input.files.length - 3) + ' lainnya' : '';
    listEl.textContent = names + more;
  } else {
    feedback.classList.add('hidden');
    feedback.classList.remove('flex');
  }
}

function resetBatchFileInput() {
  const input = document.getElementById('batch-cert-input');
  const feedback = document.getElementById('batch-file-feedback');
  if (input) input.value = '';
  if (feedback) {
    feedback.classList.add('hidden');
    feedback.classList.remove('flex');
  }
}

let organizerQrScanner = null;
let organizerIsProcessing = false;

function openOrganizerScannerModal() {
  const modal = document.getElementById('modal-organizer-scanner');
  const loading = document.getElementById('organizer-scanner-loading');
  const feedback = document.getElementById('organizer-scan-feedback');
  if (!modal) return;

  modal.classList.remove('hidden');
  modal.classList.add('flex');
  if (loading) loading.classList.remove('hidden');
  if (feedback) feedback.classList.add('hidden');
  organizerIsProcessing = false;

  const startScanner = () => {
    if (typeof Html5Qrcode === 'undefined') {
      setTimeout(startScanner, 150);
      return;
    }
    organizerQrScanner = new Html5Qrcode('organizer-qr-reader');
    organizerQrScanner.start(
      { facingMode: 'environment' },
      { fps: 10, qrbox: { width: 220, height: 220 } },
      onOrganizerQrSuccess,
      () => {}
    ).then(() => {
      if (loading) loading.classList.add('hidden');
    }).catch(err => {
      if (loading) loading.classList.add('hidden');
      showOrganizerScanFeedback('error', 'Kamera Tidak Tersedia', 'Pastikan izin akses kamera diberikan atau periksa perangkat Anda.');
    });
  };

  if (!window.html5QrCodeLoaded) {
    const s = document.createElement('script');
    s.src = '/vendor/html5-qrcode/html5-qrcode.min.js';
    s.onload = () => {
      window.html5QrCodeLoaded = true;
      startScanner();
    };
    document.head.appendChild(s);
  } else {
    startScanner();
  }
}

function closeOrganizerScannerModal() {
  const modal = document.getElementById('modal-organizer-scanner');
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
  if (organizerQrScanner) {
    organizerQrScanner.stop().catch(() => {}).then(() => {
      organizerQrScanner.clear();
      organizerQrScanner = null;
    });
  }
  organizerIsProcessing = false;
}

function onOrganizerQrSuccess(decodedText) {
  if (organizerIsProcessing) return;
  organizerIsProcessing = true;

  const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
  const url = "{{ route('organizer.workspace.quick_checkin', ['event' => $event->id]) }}";

  fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrf,
      'Accept': 'application/json'
    },
    body: JSON.stringify({ code: decodedText, source: 'camera' })
  })
  .then(res => res.json().then(data => ({ status: res.status, ok: res.ok, body: data })))
  .then(result => {
    const data = result.body;
    if (result.ok && data.status === 'success') {
      showOrganizerScanFeedback('success', 'Check-in Berhasil', data.message, data.registration);
      if (data.registration && data.registration.id) {
        const cell = document.getElementById('checkin-cell-' + data.registration.id);
        if (cell) {
          cell.innerHTML = '<div class="flex flex-col gap-0.5"><span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 w-fit"><svg class="size-3 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><span>Sudah Check-in (' + (data.registration.checked_in_at || '') + ')</span></span><span class="text-[10px] text-slate-400 font-mono">' + (data.registration.check_in_gate || 'Scan QR Pass') + '</span></div>';
        }
      }
      setTimeout(() => { organizerIsProcessing = false; }, 2200);
    } else if (data.status === 'already_checked_in' || data.status === 'already_attended') {
      showOrganizerScanFeedback('warning', 'Sudah Check-in', data.message, data.registration);
      setTimeout(() => { organizerIsProcessing = false; }, 2200);
    } else {
      showOrganizerScanFeedback('error', 'Check-in Gagal', data.message || 'Data peserta tidak valid.');
      setTimeout(() => { organizerIsProcessing = false; }, 2200);
    }
  })
  .catch(() => {
    showOrganizerScanFeedback('error', 'Koneksi Gagal', 'Gagal memverifikasi ke server. Silakan coba kembali.');
    setTimeout(() => { organizerIsProcessing = false; }, 2200);
  });
}

function showOrganizerScanFeedback(type, title, desc, reg) {
  const feedback = document.getElementById('organizer-scan-feedback');
  const icon = document.getElementById('organizer-scan-status-icon');
  const titleEl = document.getElementById('organizer-scan-status-title');
  const descEl = document.getElementById('organizer-scan-status-desc');
  const details = document.getElementById('organizer-scan-details');
  const detailCode = document.getElementById('organizer-scan-detail-code');
  const detailTime = document.getElementById('organizer-scan-detail-time');

  if (!feedback) return;
  feedback.classList.remove('hidden', 'bg-emerald-50', 'border-emerald-200', 'text-emerald-800', 'bg-amber-50', 'border-amber-200', 'text-amber-800', 'bg-rose-50', 'border-rose-200', 'text-rose-800');

  if (type === 'success') {
    feedback.classList.add('bg-emerald-50', 'border-emerald-200', 'text-emerald-800');
    icon.innerHTML = '<svg class="size-4 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>';
  } else if (type === 'warning') {
    feedback.classList.add('bg-amber-50', 'border-amber-200', 'text-amber-800');
    icon.innerHTML = '<svg class="size-4 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>';
  } else {
    feedback.classList.add('bg-rose-50', 'border-rose-200', 'text-rose-800');
    icon.innerHTML = '<svg class="size-4 text-rose-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>';
  }

  titleEl.textContent = title;
  descEl.textContent = desc;

  if (reg && details) {
    details.classList.remove('hidden');
    detailCode.textContent = reg.registration_code + (reg.qr_pass ? ' #' + reg.qr_pass : '');
    detailTime.textContent = reg.checked_in_at || '';
  } else if (details) {
    details.classList.add('hidden');
  }
}
</script>
@endsection

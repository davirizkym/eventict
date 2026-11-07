@extends('layouts.app')

@section('title', 'Pusat Kendali Penyelenggara — Eventict')

@section('content')
<div class="min-h-screen flex bg-slate-50 text-slate-800 antialiased font-['Poppins']">
  <div id="sidebar-backdrop" class="fixed inset-0 z-40 bg-black/50 backdrop-blur-xs hidden md:hidden"></div>

  <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 h-screen bg-blue-950 text-slate-300 flex flex-col justify-between transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 md:sticky md:top-0 md:h-screen shrink-0 px-5 pt-8 pb-6 shadow-xl md:shadow-none overflow-y-auto overscroll-contain">
    <div class="flex flex-col justify-start items-start gap-6 shrink-0">
      <div class="w-full px-2 inline-flex justify-between md:justify-start items-center gap-3">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
          <div class="w-10 h-11 bg-white rounded-xl flex justify-center items-center shrink-0 shadow-xs">
            <svg class="w-5 h-5 text-blue-950" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
              <path d="M6 6h10"/>
              <path d="M6 10h7"/>
            </svg>
          </div>
          <div class="inline-flex flex-col justify-start items-start gap-0.5">
            <div class="text-white text-base font-semibold leading-tight font-['Poppins'] group-hover:text-blue-100 transition">Eventict</div>
            <div class="text-slate-300 text-xs font-normal leading-tight font-['Poppins']">Organizer Suite</div>
          </div>
        </a>
        <button id="sidebar-close" aria-label="Tutup menu navigasi" class="md:hidden p-2 rounded-lg text-slate-400 hover:text-white hover:bg-white/10 cursor-pointer">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <div class="w-full p-3 rounded-xl bg-white/5 border border-white/10 flex flex-col gap-1">
        <div class="flex items-center justify-between">
          <span class="text-white text-xs font-semibold leading-tight truncate">{{ $activeEvent->title ?? 'Simposium Telemedicine 2026' }}</span>
          <svg class="size-4 text-blue-300 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="6 9 12 15 18 9"/>
          </svg>
        </div>
        <span class="text-slate-400 text-[11px] font-normal">Workspace Panitia Aktif</span>
      </div>

      <div class="w-full flex flex-col justify-start items-start gap-1">
        <a href="{{ route('organizer.dashboard') }}" class="w-full p-3 rounded-lg inline-flex items-center gap-3 transition min-h-12 bg-blue-900 text-white font-semibold">
          <svg class="w-4 h-4 shrink-0 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect width="18" height="18" x="3" y="3" rx="2"/>
            <path d="M3 9h18"/>
            <path d="M9 21V9"/>
          </svg>
          <span class="text-xs leading-5">Ringkasan & Operasional</span>
        </a>

        <a href="#tabel-peserta" class="w-full p-3 rounded-lg inline-flex items-center justify-between transition min-h-12 text-slate-300 hover:bg-white/10 font-normal">
          <div class="inline-flex items-center gap-3">
            <svg class="w-4 h-4 shrink-0 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <span class="text-xs leading-5">Peserta & Presensi</span>
          </div>
          <span class="px-2 py-0.5 bg-blue-900 text-blue-200 text-[10px] font-semibold rounded-md">{{ $totalRegistrations }}</span>
        </a>

        <button type="button" onclick="openBatchUploadModal()" class="w-full p-3 rounded-lg inline-flex items-center gap-3 transition min-h-12 text-slate-300 hover:bg-white/10 font-normal text-left cursor-pointer">
          <svg class="w-4 h-4 shrink-0 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="8" r="6"/>
            <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
          </svg>
          <span class="text-xs leading-5">Upload Sertifikat Massal</span>
        </button>

        <a href="{{ route('home') }}" class="w-full p-3 rounded-lg inline-flex items-center gap-3 transition min-h-12 text-slate-300 hover:bg-white/10 font-normal">
          <svg class="w-4 h-4 shrink-0 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="8" x2="21" y1="6" y2="6"/>
            <line x1="8" x2="21" y1="12" y2="12"/>
            <line x1="8" x2="21" y1="18" y2="18"/>
            <line x1="3" x2="3.01" y1="6" y2="6"/>
            <line x1="3" x2="3.01" y1="12" y2="12"/>
            <line x1="3" x2="3.01" y1="18" y2="18"/>
          </svg>
          <span class="text-xs leading-5">Lihat Katalog Publik</span>
        </a>
      </div>
    </div>

    <div class="flex flex-col justify-start items-start gap-4 shrink-0 pt-6 mt-auto">
      <div class="w-full p-4 bg-white/5 border border-white/10 rounded-xl flex flex-col justify-start items-start gap-2.5">
        <div class="inline-flex items-center gap-2">
          <svg class="w-4 h-4 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <span class="text-white text-xs font-semibold">Format Unggah Sertifikat</span>
        </div>
        <div class="text-slate-300 text-xs font-normal leading-4">Nama file otomatis dipetakan lewat No. Registrasi (REG-xxxx), NIK, atau Email.</div>
      </div>

      <div class="w-full p-2.5 rounded-xl bg-white/5 border border-white/10 flex items-center justify-between gap-2">
        <div class="flex items-center gap-2.5 min-w-0">
          <div class="size-8 rounded-lg bg-blue-900 text-white font-semibold text-xs flex items-center justify-center shrink-0">
            {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 2)) }}
          </div>
          <div class="flex flex-col min-w-0">
            <span class="text-white text-xs font-semibold truncate">{{ Auth::user()->name ?? 'Sekretariat Panitia' }}</span>
            <span class="text-slate-400 text-[11px] truncate">{{ Auth::user()->institution ?? 'Administrator Kegiatan' }}</span>
          </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="shrink-0">
          @csrf
          <button type="submit" title="Keluar" class="p-1.5 text-rose-300 hover:text-white hover:bg-rose-500/20 rounded-md transition cursor-pointer">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
              <polyline points="16 17 21 12 16 7"/>
              <line x1="21" x2="9" y1="12" y2="12"/>
            </svg>
          </button>
        </form>
      </div>

      <div class="w-full flex justify-between items-center text-slate-400 text-[10px] px-1">
        <span>Eventict</span>
        <span>Versi 1.0</span>
      </div>
    </div>
  </aside>

  <div class="flex-1 flex flex-col min-w-0 bg-slate-50">
    <header class="h-16 md:h-20 px-4 sm:px-6 lg:px-8 bg-white border-b border-slate-200 flex justify-between items-center sticky top-0 z-30">
      <div class="flex items-center gap-2 sm:gap-3 min-w-0 flex-1 mr-3">
        <button id="sidebar-open" aria-label="Buka menu navigasi" class="md:hidden p-1.5 sm:p-2 rounded-lg text-slate-600 hover:bg-slate-100 transition cursor-pointer shrink-0">
          <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
        <div class="min-w-0">
          <h1 class="text-slate-900 text-sm sm:text-base md:text-lg font-semibold leading-tight truncate">Pusat Kendali Penyelenggara</h1>
        </div>
      </div>

      <div class="flex items-center gap-2 sm:gap-3 shrink-0">
        <div class="hidden sm:flex items-center gap-1.5 text-xs text-slate-500">
          <svg class="size-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
          </svg>
          <span>Workspace Aktif</span>
        </div>
        <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-medium text-slate-700 hover:bg-slate-50 transition">
          Lihat Beranda
        </a>
      </div>
    </header>

    <main class="flex-1 p-6 lg:p-10 flex flex-col gap-8 overflow-y-auto">
      <div>
        <div class="text-slate-500 text-xs font-normal font-['Poppins']">Organizer / {{ $activeEvent->title ?? 'Simposium Telemedicine 2026' }}</div>
        <h2 class="text-slate-900 text-2xl lg:text-3xl font-semibold font-['Poppins'] leading-tight">Pusat Kendali Operasional Hari-H</h2>
      </div>

      @if (session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start gap-3 text-xs text-emerald-800">
          <svg class="size-4 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="20 6 9 17 4 12"/>
          </svg>
          <div class="font-medium font-['Poppins']">{{ session('success') }}</div>
        </div>
      @endif

      @if (session('warning'))
        <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl flex items-start gap-3 text-xs text-amber-800">
          <svg class="size-4 text-amber-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
          </svg>
          <div class="font-medium font-['Poppins']">{{ session('warning') }}</div>
        </div>
      @endif

      @if (session('error'))
        <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl flex items-start gap-3 text-xs text-rose-800">
          <svg class="size-4 text-rose-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="15" y1="9" x2="9" y2="15"/>
            <line x1="9" y1="9" x2="15" y2="15"/>
          </svg>
          <div class="font-medium font-['Poppins']">{{ session('error') }}</div>
        </div>
      @endif

      <div class="flex flex-wrap items-center gap-3">
        <button type="button" onclick="openBatchUploadModal()" class="px-4 py-2 bg-emerald-700 text-white hover:bg-emerald-800 rounded-lg text-xs font-semibold font-['Poppins'] transition flex items-center gap-2 cursor-pointer shadow-xs">
          <svg class="size-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
            <polyline points="17 8 12 3 7 8"/>
            <line x1="12" x2="12" y1="3" y2="15"/>
          </svg>
          <span>Unggah Sertifikat Massal</span>
        </button>
        <a href="#tabel-peserta" class="px-4 py-2 bg-white border border-slate-300 text-slate-800 hover:bg-slate-50 rounded-lg text-xs font-medium font-['Poppins'] transition flex items-center gap-2 cursor-pointer shadow-2xs">
          <svg class="size-4 text-slate-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
          </svg>
          <span>Panduan Format Nama File</span>
        </a>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="p-5 bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 flex flex-col gap-2 shadow-xs">
          <div class="flex justify-between items-center text-slate-500 text-xs font-medium font-['Poppins']">
            <span>Total Pendaftar Terkonfirmasi</span>
            <svg class="size-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
            </svg>
          </div>
          <div class="text-slate-900 text-2xl font-bold font-['Poppins']">{{ $totalRegistrations }} / {{ $activeEvent->quota ?? 400 }} Kursi</div>
          <div class="w-full bg-slate-100 rounded-full h-1.5 mt-1 overflow-hidden">
            <div class="bg-blue-950 h-1.5 rounded-full" style="width: {{ $activeEvent && $activeEvent->quota > 0 ? min(100, round(($totalRegistrations / $activeEvent->quota) * 100)) : 0 }}%"></div>
          </div>
          <div class="text-slate-500 text-[11px] font-normal font-['Poppins']">{{ $activeEvent && $activeEvent->quota > 0 ? round(($totalRegistrations / $activeEvent->quota) * 100) : 0 }}% kapasitas terisi</div>
        </div>

        <div class="p-5 bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 flex flex-col gap-2 shadow-xs">
          <div class="flex justify-between items-center text-slate-500 text-xs font-medium font-['Poppins']">
            <span>Presensi Kehadiran Real-Time</span>
            <svg class="size-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect width="5" height="5" x="3" y="3" rx="1"/>
              <rect width="5" height="5" x="16" y="3" rx="1"/>
              <rect width="5" height="5" x="3" y="16" rx="1"/>
            </svg>
          </div>
          <div class="text-slate-900 text-2xl font-bold font-['Poppins']">{{ $totalAttended }} Peserta Hadir</div>
          <div class="w-full bg-slate-100 rounded-full h-1.5 mt-1 overflow-hidden">
            <div class="bg-emerald-600 h-1.5 rounded-full" style="width: {{ $totalRegistrations > 0 ? round(($totalAttended / $totalRegistrations) * 100) : 0 }}%"></div>
          </div>
          <div class="text-slate-500 text-[11px] font-normal font-['Poppins']">{{ $totalRegistrations > 0 ? round(($totalAttended / $totalRegistrations) * 100) : 0 }}% tingkat kehadiran</div>
        </div>

        <div class="p-5 bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 flex flex-col gap-2 shadow-xs">
          <div class="flex justify-between items-center text-slate-500 text-xs font-medium font-['Poppins']">
            <span>Sertifikat Telah Diunggah</span>
            <svg class="size-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="8" r="6"/>
              <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
            </svg>
          </div>
          <div class="text-slate-900 text-2xl font-bold font-['Poppins']">{{ $totalCertificates }} Sertifikat Terbit</div>
          <div class="w-full bg-slate-100 rounded-full h-1.5 mt-1 overflow-hidden">
            <div class="bg-blue-950 h-1.5 rounded-full" style="width: {{ $totalRegistrations > 0 ? round(($totalCertificates / $totalRegistrations) * 100) : 0 }}%"></div>
          </div>
          <div class="text-slate-500 text-[11px] font-normal font-['Poppins']">{{ $totalRegistrations > 0 ? round(($totalCertificates / $totalRegistrations) * 100) : 0 }}% peserta memiliki sertifikat</div>
        </div>

        <div class="p-5 bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 flex flex-col gap-2 shadow-xs">
          <div class="flex justify-between items-center text-slate-500 text-xs font-medium font-['Poppins']">
            <span>Total Pemasukan Bersih Tiket</span>
            <svg class="size-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="12" x2="12" y1="2" y2="22"/>
              <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
          </div>
          <div class="text-slate-900 text-2xl font-bold font-['Poppins']">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
          <div class="w-full bg-slate-100 rounded-full h-1.5 mt-1 overflow-hidden">
            <div class="bg-blue-950 h-1.5 rounded-full" style="width: 100%"></div>
          </div>
          <div class="text-slate-500 text-[11px] font-normal font-['Poppins']">Tiket terkonfirmasi • bersih</div>
        </div>
      </div>

      <div id="tabel-peserta" class="bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 p-6 lg:p-8 flex flex-col gap-5 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
          <div>
            <h3 class="text-slate-900 text-lg font-semibold font-['Poppins']">Presensi & Pengelolaan Sertifikat Peserta</h3>
            <p class="text-slate-500 text-xs font-normal font-['Poppins']">Upload sertifikat satuan di setiap baris peserta atau gunakan upload massal.</p>
          </div>
          <button type="button" onclick="openBatchUploadModal()" class="px-3.5 py-1.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold rounded-lg transition cursor-pointer self-start sm:self-auto flex items-center gap-1.5">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
            <span>Upload Massal (Multi-File)</span>
          </button>
        </div>

        <form method="GET" action="{{ route('organizer.dashboard') }}" class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex flex-col md:flex-row items-center gap-3">
          <div class="flex-1 w-full flex items-center gap-2 px-3 py-1 bg-white border border-slate-200 rounded-lg">
            <svg class="size-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="11" r="8"/>
              <path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama / NIK / institusi / no. registrasi..." class="w-full bg-transparent border-none outline-none text-xs text-slate-800 placeholder:text-slate-400">
          </div>
          <select name="attendance" onchange="this.form.submit()" class="w-full md:w-44 px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs text-slate-700 outline-none cursor-pointer">
            <option value="">Semua Presensi</option>
            <option value="attended" {{ request('attendance') === 'attended' ? 'selected' : '' }}>Hadir</option>
            <option value="unattended" {{ request('attendance') === 'unattended' ? 'selected' : '' }}>Belum Hadir</option>
          </select>
          <select name="certificate" onchange="this.form.submit()" class="w-full md:w-48 px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs text-slate-700 outline-none cursor-pointer">
            <option value="">Semua Sertifikat</option>
            <option value="has_cert" {{ request('certificate') === 'has_cert' ? 'selected' : '' }}>Sudah Ada Sertifikat</option>
            <option value="no_cert" {{ request('certificate') === 'no_cert' ? 'selected' : '' }}>Belum Ada Sertifikat</option>
          </select>
          <button type="submit" class="px-4 py-2 bg-blue-950 text-white rounded-lg text-xs font-semibold hover:bg-blue-900 transition cursor-pointer">
            Filter
          </button>
          @if(request()->hasAny(['q', 'attendance', 'certificate']))
            <a href="{{ route('organizer.dashboard') }}" class="px-3 py-2 bg-slate-200 text-slate-700 rounded-lg text-xs font-medium hover:bg-slate-300 transition">
              Reset
            </a>
          @endif
        </form>

        <div class="overflow-x-auto rounded-xl border border-slate-200">
          <table class="w-full min-w-[920px] text-left border-collapse text-xs">
            <thead>
              <tr class="bg-slate-50 text-slate-600 font-semibold font-['Poppins'] border-b border-slate-200">
                <th class="p-3 w-10 text-center"><input type="checkbox" class="rounded border-slate-300"></th>
                <th class="p-3 whitespace-nowrap">No. Registrasi</th>
                <th class="p-3 whitespace-nowrap">Nama Peserta</th>
                <th class="p-3 whitespace-nowrap">Asal Instansi</th>
                <th class="p-3 whitespace-nowrap">Status Presensi</th>
                <th class="p-3 whitespace-nowrap">Status Tiket</th>
                <th class="p-3 whitespace-nowrap">Status Sertifikat</th>
                <th class="p-3 text-center whitespace-nowrap">Aksi Panitia</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 font-['Poppins']">
              @forelse($registrations as $reg)
                <tr class="hover:bg-slate-50 transition">
                  <td class="p-3 text-center"><input type="checkbox" class="rounded border-slate-300"></td>
                  <td class="p-3 font-mono font-medium text-slate-700">#{{ $reg->registration_code }}</td>
                  <td class="p-3 font-semibold text-slate-900">
                    <div>{{ $reg->user->name }}</div>
                    <div class="text-[11px] text-slate-500 font-normal">
                      NIK: {{ $reg->user->nik ?? '-' }} • {{ $reg->user->email }}
                    </div>
                  </td>
                  <td class="p-3 text-slate-700">{{ $reg->user->institution ?? '-' }}</td>
                  <td class="p-3 text-slate-700 whitespace-nowrap">
                    @if($reg->attendance_status === 'attended')
                      <span class="inline-flex items-center gap-1.5 text-emerald-800 font-medium">
                        <span class="size-1.5 rounded-full bg-emerald-600"></span>
                        <span>{{ $reg->checked_in_at ? $reg->checked_in_at->format('H:i') . ' WIB' : 'Hadir' }}</span>
                      </span>
                    @else
                      <span class="text-slate-400">Belum Presensi</span>
                    @endif
                  </td>
                  <td class="p-3 whitespace-nowrap">
                    <span class="px-2 py-0.5 bg-blue-50 text-blue-950 border border-blue-200 font-semibold rounded text-[11px] uppercase">
                      {{ $reg->payment_status === 'paid' ? 'LUNAS' : ($reg->payment_status === 'free' ? 'GRATIS' : 'PENDING') }}
                    </span>
                  </td>
                  <td class="p-3 whitespace-nowrap">
                    @if($reg->certificate)
                      <span class="px-2.5 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 font-semibold rounded-md text-[11px] whitespace-nowrap inline-flex items-center gap-1">
                        <svg class="size-3 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>TERBIT</span>
                      </span>
                    @else
                      <span class="px-2.5 py-1 bg-slate-100 text-slate-600 border border-slate-200 font-medium rounded-md text-[11px] whitespace-nowrap">
                        BELUM TERBIT
                      </span>
                    @endif
                  </td>
                  <td class="p-3 text-center">
                    <div class="flex items-center justify-center gap-1.5">
                      <button
                        type="button"
                        onclick="openSingleUploadModal('{{ $reg->id }}', '{{ addslashes($reg->user->name) }}', '{{ $reg->registration_code }}', '{{ $reg->certificate ? asset($reg->certificate->download_url) : '' }}', '{{ $reg->certificate ? $reg->certificate->certificate_number : '' }}')"
                        title="Upload Sertifikat Manual"
                        class="px-2 py-1 bg-blue-950 hover:bg-blue-900 text-white rounded text-[11px] font-medium transition cursor-pointer flex items-center gap-1"
                      >
                        <svg class="size-3 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                          <polyline points="17 8 12 3 7 8"/>
                          <line x1="12" x2="12" y1="3" y2="15"/>
                        </svg>
                        <span>{{ $reg->certificate ? 'Ganti' : 'Upload' }}</span>
                      </button>

                      @if($reg->certificate)
                        <a
                          href="{{ asset($reg->certificate->download_url) }}"
                          target="_blank"
                          title="Lihat Berkas Sertifikat"
                          class="p-1.5 hover:bg-slate-100 rounded text-slate-700 cursor-pointer border border-slate-200"
                        >
                          <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="8" r="6"/>
                            <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
                          </svg>
                        </a>
                      @endif

                      <form method="POST" action="{{ route('organizer.attendance.toggle', $reg->id) }}" class="inline">
                        @csrf
                        <button
                          type="submit"
                          title="{{ $reg->attendance_status === 'attended' ? 'Batal Hadir' : 'Tandai Hadir' }}"
                          class="p-1.5 hover:bg-slate-100 rounded {{ $reg->attendance_status === 'attended' ? 'text-emerald-700 border border-emerald-200 bg-emerald-50' : 'text-slate-400 border border-slate-200' }} cursor-pointer"
                        >
                          <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"/>
                          </svg>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="8" class="p-8 text-center text-slate-500 font-['Poppins']">
                    Tidak ada data peserta yang sesuai dengan kriteria filter.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-center gap-3 pt-2 text-xs text-slate-500">
          <div>Menampilkan {{ $registrations->count() }} peserta terdaftar</div>
        </div>
      </div>

      <div class="bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 p-6 lg:p-8 flex flex-col gap-6 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
          <div>
            <h3 class="text-slate-900 text-lg font-semibold font-['Poppins']">Panduan Penamaan File untuk Upload Massal</h3>
            <p class="text-slate-500 text-xs font-normal font-['Poppins']">Sistem akan secara otomatis mencocokkan setiap file sertifikat ke profil peserta yang tepat.</p>
          </div>
          <button type="button" onclick="openBatchUploadModal()" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold rounded-lg transition cursor-pointer self-start sm:self-auto flex items-center gap-1.5 shadow-2xs">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
            <span>Buka Form Upload Massal</span>
          </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs font-['Poppins']">
          <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl flex flex-col gap-2">
            <div class="font-semibold text-slate-900 flex items-center gap-2">
              <span class="size-6 rounded-full bg-blue-950 text-white flex items-center justify-center text-[11px] font-bold">1</span>
              <span>Berdasarkan No. Registrasi</span>
            </div>
            <p class="text-slate-600 text-[11px] leading-relaxed">
              Beri nama file PDF sesuai nomor registrasi yang tertera di tiket peserta.
            </p>
            <div class="mt-auto pt-2 font-mono text-[11px] text-blue-950 bg-white p-2 rounded border border-slate-200">
              REG-2026-0104.pdf
            </div>
          </div>

          <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl flex flex-col gap-2">
            <div class="font-semibold text-slate-900 flex items-center gap-2">
              <span class="size-6 rounded-full bg-blue-950 text-white flex items-center justify-center text-[11px] font-bold">2</span>
              <span>Berdasarkan NIM / NIP Peserta</span>
            </div>
            <p class="text-slate-600 text-[11px] leading-relaxed">
              Gunakan nomor NIM atau NIP peserta sebagai nama file dokumen sertifikat.
            </p>
            <div class="mt-auto pt-2 font-mono text-[11px] text-blue-950 bg-white p-2 rounded border border-slate-200">
              2210511001.pdf
            </div>
          </div>

          <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl flex flex-col gap-2">
            <div class="font-semibold text-slate-900 flex items-center gap-2">
              <span class="size-6 rounded-full bg-blue-950 text-white flex items-center justify-center text-[11px] font-bold">3</span>
              <span>Berdasarkan Email Peserta</span>
            </div>
            <p class="text-slate-600 text-[11px] leading-relaxed">
              Beri nama file dengan alamat email resmi peserta yang terdaftar di sistem.
            </p>
            <div class="mt-auto pt-2 font-mono text-[11px] text-blue-950 bg-white p-2 rounded border border-slate-200">
              amanda@rsupcm.co.id.pdf
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<div id="single-upload-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-4">
  <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl flex flex-col gap-5 border border-slate-200">
    <div class="flex justify-between items-center pb-3 border-b border-slate-200">
      <div>
        <h3 class="text-slate-900 font-bold text-base font-['Poppins']">Unggah Sertifikat Peserta</h3>
        <p class="text-slate-500 text-xs">Unggah file PDF atau Gambar sertifikat buatan panitia.</p>
      </div>
      <button type="button" onclick="closeSingleUploadModal()" class="text-slate-400 hover:text-slate-600 p-1 cursor-pointer">
        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
      </button>
    </div>

    <form id="single-upload-form" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
      @csrf
      <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-xs flex flex-col gap-1">
        <div class="text-slate-500">Penerima Sertifikat:</div>
        <div id="single-modal-participant-name" class="font-bold text-slate-900 text-sm"></div>
        <div id="single-modal-participant-code" class="font-mono text-blue-950 font-semibold"></div>
      </div>

      <div id="single-modal-existing-alert" class="p-2.5 bg-emerald-50 border border-emerald-200 rounded-lg text-xs text-emerald-800 hidden items-center justify-between">
        <span>Peserta sudah memiliki berkas sertifikat.</span>
        <a id="single-modal-existing-link" href="#" target="_blank" class="font-semibold underline">Lihat File</a>
      </div>

      <div class="flex flex-col gap-1.5">
        <label class="text-xs font-semibold text-slate-700 font-['Poppins']">Pilih Berkas Sertifikat (PDF / JPG / PNG)</label>
        <input type="file" name="certificate_file" accept=".pdf,.jpg,.jpeg,.png" required class="w-full text-xs text-slate-700 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-950 file:text-white hover:file:bg-blue-900 file:cursor-pointer border border-slate-300 rounded-lg p-2 bg-white">
        <span class="text-[11px] text-slate-500">Maksimum ukuran berkas: 10 MB.</span>
      </div>

      <div class="flex flex-col gap-1.5">
        <label class="text-xs font-semibold text-slate-700 font-['Poppins']">Nomor Sertifikat Resmi (Opsional)</label>
        <input type="text" id="single-modal-cert-number" name="certificate_number" placeholder="Contoh: CERT/LAB-ICT/2026/001 (Kosongkan untuk otomatis)" class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg outline-none focus:border-blue-950">
      </div>

      <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-200">
        <button type="button" onclick="closeSingleUploadModal()" class="px-4 py-2 border border-slate-300 rounded-lg text-xs font-medium text-slate-700 hover:bg-slate-50 cursor-pointer">Batal</button>
        <button type="submit" class="px-4 py-2 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-semibold cursor-pointer shadow-xs">Simpan & Terbitkan</button>
      </div>
    </form>
  </div>
</div>

<div id="batch-upload-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-4">
  <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl flex flex-col gap-5 border border-slate-200">
    <div class="flex justify-between items-center pb-3 border-b border-slate-200">
      <div>
        <h3 class="text-slate-900 font-bold text-base font-['Poppins']">Unggah Sertifikat Massal (Multi-File)</h3>
        <p class="text-slate-500 text-xs">Pilih puluhan hingga ratusan berkas sertifikat sekaligus untuk dipetakan otomatis.</p>
      </div>
      <button type="button" onclick="closeBatchUploadModal()" class="text-slate-400 hover:text-slate-600 p-1 cursor-pointer">
        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
      </button>
    </div>

    <div class="p-3.5 bg-blue-50 border border-blue-200 rounded-xl text-xs text-blue-950 flex flex-col gap-1.5">
      <div class="font-bold flex items-center gap-1.5">
        <svg class="size-4 text-blue-900" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
        <span>Format Penamaan File Otomatis:</span>
      </div>
      <ul class="list-disc list-inside space-y-1 text-slate-700 pl-1 text-[11px]">
        <li><strong>Nomor Registrasi:</strong> <code class="bg-white px-1.5 py-0.5 rounded border border-blue-200 font-mono text-blue-950">REG-2026-0104.pdf</code></li>
        <li><strong>Nomor NIM / NIP:</strong> <code class="bg-white px-1.5 py-0.5 rounded border border-blue-200 font-mono text-blue-950">2210511001.pdf</code></li>
        <li><strong>Email Peserta:</strong> <code class="bg-white px-1.5 py-0.5 rounded border border-blue-200 font-mono text-blue-950">amanda@rsupcm.co.id.pdf</code></li>
      </ul>
    </div>

    <form action="{{ route('organizer.certificate.batch') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
      @csrf
      <div class="flex flex-col gap-1.5">
        <label class="text-xs font-semibold text-slate-700 font-['Poppins']">Pilih File Sertifikat (Bisa blok banyak file sekaligus)</label>
        <input type="file" id="batch-file-input" name="certificate_files[]" accept=".pdf,.jpg,.jpeg,.png" multiple required onchange="handleBatchFileSelect(this)" class="w-full text-xs text-slate-700 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-700 file:text-white hover:file:bg-emerald-800 file:cursor-pointer border border-slate-300 rounded-lg p-2 bg-white">
        <div id="batch-file-count" class="text-[11px] text-slate-500 mt-1">Belum ada file yang dipilih.</div>
      </div>

      <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-200">
        <button type="button" onclick="closeBatchUploadModal()" class="px-4 py-2 border border-slate-300 rounded-lg text-xs font-medium text-slate-700 hover:bg-slate-50 cursor-pointer">Batal</button>
        <button type="submit" class="px-5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg text-xs font-semibold cursor-pointer shadow-xs flex items-center gap-2">
          <svg class="size-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
          <span>Mulai Sinkronisasi & Unggah</span>
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const sidebar = document.getElementById('sidebar');
  const backdrop = document.getElementById('sidebar-backdrop');
  const openBtn = document.getElementById('sidebar-open');
  const closeBtn = document.getElementById('sidebar-close');

  function openSidebar() {
    if (!sidebar) return;
    sidebar.classList.remove('-translate-x-full');
    sidebar.classList.add('translate-x-0');
    if (backdrop) {
      backdrop.classList.remove('hidden');
      backdrop.classList.add('block');
    }
  }

  function closeSidebar() {
    if (!sidebar) return;
    sidebar.classList.add('-translate-x-full');
    sidebar.classList.remove('translate-x-0');
    if (backdrop) {
      backdrop.classList.add('hidden');
      backdrop.classList.remove('block');
    }
  }

  if (openBtn) openBtn.addEventListener('click', openSidebar);
  if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
  if (backdrop) backdrop.addEventListener('click', closeSidebar);
});

function openSingleUploadModal(regId, name, code, existingUrl, certNumber) {
  const modal = document.getElementById('single-upload-modal');
  const form = document.getElementById('single-upload-form');
  const nameEl = document.getElementById('single-modal-participant-name');
  const codeEl = document.getElementById('single-modal-participant-code');
  const certInput = document.getElementById('single-modal-cert-number');
  const existingAlert = document.getElementById('single-modal-existing-alert');
  const existingLink = document.getElementById('single-modal-existing-link');

  if (!modal || !form) return;

  form.action = '/penyelenggara/registrasi/' + regId + '/upload-sertifikat';
  nameEl.textContent = name;
  codeEl.textContent = '#' + code;
  certInput.value = certNumber || '';

  if (existingUrl) {
    existingAlert.classList.remove('hidden');
    existingAlert.classList.add('flex');
    existingLink.href = existingUrl;
  } else {
    existingAlert.classList.add('hidden');
    existingAlert.classList.remove('flex');
  }

  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closeSingleUploadModal() {
  const modal = document.getElementById('single-upload-modal');
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
}

function openBatchUploadModal() {
  const modal = document.getElementById('batch-upload-modal');
  if (modal) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }
}

function closeBatchUploadModal() {
  const modal = document.getElementById('batch-upload-modal');
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
}

function handleBatchFileSelect(input) {
  const countEl = document.getElementById('batch-file-count');
  if (!countEl) return;
  const count = input.files ? input.files.length : 0;
  countEl.textContent = count > 0 ? (count + ' berkas terpilih siap dipetakan.') : 'Belum ada file yang dipilih.';
}
</script>
@endpush

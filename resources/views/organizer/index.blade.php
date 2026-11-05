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
          <span class="text-white text-xs font-semibold leading-tight truncate">Simposium Telemedicine 2026</span>
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

        <a href="#" class="w-full p-3 rounded-lg inline-flex items-center justify-between transition min-h-12 text-slate-300 hover:bg-white/10 font-normal">
          <div class="inline-flex items-center gap-3">
            <svg class="w-4 h-4 shrink-0 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <span class="text-xs leading-5">Peserta & Verifikasi Bayar</span>
          </div>
          <span class="px-2 py-0.5 bg-blue-900 text-blue-200 text-[10px] font-semibold rounded-md">4</span>
        </a>

        <a href="#" class="w-full p-3 rounded-lg inline-flex items-center gap-3 transition min-h-12 text-slate-300 hover:bg-white/10 font-normal">
          <svg class="w-4 h-4 shrink-0 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect width="5" height="5" x="3" y="3" rx="1"/>
            <rect width="5" height="5" x="16" y="3" rx="1"/>
            <rect width="5" height="5" x="3" y="16" rx="1"/>
            <path d="M21 16h-3a2 2 0 0 0-2 2v3"/>
          </svg>
          <span class="text-xs leading-5">Scanner Presensi Masuk</span>
        </a>

        <a href="#" class="w-full p-3 rounded-lg inline-flex items-center gap-3 transition min-h-12 text-slate-300 hover:bg-white/10 font-normal">
          <svg class="w-4 h-4 shrink-0 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="8" x2="21" y1="6" y2="6"/>
            <line x1="8" x2="21" y1="12" y2="12"/>
            <line x1="8" x2="21" y1="18" y2="18"/>
            <line x1="3" x2="3.01" y1="6" y2="6"/>
            <line x1="3" x2="3.01" y1="12" y2="12"/>
            <line x1="3" x2="3.01" y1="18" y2="18"/>
          </svg>
          <span class="text-xs leading-5">Rundown & Narasumber</span>
        </a>

        <a href="#" class="w-full p-3 rounded-lg inline-flex items-center gap-3 transition min-h-12 text-slate-300 hover:bg-white/10 font-normal">
          <svg class="w-4 h-4 shrink-0 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="8" r="6"/>
            <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
          </svg>
          <span class="text-xs leading-5">Template & Terbit Sertifikat</span>
        </a>

        <a href="#" class="w-full p-3 rounded-lg inline-flex items-center gap-3 transition min-h-12 text-slate-300 hover:bg-white/10 font-normal">
          <svg class="w-4 h-4 shrink-0 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" x2="12" y1="2" y2="22"/>
            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
          </svg>
          <span class="text-xs leading-5">Rekapitulasi Keuangan</span>
        </a>

        <a href="#" class="w-full p-3 rounded-lg inline-flex items-center gap-3 transition min-h-12 text-slate-300 hover:bg-white/10 font-normal">
          <svg class="w-4 h-4 shrink-0 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="3"/>
            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
          </svg>
          <span class="text-xs leading-5">Pengaturan Panitia</span>
        </a>
      </div>
    </div>

    <div class="flex flex-col justify-start items-start gap-4 shrink-0 pt-6 mt-auto">
      <div class="w-full p-4 bg-white/5 border border-white/10 rounded-xl flex flex-col justify-start items-start gap-2.5">
        <div class="inline-flex items-center gap-2">
          <svg class="w-4 h-4 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <span class="text-white text-xs font-semibold">Butuh panduan?</span>
        </div>
        <div class="text-slate-300 text-xs font-normal leading-4">Panduan scan presensi, verifikasi peserta, dan penerbitan sertifikat.</div>
        <a href="{{ route('home') }}" class="text-white text-xs font-semibold hover:underline inline-flex items-center gap-1">
          <span>Buka panduan</span>
          <span class="text-[10px]">↗</span>
        </a>
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
        <div class="text-slate-500 text-xs font-normal font-['Poppins']">Organizer / Simposium Telemedicine 2026</div>
        <h2 class="text-slate-900 text-2xl lg:text-3xl font-semibold font-['Poppins'] leading-tight">Pusat Kendali Operasional Hari-H</h2>
      </div>

      <div class="flex flex-wrap items-center gap-3">
        <button type="button" class="px-4 py-2 bg-white border border-slate-300 text-slate-800 hover:bg-slate-50 rounded-lg text-xs font-medium font-['Poppins'] transition flex items-center gap-2 cursor-pointer shadow-2xs">
          <svg class="size-4 text-slate-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
            <polyline points="7 10 12 15 17 10"/>
            <line x1="12" x2="12" y1="15" y2="3"/>
          </svg>
          <span>Ekspor Data (Excel/CSV)</span>
        </button>
        <button type="button" class="px-4 py-2 bg-white border border-slate-300 text-slate-800 hover:bg-slate-50 rounded-lg text-xs font-medium font-['Poppins'] transition flex items-center gap-2 cursor-pointer shadow-2xs">
          <svg class="size-4 text-slate-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
            <circle cx="12" cy="13" r="4"/>
          </svg>
          <span>Buka Kamera Scanner QR</span>
        </button>
        <button type="button" class="px-4 py-2 bg-blue-950 text-white hover:bg-blue-900 rounded-lg text-xs font-medium font-['Poppins'] transition flex items-center gap-2 cursor-pointer shadow-2xs">
          <svg class="size-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="8" r="6"/>
            <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
          </svg>
          <span>Proses Penerbitan Sertifikat</span>
        </button>
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
          <div class="text-slate-900 text-2xl font-bold font-['Poppins']">388 / 400 Kursi</div>
          <div class="w-full bg-slate-100 rounded-full h-1.5 mt-1 overflow-hidden">
            <div class="bg-blue-950 h-1.5 rounded-full" style="width: 97%"></div>
          </div>
          <div class="text-slate-500 text-[11px] font-normal font-['Poppins']">97% kapasitas terisi</div>
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
          <div class="text-slate-900 text-2xl font-bold font-['Poppins']">312 Peserta Hadir</div>
          <div class="w-full bg-slate-100 rounded-full h-1.5 mt-1 overflow-hidden">
            <div class="bg-emerald-600 h-1.5 rounded-full" style="width: 80.4%"></div>
          </div>
          <div class="text-slate-500 text-[11px] font-normal font-['Poppins']">80.4% tingkat kehadiran</div>
        </div>

        <div class="p-5 bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 flex flex-col gap-2 shadow-xs">
          <div class="flex justify-between items-center text-slate-500 text-xs font-medium font-['Poppins']">
            <span>Kuesioner Evaluasi Terkumpul</span>
            <svg class="size-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
              <polyline points="14 2 14 8 20 8"/>
            </svg>
          </div>
          <div class="text-slate-900 text-2xl font-bold font-['Poppins']">280 Responden</div>
          <div class="w-full bg-slate-100 rounded-full h-1.5 mt-1 overflow-hidden">
            <div class="bg-blue-950 h-1.5 rounded-full" style="width: 89.7%"></div>
          </div>
          <div class="text-slate-500 text-[11px] font-normal font-['Poppins']">89.7% dari yang hadir</div>
        </div>

        <div class="p-5 bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 flex flex-col gap-2 shadow-xs">
          <div class="flex justify-between items-center text-slate-500 text-xs font-medium font-['Poppins']">
            <span>Total Pemasukan Bersih Tiket</span>
            <svg class="size-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="12" x2="12" y1="2" y2="22"/>
              <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
          </div>
          <div class="text-slate-900 text-2xl font-bold font-['Poppins']">Rp 135.800.000</div>
          <div class="w-full bg-slate-100 rounded-full h-1.5 mt-1 overflow-hidden">
            <div class="bg-blue-950 h-1.5 rounded-full" style="width: 100%"></div>
          </div>
          <div class="text-slate-500 text-[11px] font-normal font-['Poppins']">Tiket terkonfirmasi • bersih</div>
        </div>
      </div>

      <div class="bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 p-6 lg:p-8 flex flex-col gap-5 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
          <div>
            <h3 class="text-slate-900 text-lg font-semibold font-['Poppins']">Presensi & Kelayakan Sertifikat</h3>
            <p class="text-slate-500 text-xs font-normal font-['Poppins']">Pantau hasil scan, pembayaran, dan pemenuhan syarat peserta.</p>
          </div>
          <div class="text-slate-400 text-xs font-normal font-['Poppins'] flex items-center gap-1.5 self-start sm:self-auto">
            <svg class="size-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/>
            </svg>
            <span>Sinkron 09:05 WIB</span>
          </div>
        </div>

        <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex flex-col md:flex-row items-center gap-3">
          <div class="flex-1 w-full flex items-center gap-2 px-3 py-1 bg-white border border-slate-200 rounded-lg">
            <svg class="size-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="11" r="8"/>
              <path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" placeholder="Cari nama / NIK / institusi..." class="w-full bg-transparent border-none outline-none text-xs text-slate-800 placeholder:text-slate-400">
          </div>
          <select class="w-full md:w-48 px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs text-slate-700 outline-none cursor-pointer">
            <option value="">Semua Presensi</option>
            <option value="hadir">Hadir</option>
            <option value="belum">Belum Hadir</option>
          </select>
          <select class="w-full md:w-44 px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs text-slate-700 outline-none cursor-pointer">
            <option value="">Semua Tiket</option>
            <option value="lunas">Lunas</option>
            <option value="pending">Pending</option>
          </select>
          <select class="w-full md:w-52 px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs text-slate-700 outline-none cursor-pointer">
            <option value="">Semua Kelayakan</option>
            <option value="memenuhi">Memenuhi Syarat</option>
            <option value="tidak">Tidak Memenuhi</option>
          </select>
        </div>

        <div class="overflow-x-auto rounded-xl border border-slate-200">
          <table class="w-full min-w-[860px] text-left border-collapse text-xs">
            <thead>
              <tr class="bg-slate-50 text-slate-600 font-semibold font-['Poppins'] border-b border-slate-200">
                <th class="p-3 w-10 text-center"><input type="checkbox" class="rounded border-slate-300"></th>
                <th class="p-3 whitespace-nowrap">No. Registrasi</th>
                <th class="p-3 whitespace-nowrap">Nama Peserta & Gelar Lengkap</th>
                <th class="p-3 whitespace-nowrap">Asal Instansi / Organisasi</th>
                <th class="p-3 whitespace-nowrap">Waktu Check-In Scan</th>
                <th class="p-3 text-center whitespace-nowrap">Evaluasi</th>
                <th class="p-3 whitespace-nowrap">Status Tiket</th>
                <th class="p-3 whitespace-nowrap">Status Kelayakan</th>
                <th class="p-3 text-center whitespace-nowrap">Aksi Cepat</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 font-['Poppins']">
              <tr class="hover:bg-slate-50 transition">
                <td class="p-3 text-center"><input type="checkbox" class="rounded border-slate-300" checked></td>
                <td class="p-3 font-mono font-medium text-slate-700">#REG-0104</td>
                <td class="p-3 font-semibold text-slate-900">
                  <div>dr. Amanda Putri, Sp.PD</div>
                  <div class="text-[11px] text-slate-500 font-normal">Peserta profesional</div>
                </td>
                <td class="p-3 text-slate-700">RSUP Dr. Cipto Mangunkusumo</td>
                <td class="p-3 text-slate-700">08:24:12 WIB • Pintu Aula Utama</td>
                <td class="p-3 text-center text-emerald-600 font-bold">✓</td>
                <td class="p-3 whitespace-nowrap"><span class="px-2 py-0.5 bg-blue-50 text-blue-950 border border-blue-200 font-semibold rounded text-[11px] whitespace-nowrap">LUNAS</span></td>
                <td class="p-3 whitespace-nowrap"><span class="px-2.5 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 font-semibold rounded-md text-[11px] whitespace-nowrap">MEMENUHI SYARAT</span></td>
                <td class="p-3 text-center">
                  <div class="flex items-center justify-center gap-2">
                    <button type="button" title="Cetak Badge" class="p-1.5 hover:bg-slate-100 rounded text-slate-600 cursor-pointer"><svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg></button>
                    <button type="button" title="Lihat Sertifikat" class="p-1.5 hover:bg-slate-100 rounded text-slate-600 cursor-pointer"><svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg></button>
                  </div>
                </td>
              </tr>
              <tr class="hover:bg-slate-50 transition">
                <td class="p-3 text-center"><input type="checkbox" class="rounded border-slate-300" checked></td>
                <td class="p-3 font-mono font-medium text-slate-700">#REG-0105</td>
                <td class="p-3 font-semibold text-slate-900">
                  <div>dr. Budi Santoso, Sp.JP</div>
                  <div class="text-[11px] text-slate-500 font-normal">Peserta profesional</div>
                </td>
                <td class="p-3 text-slate-700">RS Jantung dan Pembuluh Darah Harapan Kita</td>
                <td class="p-3 text-slate-700">08:26:40 WIB • Pintu Aula Utama</td>
                <td class="p-3 text-center text-emerald-600 font-bold">✓</td>
                <td class="p-3 whitespace-nowrap"><span class="px-2 py-0.5 bg-blue-50 text-blue-950 border border-blue-200 font-semibold rounded text-[11px] whitespace-nowrap">LUNAS</span></td>
                <td class="p-3 whitespace-nowrap"><span class="px-2.5 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 font-semibold rounded-md text-[11px] whitespace-nowrap">MEMENUHI SYARAT</span></td>
                <td class="p-3 text-center">
                  <div class="flex items-center justify-center gap-2">
                    <button type="button" title="Cetak Badge" class="p-1.5 hover:bg-slate-100 rounded text-slate-600 cursor-pointer"><svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg></button>
                    <button type="button" title="Lihat Sertifikat" class="p-1.5 hover:bg-slate-100 rounded text-slate-600 cursor-pointer"><svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg></button>
                  </div>
                </td>
              </tr>
              <tr class="hover:bg-slate-50 transition">
                <td class="p-3 text-center"><input type="checkbox" class="rounded border-slate-300"></td>
                <td class="p-3 font-mono font-medium text-slate-700">#REG-0106</td>
                <td class="p-3 font-semibold text-slate-900">
                  <div>dr. Nur Aisyah, M.Kes</div>
                  <div class="text-[11px] text-slate-500 font-normal">Peserta profesional</div>
                </td>
                <td class="p-3 text-slate-700">Dinas Kesehatan Provinsi DKI Jakarta</td>
                <td class="p-3 text-slate-700">08:28:05 WIB • Pintu Aula Timur</td>
                <td class="p-3 text-center text-slate-300 whitespace-nowrap">-</td>
                <td class="p-3 whitespace-nowrap"><span class="px-2 py-0.5 bg-blue-50 text-blue-950 border border-blue-200 font-semibold rounded text-[11px] whitespace-nowrap">LUNAS</span></td>
                <td class="p-3 whitespace-nowrap"><span class="px-2.5 py-1 bg-slate-100 text-slate-600 border border-slate-200 font-semibold rounded-md text-[11px] whitespace-nowrap">TIDAK MEMENUHI</span></td>
                <td class="p-3 text-center">
                  <div class="flex items-center justify-center gap-2">
                    <button type="button" title="Cetak Badge" class="p-1.5 hover:bg-slate-100 rounded text-slate-600 cursor-pointer"><svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg></button>
                  </div>
                </td>
              </tr>
              <tr class="hover:bg-slate-50 transition">
                <td class="p-3 text-center"><input type="checkbox" class="rounded border-slate-300" checked></td>
                <td class="p-3 font-mono font-medium text-slate-700">#REG-0107</td>
                <td class="p-3 font-semibold text-slate-900">
                  <div>dr. Rizky Pratama, Sp.A</div>
                  <div class="text-[11px] text-slate-500 font-normal">Peserta profesional</div>
                </td>
                <td class="p-3 text-slate-700">RSUP Fatmawati</td>
                <td class="p-3 text-slate-700">08:30:18 WIB • Pintu Aula Utama</td>
                <td class="p-3 text-center text-emerald-600 font-bold">✓</td>
                <td class="p-3 whitespace-nowrap"><span class="px-2 py-0.5 bg-blue-50 text-blue-950 border border-blue-200 font-semibold rounded text-[11px] whitespace-nowrap">LUNAS</span></td>
                <td class="p-3 whitespace-nowrap"><span class="px-2.5 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 font-semibold rounded-md text-[11px] whitespace-nowrap">MEMENUHI SYARAT</span></td>
                <td class="p-3 text-center">
                  <div class="flex items-center justify-center gap-2">
                    <button type="button" title="Cetak Badge" class="p-1.5 hover:bg-slate-100 rounded text-slate-600 cursor-pointer"><svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg></button>
                    <button type="button" title="Lihat Sertifikat" class="p-1.5 hover:bg-slate-100 rounded text-slate-600 cursor-pointer"><svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg></button>
                  </div>
                </td>
              </tr>
              <tr class="hover:bg-slate-50 transition">
                <td class="p-3 text-center"><input type="checkbox" class="rounded border-slate-300" checked></td>
                <td class="p-3 font-mono font-medium text-slate-700">#REG-0108</td>
                <td class="p-3 font-semibold text-slate-900">
                  <div>dr. Dewi Lestari, Sp.KK</div>
                  <div class="text-[11px] text-slate-500 font-normal">Peserta profesional</div>
                </td>
                <td class="p-3 text-slate-700">RSUD Pasar Minggu</td>
                <td class="p-3 text-slate-700">08:32:44 WIB • Pintu Aula Timur</td>
                <td class="p-3 text-center text-emerald-600 font-bold">✓</td>
                <td class="p-3 whitespace-nowrap"><span class="px-2 py-0.5 bg-blue-50 text-blue-950 border border-blue-200 font-semibold rounded text-[11px] whitespace-nowrap">LUNAS</span></td>
                <td class="p-3 whitespace-nowrap"><span class="px-2.5 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 font-semibold rounded-md text-[11px] whitespace-nowrap">MEMENUHI SYARAT</span></td>
                <td class="p-3 text-center">
                  <div class="flex items-center justify-center gap-2">
                    <button type="button" title="Cetak Badge" class="p-1.5 hover:bg-slate-100 rounded text-slate-600 cursor-pointer"><svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg></button>
                    <button type="button" title="Lihat Sertifikat" class="p-1.5 hover:bg-slate-100 rounded text-slate-600 cursor-pointer"><svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg></button>
                  </div>
                </td>
              </tr>
              <tr class="hover:bg-slate-50 transition">
                <td class="p-3 text-center"><input type="checkbox" class="rounded border-slate-300"></td>
                <td class="p-3 font-mono font-medium text-slate-700">#REG-0109</td>
                <td class="p-3 font-semibold text-slate-900">
                  <div>dr. Ahmad Fauzi, M.Biomed</div>
                  <div class="text-[11px] text-slate-500 font-normal">Peserta profesional</div>
                </td>
                <td class="p-3 text-slate-700">Fakultas Kedokteran Universitas Indonesia</td>
                <td class="p-3 text-slate-700">08:35:09 WIB • Pintu Aula Utama</td>
                <td class="p-3 text-center text-slate-300 whitespace-nowrap">-</td>
                <td class="p-3 whitespace-nowrap"><span class="px-2 py-0.5 bg-blue-50 text-blue-950 border border-blue-200 font-semibold rounded text-[11px] whitespace-nowrap">LUNAS</span></td>
                <td class="p-3 whitespace-nowrap"><span class="px-2.5 py-1 bg-slate-100 text-slate-600 border border-slate-200 font-semibold rounded-md text-[11px] whitespace-nowrap">TIDAK MEMENUHI</span></td>
                <td class="p-3 text-center">
                  <div class="flex items-center justify-center gap-2">
                    <button type="button" title="Cetak Badge" class="p-1.5 hover:bg-slate-100 rounded text-slate-600 cursor-pointer"><svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg></button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-center gap-3 pt-2 text-xs text-slate-500">
          <div>Menampilkan 1–6 dari 388 peserta terkonfirmasi</div>
          <div class="flex items-center gap-2">
            <button type="button" class="px-3 py-1.5 bg-white border border-slate-300 hover:bg-slate-50 rounded-md text-xs font-medium cursor-pointer">Sebelumnya</button>
            <span class="px-2.5 py-1 text-slate-700 font-semibold">1 / 65</span>
            <button type="button" class="px-3 py-1.5 bg-white border border-slate-300 hover:bg-slate-50 rounded-md text-xs font-medium cursor-pointer">Berikutnya</button>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 p-6 lg:p-8 flex flex-col gap-6 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
          <div>
            <h3 class="text-slate-900 text-lg font-semibold font-['Poppins']">Panel Konfigurasi Sertifikat Otomatis</h3>
            <p class="text-slate-500 text-xs font-normal font-['Poppins']">Syarat kelayakan penerbitan dan pemetaan data sertifikat digital.</p>
          </div>
          <button type="button" class="px-3 py-1.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-medium rounded-lg transition cursor-pointer self-start sm:self-auto">Pratinjau konfigurasi</button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="flex flex-col gap-3">
            <span class="text-xs font-semibold text-slate-700 uppercase tracking-wider font-['Poppins']">Syarat Penerbitan</span>
            <label class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-3 cursor-pointer hover:bg-slate-100 transition">
              <input type="checkbox" checked class="rounded border-slate-300 size-4 text-blue-950">
              <span class="text-xs text-slate-800 font-medium font-['Poppins']">Minimal kehadiran 80% dari total durasi acara.</span>
            </label>
            <label class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-3 cursor-pointer hover:bg-slate-100 transition">
              <input type="checkbox" checked class="rounded border-slate-300 size-4 text-blue-950">
              <span class="text-xs text-slate-800 font-medium font-['Poppins']">Telah menyelesaikan formulir evaluasi pemateri.</span>
            </label>
            <span class="text-[11px] text-slate-500">Syarat diperiksa otomatis oleh sistem sebelum sertifikat ber-QR terbit.</span>
          </div>

          <div class="flex flex-col gap-3">
            <span class="text-xs font-semibold text-slate-700 uppercase tracking-wider font-['Poppins']">Pemetaan Variabel PDF</span>
            <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg flex items-center justify-between text-xs">
              <span class="font-mono text-blue-950 font-semibold bg-blue-100 px-2 py-0.5 rounded">@{{nama_peserta}}</span>
              <span class="text-slate-700 font-medium">dr. Amanda Putri, Sp.PD</span>
            </div>
            <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg flex items-center justify-between text-xs">
              <span class="font-mono text-blue-950 font-semibold bg-blue-100 px-2 py-0.5 rounded">@{{nomor_skp}}</span>
              <span class="text-slate-700 font-medium">044/PB-IDI/SKP/XI/2026</span>
            </div>
            <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg flex items-center justify-between text-xs">
              <span class="font-mono text-blue-950 font-semibold bg-blue-100 px-2 py-0.5 rounded">@{{qr_verifikasi}}</span>
              <span class="text-slate-700 font-medium font-mono text-[11px]">https://eventict.id/verify/EVT-4409</span>
            </div>
          </div>
        </div>

        <div class="p-4 bg-amber-50/80 border border-amber-200 rounded-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div class="flex items-center gap-3">
            <input type="checkbox" checked class="rounded border-amber-400 size-4 text-amber-600">
            <div>
              <div class="text-xs font-semibold text-amber-950 font-['Poppins']">Konfirmasi sebelum pengiriman massal</div>
              <div class="text-[11px] text-amber-800 font-normal font-['Poppins']">312 peserta akan menerima e-sertifikat melalui email terdaftar dengan QR hash unik.</div>
            </div>
          </div>
          <button type="button" class="px-5 py-2.5 bg-blue-950 hover:bg-blue-900 text-white text-xs font-semibold font-['Poppins'] rounded-lg transition shrink-0 cursor-pointer shadow-xs">
            Kirim E-Sertifikat ke 312 Peserta yang Memenuhi Syarat
          </button>
        </div>
      </div>
    </main>
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
</script>
@endpush

@extends('layouts.app')

@section('title', 'Riwayat & Arsip Event Selesai — Eventict')

@section('content')
<div class="min-h-screen flex bg-slate-50 text-slate-800 antialiased font-['Poppins']">
  <div id="sidebar-backdrop" class="fixed inset-0 z-40 bg-black/50 backdrop-blur-xs hidden md:hidden"></div>

  <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 h-screen bg-blue-950 text-slate-300 flex flex-col justify-between transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 md:sticky md:top-0 md:h-screen shrink-0 px-5 pt-8 pb-6 shadow-xl md:shadow-none overflow-y-auto overscroll-contain">
    <div class="flex flex-col justify-start items-start gap-6 shrink-0">
      <div class="w-full px-2 inline-flex justify-between md:justify-start items-center gap-3">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
          <img src="{{ asset('logo_white.svg') }}" alt="Eventict" class="h-8 w-auto">
        </a>
        <button id="sidebar-close" aria-label="Tutup menu navigasi" class="md:hidden p-2 rounded-lg text-slate-400 hover:text-white hover:bg-white/10 cursor-pointer">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <div class="w-full flex flex-col justify-start items-start gap-1">
        <a href="{{ route('organizer.dashboard') }}" class="w-full p-3 rounded-lg inline-flex items-center justify-between transition min-h-12 text-slate-300 hover:bg-white/10 font-normal">
          <div class="inline-flex items-center gap-3">
            <svg class="w-4 h-4 shrink-0 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect width="18" height="18" x="3" y="3" rx="2"/>
              <path d="M3 9h18"/>
              <path d="M9 21V9"/>
            </svg>
            <span class="text-xs leading-5">Ringkasan & Operasional</span>
          </div>
          @if($upcomingCount > 0)
            <span class="px-2 py-0.5 bg-blue-900 text-blue-200 text-[10px] font-semibold rounded-md">{{ $upcomingCount }} Aktif</span>
          @endif
        </a>

        <a href="{{ route('organizer.history') }}" class="w-full p-3 rounded-lg inline-flex items-center justify-between transition min-h-12 bg-blue-900 text-white font-semibold">
          <div class="inline-flex items-center gap-3">
            <svg class="w-4 h-4 shrink-0 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <polyline points="12 6 12 12 16 14"/>
            </svg>
            <span class="text-xs leading-5">Riwayat Event Selesai</span>
          </div>
          <span class="px-2 py-0.5 bg-white/20 text-white text-[10px] font-semibold rounded-md">{{ $pastEventsCount }}</span>
        </a>

        @if(Auth::user()->isAdministrator())
          <a href="{{ route('admin.users.index') }}" class="w-full p-3 rounded-lg inline-flex items-center gap-3 transition min-h-12 text-slate-300 hover:bg-white/10 font-normal">
            <svg class="w-4 h-4 shrink-0 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <span class="text-xs leading-5">Kelola User</span>
          </a>
        @endif

        <a href="{{ route('home') }}" class="w-full p-3 rounded-lg inline-flex items-center gap-3 transition min-h-12 text-slate-300 hover:bg-white/10 font-normal">
          <svg class="w-4 h-4 shrink-0 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="8" x2="21" y1="6" y2="6"/>
            <line x1="8" x2="21" y1="12" y2="12"/>
            <line x1="8" x2="21" y1="18" y2="18"/>
            <line x1="3" x2="3.01" y1="6" y2="6"/>
            <line x1="3" x2="3.01" y1="12" y2="12"/>
            <line x1="3" x2="3.01" y1="18" y2="18"/>
          </svg>
          <span class="text-xs leading-5">Lihat Halaman Utama</span>
        </a>
      </div>
    </div>

    <div class="flex flex-col justify-start items-start gap-4 shrink-0 pt-6 mt-auto">
      <div class="w-full p-2.5 rounded-xl bg-white/5 border border-white/10 flex items-center justify-between gap-2">
        <div class="flex items-center gap-2.5 min-w-0">
          <div class="size-8 rounded-lg bg-blue-900 text-white font-semibold text-xs flex items-center justify-center shrink-0">
            {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 2)) }}
          </div>
          <div class="flex flex-col min-w-0">
            <span class="text-white text-xs font-semibold truncate">{{ Auth::user()->name ?? 'Sekretariat Panitia' }}</span>
            <span class="text-slate-400 text-[11px] truncate">{{ Auth::user()->institution ?? 'Laboratorium ICT' }}</span>
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
        <span>Eventict Lab ICT</span>
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
          <h1 class="text-slate-900 text-sm sm:text-base md:text-lg font-semibold leading-tight truncate">Riwayat & Arsip Event Selesai</h1>
        </div>
      </div>

      <div class="flex items-center gap-2 sm:gap-3 shrink-0">
        <a href="{{ route('organizer.dashboard') }}" class="px-3 py-1.5 rounded-lg bg-blue-950 text-white text-xs font-semibold hover:bg-blue-900 transition flex items-center gap-1.5 shadow-xs">
          <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect width="18" height="18" x="3" y="3" rx="2"/>
            <path d="M3 9h18"/>
            <path d="M9 21V9"/>
          </svg>
          <span>Ke Event Aktif</span>
        </a>
      </div>
    </header>

    <main class="flex-1 p-6 lg:p-10 pb-24 md:pb-10 flex flex-col gap-6 overflow-y-auto">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <div class="text-slate-500 text-xs font-normal font-['Poppins']">Arsip Penyelenggaraan / Laboratorium ICT</div>
          <h2 class="text-slate-900 text-2xl font-semibold font-['Poppins'] leading-tight">Daftar Event yang Telah Selesai</h2>
        </div>
        <div class="flex items-center gap-3">
          <a href="{{ route('organizer.export', ['event_id' => 'all']) }}" class="px-3.5 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-lg transition flex items-center gap-2 shadow-2xs">
            <svg class="size-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
              <polyline points="7 10 12 15 17 10"/>
              <line x1="12" x2="12" y1="15" y2="3"/>
            </svg>
            <span>Ekspor Semua Data Peserta (XLSX)</span>
          </a>
        </div>
      </div>

      <form method="GET" action="{{ route('organizer.history') }}" class="p-3 bg-white rounded-xl border border-slate-200 flex flex-col sm:flex-row items-center gap-3 shadow-xs">
        <div class="flex-1 w-full flex items-center gap-2 px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg">
          <svg class="size-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/>
            <path d="m21 21-4.35-4.35"/>
          </svg>
          <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama event, kategori, atau lokasi..." class="w-full bg-transparent border-none outline-none text-xs text-slate-800 placeholder:text-slate-400">
        </div>
        <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-blue-950 text-white rounded-lg text-xs font-semibold hover:bg-blue-900 transition">
          Cari Arsip
        </button>
        @if(request('q'))
          <a href="{{ route('organizer.history') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium rounded-lg transition">
            Reset
          </a>
        @endif
      </form>

      <div class="grid grid-cols-1 gap-4">
        @forelse($pastEvents as $event)
          <div class="p-5 bg-white rounded-xl border border-slate-200 hover:border-slate-300 transition shadow-xs flex flex-col lg:flex-row lg:items-center justify-between gap-5">
            <div class="flex-1 flex flex-col gap-2">
              <div class="flex flex-wrap items-center gap-2">
                <span class="px-2.5 py-0.5 bg-slate-100 text-slate-700 text-[11px] font-semibold rounded-md border border-slate-200 tracking-wide">
                  {{ $event->format === 'offline' ? 'Luring' : 'Daring' }}
                </span>
                <span class="px-2.5 py-0.5 bg-blue-50 text-blue-950 text-[11px] font-semibold rounded-md border border-blue-200">
                  {{ $event->category }}
                </span>
                <span class="text-xs text-slate-400 font-normal">
                  Selesai pada: {{ \Carbon\Carbon::parse($event->end_date)->translatedFormat('d M Y') }}
                </span>
              </div>
              <h3 class="text-slate-900 text-base font-semibold font-['Poppins']">
                {{ $event->title }}
              </h3>
              <p class="text-slate-500 text-xs line-clamp-1 max-w-3xl">
                {{ $event->description }}
              </p>
            </div>

            <div class="flex flex-wrap sm:flex-nowrap items-center gap-6 shrink-0 pt-3 lg:pt-0 border-t lg:border-t-0 border-slate-100">
              <div class="flex flex-col text-center sm:text-left">
                <span class="text-[11px] text-slate-400 uppercase tracking-wider">Total Peserta</span>
                <span class="text-slate-900 text-base font-bold">{{ $event->registrations_count }}</span>
              </div>
              <div class="flex flex-col text-center sm:text-left">
                <span class="text-[11px] text-slate-400 uppercase tracking-wider">Kehadiran</span>
                <span class="text-emerald-700 text-base font-bold">{{ $event->attended_count }}</span>
              </div>
              <div class="flex flex-col text-center sm:text-left">
                <span class="text-[11px] text-slate-400 uppercase tracking-wider">Sertifikat</span>
                <span class="text-blue-950 text-base font-bold">{{ $event->certificates_count }}</span>
              </div>
              <div class="flex items-center gap-2 ml-auto lg:ml-2">
                <a href="{{ route('organizer.dashboard', ['event_id' => $event->id]) }}" class="px-3.5 py-2 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-semibold transition shadow-xs flex items-center gap-1.5">
                  <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                    <circle cx="12" cy="12" r="3"/>
                  </svg>
                  <span>Buka Data</span>
                </a>
                <a href="{{ route('organizer.export', ['event_id' => $event->id]) }}" title="Unduh Rekap XLSX" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-medium transition border border-slate-200">
                  <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" x2="12" y1="15" y2="3"/>
                  </svg>
                </a>
              </div>
            </div>
          </div>
        @empty
          <div class="p-12 bg-white rounded-2xl border border-slate-200 text-center flex flex-col items-center justify-center gap-2">
            <svg class="size-12 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
              <circle cx="12" cy="12" r="10"/>
              <polyline points="12 6 12 12 16 14"/>
            </svg>
            <div class="text-slate-800 font-semibold text-sm">Belum ada riwayat event yang telah selesai</div>
            <p class="text-slate-500 text-xs max-w-sm">Semua event yang telah melewati tanggal akhir pelaksanaan akan otomatis tersimpan rapi di halaman arsip ini.</p>
          </div>
        @endforelse
      </div>
    </main>
  </div>
</div>
  @include('partials.organizer-bottom-nav')
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

@extends('layouts.app')

@section('title', 'Portal Pengelola Kegiatan — Eventict Lab ICT')

@section('content')
<div class="min-h-screen bg-slate-50 text-slate-800 antialiased font-['Poppins'] flex flex-col">
  <header class="bg-blue-950 text-white border-b border-blue-900 sticky top-0 z-30 shadow-xs">
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
          <a href="{{ route('organizer.dashboard') }}" class="px-3.5 py-2 rounded-lg text-xs font-semibold bg-white/10 text-white transition flex items-center gap-2">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect width="18" height="18" x="3" y="3" rx="2"/>
              <path d="M3 9h18"/>
              <path d="M9 21V9"/>
            </svg>
            <span>Semua Kegiatan</span>
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
        </nav>
      </div>

      <div class="flex items-center gap-3">
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
            {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 2)) }}
          </div>
          <div class="hidden lg:flex flex-col min-w-0">
            <span class="text-white text-xs font-semibold truncate">{{ Auth::user()->name ?? 'Sekretariat Panitia' }}</span>
            <span class="text-slate-400 text-[11px] truncate">Laboratorium ICT</span>
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

  <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col gap-8">
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

    <div class="bg-gradient-to-r from-blue-950 via-slate-900 to-blue-900 rounded-2xl p-6 sm:p-8 text-white shadow-xs flex flex-col lg:flex-row lg:items-center justify-between gap-6">
      <div class="flex flex-col gap-2 max-w-2xl">
        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-md bg-white/10 text-blue-200 text-xs font-medium w-fit">
          <span>Laboratorium ICT — Unit 7 Lantai 4</span>
        </div>
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold tracking-tight text-white">
          Selamat Datang, {{ Auth::user()->name }}
        </h1>
        <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
          Pilih salah satu kegiatan di bawah untuk membuka ruang kerja operasional (presensi, <span class="whitespace-nowrap">e-sertifikat</span>, tiket) atau tambahkan kegiatan baru.
        </p>
      </div>

      <div class="flex items-center gap-3 flex-wrap">
        <button type="button" onclick="openCreateEventModal()" class="px-5 py-2.5 bg-white text-blue-950 rounded-xl text-xs font-semibold hover:bg-slate-100 transition shadow-xs flex items-center gap-2 cursor-pointer">
          <svg class="size-4 text-blue-950" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
          </svg>
          <span>Buat Kegiatan Baru</span>
        </button>
      </div>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div class="flex items-center gap-2 p-1 bg-white border border-slate-200 rounded-xl w-fit shadow-2xs">
        <a href="{{ route('organizer.dashboard', ['status' => 'all']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ $statusFilter === 'all' ? 'bg-blue-950 text-white' : 'text-slate-600 hover:text-slate-900' }}">
          Semua Kegiatan
        </a>
        <a href="{{ route('organizer.dashboard', ['status' => 'upcoming']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition flex items-center gap-1.5 {{ $statusFilter === 'upcoming' ? 'bg-blue-950 text-white' : 'text-slate-600 hover:text-slate-900' }}">
          <span>Mendatang / Berjalan</span>
          <span class="px-1.5 py-0.2 rounded-md text-[10px] {{ $statusFilter === 'upcoming' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $upcomingCount }}</span>
        </a>
        <a href="{{ route('organizer.dashboard', ['status' => 'past']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition flex items-center gap-1.5 {{ $statusFilter === 'past' ? 'bg-blue-950 text-white' : 'text-slate-600 hover:text-slate-900' }}">
          <span>Riwayat Selesai</span>
          <span class="px-1.5 py-0.2 rounded-md text-[10px] {{ $statusFilter === 'past' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $pastCount }}</span>
        </a>
      </div>

      <form method="GET" action="{{ route('organizer.dashboard') }}" class="flex items-center gap-2 max-w-sm w-full">
        <input type="hidden" name="status" value="{{ $statusFilter }}">
        <div class="relative w-full">
          <svg class="size-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/>
            <path d="m21 21-4.3-4.3"/>
          </svg>
          <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kegiatan..." class="w-full pl-9 pr-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 outline-none focus:border-blue-950 shadow-2xs">
        </div>
        <button type="submit" class="px-3 py-2 bg-slate-900 text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition cursor-pointer">
          Cari
        </button>
      </form>
    </div>

    @if($events->isEmpty())
      <div class="p-12 bg-white rounded-2xl border border-slate-200 text-center flex flex-col items-center justify-center gap-3">
        <div class="size-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center">
          <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect width="18" height="18" x="3" y="3" rx="2"/>
            <line x1="3" x2="21" y1="9" y2="9"/>
            <line x1="9" x2="9" y1="21" y2="9"/>
          </svg>
        </div>
        <h3 class="text-sm font-semibold text-slate-900">Tidak Ada Kegiatan yang Sesuai</h3>
        <p class="text-xs text-slate-500 max-w-md">Belum ada kegiatan pada filter ini atau kata kunci tidak ditemukan. Silakan buat kegiatan baru atau ubah filter pencarian.</p>
        <button type="button" onclick="openCreateEventModal()" class="mt-2 px-4 py-2 bg-blue-950 text-white rounded-lg text-xs font-semibold hover:bg-blue-900 transition">
          Buat Kegiatan Baru
        </button>
      </div>
    @else
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($events as $evt)
          @php
            $isPast = \Carbon\Carbon::parse($evt->end_date)->isPast();
            $quotaPct = $evt->quota > 0 ? min(100, round(($evt->registrations_count / $evt->quota) * 100)) : 0;
          @endphp
          <div class="bg-white rounded-2xl border border-slate-200 hover:border-blue-900 hover:shadow-md transition duration-200 flex flex-col justify-between overflow-hidden group">
            <div class="p-6 flex flex-col gap-4">
              <div class="flex items-center justify-between gap-2">
                <div class="flex items-center gap-1.5 flex-wrap">
                  <span class="px-2.5 py-0.5 rounded-md text-[10px] font-semibold tracking-wider uppercase bg-blue-50 text-blue-950 border border-blue-100">
                    {{ $evt->category }}
                  </span>
                  <span class="px-2 py-0.5 rounded-md text-[10px] font-medium uppercase bg-slate-100 text-slate-700">
                    {{ $evt->format }}
                  </span>
                </div>

                @if($isPast)
                  <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                    Selesai
                  </span>
                @else
                  <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    Aktif
                  </span>
                @endif
              </div>

              <div class="flex flex-col gap-1">
                <a href="{{ route('organizer.workspace', ['event' => $evt->id]) }}" class="text-sm sm:text-base font-semibold text-slate-900 group-hover:text-blue-950 transition leading-snug line-clamp-2">
                  {{ $evt->title }}
                </a>
                <span class="text-slate-500 text-xs flex items-center gap-1.5 mt-1">
                  <svg class="size-3.5 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                    <line x1="16" x2="16" y1="2" y2="6"/>
                    <line x1="8" x2="8" y1="2" y2="6"/>
                    <line x1="3" x2="21" y1="10" y2="10"/>
                  </svg>
                  <span>{{ \Carbon\Carbon::parse($evt->start_date)->translatedFormat('d M Y') }} • {{ substr($evt->start_time, 0, 5) }} WIB</span>
                </span>
                <span class="text-slate-500 text-xs flex items-center gap-1.5">
                  <svg class="size-3.5 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                    <circle cx="12" cy="10" r="3"/>
                  </svg>
                  <span class="truncate">{{ $evt->location }}</span>
                </span>
              </div>

              <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
                <div class="flex items-center justify-between text-xs">
                  <span class="text-slate-500">Kuota Terisi</span>
                  <span class="font-semibold text-slate-900">{{ $evt->registrations_count }} / {{ $evt->quota }} Peserta ({{ $quotaPct }}%)</span>
                </div>
                <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                  <div class="h-full bg-blue-950 rounded-full transition-all" style="width: {{ $quotaPct }}%"></div>
                </div>
              </div>

              <div class="flex items-center justify-between text-[11px] text-slate-500 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                <span>Kehadiran: <strong class="text-slate-900">{{ $evt->attended_count }}</strong></span>
                <span>Sertifikat: <strong class="text-slate-900">{{ $evt->certificates_count }}</strong></span>
                <span>Pengisi Acara: <strong class="text-slate-900">{{ $evt->speakers->count() }}</strong></span>
              </div>
            </div>

            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
              <span class="text-xs font-semibold text-slate-700">
                {{ $evt->price == 0 ? 'Gratis' : 'Rp ' . number_format($evt->price, 0, ',', '.') }}
              </span>
              <a href="{{ route('organizer.workspace', ['event' => $evt->id]) }}" class="px-3.5 py-1.5 bg-blue-950 text-white rounded-lg text-xs font-semibold hover:bg-blue-900 transition flex items-center gap-1.5 shadow-2xs">
                <span>Buka Workspace</span>
                <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <polyline points="9 18 15 12 9 6"/>
                </svg>
              </a>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </main>

  <div id="modal-create-event" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full p-6 sm:p-8 flex flex-col gap-6 shadow-2xl max-h-[90vh] overflow-y-auto">
      <div class="flex items-start justify-between gap-4 pb-4 border-b border-slate-100">
        <div class="flex flex-col">
          <h2 class="text-base sm:text-lg font-bold text-slate-900">Buat Kegiatan Baru Lab ICT</h2>
          <p class="text-xs text-slate-500 mt-0.5">Isi rincian kegiatan seminar atau workshop. Ruang kerja operasional akan langsung dibuat otomatis.</p>
        </div>
        <button type="button" onclick="closeCreateEventModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 cursor-pointer">
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>

      <form action="{{ route('organizer.event.store') }}" method="POST" class="flex flex-col gap-4 text-xs">
        @csrf
        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Judul Kegiatan</label>
          <input type="text" name="title" required placeholder="Contoh: Workshop Cloud Computing & DevSecOps 2026" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Kategori <span class="text-rose-500">*</span></label>
            <select name="category" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 cursor-pointer">
              <option value="Workshop">Workshop</option>
              <option value="Seminar">Seminar</option>
              <option value="Webinar">Webinar</option>
              <option value="Sertifikasi">Sertifikasi</option>
            </select>
          </div>

          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Format Pelaksanaan <span class="text-rose-500">*</span></label>
            <select name="format" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 cursor-pointer">
              <option value="offline">Offline</option>
              <option value="online">Online</option>
              <option value="hybrid">Hybrid</option>
            </select>
          </div>
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Lokasi / Ruang Lab</label>
          <input type="text" name="location" required value="Laboratorium ICT, Unit 7 Lantai 4, Universitas Budi Luhur" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Tanggal Mulai</label>
            <input type="date" name="start_date" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
          </div>
          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Tanggal Selesai</label>
            <input type="date" name="end_date" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Jam Mulai</label>
            <input type="time" name="start_time" value="09:00" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
          </div>
          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Jam Selesai</label>
            <input type="time" name="end_time" value="12:00" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Target Kuota Peserta</label>
            <input type="number" name="quota" value="100" min="1" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
          </div>
          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Biaya Pendaftaran (Rp, 0 jika gratis)</label>
            <input type="number" name="price" value="0" min="0" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
          </div>
        </div>

        <!-- Bagian Pengisi Acara Kegiatan (Dinamis: Nama, Peran [MC, Pemateri, Moderator], + Tambah) -->
        <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl flex flex-col gap-3">
          <div class="flex items-center justify-between flex-wrap gap-2">
            <div class="flex items-center gap-2">
              <span class="font-bold text-slate-800 text-xs">Pengisi Acara Kegiatan <span class="text-rose-500">*</span></span>
              <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-rose-100 text-rose-800 border border-rose-200">Wajib minimal 1 orang</span>
            </div>
            <a href="{{ route('organizer.speakers.index') }}" target="_blank" class="text-[11px] text-blue-900 font-semibold hover:underline inline-flex items-center gap-1">
              <span>Kelola Data Pengisi Acara</span>
              <svg class="size-3 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                <polyline points="15 3 21 3 21 9"/>
                <line x1="10" y1="14" x2="21" y2="3"/>
              </svg>
            </a>
          </div>

          <!-- Table Header (Desktop) -->
          <div class="hidden sm:grid sm:grid-cols-12 gap-2 px-1 text-[10px] font-semibold text-slate-400 uppercase tracking-wider">
            <div class="col-span-3">Peran</div>
            <div class="col-span-5">Nama Pengisi Acara <span class="text-rose-500">*</span></div>
            <div class="col-span-3">Pilihan Peran</div>
            <div class="col-span-1 text-center">Hapus</div>
          </div>

          <!-- Dynamic Container -->
          <div id="speaker-rows-container" class="flex flex-col gap-2">
            <!-- Row Default -->
            <div class="speaker-row p-2.5 sm:p-2 bg-white border border-slate-200 rounded-xl grid grid-cols-1 sm:grid-cols-12 items-center gap-2 transition hover:border-slate-300 shadow-2xs">
              <!-- Label / Badge Peran -->
              <div class="sm:col-span-3 flex items-center justify-between sm:justify-start">
                <span class="sm:hidden text-[11px] font-semibold text-slate-500">Peran:</span>
                <span class="role-badge px-2.5 py-1.5 rounded-lg text-[11px] font-bold bg-blue-100 text-blue-950 border border-blue-200 w-full text-center truncate">
                  Pemateri
                </span>
              </div>

              <!-- Select Nama Pengisi Acara -->
              <div class="sm:col-span-5">
                <select name="speaker_ids[]" required onchange="updateSpeakerRoleLabels()" class="speaker-select w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs outline-none focus:border-blue-950 focus:bg-white cursor-pointer">
                  <option value="" disabled selected>-- Pilih Pengisi Acara (Wajib) --</option>
                  @foreach($masterSpeakers as $spk)
                    <option value="{{ $spk->id }}">{{ $spk->name }} ({{ $spk->institution ?? 'Lab ICT' }})</option>
                  @endforeach
                </select>
              </div>

              <!-- Select Peran (MC, Pemateri, Moderator) -->
              <div class="sm:col-span-3">
                <select name="speaker_roles[]" onchange="updateSpeakerRoleLabels()" class="role-select w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-semibold outline-none focus:border-blue-950 focus:bg-white cursor-pointer">
                  <option value="Pemateri" selected>Pemateri</option>
                  <option value="Moderator">Moderator</option>
                  <option value="MC">MC</option>
                </select>
              </div>

              <!-- Tombol Hapus -->
              <div class="sm:col-span-1 flex justify-end sm:justify-center">
                <button type="button" onclick="removeSpeakerRow(this)" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition cursor-pointer" title="Hapus pengisi acara ini">
                  <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <div class="pt-1">
            <button type="button" onclick="addSpeakerRow()" class="px-3.5 py-2 rounded-xl border border-dashed border-blue-400 bg-white hover:bg-blue-50 text-blue-950 font-semibold text-xs transition flex items-center gap-1.5 cursor-pointer shadow-2xs">
              <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
              </svg>
              <span>Tambah Pengisi Acara (Pemateri, MC, Moderator)</span>
            </button>
          </div>
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Deskripsi Ringkas Kegiatan</label>
          <textarea name="description" rows="3" required placeholder="Tuliskan tujuan dan pokok materi kegiatan..." class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 leading-relaxed"></textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
          <button type="button" onclick="closeCreateEventModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 cursor-pointer">
            Batal
          </button>
          <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-950 hover:bg-blue-900 text-white font-semibold shadow-xs cursor-pointer">
            Buat Kegiatan & Buka Workspace
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
const speakerMasterOptions = `@foreach($masterSpeakers as $spk)<option value="{{ $spk->id }}">{{ addslashes($spk->name) }} ({{ addslashes($spk->institution ?? 'Lab ICT') }})</option>@endforeach`;

function updateSpeakerRoleLabels() {
  const container = document.getElementById('speaker-rows-container');
  if (!container) return;
  const rows = container.querySelectorAll('.speaker-row');

  // Count each role
  const roleCounts = {};
  rows.forEach(r => {
    const sel = r.querySelector('.role-select');
    if (sel) {
      const val = sel.value;
      roleCounts[val] = (roleCounts[val] || 0) + 1;
    }
  });

  // Assign indexed label and badge color
  const roleRunning = {};
  rows.forEach(r => {
    const sel = r.querySelector('.role-select');
    const badge = r.querySelector('.role-badge');
    if (sel && badge) {
      const val = sel.value;
      let labelText = val;
      if (roleCounts[val] > 1) {
        roleRunning[val] = (roleRunning[val] || 0) + 1;
        labelText = `${val} ${roleRunning[val]}`;
      }
      badge.textContent = labelText;

      // Color scheme based on role
      badge.className = 'role-badge px-2.5 py-1.5 rounded-lg text-[11px] font-bold w-full text-center truncate border transition ';
      if (val === 'Moderator') {
        badge.className += 'bg-amber-100 text-amber-900 border-amber-200';
      } else if (val === 'MC') {
        badge.className += 'bg-purple-100 text-purple-900 border-purple-200';
      } else {
        badge.className += 'bg-blue-100 text-blue-950 border-blue-200';
      }
    }
  });
}

function addSpeakerRow() {
  const container = document.getElementById('speaker-rows-container');
  if (!container) return;

  const div = document.createElement('div');
  div.className = 'speaker-row p-2.5 sm:p-2 bg-white border border-slate-200 rounded-xl grid grid-cols-1 sm:grid-cols-12 items-center gap-2 transition hover:border-slate-300 shadow-2xs';
  div.innerHTML = `
    <div class="sm:col-span-3 flex items-center justify-between sm:justify-start">
      <span class="sm:hidden text-[11px] font-semibold text-slate-500">Peran:</span>
      <span class="role-badge px-2.5 py-1.5 rounded-lg text-[11px] font-bold bg-blue-100 text-blue-950 border border-blue-200 w-full text-center truncate">
        Pemateri
      </span>
    </div>

    <div class="sm:col-span-5">
      <select name="speaker_ids[]" required onchange="updateSpeakerRoleLabels()" class="speaker-select w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs outline-none focus:border-blue-950 focus:bg-white cursor-pointer">
        <option value="" disabled selected>-- Pilih Pengisi Acara (Wajib) --</option>
        ${speakerMasterOptions}
      </select>
    </div>

    <div class="sm:col-span-3">
      <select name="speaker_roles[]" onchange="updateSpeakerRoleLabels()" class="role-select w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-semibold outline-none focus:border-blue-950 focus:bg-white cursor-pointer">
        <option value="Pemateri" selected>Pemateri</option>
        <option value="Moderator">Moderator</option>
        <option value="MC">MC</option>
      </select>
    </div>

    <div class="sm:col-span-1 flex justify-end sm:justify-center">
      <button type="button" onclick="removeSpeakerRow(this)" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition cursor-pointer" title="Hapus pengisi acara ini">
        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"/>
          <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>
  `;

  container.appendChild(div);
  updateSpeakerRoleLabels();
}

function removeSpeakerRow(btn) {
  const row = btn.closest('.speaker-row');
  const container = document.getElementById('speaker-rows-container');
  if (row && container) {
    if (container.querySelectorAll('.speaker-row').length > 1) {
      row.remove();
    } else {
      const sel = row.querySelector('.speaker-select');
      if (sel) sel.value = '';
      const roleSel = row.querySelector('.role-select');
      if (roleSel) roleSel.value = 'Pemateri';
    }
    updateSpeakerRoleLabels();
  }
}

function openCreateEventModal() {
  const m = document.getElementById('modal-create-event');
  m.classList.remove('hidden');
  m.classList.add('flex');
}

function closeCreateEventModal() {
  const m = document.getElementById('modal-create-event');
  m.classList.add('hidden');
  m.classList.remove('flex');
}
</script>
@endsection

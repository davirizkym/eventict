@extends('layouts.app')

@section('title', 'Portal Pengelola Kegiatan — Eventict Lab ICT')

@section('content')
<div class="min-h-screen bg-slate-50 text-slate-800 antialiased font-['Poppins'] flex flex-col">
  @include('partials.organizer-header')

  <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-24 md:pb-8 flex flex-col gap-8">
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

    @if ($errors->any())
      <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl flex items-start gap-3 text-xs text-rose-800">
        <svg class="size-4 text-rose-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/>
          <line x1="15" y1="9" x2="9" y2="15"/>
          <line x1="9" y1="9" x2="15" y2="15"/>
        </svg>
        <div class="flex flex-col gap-1">
          <span class="font-bold">Gagal Menyimpan Kegiatan:</span>
          <ul class="list-disc list-inside">
            @foreach ($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
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
            $isFull = $evt->quota > 0 && $evt->registrations_count >= $evt->quota;
          @endphp
          <div class="bg-white rounded-2xl border border-slate-200 hover:border-blue-900 hover:shadow-md transition duration-200 flex flex-col justify-between overflow-hidden group">
            <div class="p-6 flex flex-col gap-4">
              <div class="flex items-center justify-between gap-2">
                <div class="flex items-center gap-1.5 flex-wrap">
                  <span class="px-2.5 py-0.5 rounded-md text-[10px] font-semibold tracking-wider uppercase bg-blue-50 text-blue-950 border border-blue-100">
                    {{ $evt->category }}
                  </span>
                  <span class="px-2 py-0.5 rounded-md text-[10px] font-medium bg-slate-100 text-slate-700">
                    {{ $evt->format === 'offline' ? 'Luring' : 'Daring' }}
                  </span>
                  @if(($evt->organizer_type ?? 'internal') === 'partner')
                    <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                      Penyelenggara: {{ $evt->organizer_name }}
                    </span>
                  @endif
                </div>

                @if($isPast)
                  <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                    Selesai
                  </span>
                @elseif($isFull)
                  <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                    Penuh
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
                  <div class="flex items-center gap-1.5">
                    @if($isFull)
                      <span class="px-1.5 py-0.2 rounded text-[10px] font-semibold bg-rose-100 text-rose-700">Penuh</span>
                    @endif
                    <span class="font-semibold text-slate-900">{{ $evt->registrations_count }} / {{ $evt->quota }} Peserta ({{ $quotaPct }}%)</span>
                  </div>
                </div>
                <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                  <div class="h-full {{ $isFull ? 'bg-rose-600' : 'bg-blue-950' }} rounded-full transition-all" style="width: {{ $quotaPct }}%"></div>
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

      <form action="{{ route('organizer.event.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4 text-xs">
        @csrf
        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Judul Kegiatan</label>
          <input type="text" name="title" required placeholder="Contoh: Workshop Cloud Computing & DevSecOps 2026" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Tipe Kegiatan <span class="text-rose-500">*</span></label>
            <select name="type" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 cursor-pointer">
              <option value="Workshop" selected>Workshop</option>
              <option value="Seminar">Seminar</option>
              <option value="Webinar">Webinar</option>
              <option value="Sertifikasi">Sertifikasi</option>
            </select>
          </div>

          <div class="flex flex-col gap-1.5">
            <div class="flex items-center justify-between">
              <label class="font-semibold text-slate-700">Kategori Acara <span class="text-rose-500">*</span></label>
              <a href="{{ route('organizer.categories.index') }}" target="_blank" class="text-[10px] text-blue-900 font-semibold hover:underline">Kelola</a>
            </div>
            <select name="category_id" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 cursor-pointer">
              <option value="" disabled selected>-- Pilih Kategori --</option>
              @foreach($masterCategories as $mcat)
                <option value="{{ $mcat->id }}">{{ $mcat->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Format Pelaksanaan <span class="text-rose-500">*</span></label>
            <select name="format" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 cursor-pointer">
              <option value="offline" selected>Offline</option>
              <option value="online">Online</option>
            </select>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Penyelenggara Kegiatan <span class="text-rose-500">*</span></label>
            <select name="organizer_type" onchange="toggleCreatePartnerName(this.value)" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 cursor-pointer">
              <option value="internal" selected>Internal (Laboratorium ICT)</option>
              <option value="partner">Mitra Penyelenggara (Himpunan / BEM / Eksternal)</option>
            </select>
          </div>
          <div id="create-partner-name-container" class="hidden flex flex-col gap-1.5">
            <div class="flex items-center justify-between">
              <label class="font-semibold text-slate-700">Pilih Mitra Penyelenggara <span class="text-rose-500">*</span></label>
              <a href="{{ route('organizer.media_partners.index') }}" target="_blank" class="text-[10px] text-blue-900 font-semibold hover:underline">Kelola Data</a>
            </div>
            <select name="media_partner_id" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 cursor-pointer">
              <option value="" disabled selected>-- Pilih Mitra Penyelenggara --</option>
              @foreach($masterMediaPartners as $mp)
                <option value="{{ $mp->id }}">{{ $mp->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div id="create-partner-promo-fields" class="hidden flex flex-col gap-3.5 p-4 bg-blue-50/60 border border-blue-200/80 rounded-2xl">
          <div class="flex flex-col gap-0.5">
            <span class="text-xs font-bold text-blue-950">Informasi Promosi Media Partner</span>
            <span class="text-[11px] text-slate-500">Media partner disini hanya untuk promosi. Masukkan tautan form pendaftaran mitra dan poster kegiatan.</span>
          </div>

          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Link Form Pendaftaran Mitra <span class="text-rose-500">*</span></label>
            <input type="url" name="registration_url" id="create-registration-url" placeholder="https://forms.gle/... atau https://..." class="px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl outline-none focus:border-blue-950 text-xs">
          </div>

          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Unggah Poster Kegiatan</label>
            <input type="file" name="poster" accept="image/*" class="px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs outline-none focus:border-blue-950 cursor-pointer file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-100 file:text-blue-950 hover:file:bg-blue-200">
            <span class="text-[10px] text-slate-400">Format gambar JPG, PNG, atau WEBP</span>
          </div>
        </div>

        <div class="flex flex-col gap-2">
          <div class="flex items-center justify-between">
            <label class="font-semibold text-slate-700">Media Partner Pendukung Acara</label>
            <a href="{{ route('organizer.media_partners.index') }}" target="_blank" class="text-[10px] text-blue-900 font-semibold hover:underline">Kelola Master Media Partner</a>
          </div>
          @if($masterMediaPartners->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 max-h-40 overflow-y-auto p-2.5 bg-slate-50 border border-slate-200 rounded-xl">
              @foreach($masterMediaPartners as $mp)
                <label class="flex items-center gap-2.5 p-2 bg-white rounded-lg border border-slate-200/80 hover:border-blue-900 cursor-pointer transition text-xs">
                  <input type="checkbox" name="media_partner_ids[]" value="{{ $mp->id }}" class="size-4 rounded text-blue-950 focus:ring-blue-950 border-slate-300">
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
            <p class="text-xs text-slate-400 bg-slate-50 p-3 rounded-xl border border-slate-200">Belum ada data media partner di master. Anda dapat menambahkannya nanti.</p>
          @endif
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Lokasi / Ruang Lab</label>
          <input type="text" name="location" required value="Laboratorium ICT, Unit 7 Lantai 4, Universitas Budi Luhur" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Tanggal Mulai</label>
            <input type="date" name="start_date" min="{{ date('Y-m-d') }}" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
          </div>
          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Tanggal Selesai</label>
            <input type="date" name="end_date" min="{{ date('Y-m-d') }}" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
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

        <!-- Pengisi Acara Kegiatan -->
        <div id="create-speakers-section" class="flex flex-col gap-2">
          <div class="flex items-center justify-between">
            <label class="font-semibold text-slate-700">Pengisi Acara <span class="text-rose-500">*</span></label>
            <button type="button" onclick="addSpeakerRow()" class="text-xs text-blue-950 font-bold hover:underline flex items-center gap-1 cursor-pointer">
              <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
              </svg>
              <span>Tambah Pengisi Acara</span>
            </button>
          </div>

          <div id="speaker-rows-container" class="flex flex-col gap-2.5">
            <!-- Row -->
            <div class="speaker-row flex items-start gap-2">
              <div class="flex-1 min-w-0 flex flex-col gap-1">
                <select name="speaker_ids[]" onchange="onSpeakerSelectChange(this)" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:border-blue-950 focus:bg-white cursor-pointer">
                  <option value="" disabled selected>-- Pilih Pengisi Acara --</option>
                  @foreach($masterSpeakers as $spk)
                    <option value="{{ $spk->id }}" data-institution="{{ $spk->institution ?? 'Lab ICT' }}">{{ $spk->name }}</option>
                  @endforeach
                </select>
                <div class="speaker-institution-badge hidden text-[11px] text-slate-500 font-normal truncate px-1 items-center gap-1.5">
                  <svg class="size-3 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/>
                    <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/>
                    <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/>
                    <path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/>
                  </svg>
                  <span class="institution-text truncate"></span>
                </div>
              </div>

              <select name="speaker_roles[]" onchange="updateSpeakerRoleLabels()" class="role-select w-36 shrink-0 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold outline-none focus:border-blue-950 focus:bg-white cursor-pointer">
                <option value="Pemateri" selected>Pemateri</option>
                <option value="Moderator">Moderator</option>
                <option value="MC">MC</option>
              </select>

              <button type="button" onclick="removeSpeakerRow(this)" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition cursor-pointer shrink-0 mt-0.5" title="Hapus">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="18" y1="6" x2="6" y2="18"/>
                  <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
              </button>
            </div>
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
const speakerMasterOptions = `@foreach($masterSpeakers as $spk)<option value="{{ $spk->id }}" data-institution="{{ addslashes($spk->institution ?? 'Lab ICT') }}">{{ addslashes($spk->name) }}</option>@endforeach`;

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

  // Dynamic numbering on the role options
  const roleRunning = {};
  rows.forEach(r => {
    const sel = r.querySelector('.role-select');
    if (sel) {
      const val = sel.value;
      const pemateriOpt = sel.querySelector('option[value="Pemateri"]');
      const moderatorOpt = sel.querySelector('option[value="Moderator"]');
      const mcOpt = sel.querySelector('option[value="MC"]');

      if (val === 'Pemateri') {
        if (roleCounts['Pemateri'] > 1) {
          roleRunning['Pemateri'] = (roleRunning['Pemateri'] || 0) + 1;
          if (pemateriOpt) pemateriOpt.textContent = `Pemateri ${roleRunning['Pemateri']}`;
        } else {
          if (pemateriOpt) pemateriOpt.textContent = 'Pemateri';
        }
      } else {
        if (pemateriOpt) pemateriOpt.textContent = 'Pemateri';
      }

      if (val === 'Moderator') {
        if (roleCounts['Moderator'] > 1) {
          roleRunning['Moderator'] = (roleRunning['Moderator'] || 0) + 1;
          if (moderatorOpt) moderatorOpt.textContent = `Moderator ${roleRunning['Moderator']}`;
        } else {
          if (moderatorOpt) moderatorOpt.textContent = 'Moderator';
        }
      } else {
        if (moderatorOpt) moderatorOpt.textContent = 'Moderator';
      }

      if (val === 'MC') {
        if (roleCounts['MC'] > 1) {
          roleRunning['MC'] = (roleRunning['MC'] || 0) + 1;
          if (mcOpt) mcOpt.textContent = `MC ${roleRunning['MC']}`;
        } else {
          if (mcOpt) mcOpt.textContent = 'MC';
        }
      } else {
        if (mcOpt) mcOpt.textContent = 'MC';
      }
    }
  });
}

function onSpeakerSelectChange(selectElem) {
  const container = document.getElementById('speaker-rows-container');
  if (!container) return;
  const currentVal = selectElem.value;

  const row = selectElem.closest('.speaker-row');
  const badge = row ? row.querySelector('.speaker-institution-badge') : null;
  const instText = row ? row.querySelector('.institution-text') : null;

  if (currentVal) {
    const allSelects = container.querySelectorAll('select[name="speaker_ids[]"]');
    let duplicateCount = 0;
    allSelects.forEach(sel => {
      if (sel.value === currentVal) {
        duplicateCount++;
      }
    });

    if (duplicateCount > 1) {
      alert('Pengisi acara ini sudah dipilih untuk peran lain di kegiatan ini. Satu orang hanya boleh memiliki 1 peran.');
      selectElem.value = '';
      if (badge) {
        badge.classList.add('hidden');
        badge.classList.remove('flex');
      }
    } else {
      const selectedOpt = selectElem.options[selectElem.selectedIndex];
      const inst = selectedOpt ? selectedOpt.getAttribute('data-institution') : '';
      if (inst && badge && instText) {
        instText.textContent = inst;
        badge.classList.remove('hidden');
        badge.classList.add('flex');
      } else if (badge) {
        badge.classList.add('hidden');
        badge.classList.remove('flex');
      }
    }
  } else if (badge) {
    badge.classList.add('hidden');
    badge.classList.remove('flex');
  }

  syncSpeakerOptionsState();
  updateSpeakerRoleLabels();
}

function syncSpeakerOptionsState() {
  const container = document.getElementById('speaker-rows-container');
  if (!container) return;
  const allSelects = container.querySelectorAll('select[name="speaker_ids[]"]');

  const selectedValues = new Set();
  allSelects.forEach(sel => {
    if (sel.value) selectedValues.add(sel.value);
  });

  allSelects.forEach(sel => {
    const cur = sel.value;
    Array.from(sel.options).forEach(opt => {
      if (!opt.value) return;
      if (!opt.hasAttribute('data-orig-text')) {
        opt.setAttribute('data-orig-text', opt.textContent);
      }
      const origText = opt.getAttribute('data-orig-text');
      if (opt.value !== cur && selectedValues.has(opt.value)) {
        opt.disabled = true;
        opt.textContent = origText + ' (Sudah dipilih)';
      } else {
        opt.disabled = false;
        opt.textContent = origText;
      }
    });
  });
}

function addSpeakerRow() {
  const container = document.getElementById('speaker-rows-container');
  if (!container) return;

  const div = document.createElement('div');
  div.className = 'speaker-row flex items-start gap-2';
  div.innerHTML = `
    <div class="flex-1 min-w-0 flex flex-col gap-1">
      <select name="speaker_ids[]" onchange="onSpeakerSelectChange(this)" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:border-blue-950 focus:bg-white cursor-pointer">
        <option value="" disabled selected>-- Pilih Pengisi Acara --</option>
        ${speakerMasterOptions}
      </select>
      <div class="speaker-institution-badge hidden text-[11px] text-slate-500 font-normal truncate px-1 items-center gap-1.5">
        <svg class="size-3 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/>
          <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/>
          <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/>
          <path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/>
        </svg>
        <span class="institution-text truncate"></span>
      </div>
    </div>

    <select name="speaker_roles[]" onchange="updateSpeakerRoleLabels()" class="role-select w-36 shrink-0 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold outline-none focus:border-blue-950 focus:bg-white cursor-pointer">
      <option value="Pemateri" selected>Pemateri</option>
      <option value="Moderator">Moderator</option>
      <option value="MC">MC</option>
    </select>

    <button type="button" onclick="removeSpeakerRow(this)" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition cursor-pointer shrink-0 mt-0.5" title="Hapus">
      <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="18" y1="6" x2="6" y2="18"/>
        <line x1="6" y1="6" x2="18" y2="18"/>
      </svg>
    </button>
  `;

  container.appendChild(div);
  syncSpeakerOptionsState();
  updateSpeakerRoleLabels();
}

function removeSpeakerRow(btn) {
  const row = btn.closest('.speaker-row');
  const container = document.getElementById('speaker-rows-container');
  if (row && container) {
    if (container.querySelectorAll('.speaker-row').length > 1) {
      row.remove();
    } else {
      const sel = row.querySelector('select[name="speaker_ids[]"]');
      if (sel) sel.value = '';
      const badge = row.querySelector('.speaker-institution-badge');
      if (badge) {
        badge.classList.add('hidden');
        badge.classList.remove('flex');
      }
      const roleSel = row.querySelector('.role-select');
      if (roleSel) roleSel.value = 'Pemateri';
    }
    syncSpeakerOptionsState();
    updateSpeakerRoleLabels();
  }
}

document.addEventListener('DOMContentLoaded', function() {
  const createForm = document.querySelector('#modal-create-event form');
  if (createForm) {
    createForm.addEventListener('submit', function(e) {
      const container = document.getElementById('speaker-rows-container');
      if (!container) return;
      const selects = container.querySelectorAll('select[name="speaker_ids[]"]');
      const seen = new Set();
      for (const sel of selects) {
        if (!sel.value) continue;
        if (seen.has(sel.value)) {
          e.preventDefault();
          alert('Pengisi acara tidak boleh dipilih lebih dari 1 kali. Satu orang hanya boleh memiliki 1 peran dalam kegiatan yang sama.');
          sel.focus();
          return false;
        }
        seen.add(sel.value);
      }
    });
  }
});

function toggleCreatePartnerName(val) {
  const container = document.getElementById('create-partner-name-container');
  const promoFields = document.getElementById('create-partner-promo-fields');
  const speakerSection = document.getElementById('create-speakers-section');
  const regUrlInput = document.getElementById('create-registration-url');
  const speakerSelects = document.querySelectorAll('#speaker-rows-container select[name="speaker_ids[]"]');

  if (val === 'partner') {
    if (container) container.classList.remove('hidden');
    if (promoFields) promoFields.classList.remove('hidden');
    if (speakerSection) speakerSection.classList.add('hidden');
    if (regUrlInput) regUrlInput.required = true;
    speakerSelects.forEach(sel => sel.required = false);
  } else {
    if (container) container.classList.add('hidden');
    if (promoFields) promoFields.classList.add('hidden');
    if (speakerSection) speakerSection.classList.remove('hidden');
    if (regUrlInput) regUrlInput.required = false;
    speakerSelects.forEach(sel => sel.required = true);
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

@include('partials.organizer-bottom-nav')
@endsection

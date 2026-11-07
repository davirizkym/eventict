@extends('layouts.app')

@section('title', 'Jelajahi Kegiatan — Laboratorium ICT')

@section('content')
<div class="w-full min-h-screen bg-white flex justify-center items-start">
  <div class="w-full max-w-[1440px] bg-white flex flex-col justify-start items-start">
    <header class="self-stretch h-16 px-6 lg:px-20 bg-blue-950 border-b border-slate-900 flex justify-between items-center sticky top-0 z-50">
      <div class="w-64 flex justify-start items-center">
        <a href="{{ route('home') }}" class="flex justify-start items-center gap-2.5 cursor-pointer group">
          <div class="size-8 bg-white rounded flex items-center justify-center text-blue-950 font-bold text-sm">
            <svg class="size-5 text-blue-900" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
              <path d="M6 6h10"/>
              <path d="M6 10h7"/>
            </svg>
          </div>
          <span class="text-white text-xl font-semibold font-['Poppins'] leading-7 group-hover:text-blue-100 transition">Eventict</span>
        </a>
      </div>
      <nav class="hidden md:flex justify-start items-center gap-8">
        <a href="{{ route('home') }}" class="text-white/90 text-sm font-medium font-['Poppins'] hover:text-white transition">Beranda</a>
        <a href="{{ route('events.index_public') }}" class="text-white text-sm font-semibold font-['Poppins'] transition">Jelajahi Kegiatan</a>
        <a href="{{ route('about') }}" class="text-white/90 text-sm font-medium font-['Poppins'] hover:text-white transition">Tentang Kami</a>
      </nav>
      <div class="flex justify-start items-center gap-3">
        @auth
          @if(Auth::user()->role === 'penyelenggara')
            <a href="{{ route('organizer.dashboard') }}" class="px-3.5 py-2 bg-white rounded-md text-blue-900 flex justify-center items-center gap-2 hover:bg-blue-50 transition cursor-pointer font-semibold shadow-xs">
              <span class="text-xs font-semibold font-['Poppins'] leading-4">Dashboard Panitia</span>
            </a>
          @else
            <a href="{{ route('peserta.dashboard') }}" class="px-3.5 py-2 bg-white rounded-md text-blue-900 flex justify-center items-center gap-2 hover:bg-blue-50 transition cursor-pointer font-semibold shadow-xs">
              <span class="text-xs font-semibold font-['Poppins'] leading-4">Portal Peserta</span>
            </a>
          @endif
          <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="px-3 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-medium font-['Poppins'] rounded-md transition cursor-pointer">
              Keluar
            </button>
          </form>
        @else
          <a href="{{ route('login') }}" class="px-3.5 py-2 bg-transparent text-white border border-white/40 rounded-md flex justify-center items-center gap-2 hover:bg-white/10 transition cursor-pointer">
            <span class="text-white text-xs font-medium font-['Poppins'] leading-4">Masuk Akun</span>
          </a>
          <a href="{{ route('register') }}" class="px-3.5 py-2 bg-white text-blue-950 rounded-md flex justify-center items-center gap-2 hover:bg-blue-50 transition cursor-pointer font-semibold shadow-xs">
            <span class="text-blue-950 text-xs font-semibold font-['Poppins'] leading-4">Daftar Sekarang</span>
          </a>
        @endauth
      </div>
    </header>

    <main class="self-stretch flex flex-col justify-start items-start">
      <section class="self-stretch px-6 lg:px-20 pt-10 pb-6 flex flex-col gap-6">
        <div class="flex items-center gap-2 text-xs text-slate-500 font-['Poppins']">
          <a href="{{ route('home') }}" class="hover:text-blue-950 transition">Beranda</a>
          <span>/</span>
          <span class="text-slate-900 font-medium">Jelajahi Kegiatan</span>
        </div>

        <div class="flex flex-col gap-2 pb-4 border-b border-slate-200">
          <h1 class="text-slate-900 text-2xl sm:text-3xl font-semibold font-['Poppins']">
            Jelajahi Semua Kegiatan
          </h1>
          <p class="text-slate-600 text-xs sm:text-sm font-normal font-['Poppins']">
            Temukan simposium, seminar nasional, workshop teknologi, dan pelatihan praktikum Laboratorium ICT.
          </p>
        </div>

        <div class="w-full pt-2 flex flex-col justify-start items-center">
          <form action="{{ route('events.index_public') }}" method="GET" class="w-full p-2 sm:p-2.5 bg-white rounded-xl shadow-[0px_1px_3px_0px_rgba(0,0,0,0.06)] outline outline-1 outline-offset-[-1px] outline-slate-300 flex flex-col md:flex-row justify-start items-center gap-2">
            <div class="flex-1 w-full flex justify-start items-center gap-3 px-3">
              <svg class="size-4 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.35-4.35"/>
              </svg>
              <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari topik kegiatan atau narasumber..." class="w-full bg-transparent border-none outline-none text-slate-900 placeholder:text-slate-400 text-sm font-normal font-['Poppins'] py-1.5">
            </div>
            <div class="h-8 w-px bg-slate-200 hidden md:block"></div>
            <div class="w-full md:w-44 flex flex-col justify-start items-start px-3 py-1">
              <label class="text-slate-500 text-[10px] uppercase tracking-wider font-semibold font-['Poppins']">Format</label>
              <select name="format" class="w-full bg-transparent border-none outline-none text-slate-900 text-xs font-medium font-['Poppins'] cursor-pointer">
                <option value="">Semua Format</option>
                <option value="offline" {{ request('format') === 'offline' ? 'selected' : '' }}>Offline / Tatap Muka</option>
                <option value="online" {{ request('format') === 'online' ? 'selected' : '' }}>Online / Webinar</option>
                <option value="hybrid" {{ request('format') === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
              </select>
            </div>
            <div class="h-8 w-px bg-slate-200 hidden md:block"></div>
            <div class="w-full md:w-52 flex flex-col justify-start items-start px-3 py-1">
              <label class="text-slate-500 text-[10px] uppercase tracking-wider font-semibold font-['Poppins']">Rumpun Ilmu</label>
              <select name="category" class="w-full bg-transparent border-none outline-none text-slate-900 text-xs font-medium font-['Poppins'] cursor-pointer">
                <option value="">Semua Rumpun</option>
                <option value="Kedokteran & Kesehatan" {{ request('category') === 'Kedokteran & Kesehatan' ? 'selected' : '' }}>Kedokteran & Kesehatan</option>
                <option value="Teknologi & Rekayasa" {{ request('category') === 'Teknologi & Rekayasa' ? 'selected' : '' }}>Teknologi & Rekayasa</option>
                <option value="Hukum & Kebijakan" {{ request('category') === 'Hukum & Kebijakan' ? 'selected' : '' }}>Hukum & Kebijakan</option>
                <option value="Ekonomi & Bisnis" {{ request('category') === 'Ekonomi & Bisnis' ? 'selected' : '' }}>Ekonomi & Bisnis</option>
              </select>
            </div>
            <button type="submit" class="w-full md:w-auto px-6 py-3 bg-blue-950 rounded-lg outline outline-1 outline-offset-[-1px] outline-transparent flex justify-center items-center gap-2 hover:bg-blue-900 transition cursor-pointer shrink-0">
              <svg class="size-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.35-4.35"/>
              </svg>
              <span class="text-white text-xs font-semibold font-['Poppins'] leading-4">Temukan Sesi</span>
            </button>
            @if(request()->hasAny(['q', 'format', 'category']))
              <a href="{{ route('events.index_public') }}" class="text-xs text-rose-600 hover:underline px-2 py-1 font-medium font-['Poppins']">
                Reset
              </a>
            @endif
          </form>
        </div>
      </section>

      <section class="self-stretch px-6 lg:px-20 pb-16 flex flex-col justify-start items-start gap-8">
        <div class="self-stretch flex justify-between items-center">
          <span class="text-slate-600 text-xs font-medium font-['Poppins']">
            Menampilkan {{ $events->count() }} Kegiatan
          </span>
          @if(request()->hasAny(['q', 'format', 'category']))
            <span class="text-xs font-medium text-blue-950 font-['Poppins']">Filter Aktif</span>
          @endif
        </div>

        <div class="self-stretch grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          @forelse($events as $event)
            <div class="bg-white rounded-xl outline outline-1 outline-offset-[-1px] outline-slate-200 flex flex-col justify-between overflow-hidden hover:shadow-lg hover:-translate-y-1 transition duration-200 group">
              <div>
                <div class="self-stretch h-52 relative bg-gradient-to-br from-[#142D4E] to-[#0A192F] p-6 flex flex-col justify-between overflow-hidden">
                  <div class="relative z-10 flex justify-between items-start">
                    <div class="px-2.5 py-1 bg-blue-500/20 backdrop-blur-md rounded-md border border-blue-400/30 flex items-center gap-1.5">
                      <span class="text-blue-100 text-xs font-semibold font-['Poppins']">Sertifikat Resmi</span>
                    </div>
                    <span class="px-2 py-0.5 bg-white/10 backdrop-blur-md text-white/90 text-[10px] font-medium rounded uppercase tracking-wider">{{ $event->category }}</span>
                  </div>
                  <div class="relative z-10">
                    <span class="text-white/60 text-xs font-medium uppercase tracking-wider capitalize">{{ $event->format }} Event</span>
                  </div>
                </div>

                <div class="p-6 flex flex-col gap-4">
                  <div class="flex flex-col gap-1.5">
                    <div class="flex items-center gap-2 text-slate-600 text-xs font-normal font-['Poppins']">
                      <svg class="size-3.5 text-slate-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                        <line x1="16" x2="16" y1="2" y2="6"/>
                        <line x1="8" x2="8" y1="2" y2="6"/>
                        <line x1="3" x2="21" y1="10" y2="10"/>
                      </svg>
                      <span>{{ $event->start_date ? $event->start_date->format('d M Y') : 'Segera' }} &bull; {{ substr($event->start_time, 0, 5) }} WIB</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-600 text-xs font-normal font-['Poppins']">
                      <svg class="size-3.5 text-slate-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                        <circle cx="12" cy="10" r="3"/>
                      </svg>
                      <span class="truncate">{{ $event->location }}</span>
                    </div>
                  </div>

                  <h3 class="text-slate-900 text-base font-semibold font-['Poppins'] leading-snug line-clamp-2 group-hover:text-blue-900 transition">
                    {{ $event->title }}
                  </h3>

                  @if($event->speakers->isNotEmpty())
                    <div class="flex items-center gap-2.5 pt-1">
                      <div class="size-8 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-700 text-xs font-bold shrink-0">
                        {{ strtoupper(substr($event->speakers->first()->name, 0, 2)) }}
                      </div>
                      <div class="flex flex-col overflow-hidden">
                        <span class="text-xs font-medium text-slate-800 font-['Poppins'] truncate">{{ $event->speakers->first()->name }}</span>
                        @if($event->speakers->count() > 1)
                          <span class="text-[10px] text-slate-400 font-['Poppins']">+{{ $event->speakers->count() - 1 }} Pembicara Lainnya</span>
                        @endif
                      </div>
                    </div>
                  @endif
                </div>
              </div>

              <div class="p-6 border-t border-slate-100 flex justify-between items-center bg-slate-50/50">
                <div class="flex flex-col">
                  <span class="text-slate-900 font-semibold text-sm font-['Poppins']">
                    {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                  </span>
                  <span class="text-slate-500 text-[10px] font-normal font-['Poppins']">Kuota {{ $event->quota }} Kursi</span>
                </div>
                <div class="flex items-center gap-2">
                  <a href="{{ route('events.show', $event->slug) }}" class="px-3.5 py-2 bg-blue-950 text-white rounded-lg flex items-center gap-1.5 text-xs font-semibold font-['Poppins'] hover:bg-blue-900 transition">
                    <span>Lihat Sesi</span>
                    <span>&rarr;</span>
                  </a>
                </div>
              </div>
            </div>
          @empty
            <div class="col-span-full py-16 flex flex-col items-center justify-center gap-2 text-center">
              <svg class="size-12 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.35-4.35"/>
              </svg>
              <div class="text-slate-800 font-semibold text-base font-['Poppins']">Tidak ada kegiatan yang cocok</div>
              <p class="text-slate-500 text-xs font-normal font-['Poppins'] max-w-md">Coba ubah kata kunci pencarian atau bersihkan filter format dan rumpun ilmu.</p>
              <a href="{{ route('events.index_public') }}" class="mt-2 px-4 py-2 bg-blue-950 text-white rounded-lg text-xs font-semibold font-['Poppins']">Tampilkan Semua Kegiatan</a>
            </div>
          @endforelse
        </div>
      </section>
    </main>

    <footer class="self-stretch px-6 lg:px-20 py-12 bg-blue-950 flex flex-col justify-start items-start gap-12">
      <div class="self-stretch grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="flex flex-col gap-4">
          <div class="flex items-center gap-2.5">
            <div class="size-8 bg-white rounded flex items-center justify-center text-blue-950 font-bold text-sm">
              <svg class="size-5 text-blue-950" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
                <path d="M6 6h10"/>
                <path d="M6 10h7"/>
              </svg>
            </div>
            <span class="text-white text-xl font-semibold font-['Poppins'] leading-7">Eventict</span>
          </div>
          <p class="text-slate-300 text-xs font-normal font-['Poppins'] leading-relaxed">Platform terpadu pendaftaran dan manajemen workshop, seminar teknologi, pelatihan praktikum, dan sertifikasi komputasi Laboratorium ICT.</p>
          <div class="text-slate-400 text-xs font-normal font-['Poppins']">Sekretariat Laboratorium ICT • Gedung Lab Komputer</div>
        </div>

        <div class="flex flex-col gap-3">
          <span class="text-white text-sm font-semibold font-['Poppins']">Kategori Event</span>
          <a href="{{ route('events.index_public') }}" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Workshop Pemrograman & Web/Mobile</a>
          <a href="{{ route('events.index_public') }}" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Pelatihan AI, Data & Machine Learning</a>
          <a href="{{ route('events.index_public') }}" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Jaringan Komputer & Cyber Security</a>
          <a href="{{ route('events.index_public') }}" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Seminar Teknologi & Tech Talk</a>
        </div>

        <div class="flex flex-col gap-3">
          <span class="text-white text-sm font-semibold font-['Poppins']">Informasi & Layanan</span>
          <a href="{{ route('about') }}" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Tentang Laboratorium ICT</a>
          <a href="{{ route('about') }}" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Fasilitas Ruang Lab Komputer</a>
          <a href="{{ route('peserta.dashboard') }}" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Ketentuan Presensi & Sertifikat Lab</a>
        </div>

        <div class="flex flex-col gap-3">
          <span class="text-white text-sm font-semibold font-['Poppins']">Pusat Bantuan & Kontak</span>
          <a href="{{ route('peserta.dashboard') }}" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Portal Peserta & Mahasiswa</a>
          <a href="{{ route('login') }}" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Akses Panitia / Asisten Lab</a>
          <span class="text-slate-300 text-xs font-normal font-['Poppins']">help@eventict.id</span>
          <span class="text-slate-400 text-xs font-normal font-['Poppins']">Senin–Jumat, 08:00–17:00 WIB</span>
        </div>
      </div>

      <div class="self-stretch pt-6 border-t border-slate-800 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs font-normal font-['Poppins'] text-slate-400">
        <div>© 2026 Eventict — Laboratorium ICT. Seluruh hak dilindungi.</div>
        <div>Sistem Informasi Manajemen Event Laboratorium Komputer & Teknologi Informasi.</div>
      </div>
    </footer>
  </div>
</div>
@endsection

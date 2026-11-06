@extends('layouts.app')

@section('title', 'Eventict — Platform Event, Seminar & Workshop Laboratorium ICT')

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
        <a href="{{ route('home') }}" class="text-white text-sm font-semibold font-['Poppins'] transition">Beranda</a>
        <a href="{{ route('events.index_public') }}" class="text-white/90 text-sm font-medium font-['Poppins'] hover:text-white transition">Jelajahi Kegiatan</a>
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
      <section class="self-stretch px-6 lg:px-20 pt-16 md:pt-24 pb-14 flex flex-col justify-start items-center gap-6">
        <h1 class="w-full max-w-[980px] text-center text-blue-950 text-3xl sm:text-4xl lg:text-5xl font-semibold font-['Poppins'] leading-tight lg:leading-[60px] tracking-tight min-h-[96px] sm:min-h-[110px] lg:min-h-[130px] flex items-center justify-center">
          <span><span id="typewriter-text"></span><span class="inline-block w-[3px] h-[0.85em] bg-blue-950 ml-1.5 align-middle animate-pulse"></span></span>
        </h1>
        
        <div class="w-full max-w-[960px] pt-4 flex flex-col justify-start items-center">
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

      @if($events->count() > 0)
      @php
        $carouselEvents = $events->count() > 1
          ? collect([$events->last()])->concat($events)->concat([$events->first()])
          : $events;
      @endphp
      <section class="self-stretch px-6 lg:px-20 py-4">
        <div class="w-full relative rounded-2xl overflow-hidden bg-gradient-to-br from-[#071326] via-[#0B1E38] to-[#142D4E] border border-slate-800 shadow-xl" id="event-carousel-container">
          <div class="relative w-full overflow-hidden">
            <div id="event-carousel-track" class="flex" style="transform: translateX({{ $events->count() > 1 ? '-100%' : '0%' }});">
              @foreach($carouselEvents as $index => $event)
              <div class="w-full shrink-0 flex flex-col lg:flex-row justify-between items-stretch p-6 sm:p-10 lg:p-12 pb-14 sm:pb-14 lg:pb-14 gap-8 min-h-[360px] relative">
                <div class="flex-1 flex flex-col justify-between gap-6 z-10">
                  <div class="flex flex-col gap-3">
                    <div class="flex flex-wrap items-center gap-2.5">
                      <span class="px-3 py-1 bg-blue-500/20 text-blue-200 border border-blue-400/30 rounded-full text-xs font-semibold font-['Poppins']">
                        Acara Terdekat Laboratorium ICT
                      </span>
                      <span class="px-2.5 py-1 bg-white/10 text-white/90 rounded-full text-xs font-medium font-['Poppins'] uppercase tracking-wider">
                        {{ $event->format }} Event
                      </span>
                      <span class="px-2.5 py-1 bg-white/10 text-white/90 rounded-full text-xs font-medium font-['Poppins']">
                        {{ $event->category }}
                      </span>
                    </div>

                    <h2 class="text-white text-2xl sm:text-3xl lg:text-4xl font-bold font-['Poppins'] leading-tight tracking-tight mt-1">
                      <a href="{{ route('events.show', $event->slug) }}" class="hover:text-blue-200 transition">
                        {{ $event->title }}
                      </a>
                    </h2>

                    <p class="text-slate-300 text-xs sm:text-sm font-normal font-['Poppins'] leading-relaxed line-clamp-2 max-w-2xl">
                      {{ $event->description }}
                    </p>
                  </div>

                  <div class="flex flex-wrap items-center gap-6 pt-2 border-t border-white/10 text-slate-300 text-xs font-['Poppins']">
                    <div class="flex items-center gap-2">
                      <div class="size-7 rounded-lg bg-white/10 flex items-center justify-center text-blue-300 shrink-0">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                          <line x1="16" x2="16" y1="2" y2="6"/>
                          <line x1="8" x2="8" y1="2" y2="6"/>
                          <line x1="3" x2="21" y1="10" y2="10"/>
                        </svg>
                      </div>
                      <div class="flex flex-col">
                        <span class="text-slate-400 text-[10px] uppercase tracking-wider">Tanggal & Waktu</span>
                        <span class="text-white font-medium">{{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d M Y') }} • {{ substr($event->start_time, 0, 5) }} WIB</span>
                      </div>
                    </div>

                    <div class="flex items-center gap-2">
                      <div class="size-7 rounded-lg bg-white/10 flex items-center justify-center text-blue-300 shrink-0">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                          <circle cx="12" cy="10" r="3"/>
                        </svg>
                      </div>
                      <div class="flex flex-col">
                        <span class="text-slate-400 text-[10px] uppercase tracking-wider">Lokasi Pelaksanaan</span>
                        <span class="text-white font-medium truncate max-w-xs sm:max-w-sm">{{ $event->location }}</span>
                      </div>
                    </div>

                    @if($event->speakers->isNotEmpty())
                    <div class="flex items-center gap-2">
                      <div class="size-7 rounded-full bg-blue-400/20 border border-blue-300/40 flex items-center justify-center text-blue-200 font-bold text-xs shrink-0">
                        {{ strtoupper(substr($event->speakers->first()->name, 0, 2)) }}
                      </div>
                      <div class="flex flex-col">
                        <span class="text-slate-400 text-[10px] uppercase tracking-wider">Instruktur / Narasumber</span>
                        <span class="text-white font-medium truncate max-w-xs">{{ $event->speakers->first()->name }}</span>
                      </div>
                    </div>
                    @endif
                  </div>

                  <div class="flex flex-wrap items-center justify-between gap-4 pt-2 border-t border-white/10">
                    <div class="flex items-center gap-3">
                      <span class="text-white text-xl sm:text-2xl font-bold font-['Poppins']">
                        @if($event->price == 0)
                          <span class="text-emerald-400">Gratis</span>
                        @else
                          Rp {{ number_format($event->price, 0, ',', '.') }}
                        @endif
                      </span>
                      <span class="text-emerald-300 text-xs font-semibold font-['Poppins']">
                        Pendaftaran Dibuka
                      </span>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                      <a href="{{ route('events.show', $event->slug) }}" class="px-5 py-2.5 bg-blue-500 hover:bg-blue-400 text-white rounded-lg text-xs font-semibold font-['Poppins'] flex items-center gap-2 transition shadow-lg shadow-blue-500/30">
                        <span>Lihat Sesi & Registrasi</span>
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <path d="M5 12h14"/>
                          <path d="m12 5 7 7-7 7"/>
                        </svg>
                      </a>
                      <a href="{{ route('events.index_public') }}" class="px-4 py-2.5 bg-white/10 hover:bg-white/15 text-white/90 hover:text-white rounded-lg text-xs font-medium font-['Poppins'] transition border border-white/15">
                        Lihat Semua Kegiatan
                      </a>
                    </div>
                  </div>
                </div>

                <div class="w-full lg:w-72 shrink-0 rounded-xl overflow-hidden border border-white/10 bg-white/5 backdrop-blur-md z-10 relative flex items-center justify-center min-h-[280px]">
                  @if($event->banner_url)
                    <img src="{{ asset($event->banner_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                  @else
                    <div class="w-full h-full min-h-[280px] flex flex-col items-center justify-center p-6 text-center bg-gradient-to-b from-white/[0.08] to-white/[0.02] relative">
                      <div class="size-14 rounded-2xl bg-white/10 border border-white/15 flex items-center justify-center text-blue-300 mb-3 shadow-inner">
                        <svg class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                          <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/>
                          <circle cx="8.5" cy="8.5" r="1.5"/>
                          <path d="m21 15-5-5L5 21"/>
                        </svg>
                      </div>
                      <span class="text-white text-xs font-semibold font-['Poppins']">Poster Kegiatan</span>
                      <span class="text-slate-400 text-[11px] font-normal font-['Poppins'] mt-1">Laboratorium ICT</span>
                      <div class="mt-4 px-3 py-1 rounded-full bg-white/10 text-slate-300 text-[10px] font-medium font-['Poppins'] uppercase tracking-wider">
                        {{ $event->format }} Event
                      </div>
                    </div>
                  @endif
                </div>
              </div>
              @endforeach
            </div>
          </div>

          @if($events->count() > 1)
          <button type="button" id="carousel-prev" class="absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 z-20 size-10 rounded-full bg-slate-900/60 hover:bg-slate-900/90 text-white flex items-center justify-center transition border border-white/20 backdrop-blur-md shadow-lg cursor-pointer">
            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="m15 18-6-6 6-6"/>
            </svg>
          </button>
          <button type="button" id="carousel-next" class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 z-20 size-10 rounded-full bg-slate-900/60 hover:bg-slate-900/90 text-white flex items-center justify-center transition border border-white/20 backdrop-blur-md shadow-lg cursor-pointer">
            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="m9 18 6-6-6-6"/>
            </svg>
          </button>

          <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex items-center justify-center gap-2" id="carousel-dots">
            @foreach($events as $index => $event)
            <button type="button" data-slide="{{ $index }}" class="carousel-dot h-1.5 rounded-full transition-all duration-300 cursor-pointer {{ $index === 0 ? 'w-6 bg-blue-400' : 'w-2 bg-white/40 hover:bg-white/70' }}"></button>
            @endforeach
          </div>
          @endif
        </div>
      </section>
      @endif

      <section id="kategori" class="self-stretch px-6 lg:px-20 py-16 flex flex-col justify-start items-start gap-8">
        <div class="self-stretch flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
          <div>
            <h2 class="text-slate-900 text-2xl lg:text-3xl font-semibold font-['Poppins'] leading-10">Jelajahi Kategori Populer</h2>
            <p class="text-slate-500 text-xs font-normal font-['Poppins']">Pilih bidang topik yang kamu minati untuk menemukan seminar dan workshop yang sesuai.</p>
          </div>
          <a href="{{ route('events.index_public') }}" class="text-blue-950 hover:text-blue-900 text-xs font-semibold font-['Poppins'] hover:underline inline-flex items-center gap-1 shrink-0">
            <span>Lihat Semua Kegiatan</span>
            <span>&rarr;</span>
          </a>
        </div>

        <div class="self-stretch grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
          <a href="{{ route('events.index_public', ['category' => 'Teknologi & Rekayasa']) }}" class="p-5 bg-white rounded-xl outline outline-1 outline-offset-[-1px] outline-slate-200 hover:outline-blue-900 hover:shadow-md hover:-translate-y-0.5 transition duration-200 flex flex-col justify-between gap-4 group">
            <div class="flex items-start justify-between">
              <div class="size-11 rounded-lg bg-blue-50 group-hover:bg-blue-950 text-blue-900 group-hover:text-white flex items-center justify-center transition-colors duration-200">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <polyline points="16 18 22 12 16 6"/>
                  <polyline points="8 6 2 12 8 18"/>
                </svg>
              </div>
              <span class="text-slate-400 group-hover:text-blue-950 text-xs transition">&rarr;</span>
            </div>
            <div>
              <h3 class="text-slate-900 group-hover:text-blue-950 font-semibold text-sm font-['Poppins'] transition">Pemrograman & Web/Mobile</h3>
              <p class="text-slate-500 text-xs font-normal font-['Poppins'] mt-1">Frontend, Backend API, Framework Modern, Aplikasi Mobile</p>
            </div>
          </a>

          <a href="{{ route('events.index_public', ['category' => 'Teknologi & Rekayasa']) }}" class="p-5 bg-white rounded-xl outline outline-1 outline-offset-[-1px] outline-slate-200 hover:outline-blue-900 hover:shadow-md hover:-translate-y-0.5 transition duration-200 flex flex-col justify-between gap-4 group">
            <div class="flex items-start justify-between">
              <div class="size-11 rounded-lg bg-blue-50 group-hover:bg-blue-950 text-blue-900 group-hover:text-white flex items-center justify-center transition-colors duration-200">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M12 2a8 8 0 0 0-8 8c0 3.36 2.06 6.24 5 7.42V20a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2.58c2.94-1.18 5-4.06 5-7.42a8 8 0 0 0-8-8z"/>
                  <line x1="9.5" y1="9" x2="9.5" y2="9.01"/>
                  <line x1="14.5" y1="9" x2="14.5" y2="9.01"/>
                </svg>
              </div>
              <span class="text-slate-400 group-hover:text-blue-950 text-xs transition">&rarr;</span>
            </div>
            <div>
              <h3 class="text-slate-900 group-hover:text-blue-950 font-semibold text-sm font-['Poppins'] transition">Kecerdasan Buatan & Data</h3>
              <p class="text-slate-500 text-xs font-normal font-['Poppins'] mt-1">Machine Learning, Deep Learning, Python Data Science, Analitika</p>
            </div>
          </a>

          <a href="{{ route('events.index_public', ['category' => 'Teknologi & Rekayasa']) }}" class="p-5 bg-white rounded-xl outline outline-1 outline-offset-[-1px] outline-slate-200 hover:outline-blue-900 hover:shadow-md hover:-translate-y-0.5 transition duration-200 flex flex-col justify-between gap-4 group">
            <div class="flex items-start justify-between">
              <div class="size-11 rounded-lg bg-blue-50 group-hover:bg-blue-950 text-blue-900 group-hover:text-white flex items-center justify-center transition-colors duration-200">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
              </div>
              <span class="text-slate-400 group-hover:text-blue-950 text-xs transition">&rarr;</span>
            </div>
            <div>
              <h3 class="text-slate-900 group-hover:text-blue-950 font-semibold text-sm font-['Poppins'] transition">Keamanan Siber & Jaringan</h3>
              <p class="text-slate-500 text-xs font-normal font-['Poppins'] mt-1">Cyber Security, Jaringan Komputer, Infrastruktur Server, Ethical Hacking</p>
            </div>
          </a>

          <a href="{{ route('events.index_public', ['category' => 'Kedokteran & Kesehatan']) }}" class="p-5 bg-white rounded-xl outline outline-1 outline-offset-[-1px] outline-slate-200 hover:outline-blue-900 hover:shadow-md hover:-translate-y-0.5 transition duration-200 flex flex-col justify-between gap-4 group">
            <div class="flex items-start justify-between">
              <div class="size-11 rounded-lg bg-blue-50 group-hover:bg-blue-950 text-blue-900 group-hover:text-white flex items-center justify-center transition-colors duration-200">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                </svg>
              </div>
              <span class="text-slate-400 group-hover:text-blue-950 text-xs transition">&rarr;</span>
            </div>
            <div>
              <h3 class="text-slate-900 group-hover:text-blue-950 font-semibold text-sm font-['Poppins'] transition">Teknologi Medis & Telemedicine</h3>
              <p class="text-slate-500 text-xs font-normal font-['Poppins'] mt-1">Sistem Rekam Medis Elektronik, Interoperabilitas Data Klinis</p>
            </div>
          </a>

          <a href="{{ route('events.index_public', ['category' => 'Hukum & Kebijakan']) }}" class="p-5 bg-white rounded-xl outline outline-1 outline-offset-[-1px] outline-slate-200 hover:outline-blue-900 hover:shadow-md hover:-translate-y-0.5 transition duration-200 flex flex-col justify-between gap-4 group">
            <div class="flex items-start justify-between">
              <div class="size-11 rounded-lg bg-blue-50 group-hover:bg-blue-950 text-blue-900 group-hover:text-white flex items-center justify-center transition-colors duration-200">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/>
                  <path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/>
                  <path d="M7 21h10"/>
                  <path d="M12 3v18"/>
                  <path d="M3 7h2c2 0 5-1 7-2 2 1 5 2 7 2h2"/>
                </svg>
              </div>
              <span class="text-slate-400 group-hover:text-blue-950 text-xs transition">&rarr;</span>
            </div>
            <div>
              <h3 class="text-slate-900 group-hover:text-blue-950 font-semibold text-sm font-['Poppins'] transition">Hukum Siber & Privasi Data</h3>
              <p class="text-slate-500 text-xs font-normal font-['Poppins'] mt-1">UU Pelindungan Data Pribadi (UU PDP), Kepatuhan Tata Kelola Digital</p>
            </div>
          </a>

          <a href="{{ route('events.index_public', ['category' => 'Ekonomi & Bisnis']) }}" class="p-5 bg-white rounded-xl outline outline-1 outline-offset-[-1px] outline-slate-200 hover:outline-blue-900 hover:shadow-md hover:-translate-y-0.5 transition duration-200 flex flex-col justify-between gap-4 group">
            <div class="flex items-start justify-between">
              <div class="size-11 rounded-lg bg-blue-50 group-hover:bg-blue-950 text-blue-900 group-hover:text-white flex items-center justify-center transition-colors duration-200">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M3 3v18h18"/>
                  <path d="m19 9-5 5-4-4-3 3"/>
                </svg>
              </div>
              <span class="text-slate-400 group-hover:text-blue-950 text-xs transition">&rarr;</span>
            </div>
            <div>
              <h3 class="text-slate-900 group-hover:text-blue-950 font-semibold text-sm font-['Poppins'] transition">Bisnis Digital & Manajemen Produk</h3>
              <p class="text-slate-500 text-xs font-normal font-['Poppins'] mt-1">Kewirausahaan Teknologi, Manajemen Produk Digital, Inovasi Startup</p>
            </div>
          </a>
        </div>
      </section>

      <section class="self-stretch px-6 lg:px-20 py-16 bg-slate-50 border-y border-slate-200 flex flex-col justify-start items-start gap-10">
        <div class="self-stretch flex flex-col justify-start items-start gap-2">
          <h2 class="text-slate-900 text-2xl lg:text-3xl font-semibold font-['Poppins'] leading-tight">Kenapa Mengikuti Seminar & Workshop di Eventict?</h2>
          <p class="text-slate-600 text-sm font-normal font-['Poppins'] leading-5">Temukan beragam seminar, workshop, dan event kolaborasi untuk tingkatkan wawasan serta keahlian kamu.</p>
        </div>

        <div class="self-stretch grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="p-6 bg-white rounded-xl outline outline-1 outline-offset-[-1px] outline-slate-200 flex flex-col gap-4 shadow-xs hover:border-blue-950 transition">
            <div class="size-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-950">
              <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect width="20" height="14" x="2" y="3" rx="2"/>
                <line x1="8" x2="16" y1="21" y2="21"/>
                <line x1="12" x2="12" y1="17" y2="21"/>
              </svg>
            </div>
            <div class="flex flex-col gap-1.5">
              <h3 class="text-slate-900 text-base font-semibold font-['Poppins']">Materi Praktis & Terkini</h3>
              <p class="text-slate-600 text-xs font-normal font-['Poppins'] leading-relaxed">Setiap sesi dirancang fokus pada ilmu dan keahlian terkini yang langsung bisa kamu terapkan dalam studi maupun karier.</p>
            </div>
          </div>

          <div class="p-6 bg-white rounded-xl outline outline-1 outline-offset-[-1px] outline-slate-200 flex flex-col gap-4 shadow-xs hover:border-blue-950 transition">
            <div class="size-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-950">
              <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
              </svg>
            </div>
            <div class="flex flex-col gap-1.5">
              <h3 class="text-slate-900 text-base font-semibold font-['Poppins']">Narasumber & Praktisi Ahli</h3>
              <p class="text-slate-600 text-xs font-normal font-['Poppins'] leading-relaxed">Dapatkan wawasan langsung dari praktisi industri, akademisi, dan pembicara berpengalaman di bidangnya.</p>
            </div>
          </div>

          <div class="p-6 bg-white rounded-xl outline outline-1 outline-offset-[-1px] outline-slate-200 flex flex-col gap-4 shadow-xs hover:border-blue-950 transition">
            <div class="size-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-950">
              <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="8" r="6"/>
                <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
              </svg>
            </div>
            <div class="flex flex-col gap-1.5">
              <h3 class="text-slate-900 text-base font-semibold font-['Poppins']">Sertifikat Resmi Kegiatan</h3>
              <p class="text-slate-600 text-xs font-normal font-['Poppins'] leading-relaxed">Selesai mengikuti kegiatan, kamu akan mendapatkan sertifikat digital resmi untuk melengkapi portofolio dan CV.</p>
            </div>
          </div>
        </div>
      </section>

      <section class="self-stretch px-6 lg:px-20 py-16 bg-white flex flex-col justify-start items-center">
        <div class="w-full rounded-2xl bg-slate-50 border border-slate-200/90 p-8 sm:p-10 lg:p-12 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-10">
          <div class="w-full lg:max-w-xl flex flex-col gap-4">
            <span class="self-start px-3 py-1 bg-blue-100/70 text-blue-900 border border-blue-200/80 rounded-full text-xs font-semibold font-['Poppins']">
              Kerja Sama &amp; Media Partner
            </span>
            <h2 class="text-slate-900 text-2xl sm:text-3xl lg:text-4xl font-bold font-['Poppins'] leading-tight tracking-tight">
              Punya Acara atau Mau Kerja Sama Media Partner?
            </h2>
            <p class="text-slate-600 text-xs sm:text-sm font-normal font-['Poppins'] leading-relaxed">
              Kamu punya seminar, workshop, atau lomba? Eventict siap bantu promosikan acaramu ke ribuan mahasiswa dan peminat teknologi agar makin ramai peserta.
            </p>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
              <a href="{{ route('register') }}" class="w-full sm:w-auto px-6 py-3.5 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold font-['Poppins'] text-center transition shadow-xs flex items-center justify-center gap-2">
                <span>Pasang Acara Sekarang</span>
                <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <path d="M5 12h14"/>
                  <path d="m12 5 7 7-7 7"/>
                </svg>
              </a>
              <a href="mailto:help@eventict.id" class="w-full sm:w-auto px-6 py-3.5 bg-white hover:bg-slate-100 text-slate-800 rounded-xl text-xs font-medium font-['Poppins'] text-center transition border border-slate-300 shadow-2xs flex items-center justify-center gap-2">
                <svg class="size-3.5 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect width="20" height="16" x="2" y="4" rx="2"/>
                  <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                </svg>
                <span>Tanya Kerja Sama</span>
              </a>
            </div>
          </div>

          <div class="w-full lg:w-84 xl:w-96 bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-6 flex flex-col gap-4 shrink-0">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
              <span class="text-xs font-semibold font-['Poppins'] text-slate-900">Cara Pasang Acara</span>
              <span class="text-[11px] font-medium font-['Poppins'] text-blue-900 bg-blue-50 px-2 py-0.5 rounded-md border border-blue-100">3 Langkah Mudah</span>
            </div>

            <div class="flex flex-col gap-3.5">
              <div class="flex items-start gap-3">
                <div class="size-7 rounded-lg bg-blue-950 text-white flex items-center justify-center text-xs font-bold font-['Poppins'] shrink-0 mt-0.5">
                  1
                </div>
                <div class="flex flex-col">
                  <span class="text-slate-900 text-xs font-semibold font-['Poppins']">Kirim Info Acara</span>
                  <span class="text-slate-500 text-[11px] font-normal font-['Poppins'] leading-relaxed">Kirim poster dan jadwal acaramu ke tim kami.</span>
                </div>
              </div>

              <div class="flex items-start gap-3">
                <div class="size-7 rounded-lg bg-blue-950 text-white flex items-center justify-center text-xs font-bold font-['Poppins'] shrink-0 mt-0.5">
                  2
                </div>
                <div class="flex flex-col">
                  <span class="text-slate-900 text-xs font-semibold font-['Poppins']">Kami Siapkan Halamannya</span>
                  <span class="text-slate-500 text-[11px] font-normal font-['Poppins'] leading-relaxed">Tim kami akan memeriksa detail acara dan menyiapkan link pendaftarannya.</span>
                </div>
              </div>

              <div class="flex items-start gap-3">
                <div class="size-7 rounded-lg bg-blue-950 text-white flex items-center justify-center text-xs font-bold font-['Poppins'] shrink-0 mt-0.5">
                  3
                </div>
                <div class="flex flex-col">
                  <span class="text-slate-900 text-xs font-semibold font-['Poppins']">Acara Langsung Tayang</span>
                  <span class="text-slate-500 text-[11px] font-normal font-['Poppins'] leading-relaxed">Acaramu langsung muncul di website dan peserta bisa langsung daftar online.</span>
                </div>
              </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500 font-['Poppins']">
              <span class="flex items-center gap-1.5 text-slate-600 font-medium">
                <svg class="size-3.5 text-blue-900" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
                Terbuka untuk Umum &amp; Kampus
              </span>
              <span class="text-emerald-700 font-semibold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200/60">Gratis Promosi</span>
            </div>
          </div>
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
          <div class="text-slate-400 text-xs font-normal font-['Poppins']">Laboratorium ICT, Unit 7 Lantai 4, Universitas Budi Luhur</div>
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
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const phrases = [
    "Pusat Seminar dan Workshop Kreatif, Inspiratif, Edukatif, dan pastinya Seru dari Lab ICT.",
    "Belajar skill teknologi baru dan langsung praktik bareng ahlinya.",
    "Daftar acaranya dengan mudah dan dapatkan berbagai benefit."
  ];
  const el = document.getElementById('typewriter-text');
  if (!el) return;

  let phraseIdx = 0;
  let charIdx = 0;
  let isDeleting = false;

  function type() {
    const current = phrases[phraseIdx];
    if (isDeleting) {
      el.textContent = current.substring(0, charIdx - 1);
      charIdx--;
    } else {
      el.textContent = current.substring(0, charIdx + 1);
      charIdx++;
    }

    let speed = isDeleting ? 25 : 50;

    if (!isDeleting && charIdx === current.length) {
      speed = 2200;
      isDeleting = true;
    } else if (isDeleting && charIdx === 0) {
      isDeleting = false;
      phraseIdx = (phraseIdx + 1) % phrases.length;
      speed = 400;
    }

    setTimeout(type, speed);
  }

  type();

  const track = document.getElementById('event-carousel-track');
  const prevBtn = document.getElementById('carousel-prev');
  const nextBtn = document.getElementById('carousel-next');
  const dots = document.querySelectorAll('.carousel-dot');
  const container = document.getElementById('event-carousel-container');

  if (track && dots.length > 1) {
    const totalEvents = dots.length;
    const totalSlides = totalEvents + 2;
    let currentIndex = 1;
    let isTransitioning = false;
    let timer = null;

    function updateDots() {
      const activeIdx = (currentIndex - 1 + totalEvents) % totalEvents;
      dots.forEach((dot, idx) => {
        if (idx === activeIdx) {
          dot.classList.remove('w-2', 'bg-white/40');
          dot.classList.add('w-6', 'bg-blue-400');
        } else {
          dot.classList.remove('w-6', 'bg-blue-400');
          dot.classList.add('w-2', 'bg-white/40');
        }
      });
    }

    function slideTo(idx) {
      if (isTransitioning) return;
      isTransitioning = true;
      currentIndex = idx;
      track.style.transition = 'transform 600ms cubic-bezier(0.16, 1, 0.3, 1)';
      track.style.transform = `translateX(-${currentIndex * 100}%)`;
      updateDots();
    }

    function nextSlide() {
      slideTo(currentIndex + 1);
    }

    function prevSlide() {
      slideTo(currentIndex - 1);
    }

    track.addEventListener('transitionend', (e) => {
      if (e.target !== track) return;
      if (currentIndex === totalSlides - 1) {
        track.style.transition = 'none';
        currentIndex = 1;
        track.style.transform = 'translateX(-100%)';
        void track.offsetHeight;
      } else if (currentIndex === 0) {
        track.style.transition = 'none';
        currentIndex = totalSlides - 2;
        track.style.transform = `translateX(-${currentIndex * 100}%)`;
        void track.offsetHeight;
      }
      isTransitioning = false;
    });

    if (nextBtn) {
      nextBtn.addEventListener('click', () => {
        nextSlide();
        resetTimer();
      });
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', () => {
        prevSlide();
        resetTimer();
      });
    }

    dots.forEach((dot) => {
      dot.addEventListener('click', () => {
        if (isTransitioning) return;
        const slideIdx = parseInt(dot.getAttribute('data-slide'), 10);
        slideTo(slideIdx + 1);
        resetTimer();
      });
    });

    function startTimer() {
      timer = setInterval(() => {
        nextSlide();
      }, 5000);
    }

    function resetTimer() {
      if (timer) clearInterval(timer);
      startTimer();
    }

    if (container) {
      container.addEventListener('mouseenter', () => {
        if (timer) clearInterval(timer);
      });
      container.addEventListener('mouseleave', () => {
        startTimer();
      });
    }

    let startX = 0;
    track.addEventListener('touchstart', (e) => {
      startX = e.touches[0].clientX;
    }, { passive: true });
    track.addEventListener('touchend', (e) => {
      const diffX = e.changedTouches[0].clientX - startX;
      if (diffX > 50) {
        prevSlide();
        resetTimer();
      } else if (diffX < -50) {
        nextSlide();
        resetTimer();
      }
    }, { passive: true });

    startTimer();
  }
});
</script>
@endpush
@endsection

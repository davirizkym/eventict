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
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-white font-semibold' : 'text-white/90 font-medium hover:text-white' }} text-sm font-['Poppins'] transition">Beranda</a>
    <a href="{{ route('events.index_public') }}" class="{{ request()->routeIs('events.index_public') || request()->routeIs('events.show') ? 'text-white font-semibold' : 'text-white/90 font-medium hover:text-white' }} text-sm font-['Poppins'] transition">Jelajahi Kegiatan</a>
    <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-white font-semibold' : 'text-white/90 font-medium hover:text-white' }} text-sm font-['Poppins'] transition">Tentang Kami</a>
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

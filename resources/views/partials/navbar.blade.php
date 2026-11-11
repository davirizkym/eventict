<header class="self-stretch h-16 px-4 sm:px-6 lg:px-20 bg-blue-950 border-b border-slate-900 flex justify-between items-center sticky top-0 z-50">
  <div class="flex items-center shrink-0">
    <a href="{{ route('home') }}" class="flex items-center cursor-pointer group">
      <img src="{{ asset('logo_white.svg') }}" alt="Eventict" class="h-7 sm:h-8 w-auto">
    </a>
  </div>
  <nav class="hidden md:flex justify-start items-center gap-8">
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-white font-semibold' : 'text-white/90 font-medium hover:text-white' }} text-sm font-['Poppins'] transition">Beranda</a>
    <a href="{{ route('events.index_public') }}" class="{{ request()->routeIs('events.index_public') || request()->routeIs('events.show') ? 'text-white font-semibold' : 'text-white/90 font-medium hover:text-white' }} text-sm font-['Poppins'] transition">Jelajahi Kegiatan</a>
    <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-white font-semibold' : 'text-white/90 font-medium hover:text-white' }} text-sm font-['Poppins'] transition">Tentang Kami</a>
  </nav>
  <div class="flex items-center gap-2 sm:gap-3">
    @auth
      @if(Auth::user()->isAdministrator())
        <a href="{{ route('organizer.dashboard') }}" class="px-2.5 sm:px-3.5 py-1.5 sm:py-2 bg-white rounded-md text-purple-950 flex justify-center items-center gap-2 hover:bg-purple-50 transition cursor-pointer font-semibold shadow-xs">
          <span class="text-xs font-semibold font-['Poppins'] leading-4"><span class="hidden sm:inline">Panel Admin</span><span class="sm:hidden">Admin</span></span>
        </a>
      @elseif(Auth::user()->isPenyelenggara())
        <a href="{{ route('organizer.dashboard') }}" class="px-2.5 sm:px-3.5 py-1.5 sm:py-2 bg-white rounded-md text-blue-900 flex justify-center items-center gap-2 hover:bg-blue-50 transition cursor-pointer font-semibold shadow-xs">
          <span class="text-xs font-semibold font-['Poppins'] leading-4"><span class="hidden sm:inline">Dashboard Panitia</span><span class="sm:hidden">Panitia</span></span>
        </a>
      @else
        <a href="{{ route('peserta.dashboard') }}" class="px-2.5 sm:px-3.5 py-1.5 sm:py-2 bg-white rounded-md text-blue-900 flex justify-center items-center gap-2 hover:bg-blue-50 transition cursor-pointer font-semibold shadow-xs">
          <span class="text-xs font-semibold font-['Poppins'] leading-4"><span class="hidden sm:inline">Portal Peserta</span><span class="sm:hidden">Portal</span></span>
        </a>
      @endif
      <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button type="submit" class="px-2.5 sm:px-3 py-1.5 sm:py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-medium font-['Poppins'] rounded-md transition cursor-pointer">
          Keluar
        </button>
      </form>
    @else
      <a href="{{ route('login') }}" class="hidden sm:flex px-3.5 py-2 bg-transparent text-white border border-white/40 rounded-md justify-center items-center gap-2 hover:bg-white/10 transition cursor-pointer">
        <span class="text-white text-xs font-medium font-['Poppins'] leading-4">Masuk Akun</span>
      </a>
      <a href="{{ route('register') }}" class="px-3 sm:px-3.5 py-1.5 sm:py-2 bg-white text-blue-950 rounded-md flex justify-center items-center gap-2 hover:bg-blue-50 transition cursor-pointer font-semibold shadow-xs">
        <span class="text-blue-950 text-xs font-semibold font-['Poppins'] leading-4"><span class="hidden sm:inline">Daftar Sekarang</span><span class="sm:hidden">Daftar</span></span>
      </a>
    @endauth
  </div>
</header>

@include('partials.public-bottom-nav')

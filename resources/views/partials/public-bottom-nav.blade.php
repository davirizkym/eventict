<nav class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200/90 shadow-[0_-4px_20px_rgba(0,0,0,0.06)] md:hidden px-2 py-1.5 font-['Poppins']" style="padding-bottom: max(0.4rem, env(safe-area-inset-bottom));">
  <div class="grid grid-cols-4 items-center text-center">
    <a
      href="{{ route('home') }}"
      class="flex flex-col items-center justify-center gap-1 py-1 px-1 rounded-lg transition {{ request()->routeIs('home') ? 'text-blue-950 font-bold' : 'text-slate-400 hover:text-slate-700 font-medium' }}"
    >
      <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ request()->routeIs('home') ? '2.5' : '2' }}">
        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
        <polyline points="9 22 9 12 15 12 15 22"/>
      </svg>
      <span class="text-[10px] leading-none tracking-tight">Beranda</span>
    </a>

    <a
      href="{{ route('events.index_public') }}"
      class="flex flex-col items-center justify-center gap-1 py-1 px-1 rounded-lg transition {{ (request()->routeIs('events.index_public') || request()->routeIs('events.show') || request()->routeIs('events.register.form')) ? 'text-blue-950 font-bold' : 'text-slate-400 hover:text-slate-700 font-medium' }}"
    >
      <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ (request()->routeIs('events.index_public') || request()->routeIs('events.show') || request()->routeIs('events.register.form')) ? '2.5' : '2' }}">
        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
        <line x1="16" x2="16" y1="2" y2="6"/>
        <line x1="8" x2="8" y1="2" y2="6"/>
        <line x1="3" x2="21" y1="10" y2="10"/>
      </svg>
      <span class="text-[10px] leading-none tracking-tight">Kegiatan</span>
    </a>

    <a
      href="{{ route('about') }}"
      class="flex flex-col items-center justify-center gap-1 py-1 px-1 rounded-lg transition {{ request()->routeIs('about') ? 'text-blue-950 font-bold' : 'text-slate-400 hover:text-slate-700 font-medium' }}"
    >
      <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ request()->routeIs('about') ? '2.5' : '2' }}">
        <circle cx="12" cy="12" r="10"/>
        <line x1="12" x2="12" y1="16" y2="12"/>
        <line x1="12" x2="12.01" y1="8" y2="8"/>
      </svg>
      <span class="text-[10px] leading-none tracking-tight">Tentang</span>
    </a>

    @guest
      <a
        href="{{ route('login') }}"
        class="flex flex-col items-center justify-center gap-1 py-1 px-1 rounded-lg transition {{ (request()->routeIs('login') || request()->routeIs('register')) ? 'text-blue-950 font-bold' : 'text-slate-400 hover:text-slate-700 font-medium' }}"
      >
        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ (request()->routeIs('login') || request()->routeIs('register')) ? '2.5' : '2' }}">
          <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
          <polyline points="10 17 15 12 10 7"/>
          <line x1="15" x2="3" y1="12" y2="12"/>
        </svg>
        <span class="text-[10px] leading-none tracking-tight">Masuk</span>
      </a>
    @else
      @if(Auth::user()->isAdministrator())
        <a
          href="{{ route('organizer.dashboard') }}"
          class="flex flex-col items-center justify-center gap-1 py-1 px-1 rounded-lg transition {{ (request()->routeIs('organizer.*') || request()->routeIs('admin.*')) ? 'text-purple-900 font-bold' : 'text-slate-400 hover:text-slate-700 font-medium' }}"
        >
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ (request()->routeIs('organizer.*') || request()->routeIs('admin.*')) ? '2.5' : '2' }}">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
          <span class="text-[10px] leading-none tracking-tight">Admin</span>
        </a>
      @elseif(Auth::user()->isPenyelenggara())
        <a
          href="{{ route('organizer.dashboard') }}"
          class="flex flex-col items-center justify-center gap-1 py-1 px-1 rounded-lg transition {{ request()->routeIs('organizer.*') ? 'text-blue-950 font-bold' : 'text-slate-400 hover:text-slate-700 font-medium' }}"
        >
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ request()->routeIs('organizer.*') ? '2.5' : '2' }}">
            <rect width="18" height="18" x="3" y="3" rx="2"/>
            <path d="M3 9h18"/>
            <path d="M9 21V9"/>
          </svg>
          <span class="text-[10px] leading-none tracking-tight">Panitia</span>
        </a>
      @else
        <a
          href="{{ route('peserta.dashboard') }}"
          class="flex flex-col items-center justify-center gap-1 py-1 px-1 rounded-lg transition {{ request()->routeIs('peserta.*') ? 'text-blue-950 font-bold' : 'text-slate-400 hover:text-slate-700 font-medium' }}"
        >
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ request()->routeIs('peserta.*') ? '2.5' : '2' }}">
            <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/>
            <path d="M13 5v2"/>
            <path d="M13 17v2"/>
            <path d="M13 11v2"/>
          </svg>
          <span class="text-[10px] leading-none tracking-tight">Tiket Saya</span>
        </a>
      @endif
    @endguest
  </div>
</nav>

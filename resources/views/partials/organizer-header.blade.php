<header class="bg-blue-950 text-white border-b border-blue-900 sticky top-0 z-30 shadow-xs">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-4">
    <div class="flex items-center gap-6 sm:gap-8">
      <a href="{{ route('organizer.dashboard') }}" class="flex items-center gap-3 group">
        <img src="{{ asset('logo_white.svg') }}" alt="Eventict" class="h-8 w-auto">
      </a>

      <nav class="hidden md:flex items-center gap-2">
        <a href="{{ route('organizer.dashboard') }}" class="px-3.5 py-2 rounded-lg text-xs {{ (request()->routeIs('organizer.dashboard') || request()->routeIs('organizer.workspace')) ? 'font-semibold bg-white/10 text-white' : 'font-medium text-slate-300 hover:text-white hover:bg-white/5' }} transition flex items-center gap-2">
          <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect width="18" height="18" x="3" y="3" rx="2"/>
            <path d="M3 9h18"/>
            <path d="M9 21V9"/>
          </svg>
          <span>Semua Kegiatan</span>
        </a>
        <a href="{{ route('organizer.categories.index') }}" class="px-3.5 py-2 rounded-lg text-xs {{ request()->routeIs('organizer.categories.*') ? 'font-semibold bg-white/10 text-white' : 'font-medium text-slate-300 hover:text-white hover:bg-white/5' }} transition flex items-center gap-2">
          <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M4 6h16M4 12h16M4 18h7"/>
          </svg>
          <span>Kategori</span>
        </a>
        <a href="{{ route('organizer.speakers.index') }}" class="px-3.5 py-2 rounded-lg text-xs {{ request()->routeIs('organizer.speakers.*') ? 'font-semibold bg-white/10 text-white' : 'font-medium text-slate-300 hover:text-white hover:bg-white/5' }} transition flex items-center gap-2">
          <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
          <span>Pengisi Acara</span>
        </a>
        <a href="{{ route('organizer.media_partners.index') }}" class="px-3.5 py-2 rounded-lg text-xs {{ request()->routeIs('organizer.media_partners.*') ? 'font-semibold bg-white/10 text-white' : 'font-medium text-slate-300 hover:text-white hover:bg-white/5' }} transition flex items-center gap-2">
          <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="m3 11 18-5v12L3 14v-3z"/>
            <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>
          </svg>
          <span>Media Partner</span>
        </a>
        @if(Auth::user()->isAdministrator())
          <a href="{{ route('admin.users.index') }}" class="px-3.5 py-2 rounded-lg text-xs {{ request()->routeIs('admin.users.*') ? 'font-semibold bg-white/10 text-white' : 'font-medium text-slate-300 hover:text-white hover:bg-white/5' }} transition flex items-center gap-2">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <span>Kelola User</span>
          </a>
        @endif
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
        <div class="size-8 rounded-lg {{ Auth::user()->isAdministrator() ? 'bg-purple-700' : 'bg-blue-900' }} text-white font-semibold text-xs flex items-center justify-center shrink-0">
          {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 2)) }}
        </div>
        <div class="hidden lg:flex flex-col min-w-0">
          <span class="text-white text-xs font-semibold truncate max-w-[170px]">{{ Auth::user()->name ?? 'Sekretariat Panitia' }}</span>
          <span class="text-slate-400 text-[11px] truncate max-w-[170px]">{{ Auth::user()->isAdministrator() ? 'Administrator' : (Auth::user()->institution ?? 'Laboratorium ICT') }}</span>
        </div>
        <form id="logout-form-organizer" method="POST" action="{{ route('logout') }}" class="shrink-0">
          @csrf
          <button type="button" onclick="confirmLogout('logout-form-organizer')" title="Keluar" class="p-1.5 text-rose-300 hover:text-white hover:bg-rose-500/20 rounded-lg transition cursor-pointer">
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

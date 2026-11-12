@auth
  @if(Auth::user()->isPenyelenggara())
    @php
      $isAdmin = Auth::user()->isAdministrator();
      $gridCols = $isAdmin ? 'grid-cols-5' : 'grid-cols-4';
    @endphp
    <nav class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200/90 shadow-[0_-4px_20px_rgba(0,0,0,0.06)] md:hidden px-2 py-1.5 font-['Poppins']" style="padding-bottom: max(0.4rem, env(safe-area-inset-bottom));">
      <div class="grid {{ $gridCols }} items-center text-center">
        <a
          href="{{ route('organizer.dashboard') }}"
          class="flex flex-col items-center justify-center gap-1 py-1 px-1 rounded-lg transition {{ (request()->routeIs('organizer.dashboard') || request()->routeIs('organizer.workspace') || request()->routeIs('organizer.history')) ? 'text-blue-950 font-bold' : 'text-slate-400 hover:text-slate-700 font-medium' }}"
        >
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ (request()->routeIs('organizer.dashboard') || request()->routeIs('organizer.workspace') || request()->routeIs('organizer.history')) ? '2.5' : '2' }}">
            <rect width="18" height="18" x="3" y="3" rx="2"/>
            <path d="M3 9h18"/>
            <path d="M9 21V9"/>
          </svg>
          <span class="text-[10px] leading-none tracking-tight">Kegiatan</span>
        </a>

        <a
          href="{{ route('organizer.categories.index') }}"
          class="flex flex-col items-center justify-center gap-1 py-1 px-1 rounded-lg transition {{ request()->routeIs('organizer.categories.*') ? 'text-blue-950 font-bold' : 'text-slate-400 hover:text-slate-700 font-medium' }}"
        >
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ request()->routeIs('organizer.categories.*') ? '2.5' : '2' }}">
            <path d="M4 6h16M4 12h16M4 18h7"/>
          </svg>
          <span class="text-[10px] leading-none tracking-tight">Kategori</span>
        </a>

        <a
          href="{{ route('organizer.speakers.index') }}"
          class="flex flex-col items-center justify-center gap-1 py-1 px-1 rounded-lg transition {{ request()->routeIs('organizer.speakers.*') ? 'text-blue-950 font-bold' : 'text-slate-400 hover:text-slate-700 font-medium' }}"
        >
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ request()->routeIs('organizer.speakers.*') ? '2.5' : '2' }}">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
          <span class="text-[10px] leading-none tracking-tight">Narasumber</span>
        </a>

        <a
          href="{{ route('organizer.media_partners.index') }}"
          class="flex flex-col items-center justify-center gap-1 py-1 px-1 rounded-lg transition {{ request()->routeIs('organizer.media_partners.*') ? 'text-blue-950 font-bold' : 'text-slate-400 hover:text-slate-700 font-medium' }}"
        >
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ request()->routeIs('organizer.media_partners.*') ? '2.5' : '2' }}">
            <path d="m3 11 18-5v12L3 14v-3z"/>
            <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>
          </svg>
          <span class="text-[10px] leading-none tracking-tight">Mitra</span>
        </a>

        @if($isAdmin)
          <a
            href="{{ route('admin.users.index') }}"
            class="flex flex-col items-center justify-center gap-1 py-1 px-1 rounded-lg transition {{ request()->routeIs('admin.users.*') ? 'text-purple-900 font-bold' : 'text-slate-400 hover:text-slate-700 font-medium' }}"
          >
            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ request()->routeIs('admin.users.*') ? '2.5' : '2' }}">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <span class="text-[10px] leading-none tracking-tight">User</span>
          </a>
        @endif
      </div>
    </nav>
  @endif
@endauth

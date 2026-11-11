<nav class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200/90 shadow-[0_-4px_20px_rgba(0,0,0,0.06)] md:hidden px-2 py-1.5 font-['Poppins']" style="padding-bottom: max(0.4rem, env(safe-area-inset-bottom));">
  <div class="grid grid-cols-5 items-center text-center">
    <a
      href="{{ route('peserta.dashboard', ['tab' => 'dashboard']) }}"
      class="flex flex-col items-center justify-center gap-1 py-1 px-1 rounded-lg transition {{ $tab === 'dashboard' ? 'text-blue-950 font-bold' : 'text-slate-400 hover:text-slate-700 font-medium' }}"
    >
      <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $tab === 'dashboard' ? '2.5' : '2' }}">
        <rect width="18" height="18" x="3" y="3" rx="2"/>
        <path d="M3 9h18"/>
        <path d="M9 21V9"/>
      </svg>
      <span class="text-[10px] leading-none tracking-tight">Dashboard</span>
    </a>

    <a
      href="{{ route('peserta.dashboard', ['tab' => 'tiket']) }}"
      class="flex flex-col items-center justify-center gap-1 py-1 px-1 rounded-lg transition {{ ($tab === 'tiket' || $tab === 'acara') ? 'text-blue-950 font-bold' : 'text-slate-400 hover:text-slate-700 font-medium' }}"
    >
      <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ ($tab === 'tiket' || $tab === 'acara') ? '2.5' : '2' }}">
        <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/>
        <path d="M13 5v2"/>
        <path d="M13 17v2"/>
        <path d="M13 11v2"/>
      </svg>
      <span class="text-[10px] leading-none tracking-tight">Tiket</span>
    </a>

    <a
      href="{{ route('peserta.dashboard', ['tab' => 'sertifikat']) }}"
      class="flex flex-col items-center justify-center gap-1 py-1 px-1 rounded-lg transition {{ $tab === 'sertifikat' ? 'text-blue-950 font-bold' : 'text-slate-400 hover:text-slate-700 font-medium' }}"
    >
      <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $tab === 'sertifikat' ? '2.5' : '2' }}">
        <circle cx="12" cy="8" r="6"/>
        <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
      </svg>
      <span class="text-[10px] leading-none tracking-tight">Sertifikat</span>
    </a>

    <a
      href="{{ route('peserta.dashboard', ['tab' => 'kegiatan']) }}"
      class="flex flex-col items-center justify-center gap-1 py-1 px-1 rounded-lg transition {{ $tab === 'kegiatan' ? 'text-blue-950 font-bold' : 'text-slate-400 hover:text-slate-700 font-medium' }}"
    >
      <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $tab === 'kegiatan' ? '2.5' : '2' }}">
        <circle cx="11" cy="11" r="8"/>
        <path d="m21 21-4.35-4.35"/>
      </svg>
      <span class="text-[10px] leading-none tracking-tight">Jelajahi</span>
    </a>

    <a
      href="{{ route('peserta.dashboard', ['tab' => 'profil']) }}"
      class="flex flex-col items-center justify-center gap-1 py-1 px-1 rounded-lg transition {{ $tab === 'profil' ? 'text-blue-950 font-bold' : 'text-slate-400 hover:text-slate-700 font-medium' }}"
    >
      <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $tab === 'profil' ? '2.5' : '2' }}">
        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
        <circle cx="12" cy="7" r="4"/>
      </svg>
      <span class="text-[10px] leading-none tracking-tight">Profil</span>
    </a>
  </div>
</nav>

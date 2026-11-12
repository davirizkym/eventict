<style>
  .footer-grid {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
  }
  @media (min-width: 768px) {
    .footer-grid {
      display: grid !important;
      grid-template-columns: 1fr auto !important;
      column-gap: 2rem !important;
      row-gap: 2rem !important;
    }
  }
</style>

<footer class="w-full bg-blue-950 border-t border-slate-900">
  <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-16 md:pb-8 footer-grid">
    {{-- Row 1, Col 1: Brand Info --}}
    <div class="flex flex-col gap-3 max-w-sm sm:max-w-md">
      <div class="flex items-center">
        <img src="{{ asset('logo_white.svg') }}" alt="Eventict" class="h-8 w-auto">
      </div>
      <p class="text-slate-300 text-xs font-normal font-['Poppins'] leading-relaxed">Platform terpadu manajemen pendaftaran workshop dan seminar Laboratorium ICT.</p>
      <div class="text-slate-400 text-xs font-normal font-['Poppins']">Laboratorium ICT, Unit 7 Lantai 4, Universitas Budi Luhur</div>
    </div>

    {{-- Row 1, Col 2: Pusat Bantuan & Kontak + Medsos --}}
    <div class="flex flex-col gap-2.5">
      <span class="text-white text-sm font-semibold font-['Poppins']">Pusat Bantuan & Kontak</span>
      <a href="mailto:labkom@budiluhur.ac.id" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition flex items-center gap-2">
        <svg class="size-3.5 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <rect width="20" height="16" x="2" y="4" rx="2"/>
          <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
        </svg>
        <span>labkom@budiluhur.ac.id</span>
      </a>
      <div class="flex flex-col gap-0.5 text-slate-400 text-xs font-normal font-['Poppins']">
        <span>Senin–Jumat: 08:00–20:40 WIB</span>
        <span>Sabtu: 08:00–17:00 WIB</span>
      </div>

      <div class="pt-1.5 flex flex-col gap-1.5">
        <span class="text-slate-400 text-[11px] font-medium font-['Poppins'] uppercase tracking-wider">Media Sosial &amp; Web</span>
        <div class="flex items-center gap-2">
          <a href="https://www.instagram.com/labictubl?utm_source=ig_web_button_share_sheet&xtok=ZDNlZDc0MzIxNw==" target="_blank" rel="noopener noreferrer" class="size-8 rounded-lg bg-white/10 hover:bg-white/20 text-slate-300 hover:text-white flex items-center justify-center transition shadow-2xs" title="Instagram @labictubl" aria-label="Instagram">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
              <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
              <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
            </svg>
          </a>
          <a href="http://www.youtube.com/@labictubl6291" target="_blank" rel="noopener noreferrer" class="size-8 rounded-lg bg-white/10 hover:bg-white/20 text-slate-300 hover:text-white flex items-center justify-center transition shadow-2xs" title="YouTube @labictubl6291" aria-label="YouTube">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/>
              <polygon points="10 15 15 12 10 9"/>
            </svg>
          </a>
          <a href="https://labict.budiluhur.ac.id/" target="_blank" rel="noopener noreferrer" class="size-8 rounded-lg bg-white/10 hover:bg-white/20 text-slate-300 hover:text-white flex items-center justify-center transition shadow-2xs" title="Website Lab ICT" aria-label="Website Lab ICT">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/>
              <line x1="2" x2="22" y1="12" y2="12"/>
              <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </svg>
          </a>
        </div>
      </div>
    </div>

    {{-- Row 2, Col 1: Copyright --}}
    <div class="text-xs font-normal font-['Poppins'] text-slate-400 self-center">
      © 2026 Eventict — Laboratorium ICT. Seluruh hak dilindungi.
    </div>

    {{-- Row 2, Col 2: Sistem Informasi Manajemen (Sejajar vertikal dengan Pusat Bantuan & Kontak) --}}
    <div class="text-xs font-normal font-['Poppins'] text-slate-400 self-center whitespace-nowrap">
      Sistem Informasi Manajemen Event Laboratorium ICT.
    </div>
  </div>
</footer>

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
      <a href="{{ route('events.index_public', ['category' => 'Teknologi & Rekayasa']) }}" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Workshop Pemrograman & Web/Mobile</a>
      <a href="{{ route('events.index_public', ['category' => 'Teknologi & Rekayasa']) }}" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Pelatihan AI, Data & Machine Learning</a>
      <a href="{{ route('events.index_public', ['category' => 'Teknologi & Rekayasa']) }}" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Jaringan Komputer & Cyber Security</a>
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
      <a href="mailto:help@eventict.id" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition flex items-center gap-2">
        <svg class="size-3.5 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <rect width="20" height="16" x="2" y="4" rx="2"/>
          <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
        </svg>
        <span>help@eventict.id</span>
      </a>
      <span class="text-slate-400 text-xs font-normal font-['Poppins']">Senin–Jumat, 08:00–17:00 WIB</span>

      <div class="pt-2 flex flex-col gap-2.5">
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
  </div>

  <div class="self-stretch pt-6 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs font-normal font-['Poppins'] text-slate-400">
    <div>© 2026 Eventict — Laboratorium ICT. Seluruh hak dilindungi.</div>
    <div>Sistem Informasi Manajemen Event Laboratorium Komputer & Teknologi Informasi.</div>
  </div>
</footer>

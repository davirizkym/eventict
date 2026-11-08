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
      <span class="text-slate-300 text-xs font-normal font-['Poppins']">help@eventict.id</span>
      <span class="text-slate-400 text-xs font-normal font-['Poppins']">Senin–Jumat, 08:00–17:00 WIB</span>
    </div>
  </div>

  <div class="self-stretch pt-6 border-t border-slate-800 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs font-normal font-['Poppins'] text-slate-400">
    <div>© 2026 Eventict — Laboratorium ICT. Seluruh hak dilindungi.</div>
    <div>Sistem Informasi Manajemen Event Laboratorium Komputer & Teknologi Informasi.</div>
  </div>
</footer>

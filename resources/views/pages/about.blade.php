@extends('layouts.app')

@section('title', 'Tentang Kami — Laboratorium ICT')

@section('content')
<div class="w-full min-h-screen bg-slate-50 flex justify-center items-start">
  <div class="w-full max-w-[1440px] bg-slate-50 flex flex-col justify-start items-start">
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
        <a href="{{ route('home') }}" class="text-white/90 text-sm font-medium font-['Poppins'] hover:text-white transition">Beranda</a>
        <a href="{{ route('events.index_public') }}" class="text-white/90 text-sm font-medium font-['Poppins'] hover:text-white transition">Jelajahi Kegiatan</a>
        <a href="{{ route('about') }}" class="text-white text-sm font-semibold font-['Poppins'] transition">Tentang Kami</a>
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

    <main class="self-stretch px-6 lg:px-20 py-10 flex flex-col gap-10">
      <div class="flex items-center gap-2 text-xs text-slate-500 font-['Poppins']">
        <a href="{{ route('home') }}" class="hover:text-blue-950 transition">Beranda</a>
        <span>/</span>
        <span class="text-slate-900 font-medium">Tentang Kami</span>
      </div>

      <div class="flex flex-col gap-2 pb-6 border-b border-slate-200">
        <h1 class="text-slate-900 text-2xl sm:text-3xl font-semibold font-['Poppins']">
          Tentang Eventict — Laboratorium ICT
        </h1>
        <p class="text-slate-600 text-xs sm:text-sm font-normal font-['Poppins'] max-w-3xl leading-relaxed">
          Sistem informasi direktori dan administrasi kegiatan workshop, pelatihan komputasi, seminar teknologi, dan sertifikasi Laboratorium ICT.
        </p>
      </div>

      <section class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <div class="lg:col-span-2 flex flex-col gap-6">
          <div class="p-8 bg-white rounded-xl border border-slate-200 flex flex-col gap-4 shadow-xs">
            <h2 class="text-slate-900 text-lg font-semibold font-['Poppins']">Peran & Fungsi Platform</h2>
            <p class="text-slate-600 text-xs sm:text-sm leading-relaxed font-['Poppins']">
              Eventict dikembangkan sebagai pusat publikasi, pendaftaran, dan manajemen kegiatan yang diselenggarakan oleh Laboratorium ICT (ICT Laboratory). Platform ini memfasilitasi mahasiswa, dosen, asisten laboratorium, dan praktisi industri untuk terhubung dalam program peningkatan keterampilan teknologi informasi dan komputasi praktis.
            </p>
            <p class="text-slate-600 text-xs sm:text-sm leading-relaxed font-['Poppins']">
              Seluruh proses mulai dari pendaftaran peserta, alokasi kuota sesi, presensi terverifikasi di ruang lab komputer maupun sesi daring, hingga penerbitan e-sertifikat digital terkelola secara otomatis dan transparan.
            </p>
          </div>

          <div class="p-8 bg-white rounded-xl border border-slate-200 flex flex-col gap-4 shadow-xs">
            <h2 class="text-slate-900 text-lg font-semibold font-['Poppins']">Fasilitas & Infrastruktur Pendukung</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-['Poppins']">
              <div class="p-4 bg-slate-50 rounded-lg border border-slate-200 flex flex-col gap-1.5">
                <span class="font-semibold text-slate-900">Lab Komputer Terintegrasi</span>
                <p class="text-slate-600 leading-relaxed">
                  Ruang laboratorium komputer dengan spesifikasi perangkat modern untuk kebutuhan praktikum programming, data science, dan simulasi jaringan.
                </p>
              </div>
              <div class="p-4 bg-slate-50 rounded-lg border border-slate-200 flex flex-col gap-1.5">
                <span class="font-semibold text-slate-900">Jaringan & Server Komputasi</span>
                <p class="text-slate-600 leading-relaxed">
                  Koneksi internet gigabit dedicated dan server komputasi lokal yang mendukung lingkungan eksperimen komputasi dan cloud lab.
                </p>
              </div>
              <div class="p-4 bg-slate-50 rounded-lg border border-slate-200 flex flex-col gap-1.5">
                <span class="font-semibold text-slate-900">Presensi & Validasi Terdata</span>
                <p class="text-slate-600 leading-relaxed">
                  Sistem pencatatan kehadiran berbasis pass kode unik guna memastikan keabsahan kehadiran peserta di setiap sesi kegiatan.
                </p>
              </div>
              <div class="p-4 bg-slate-50 rounded-lg border border-slate-200 flex flex-col gap-1.5">
                <span class="font-semibold text-slate-900">E-Sertifikat Terverifikasi</span>
                <p class="text-slate-600 leading-relaxed">
                  Dokumen sertifikat pelatihan resmi yang diterbitkan langsung oleh Laboratorium ICT dan tersimpan permanen di akun peserta.
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="flex flex-col gap-6">
          <div class="p-6 bg-white rounded-xl border border-slate-200 flex flex-col gap-4 shadow-xs">
            <h2 class="text-slate-900 text-base font-semibold font-['Poppins']">Sekretariat Laboratorium ICT</h2>
            <div class="text-xs text-slate-600 flex flex-col gap-3 font-['Poppins']">
              <div>
                <span class="text-slate-400 block text-[11px]">Lokasi Laboratorium:</span>
                <span class="text-slate-800 font-medium">Gedung Laboratorium Komputer ICT, Universitas Budi Luhur</span>
              </div>
              <div>
                <span class="text-slate-400 block text-[11px]">Email Dukungan:</span>
                <span class="text-slate-800 font-medium">help@eventict.id</span>
              </div>
              <div>
                <span class="text-slate-400 block text-[11px]">Jam Operasional:</span>
                <span class="text-slate-800 font-medium">Senin – Jumat, 08:00 – 17:00 WIB</span>
              </div>
            </div>
          </div>

          <div class="p-6 bg-blue-950 text-white rounded-xl flex flex-col gap-3 shadow-xs">
            <h2 class="text-white text-base font-semibold font-['Poppins']">Akses Panitia & Asisten Lab</h2>
            <p class="text-slate-300 text-xs leading-relaxed font-['Poppins']">
              Bagi asisten lab, dosen pengampu, maupun panitia kegiatan internal yang ingin mengelola pendaftaran peserta, presensi hari-H, dan distribusi sertifikat, silakan masuk melalui portal panitia.
            </p>
            <a href="{{ route('login') }}" class="mt-2 py-2.5 px-4 bg-white text-blue-950 rounded-lg text-xs font-semibold font-['Poppins'] hover:bg-slate-100 transition text-center">
              Masuk Portal Panitia
            </a>
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
          <div class="text-slate-400 text-xs font-normal font-['Poppins']">Sekretariat Laboratorium ICT • Gedung Lab Komputer</div>
        </div>

        <div class="flex flex-col gap-3">
          <span class="text-white text-sm font-semibold font-['Poppins']">Kategori Event</span>
          <a href="{{ route('home') }}#kegiatan" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Workshop Pemrograman & Web/Mobile</a>
          <a href="{{ route('home') }}#kegiatan" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Pelatihan AI, Data & Machine Learning</a>
          <a href="{{ route('home') }}#kegiatan" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Jaringan Komputer & Cyber Security</a>
          <a href="{{ route('home') }}#kegiatan" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Seminar Teknologi & Tech Talk</a>
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
@endsection

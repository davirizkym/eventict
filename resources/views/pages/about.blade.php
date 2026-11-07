@extends('layouts.app')

@section('title', 'Tentang Kami — Laboratorium ICT')

@section('content')
<div class="w-full min-h-screen bg-slate-50 flex justify-center items-start">
  <div class="w-full max-w-[1440px] bg-slate-50 flex flex-col justify-start items-start">
    @include('partials.navbar')

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
                <span class="text-slate-800 font-medium">Laboratorium ICT, Unit 7 Lantai 4, Universitas Budi Luhur</span>
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

        </div>
      </section>
    </main>

    @include('partials.footer')
  </div>
</div>
@endsection

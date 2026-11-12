@extends('layouts.app')

@section('title', 'Tentang Kami — Laboratorium ICT')

@section('content')
<div class="w-full min-h-screen bg-slate-50 flex flex-col justify-between">
  @include('partials.navbar')

  <div class="w-full flex-1 flex justify-center items-start">
    <div class="w-full max-w-[1440px] bg-slate-50 flex flex-col justify-start items-start">
      <main class="self-stretch px-4 sm:px-6 lg:px-20 py-8 sm:py-10 pb-24 md:pb-12 flex flex-col gap-8 sm:gap-10">
      <div class="flex items-center gap-2 text-xs text-slate-500 font-['Poppins']">
        <a href="{{ route('home') }}" class="hover:text-blue-950 transition">Beranda</a>
        <span>/</span>
        <span class="text-slate-900 font-medium">Tentang Kami</span>
      </div>

      <div class="flex flex-col gap-2 pb-6 border-b border-slate-200">
        <h1 class="text-slate-900 text-2xl sm:text-3xl font-semibold font-['Poppins']">
          Tentang Eventict
        </h1>
        <p class="text-slate-600 text-xs sm:text-sm font-normal font-['Poppins'] max-w-3xl leading-relaxed">
          Tempat mencari dan mendaftar berbagai acara, pelatihan komputer, dan seminar seru yang diselenggarakan oleh Laboratorium ICT.
        </p>
      </div>

      <section class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <div class="lg:col-span-2 flex flex-col gap-6">
          <div class="p-5 sm:p-8 bg-white rounded-xl border border-slate-200 flex flex-col gap-4 shadow-xs">
            <h2 class="text-slate-900 text-lg font-semibold font-['Poppins']">Mengenal Eventict</h2>
            <p class="text-slate-600 text-xs sm:text-sm leading-relaxed font-['Poppins']">
              Eventict adalah wadah resmi dari Laboratorium ICT untuk membantu Anda menemukan kegiatan bermanfaat seputar dunia teknologi. Siapa pun, baik mahasiswa, pelajar, maupun masyarakat umum, dapat ikut serta untuk belajar dan menambah wawasan baru.
            </p>
            <p class="text-slate-600 text-xs sm:text-sm leading-relaxed font-['Poppins']">
              Semua proses dibuat praktis dan mudah: Anda cukup memilih acara yang diminati, mendaftar langsung secara online, melakukan absensi saat hadir, dan mengunduh sertifikat resmi setelah acara selesai.
            </p>
          </div>

          <div class="p-5 sm:p-8 bg-white rounded-xl border border-slate-200 flex flex-col gap-4 shadow-xs">
            <h2 class="text-slate-900 text-lg font-semibold font-['Poppins']">Apa Saja yang Anda Dapatkan?</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-['Poppins']">
              <div class="p-4 bg-slate-50 rounded-lg border border-slate-200 flex flex-col gap-1.5">
                <span class="font-semibold text-slate-900">Wawasan Bermanfaat</span>
                <p class="text-slate-600 leading-relaxed">
                  Pahami topik pembahasan lewat penyampaian yang santai, jelas, dan mudah dimengerti.
                </p>
              </div>
              <div class="p-4 bg-slate-50 rounded-lg border border-slate-200 flex flex-col gap-1.5">
                <span class="font-semibold text-slate-900">Slide Materi Acara</span>
                <p class="text-slate-600 leading-relaxed">
                  Dapatkan salinan bahan presentasi untuk kamu pelajari ulang di rumah.
                </p>
              </div>
              <div class="p-4 bg-slate-50 rounded-lg border border-slate-200 flex flex-col gap-1.5">
                <span class="font-semibold text-slate-900">Koneksi Baru</span>
                <p class="text-slate-600 leading-relaxed">
                  Wadah temu dan interaksi bareng audiens lain yang punya minat sama.
                </p>
              </div>
              <div class="p-4 bg-slate-50 rounded-lg border border-slate-200 flex flex-col gap-1.5">
                <span class="font-semibold text-slate-900">Sertifikat Digital</span>
                <p class="text-slate-600 leading-relaxed">
                  Bisa diunduh langsung lewat web kapan saja tanpa takut hilang atau terselip.
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="flex flex-col gap-6">
          <div class="p-5 sm:p-6 bg-white rounded-xl border border-slate-200 flex flex-col gap-4 shadow-xs">
            <h2 class="text-slate-900 text-base font-semibold font-['Poppins']">Kontak & Lokasi Kami</h2>
            <div class="text-xs text-slate-600 flex flex-col gap-3 font-['Poppins']">
              <div>
                <span class="text-slate-400 block text-[11px]">Alamat:</span>
                <span class="text-slate-800 font-medium">Laboratorium ICT, Unit 7 Lantai 4, Universitas Budi Luhur</span>
              </div>
              <div>
                <span class="text-slate-400 block text-[11px]">Email Bantuan:</span>
                <span class="text-slate-800 font-medium">labkom@budiluhur.ac.id</span>
              </div>
              <div>
                <span class="text-slate-400 block text-[11px]">Jam Layanan:</span>
                <span class="text-slate-800 font-medium block">Senin – Jumat: 08:00 – 20:40 WIB</span>
                <span class="text-slate-800 font-medium block">Sabtu: 08:00 – 17:00 WIB</span>
              </div>
            </div>
          </div>
        </div>
      </section>
      </main>
    </div>
  </div>

  @include('partials.footer')
</div>
@endsection
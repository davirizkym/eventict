@extends('layouts.app')

@section('title', 'Daftar Akun Peserta — Eventict')

@section('content')
<div class="w-full min-h-screen bg-slate-50 flex flex-col justify-between items-center py-8 px-4 sm:px-6 lg:px-8">
  <div class="w-full max-w-5xl flex items-center justify-between mb-6">
    <a href="{{ route('home') }}" class="flex items-center group">
      <img src="{{ asset('logo_blue.svg') }}" alt="Eventict" class="h-8 sm:h-9 w-auto">
    </a>
    <a href="{{ route('home') }}" class="text-xs font-medium text-slate-500 hover:text-blue-950 font-['Poppins'] flex items-center gap-1.5 transition">
      <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="m15 18-6-6 6-6"/>
      </svg>
      <span><span class="hidden sm:inline">Kembali ke Beranda</span><span class="sm:hidden">Beranda</span></span>
    </a>
  </div>

  <div class="w-full max-w-5xl bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 shadow-xs flex flex-col md:flex-row overflow-hidden my-auto">
    <div class="w-full md:w-5/12 bg-blue-950 text-white p-6 sm:p-8 lg:p-10 flex flex-col justify-between">
      <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-2">
          <h2 class="text-2xl font-bold font-['Poppins'] leading-snug">Portal Peserta Eventict</h2>
          <p class="text-slate-300 text-xs font-normal font-['Poppins'] leading-relaxed">Pendaftaran peserta untuk kemudahan akses seminar teknologi, absensi digital presisi, dan portofolio sertifikat terpadu.</p>
        </div>

        <div class="p-4 bg-white/5 border border-white/10 rounded-xl flex flex-col gap-3">
          <div class="flex items-center gap-2.5 text-xs text-slate-200 font-['Poppins']">
            <svg class="size-4 text-emerald-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span>Wawasan Bermanfaat</span>
          </div>
          <div class="flex items-center gap-2.5 text-xs text-slate-200 font-['Poppins']">
            <svg class="size-4 text-emerald-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span>Slide Materi Acara</span>
          </div>
          <div class="flex items-center gap-2.5 text-xs text-slate-200 font-['Poppins']">
            <svg class="size-4 text-emerald-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span>Koneksi Baru</span>
          </div>
          <div class="flex items-center gap-2.5 text-xs text-slate-200 font-['Poppins']">
            <svg class="size-4 text-emerald-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span>Sertifikat Digital</span>
          </div>
        </div>
      </div>
    </div>

    <div class="w-full md:w-7/12 p-6 sm:p-8 lg:p-12 flex flex-col justify-center">
      <div class="flex flex-col gap-2 mb-6">
        <h1 class="text-2xl font-bold font-['Poppins'] text-slate-900">Daftar Akun Peserta</h1>
        <p class="text-xs text-slate-500 font-normal font-['Poppins']">Lengkapi data diri Anda untuk mengikuti seminar dan workshop.</p>
      </div>

      @if (isset($errors) && $errors->any())
        <div class="p-3.5 mb-5 bg-rose-50 border border-rose-200 rounded-xl flex items-start gap-2.5 text-xs text-rose-800">
          <svg class="size-4 text-rose-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
          </svg>
          <div class="flex-1 font-medium font-['Poppins']">
            @foreach ($errors->all() as $error)
              <div>{{ $error }}</div>
            @endforeach
          </div>
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-4">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div class="flex flex-col gap-1.5">
            <label for="name" class="text-xs font-semibold text-slate-700 font-['Poppins']">Nama Lengkap & Gelar</label>
            <input
              type="text"
              id="name"
              name="name"
              value="{{ old('name') }}"
              required
              placeholder="Budi Santoso, M.Kom"
              class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-950 focus:ring-1 focus:ring-blue-950 font-['Poppins']"
            >
          </div>
          <div class="flex flex-col gap-1.5">
            <label for="identity_no" class="text-xs font-semibold text-slate-700 font-['Poppins']">
              NIM / NIP / NIS <span class="text-rose-500">*</span>
            </label>
            <input
              type="text"
              id="identity_no"
              name="identity_no"
              value="{{ old('identity_no') }}"
              required
              maxlength="20"
              placeholder="Contoh: 2210511001"
              class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-950 focus:ring-1 focus:ring-blue-950 font-['Poppins'] font-mono"
            >
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div class="flex flex-col gap-1.5">
            <label for="institution" class="text-xs font-semibold text-slate-700 font-['Poppins']">Asal Kampus / Sekolah / Instansi</label>
            <input
              type="text"
              id="institution"
              name="institution"
              value="{{ old('institution') }}"
              placeholder="Universitas Budi Luhur / Nama Sekolah / Instansi"
              class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-950 focus:ring-1 focus:ring-blue-950 font-['Poppins']"
            >
          </div>
          <div class="flex flex-col gap-1.5">
            <label for="phone" class="text-xs font-semibold text-slate-700 font-['Poppins']">Nomor WhatsApp</label>
            <input
              type="text"
              id="phone"
              name="phone"
              value="{{ old('phone') }}"
              placeholder="081234567890"
              class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-950 focus:ring-1 focus:ring-blue-950 font-['Poppins']"
            >
          </div>
        </div>

        <div class="flex flex-col gap-1.5">
          <label for="email" class="text-xs font-semibold text-slate-700 font-['Poppins']">Alamat Email</label>
          <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            required
            placeholder="nama@institusi.ac.id"
            class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-950 focus:ring-1 focus:ring-blue-950 font-['Poppins']"
          >
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div class="flex flex-col gap-1.5">
            <label for="password" class="text-xs font-semibold text-slate-700 font-['Poppins']">Kata Sandi</label>
            <input
              type="password"
              id="password"
              name="password"
              required
              placeholder="Minimal 8 karakter"
              class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-950 focus:ring-1 focus:ring-blue-950 font-['Poppins']"
            >
          </div>
          <div class="flex flex-col gap-1.5">
            <label for="password_confirmation" class="text-xs font-semibold text-slate-700 font-['Poppins']">Konfirmasi Kata Sandi</label>
            <input
              type="password"
              id="password_confirmation"
              name="password_confirmation"
              required
              placeholder="Ulangi kata sandi"
              class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-950 focus:ring-1 focus:ring-blue-950 font-['Poppins']"
            >
          </div>
        </div>

        <button
          type="submit"
          class="w-full py-2.5 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-semibold font-['Poppins'] transition shadow-xs cursor-pointer mt-2"
        >
          Daftar Sebagai Peserta
        </button>
      </form>

      <div class="pt-6 mt-6 border-t border-slate-200 text-center">
        <span class="text-xs text-slate-600 font-['Poppins']">Sudah memiliki akun Eventict? </span>
        <a href="{{ route('login') }}" class="text-xs font-semibold text-blue-950 hover:underline font-['Poppins']">Masuk Akun</a>
      </div>
    </div>
  </div>


</div>
@endsection

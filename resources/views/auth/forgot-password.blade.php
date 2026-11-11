@extends('layouts.app')

@section('title', 'Lupa Kata Sandi — Eventict')

@section('content')
<div class="w-full min-h-screen bg-slate-50 flex flex-col justify-between items-center py-8 px-4 sm:px-6 lg:px-8">
  <div class="w-full max-w-5xl flex items-center justify-between mb-6">
    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
      <div class="size-8 bg-blue-950 rounded flex items-center justify-center text-white font-bold text-sm">
        <svg class="size-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
          <path d="M6 6h10"/>
          <path d="M6 10h7"/>
        </svg>
      </div>
      <span class="text-blue-950 text-xl font-semibold font-['Poppins'] leading-none group-hover:text-blue-900 transition">Eventict</span>
    </a>
    <a href="{{ route('login') }}" class="text-xs font-medium text-slate-500 hover:text-blue-950 font-['Poppins'] flex items-center gap-1.5 transition">
      <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="m15 18-6-6 6-6"/>
      </svg>
      <span>Kembali ke Masuk</span>
    </a>
  </div>

  <div class="w-full max-w-5xl bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 shadow-xs flex flex-col md:flex-row overflow-hidden my-auto">
    <div class="w-full md:w-5/12 bg-blue-950 text-white p-8 lg:p-10 flex flex-col justify-between">
      <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-2">
          <h2 class="text-2xl font-bold font-['Poppins'] leading-snug">Pemulihan Akun Aman & Cepat</h2>
          <p class="text-slate-300 text-xs font-normal font-['Poppins'] leading-relaxed">Jangan khawatir, kami akan membantu memulihkan akses ke seluruh tiket dan sertifikat kegiatan Anda.</p>
        </div>

        <div class="flex flex-col gap-3 pt-2">
          <div class="flex items-start gap-2.5 text-xs text-slate-200 font-['Poppins']">
            <svg class="size-4 text-emerald-400 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span>Tautan pemulihan langsung dikirimkan ke email terdaftar</span>
          </div>
          <div class="flex items-start gap-2.5 text-xs text-slate-200 font-['Poppins']">
            <svg class="size-4 text-emerald-400 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span>Masa berlaku tautan terlindungi hingga 60 menit</span>
          </div>
          <div class="flex items-start gap-2.5 text-xs text-slate-200 font-['Poppins']">
            <svg class="size-4 text-emerald-400 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span>Enkripsi kata sandi baru berstandar industri</span>
          </div>
        </div>
      </div>

      <div class="pt-8 border-t border-blue-900/60 mt-8">
        <p class="text-[11px] text-slate-400 font-['Poppins']">Lab ICT — Fakultas Teknologi Informasi Universitas Budi Luhur</p>
      </div>
    </div>

    <div class="w-full md:w-7/12 p-8 lg:p-12 flex flex-col justify-center">
      <div class="flex flex-col gap-2 mb-6">
        <h1 class="text-2xl font-bold font-['Poppins'] text-slate-900">Lupa Kata Sandi?</h1>
        <p class="text-xs text-slate-500 font-normal font-['Poppins']">Masukkan alamat email yang terdaftar pada akun Eventict Anda untuk menerima tautan reset kata sandi.</p>
      </div>

      @if (session('status'))
        <div class="p-3.5 mb-5 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start gap-2.5 text-xs text-emerald-800">
          <svg class="size-4 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
            <polyline points="22 4 12 14.01 9 11.01"/>
          </svg>
          <div class="flex-1 font-medium font-['Poppins']">
            {{ session('status') }}
          </div>
        </div>
      @endif

      @if (isset($errors) && $errors->any())
        <div class="p-3.5 mb-5 bg-rose-50 border border-rose-200 rounded-xl flex items-start gap-2.5 text-xs text-rose-800">
          <svg class="size-4 text-rose-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" x2="12" y1="8" y2="12"/>
            <line x1="12" x2="12.01" y1="16" y2="16"/>
          </svg>
          <div class="flex-1 font-medium font-['Poppins']">
            @foreach ($errors->all() as $error)
              <div>{{ $error }}</div>
            @endforeach
          </div>
        </div>
      @endif

      <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-4">
        @csrf

        <div class="flex flex-col gap-1.5">
          <label for="email" class="text-xs font-semibold text-slate-700 font-['Poppins']">Alamat Email Terdaftar</label>
          <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            required
            autofocus
            placeholder="nama@institusi.ac.id"
            class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-950 focus:ring-1 focus:ring-blue-950 font-['Poppins']"
          >
        </div>

        <button
          type="submit"
          class="w-full mt-2 py-2.5 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-semibold font-['Poppins'] transition shadow-xs cursor-pointer"
        >
          Kirim Tautan Atur Ulang
        </button>
      </form>

      <div class="mt-6 pt-6 border-t border-slate-200 text-center">
        <p class="text-xs text-slate-500 font-normal font-['Poppins']">
          Ingat kata sandi Anda?
          <a href="{{ route('login') }}" class="font-semibold text-blue-950 hover:underline">Masuk Sekarang</a>
        </p>
      </div>
    </div>
  </div>

  <div class="w-full max-w-5xl text-center mt-6">
    <p class="text-xs text-slate-400 font-normal font-['Poppins']">© 2026 Eventict Lab ICT — Universitas Budi Luhur. Hak cipta dilindungi.</p>
  </div>
</div>
@endsection

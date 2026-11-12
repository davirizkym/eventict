@extends('layouts.app')

@section('title', 'Verifikasi Email — Eventict')

@section('content')
<div class="w-full min-h-screen bg-slate-50 flex flex-col justify-between items-center py-8 px-4 sm:px-6 lg:px-8">
  <div class="w-full max-w-5xl flex items-center justify-between mb-6">
    <a href="{{ route('home') }}" class="flex items-center group">
      <img src="{{ asset('logo_blue.svg') }}" alt="Eventict" class="h-8 sm:h-9 w-auto">
    </a>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="text-xs font-medium text-slate-500 hover:text-rose-600 font-['Poppins'] flex items-center gap-1.5 transition cursor-pointer">
        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
          <polyline points="16 17 21 12 16 7"/>
          <line x1="21" x2="9" y1="12" y2="12"/>
        </svg>
        <span>Keluar Akun</span>
      </button>
    </form>
  </div>

  <div class="w-full max-w-xl bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 shadow-xs p-8 lg:p-10 flex flex-col items-center text-center my-auto">
    <div class="size-14 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-950 mb-5">
      <svg class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect width="20" height="16" x="2" y="4" rx="2"/>
        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
      </svg>
    </div>

    <h1 class="text-2xl font-bold font-['Poppins'] text-slate-900 mb-2">Verifikasi Alamat Email Anda</h1>
    <p class="text-xs text-slate-500 font-normal font-['Poppins'] leading-relaxed max-w-md mb-6">
      Terima kasih telah mendaftar di Eventict! Tautan verifikasi telah kami kirimkan ke alamat email <span class="font-semibold text-slate-700">{{ Auth::user()->email ?? '' }}</span>. Silakan klik tautan di dalam email tersebut untuk mengaktifkan akun Anda secara penuh.
    </p>

    @if (session('status'))
      <div class="w-full p-3.5 mb-5 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start gap-2.5 text-xs text-emerald-800 text-left">
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
      <div class="w-full p-3.5 mb-5 bg-rose-50 border border-rose-200 rounded-xl flex items-start gap-2.5 text-xs text-rose-800 text-left">
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

    <div class="flex flex-col sm:flex-row items-center gap-3 w-full justify-center">
      <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
        @csrf
        <button
          type="submit"
          class="w-full sm:w-auto px-5 py-2.5 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-semibold font-['Poppins'] transition shadow-xs cursor-pointer flex items-center justify-center gap-2"
        >
          <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="23 4 23 10 17 10"/>
            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
          </svg>
          <span>Kirim Ulang Email Verifikasi</span>
        </button>
      </form>
    </div>

    <div class="mt-8 pt-6 border-t border-slate-200 w-full flex items-center justify-between text-xs text-slate-500 font-['Poppins']">
      <span>Belum menerima email? Periksa folder spam Anda.</span>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="font-semibold text-rose-600 hover:underline cursor-pointer">Keluar</button>
      </form>
    </div>
  </div>

  <div class="w-full max-w-5xl text-center mt-6">
    <p class="text-xs text-slate-400 font-normal font-['Poppins']">© 2026 Eventict Lab ICT — Universitas Budi Luhur. Hak cipta dilindungi.</p>
  </div>
</div>
@endsection

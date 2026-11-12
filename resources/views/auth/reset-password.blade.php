@extends('layouts.app')

@section('title', 'Buat Kata Sandi Baru — Eventict')

@section('content')
<div class="w-full min-h-screen bg-slate-50 flex flex-col justify-between items-center py-8 px-4 sm:px-6 lg:px-8">
  <div class="w-full max-w-5xl flex items-center justify-between mb-6">
    <a href="{{ route('home') }}" class="flex items-center group">
      <img src="{{ asset('logo_blue.svg') }}" alt="Eventict" class="h-8 sm:h-9 w-auto">
    </a>
    <a href="{{ route('login') }}" class="text-xs font-medium text-slate-500 hover:text-blue-950 font-['Poppins'] flex items-center gap-1.5 transition">
      <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="m15 18-6-6 6-6"/>
      </svg>
      <span>Batal & Masuk</span>
    </a>
  </div>

  <div class="w-full max-w-5xl bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 shadow-xs flex flex-col md:flex-row overflow-hidden my-auto">
    <div class="w-full md:w-5/12 bg-blue-950 text-white p-8 lg:p-10 flex flex-col justify-between">
      <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-2">
          <h2 class="text-2xl font-bold font-['Poppins'] leading-snug">Buat Kata Sandi Baru Anda</h2>
          <p class="text-slate-300 text-xs font-normal font-['Poppins'] leading-relaxed">Gunakan kombinasi karakter yang kuat agar akun Anda tetap terlindungi dengan baik.</p>
        </div>

        <div class="flex flex-col gap-3 pt-2">
          <div class="flex items-start gap-2.5 text-xs text-slate-200 font-['Poppins']">
            <svg class="size-4 text-emerald-400 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span>Minimal 8 karakter kombinasi huruf dan angka</span>
          </div>
          <div class="flex items-start gap-2.5 text-xs text-slate-200 font-['Poppins']">
            <svg class="size-4 text-emerald-400 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span>Pastikan konfirmasi kata sandi cocok</span>
          </div>
          <div class="flex items-start gap-2.5 text-xs text-slate-200 font-['Poppins']">
            <svg class="size-4 text-emerald-400 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span>Sesi login lain akan disegarkan otomatis</span>
          </div>
        </div>
      </div>

      <div class="pt-8 border-t border-blue-900/60 mt-8">
        <p class="text-[11px] text-slate-400 font-['Poppins']">Lab ICT — Fakultas Teknologi Informasi Universitas Budi Luhur</p>
      </div>
    </div>

    <div class="w-full md:w-7/12 p-8 lg:p-12 flex flex-col justify-center">
      <div class="flex flex-col gap-2 mb-6">
        <h1 class="text-2xl font-bold font-['Poppins'] text-slate-900">Atur Kata Sandi Baru</h1>
        <p class="text-xs text-slate-500 font-normal font-['Poppins']">Silakan masukkan kata sandi baru untuk akun Anda.</p>
      </div>

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

      <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-4">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="flex flex-col gap-1.5">
          <label for="email" class="text-xs font-semibold text-slate-700 font-['Poppins']">Alamat Email</label>
          <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email', $email) }}"
            required
            readonly
            class="w-full px-3.5 py-2.5 bg-slate-100 border border-slate-300 rounded-lg text-xs text-slate-600 cursor-not-allowed font-['Poppins']"
          >
        </div>

        <div class="flex flex-col gap-1.5">
          <label for="password" class="text-xs font-semibold text-slate-700 font-['Poppins']">Kata Sandi Baru</label>
          <div class="relative">
            <input
              type="password"
              id="password"
              name="password"
              required
              autofocus
              placeholder="Minimal 8 karakter"
              class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-950 focus:ring-1 focus:ring-blue-950 font-['Poppins'] pr-10"
            >
            <button type="button" onclick="toggleVisibility('password', 'eye-1')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 cursor-pointer">
              <svg id="eye-1" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
        </div>

        <div class="flex flex-col gap-1.5">
          <label for="password_confirmation" class="text-xs font-semibold text-slate-700 font-['Poppins']">Ulangi Kata Sandi Baru</label>
          <div class="relative">
            <input
              type="password"
              id="password_confirmation"
              name="password_confirmation"
              required
              placeholder="Ketik ulang kata sandi baru"
              class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-950 focus:ring-1 focus:ring-blue-950 font-['Poppins'] pr-10"
            >
            <button type="button" onclick="toggleVisibility('password_confirmation', 'eye-2')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 cursor-pointer">
              <svg id="eye-2" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
        </div>

        <button
          type="submit"
          class="w-full mt-2 py-2.5 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-semibold font-['Poppins'] transition shadow-xs cursor-pointer"
        >
          Simpan Kata Sandi Baru
        </button>
      </form>
    </div>
  </div>

  <div class="w-full max-w-5xl text-center mt-6">
    <p class="text-xs text-slate-400 font-normal font-['Poppins']">© 2026 Eventict Lab ICT — Universitas Budi Luhur. Hak cipta dilindungi.</p>
  </div>
</div>

<script>
function toggleVisibility(inputId, iconId) {
  const input = document.getElementById(inputId);
  const icon = document.getElementById(iconId);
  if (input.type === 'password') {
    input.type = 'text';
    icon.innerHTML = '<path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/>';
  } else {
    input.type = 'password';
    icon.innerHTML = '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>';
  }
}
</script>
@endsection

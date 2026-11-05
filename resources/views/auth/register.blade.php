@extends('layouts.app')

@section('title', 'Daftar Akun Baru — Eventict')

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
    <a href="{{ route('home') }}" class="text-xs font-medium text-slate-500 hover:text-blue-950 font-['Poppins'] flex items-center gap-1.5 transition">
      <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="m15 18-6-6 6-6"/>
      </svg>
      <span>Kembali ke Beranda</span>
    </a>
  </div>

  <div class="w-full max-w-5xl bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 shadow-xs flex flex-col md:flex-row overflow-hidden my-auto">
    <div class="w-full md:w-5/12 bg-blue-950 text-white p-8 lg:p-10 flex flex-col justify-between">
      <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-2">
          <h2 class="text-2xl font-bold font-['Poppins'] leading-snug">Mulai Bersama Jaringan Eventict</h2>
          <p class="text-slate-300 text-xs font-normal font-['Poppins'] leading-relaxed">Pendaftaran cepat untuk kemudahan akses seminar ilmiah, absensi digital, dan portofolio SKP.</p>
        </div>

        <div class="p-4 bg-white/5 border border-white/10 rounded-xl flex flex-col gap-3">
          <span class="text-xs font-semibold text-slate-200 font-['Poppins']">Keuntungan Akun Terverifikasi:</span>
          <div class="flex items-start gap-2 text-xs text-slate-300 font-['Poppins']">
            <svg class="size-4 text-emerald-400 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span>Simpan riwayat tiket dan materi workshop secara permanen</span>
          </div>
          <div class="flex items-start gap-2 text-xs text-slate-300 font-['Poppins']">
            <svg class="size-4 text-emerald-400 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span>Download e-sertifikat ber-QR resmi kapan saja</span>
          </div>
          <div class="flex items-start gap-2 text-xs text-slate-300 font-['Poppins']">
            <svg class="size-4 text-emerald-400 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span>Bagi panitia: kemudahan publikasi dan kelola operasional</span>
          </div>
        </div>
      </div>

      <div class="pt-6 border-t border-white/10 text-xs text-slate-400 font-['Poppins']">
        Sudah memiliki akun terdaftar?
        <a href="{{ route('login') }}" class="text-white font-semibold hover:underline block mt-1">Masuk ke Akun Anda</a>
      </div>
    </div>

    <div class="w-full md:w-7/12 p-8 lg:p-12 flex flex-col justify-center">
      <div class="flex flex-col gap-2 mb-6">
        <h1 class="text-2xl font-bold font-['Poppins'] text-slate-900">Buat Akun Eventict</h1>
        <p class="text-xs text-slate-500 font-normal font-['Poppins']">Pilih peran akun yang sesuai dengan kebutuhan Anda.</p>
      </div>

      @if ($errors->any())
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

        <div class="flex flex-col gap-1.5">
          <label class="text-xs font-semibold text-slate-700 font-['Poppins']">Tipe Akun</label>
          <div class="grid grid-cols-2 gap-2 p-1 bg-slate-100 rounded-xl border border-slate-200">
            <button
              type="button"
              id="role-btn-peserta"
              onclick="setRole('peserta')"
              class="py-2 px-3 rounded-lg text-xs font-semibold font-['Poppins'] transition cursor-pointer flex items-center justify-center gap-1.5 bg-white text-blue-950 shadow-2xs"
            >
              <svg class="size-3.5 text-blue-950" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
              </svg>
              <span>Peserta Kegiatan</span>
            </button>
            <button
              type="button"
              id="role-btn-penyelenggara"
              onclick="setRole('penyelenggara')"
              class="py-2 px-3 rounded-lg text-xs font-medium font-['Poppins'] transition cursor-pointer flex items-center justify-center gap-1.5 text-slate-600 hover:text-slate-900"
            >
              <svg class="size-3.5 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect width="18" height="18" x="3" y="3" rx="2"/>
                <path d="M3 9h18"/>
                <path d="M9 21V9"/>
              </svg>
              <span>Penyelenggara / Panitia</span>
            </button>
          </div>
          <input type="hidden" name="role" id="role-input" value="{{ old('role', $defaultRole ?? 'peserta') }}">
        </div>

        <div class="flex flex-col gap-1.5">
          <label for="name" id="label-name" class="text-xs font-semibold text-slate-700 font-['Poppins']">Nama Lengkap</label>
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

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div class="flex flex-col gap-1.5">
            <label for="institution" id="label-institution" class="text-xs font-semibold text-slate-700 font-['Poppins']">Asal Instansi / Perusahaan / Kampus</label>
            <input
              type="text"
              id="institution"
              name="institution"
              value="{{ old('institution') }}"
              placeholder="Universitas Indonesia / PT Teknologi Maju"
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
          Daftar Sekarang
        </button>
      </form>

      <div class="pt-6 mt-6 border-t border-slate-200 text-center">
        <span class="text-xs text-slate-600 font-['Poppins']">Sudah memiliki akun Eventict? </span>
        <a href="{{ route('login') }}" class="text-xs font-semibold text-blue-950 hover:underline font-['Poppins']">Masuk Akun</a>
      </div>
    </div>
  </div>

  <div class="text-center text-xs text-slate-400 font-['Poppins'] mt-6">
    &copy; {{ date('Y') }} Eventict. Sistem Informasi Seminar & Workshop Berstandar Nasional.
  </div>
</div>

<script>
function setRole(role) {
  document.getElementById('role-input').value = role;
  const btnPeserta = document.getElementById('role-btn-peserta');
  const btnPenyelenggara = document.getElementById('role-btn-penyelenggara');
  const labelName = document.getElementById('label-name');
  const inputName = document.getElementById('name');
  const labelInst = document.getElementById('label-institution');
  const inputInst = document.getElementById('institution');

  if (role === 'peserta') {
    btnPeserta.className = "py-2 px-3 rounded-lg text-xs font-semibold font-['Poppins'] transition cursor-pointer flex items-center justify-center gap-1.5 bg-white text-blue-950 shadow-2xs";
    btnPenyelenggara.className = "py-2 px-3 rounded-lg text-xs font-medium font-['Poppins'] transition cursor-pointer flex items-center justify-center gap-1.5 text-slate-600 hover:text-slate-900";
    labelName.innerText = "Nama Lengkap";
    inputName.placeholder = "Budi Santoso, M.Kom";
    labelInst.innerText = "Asal Instansi / Perusahaan / Kampus";
    inputInst.placeholder = "Universitas Indonesia / PT Teknologi Maju";
  } else {
    btnPenyelenggara.className = "py-2 px-3 rounded-lg text-xs font-semibold font-['Poppins'] transition cursor-pointer flex items-center justify-center gap-1.5 bg-white text-blue-950 shadow-2xs";
    btnPeserta.className = "py-2 px-3 rounded-lg text-xs font-medium font-['Poppins'] transition cursor-pointer flex items-center justify-center gap-1.5 text-slate-600 hover:text-slate-900";
    labelName.innerText = "Nama Organisasi / Komunitas Penyelenggara";
    inputName.placeholder = "Komunitas Developer Indonesia / Himpunan Mahasiswa";
    labelInst.innerText = "Institusi Induk / Afiliasi";
    inputInst.placeholder = "Fakultas Ilmu Komputer / Asosiasi Profesi";
  }
}

document.addEventListener('DOMContentLoaded', function() {
  const initialRole = document.getElementById('role-input').value;
  if (initialRole) {
    setRole(initialRole);
  }
});
</script>
@endsection

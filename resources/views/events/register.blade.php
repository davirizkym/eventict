@extends('layouts.app')

@section('title', 'Pendaftaran — ' . $event->title . ' — Eventict')

@section('content')
<div class="w-full min-h-screen bg-slate-50 flex flex-col justify-start items-center">
  <header class="self-stretch h-16 px-6 lg:px-20 bg-blue-950 border-b border-slate-900 flex justify-between items-center sticky top-0 z-50">
    <div class="w-56 flex justify-start items-center">
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
      <a href="{{ route('home') }}#kegiatan" class="text-white/90 text-sm font-medium font-['Poppins'] hover:text-white transition">Jelajahi Kegiatan</a>
      <a href="{{ route('peserta.dashboard') }}" class="text-white/90 text-sm font-medium font-['Poppins'] hover:text-white transition">Portal Peserta</a>
    </nav>

    <div class="flex justify-start items-center gap-3">
      <a href="{{ route('events.show', $event->slug) }}" class="px-3.5 py-2 bg-white/10 hover:bg-white/20 text-white rounded-md flex items-center gap-1.5 transition text-xs font-medium font-['Poppins']">
        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="m15 18-6-6 6-6"/>
        </svg>
        <span>Batal & Kembali</span>
      </a>
    </div>
  </header>

  <main class="w-full max-w-[1200px] px-4 sm:px-6 lg:px-8 py-8 flex flex-col gap-6">
    <div class="flex items-center gap-2 text-xs text-slate-500 font-['Poppins']">
      <a href="{{ route('home') }}" class="hover:text-blue-950 transition">Beranda</a>
      <span>/</span>
      <a href="{{ route('home') }}#kegiatan" class="hover:text-blue-950 transition">Kegiatan</a>
      <span>/</span>
      <a href="{{ route('events.show', $event->slug) }}" class="hover:text-blue-950 transition truncate max-w-xs">{{ $event->title }}</a>
      <span>/</span>
      <span class="text-slate-800 font-semibold">Formulir Pendaftaran</span>
    </div>

    @if (isset($errors) && $errors->any())
      <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs font-medium flex items-start gap-2.5">
        <svg class="size-4 shrink-0 text-rose-600 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/>
          <line x1="12" y1="8" x2="12" y2="12"/>
          <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <div class="flex-1">
          <div class="font-bold mb-1">Pendaftaran belum dapat diproses:</div>
          <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
      <!-- Kolom Formulir Pendaftaran -->
      <div class="lg:col-span-2 flex flex-col gap-6">
        <div class="bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 p-6 sm:p-8 shadow-xs flex flex-col gap-6">
          <div>
            <span class="text-xs font-bold text-blue-950 uppercase tracking-wider font-['Poppins']">Langkah Konfirmasi</span>
            <h1 class="text-2xl font-bold text-slate-900 font-['Poppins'] mt-1">Formulir Pendaftaran Peserta</h1>
          </div>

          <form id="form-register" method="POST" action="{{ route('events.register', $event->slug) }}" class="flex flex-col gap-6 font-['Poppins']">
            @csrf

            <!-- Section 1: Data Identitas Peserta -->
            <div class="flex flex-col gap-4">
              <div class="flex items-center gap-2 text-sm font-semibold text-slate-800">
                <span class="size-6 rounded-full bg-blue-950 text-white text-xs flex items-center justify-center font-bold">1</span>
                <span>Data Identitas & Portofolio Peserta</span>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex flex-col gap-1.5">
                  <label class="text-xs font-semibold text-slate-700">Nama Lengkap & Gelar</label>
                  <input
                    type="text"
                    value="{{ $user->name }}"
                    disabled
                    class="w-full px-3.5 py-2.5 bg-slate-100 border border-slate-200 rounded-lg text-xs text-slate-700 font-medium cursor-not-allowed"
                  >
                  <span class="text-[10px] text-slate-400">Nama sesuai akun terdaftar yang akan dicetak di sertifikat.</span>
                </div>

                <div class="flex flex-col gap-1.5">
                  <label for="nik" class="text-xs font-semibold text-slate-700">
                    NIM / NIP / NIS <span class="text-rose-500">*</span>
                  </label>
                  <input
                    type="text"
                    id="nik"
                    name="nik"
                    value="{{ old('nik', $user->nik) }}"
                    maxlength="20"
                    placeholder="Contoh: 2210511001"
                    class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-950 focus:ring-1 focus:ring-blue-950 font-mono"
                  >
                  <span class="text-[10px] text-slate-400">Digunakan panitia untuk pendataan dan penomoran sertifikat resmi.</span>
                </div>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex flex-col gap-1.5">
                  <label class="text-xs font-semibold text-slate-700">Alamat Email</label>
                  <input
                    type="email"
                    value="{{ $user->email }}"
                    disabled
                    class="w-full px-3.5 py-2.5 bg-slate-100 border border-slate-200 rounded-lg text-xs text-slate-700 font-medium cursor-not-allowed"
                  >
                  <span class="text-[10px] text-slate-400">Tautan tiket dan reminder sesi dikirimkan ke email ini.</span>
                </div>

                <div class="flex flex-col gap-1.5">
                  <label for="phone" class="text-xs font-semibold text-slate-700">Nomor WhatsApp Aktif</label>
                  <input
                    type="text"
                    id="phone"
                    name="phone"
                    value="{{ old('phone', $user->phone) }}"
                    placeholder="081234567890"
                    class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-950 focus:ring-1 focus:ring-blue-950"
                  >
                  <span class="text-[10px] text-slate-400">Untuk koordinasi presensi & pemberitahuan grup kegiatan.</span>
                </div>
              </div>

              <div class="flex flex-col gap-1.5">
                <label for="institution" class="text-xs font-semibold text-slate-700">Asal Instansi</label>
                <input
                  type="text"
                  id="institution"
                  name="institution"
                  value="{{ old('institution', $user->institution) }}"
                  placeholder="Contoh: Universitas Budi Luhur"
                  class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-950 focus:ring-1 focus:ring-blue-950"
                >
              </div>
            </div>

            <div class="flex flex-col gap-3">
              <div class="flex items-center gap-2 text-sm font-semibold text-slate-800">
                <span class="size-6 rounded-full bg-blue-950 text-white text-xs flex items-center justify-center font-bold">2</span>
                <span>Pilihan Format Kehadiran</span>
              </div>

              @if($event->format === 'online')
                <div class="p-3.5 bg-blue-50/70 border border-blue-200/60 rounded-xl flex items-center gap-3 text-xs text-blue-950">
                  <svg class="size-5 text-blue-900 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <polygon points="10 8 16 12 10 16 10 8"/>
                  </svg>
                  <div>
                    <span class="font-semibold block">Format Acara: Online / Webinar</span>
                    <span class="text-[11px] text-blue-800">Akses ruang virtual dan tautan video conference akan tersedia di tiket Portal Peserta Anda.</span>
                  </div>
                </div>
                <input type="hidden" name="attendance_mode" value="online">
              @else
                <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-3 text-xs text-slate-800">
                  <svg class="size-5 text-slate-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                    <circle cx="12" cy="10" r="3"/>
                  </svg>
                  <div>
                    <span class="font-semibold block">Format Acara: Offline / Tatap Muka</span>
                    <span class="text-[11px] text-slate-600">Lokasi: {{ $event->location }}</span>
                    <span class="text-[11px] text-slate-500 block mt-0.5">E-Tiket dengan QR Pass akan diterbitkan untuk registrasi ulang (check-in) di lokasi acara.</span>
                  </div>
                </div>
                <input type="hidden" name="attendance_mode" value="offline">
              @endif
            </div>

            <!-- Section 3: Rincian Biaya -->
            <div class="flex flex-col gap-3">
              <div class="flex items-center gap-2 text-sm font-semibold text-slate-800">
                <span class="size-6 rounded-full bg-blue-950 text-white text-xs flex items-center justify-center font-bold">3</span>
                <span>Rincian Biaya</span>
              </div>

              @if($event->price == 0)
                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center justify-between">
                  <div class="flex items-center gap-3">
                    <div class="size-9 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-bold text-sm">
                      ✓
                    </div>
                    <div>
                      <div class="text-xs font-semibold text-emerald-950">Biaya Investasi: Gratis (Bebas Biaya)</div>
                      <div class="text-[11px] text-emerald-800 mt-0.5">Sesi ini disponsori penuh dan tidak dikenakan biaya pendaftaran.</div>
                    </div>
                  </div>
                  <span class="px-2.5 py-1 bg-emerald-200 text-emerald-950 text-xs font-bold rounded-md">FREE PASS</span>
                </div>
              @else
                <div class="p-4.5 bg-slate-50 border border-slate-200 rounded-2xl flex flex-col gap-2.5">
                  <div class="flex justify-between items-center text-xs text-slate-600">
                    <span>Harga Tiket Kegiatan (1 Peserta)</span>
                    <span class="font-semibold text-slate-900">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                  </div>
                  <div class="pt-2.5 border-t border-slate-200 flex justify-between items-center">
                    <span class="text-xs font-bold text-slate-900">Total Tagihan Pembayaran</span>
                    <span class="text-lg font-bold text-blue-950">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                  </div>
                </div>
              @endif
            </div>

            <div class="flex flex-col gap-3">
              <label class="flex items-start gap-2.5 cursor-pointer p-3.5 bg-slate-50 border border-slate-200 rounded-xl hover:bg-slate-100/80 transition">
                <input
                  type="checkbox"
                  name="agree_terms"
                  value="1"
                  required
                  class="mt-1 size-4 rounded border-slate-300 text-blue-950 focus:ring-blue-950"
                  {{ old('agree_terms') ? 'checked' : '' }}
                >
                <div class="text-xs text-slate-700 leading-relaxed">
                  <span class="font-semibold text-slate-900">Pernyataan & Persetujuan:</span>
                  Saya menyatakan data di atas benar, siap menaati tata tertib, dan bersedia memenuhi seluruh syarat serta ketentuan kegiatan yang telah ditetapkan panitia.
                </div>
              </label>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
              <a href="{{ route('events.show', $event->slug) }}" class="px-5 py-2.5 border border-slate-300 hover:bg-slate-100 text-slate-700 rounded-xl text-xs font-semibold transition">
                Batalkan
              </a>
              <button
                type="submit"
                class="px-6 py-2.5 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold transition shadow-xs cursor-pointer flex items-center gap-2"
              >
                <span>Konfirmasi Pendaftaran</span>
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
              </button>
            </div>
          </form>
        </div>
      </div>

      <div class="flex flex-col gap-6 lg:sticky lg:top-24 font-['Poppins']">
        <div class="bg-gradient-to-br from-blue-950 to-slate-900 text-white rounded-2xl p-6 shadow-xs flex flex-col gap-4">
          <div class="flex flex-wrap items-center gap-2">
            <span class="px-2.5 py-0.5 bg-white/10 text-white/90 text-xs font-medium rounded uppercase tracking-wider">
              {{ $event->category }}
            </span>
          </div>

          <h2 class="text-lg font-bold leading-snug">
            {{ $event->title }}
          </h2>

          <div class="flex flex-col gap-2.5 text-xs text-slate-300">
            <div class="flex items-center gap-2">
              <svg class="size-4 text-blue-300 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                <line x1="16" x2="16" y1="2" y2="6"/>
                <line x1="8" x2="8" y1="2" y2="6"/>
                <line x1="3" x2="21" y1="10" y2="10"/>
              </svg>
              <span>{{ $event->start_date ? $event->start_date->format('d M Y') : 'Segera' }} &bull; {{ substr($event->start_time, 0, 5) }} WIB</span>
            </div>

            <div class="flex items-center gap-2">
              <svg class="size-4 text-blue-300 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                <circle cx="12" cy="10" r="3"/>
              </svg>
              <span class="truncate">{{ $event->location ?? 'Online via Eventict' }}</span>
            </div>
          </div>

          @php
            $regRemaining = max(0, $event->quota - ($registeredCount ?? 0));
          @endphp
          <div class="p-3 bg-white/5 border border-white/10 rounded-xl flex items-center justify-between text-xs">
            <span class="text-slate-300">Ketersediaan</span>
            @if($regRemaining <= 5 && $regRemaining > 0)
              <span class="font-semibold text-amber-300">Slot Terbatas: Sisa {{ $regRemaining }} pendaftar lagi</span>
            @else
              <span class="font-medium text-emerald-300">Pendaftaran Dibuka</span>
            @endif
          </div>
        </div>

        <div class="p-4 bg-white rounded-xl border border-slate-200 flex items-start gap-3 text-xs text-slate-600">
          <svg class="size-5 text-blue-950 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/>
          </svg>
          <div class="leading-relaxed">
            Data registrasi Anda langsung terhubung ke sistem panitia. Tiket digital beserta QR Pass instan akan langsung dapat diakses pada <strong>Portal Peserta</strong>.
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
@endsection

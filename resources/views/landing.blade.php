@extends('layouts.app')

@section('title', 'Eventict — Direktori Konferensi, Seminar Nasional, dan Workshop Ber-SKP')

@section('content')
<div class="w-full min-h-screen bg-white flex justify-center items-start">
  <div class="w-full max-w-[1440px] bg-white flex flex-col justify-start items-start">
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
        <a href="#kegiatan" class="text-white/90 text-sm font-medium font-['Poppins'] hover:text-white transition">Jelajahi Kegiatan</a>
        <a href="#alur" class="text-white/90 text-sm font-medium font-['Poppins'] hover:text-white transition">Alur & SKP</a>
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

    <main class="self-stretch flex flex-col justify-start items-start">
      <section class="self-stretch px-6 lg:px-20 pt-16 md:pt-24 pb-14 flex flex-col justify-start items-center gap-6">
        <h1 class="w-full max-w-[980px] text-center text-blue-950 text-3xl sm:text-4xl lg:text-5xl font-semibold font-['Poppins'] leading-tight lg:leading-[60px] tracking-tight min-h-[96px] sm:min-h-[110px] lg:min-h-[130px] flex items-center justify-center">
          <span><span id="typewriter-text"></span><span class="inline-block w-[3px] h-[0.85em] bg-blue-950 ml-1.5 align-middle animate-pulse"></span></span>
        </h1>
        
        <div class="w-full max-w-[960px] pt-4 flex flex-col justify-start items-center">
          <form action="{{ route('home') }}#kegiatan" method="GET" class="w-full p-2 sm:p-2.5 bg-white rounded-xl shadow-[0px_1px_3px_0px_rgba(0,0,0,0.06)] outline outline-1 outline-offset-[-1px] outline-slate-300 flex flex-col md:flex-row justify-start items-center gap-2">
            <div class="flex-1 w-full flex justify-start items-center gap-3 px-3">
              <svg class="size-4 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.35-4.35"/>
              </svg>
              <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari topik kegiatan atau narasumber..." class="w-full bg-transparent border-none outline-none text-slate-900 placeholder:text-slate-400 text-sm font-normal font-['Poppins'] py-1.5">
            </div>
            <div class="h-8 w-px bg-slate-200 hidden md:block"></div>
            <div class="w-full md:w-44 flex flex-col justify-start items-start px-3 py-1">
              <label class="text-slate-500 text-[10px] uppercase tracking-wider font-semibold font-['Poppins']">Format</label>
              <select name="format" class="w-full bg-transparent border-none outline-none text-slate-900 text-xs font-medium font-['Poppins'] cursor-pointer">
                <option value="">Semua Format</option>
                <option value="offline" {{ request('format') === 'offline' ? 'selected' : '' }}>Offline / Tatap Muka</option>
                <option value="online" {{ request('format') === 'online' ? 'selected' : '' }}>Online / Webinar</option>
                <option value="hybrid" {{ request('format') === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
              </select>
            </div>
            <div class="h-8 w-px bg-slate-200 hidden md:block"></div>
            <div class="w-full md:w-52 flex flex-col justify-start items-start px-3 py-1">
              <label class="text-slate-500 text-[10px] uppercase tracking-wider font-semibold font-['Poppins']">Rumpun Ilmu</label>
              <select name="category" class="w-full bg-transparent border-none outline-none text-slate-900 text-xs font-medium font-['Poppins'] cursor-pointer">
                <option value="">Semua Rumpun</option>
                <option value="Kedokteran & Kesehatan" {{ request('category') === 'Kedokteran & Kesehatan' ? 'selected' : '' }}>Kedokteran & Kesehatan</option>
                <option value="Teknologi & Rekayasa" {{ request('category') === 'Teknologi & Rekayasa' ? 'selected' : '' }}>Teknologi & Rekayasa</option>
                <option value="Hukum & Kebijakan" {{ request('category') === 'Hukum & Kebijakan' ? 'selected' : '' }}>Hukum & Kebijakan</option>
                <option value="Ekonomi & Bisnis" {{ request('category') === 'Ekonomi & Bisnis' ? 'selected' : '' }}>Ekonomi & Bisnis</option>
              </select>
            </div>
            <button type="submit" class="w-full md:w-auto px-6 py-3 bg-blue-950 rounded-lg outline outline-1 outline-offset-[-1px] outline-transparent flex justify-center items-center gap-2 hover:bg-blue-900 transition cursor-pointer shrink-0">
              <svg class="size-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.35-4.35"/>
              </svg>
              <span class="text-white text-xs font-semibold font-['Poppins'] leading-4">Temukan Sesi</span>
            </button>
            @if(request()->hasAny(['q', 'format', 'category']))
              <a href="{{ route('home') }}#kegiatan" class="text-xs text-rose-600 hover:underline px-2 py-1 font-medium font-['Poppins']">
                Reset
              </a>
            @endif
          </form>
        </div>
      </section>

      <section id="kegiatan" class="self-stretch px-6 lg:px-20 py-16 flex flex-col justify-start items-start gap-8">
        <div class="self-stretch flex justify-between items-center">
          <div>
            <h2 class="text-slate-900 text-2xl lg:text-3xl font-semibold font-['Poppins'] leading-10">Kegiatan Terakreditasi Mendatang</h2>
            <p class="text-slate-500 text-xs font-normal font-['Poppins']">Temukan simposium, seminar, dan workshop berbobot SKP resmi.</p>
          </div>
          <span class="text-slate-600 text-xs font-medium font-['Poppins']">
            Menampilkan {{ $events->count() }} Kegiatan
          </span>
        </div>

        <div class="self-stretch grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          @forelse($events as $event)
            <div class="bg-white rounded-xl outline outline-1 outline-offset-[-1px] outline-slate-200 flex flex-col justify-between overflow-hidden hover:shadow-lg hover:-translate-y-1 transition duration-200 group">
              <div>
                <div class="self-stretch h-52 relative bg-gradient-to-br from-[#142D4E] to-[#0A192F] p-6 flex flex-col justify-between overflow-hidden">
                  <div class="relative z-10 flex justify-between items-start">
                    @if($event->skp_points > 0)
                      <div class="px-2.5 py-1 bg-emerald-500/20 backdrop-blur-md rounded-md border border-emerald-400/30 flex items-center gap-1.5">
                        <svg class="size-3 text-emerald-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                          <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/>
                        </svg>
                        <span class="text-emerald-100 text-xs font-semibold font-['Poppins']">{{ $event->skp_points }} SKP</span>
                      </div>
                    @else
                      <div class="px-2.5 py-1 bg-blue-500/20 backdrop-blur-md rounded-md border border-blue-400/30 flex items-center gap-1.5">
                        <span class="text-blue-100 text-xs font-semibold font-['Poppins']">Sertifikat Resmi</span>
                      </div>
                    @endif
                    <span class="px-2 py-0.5 bg-white/10 backdrop-blur-md text-white/90 text-[10px] font-medium rounded uppercase tracking-wider">{{ $event->category }}</span>
                  </div>
                  <div class="relative z-10">
                    <span class="text-white/60 text-xs font-medium uppercase tracking-wider capitalize">{{ $event->format }} Event</span>
                  </div>
                </div>

                <div class="p-6 flex flex-col gap-4">
                  <div class="flex flex-col gap-1.5">
                    <div class="flex items-center gap-2 text-slate-600 text-xs font-normal font-['Poppins']">
                      <svg class="size-3.5 text-slate-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                        <line x1="16" x2="16" y1="2" y2="6"/>
                        <line x1="8" x2="8" y1="2" y2="6"/>
                        <line x1="3" x2="21" y1="10" y2="10"/>
                      </svg>
                      <span>{{ $event->start_date ? $event->start_date->format('d M Y') : 'Segera' }} &bull; {{ substr($event->start_time, 0, 5) }} WIB</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-600 text-xs font-normal font-['Poppins']">
                      <svg class="size-3.5 text-slate-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                        <circle cx="12" cy="10" r="3"/>
                      </svg>
                      <span class="truncate">{{ $event->location ?? 'Online via Eventict' }}</span>
                    </div>
                  </div>

                  <a href="{{ route('events.show', $event->slug) }}" class="min-h-14 text-slate-900 text-lg font-semibold font-['Poppins'] leading-snug group-hover:text-blue-950 transition line-clamp-2">
                    {{ $event->title }}
                  </a>

                  @if($event->speakers->count() > 0)
                    <div class="flex items-center gap-2.5">
                      <div class="size-8 rounded-full bg-blue-100 border border-blue-200 flex items-center justify-center text-blue-950 font-bold text-xs shrink-0">
                        {{ strtoupper(substr($event->speakers->first()->name, 0, 2)) }}
                      </div>
                      <span class="flex-1 text-slate-700 text-xs font-medium font-['Poppins'] truncate">{{ $event->speakers->first()->name }}</span>
                    </div>
                  @endif
                </div>
              </div>

              <div class="p-6 pt-0 flex flex-col gap-3">
                <div class="h-px bg-slate-200"></div>
                <div class="flex justify-between items-center">
                  <span class="text-slate-900 text-lg font-semibold font-['Poppins'] leading-7">
                    {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                  </span>
                  <span class="text-xs font-medium text-slate-500 font-['Poppins']">Kuota {{ $event->quota }} Kursi</span>
                </div>
                <div class="flex justify-between items-center pt-1">
                  <a href="{{ route('events.show', $event->slug) }}" class="text-slate-500 hover:text-blue-950 text-xs font-normal font-['Poppins']">Detail sesi</a>
                  <a href="{{ route('events.show', $event->slug) }}" class="px-4 py-2 bg-blue-950 rounded-md text-white text-xs font-medium font-['Poppins'] hover:bg-blue-900 transition flex items-center gap-1.5 cursor-pointer">
                    <span>Lihat Sesi</span>
                    <svg class="size-3.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M5 12h14"/>
                      <path d="m12 5 7 7-7 7"/>
                    </svg>
                  </a>
                </div>
              </div>
            </div>
          @empty
            <div class="col-span-full p-12 bg-slate-50 rounded-2xl border border-slate-200 text-center flex flex-col items-center gap-3">
              <svg class="size-10 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.35-4.35"/>
              </svg>
              <div class="text-slate-800 font-semibold text-base font-['Poppins']">Tidak ada kegiatan yang cocok</div>
              <p class="text-slate-500 text-xs font-normal font-['Poppins'] max-w-md">Coba ubah kata kunci pencarian atau bersihkan filter format dan rumpun ilmu.</p>
              <a href="{{ route('home') }}#kegiatan" class="mt-2 px-4 py-2 bg-blue-950 text-white rounded-lg text-xs font-semibold font-['Poppins']">Tampilkan Semua Kegiatan</a>
            </div>
          @endforelse
        </div>
      </section>

      <section id="alur" class="self-stretch px-6 lg:px-20 py-16 bg-slate-50 border-y border-slate-200 flex flex-col justify-start items-start gap-10">
        <div class="self-stretch flex flex-col justify-start items-start gap-2">
          <h2 class="text-slate-900 text-2xl lg:text-3xl font-semibold font-['Poppins'] leading-tight">Transparansi Alur Penerbitan E-Sertifikat</h2>
          <p class="text-slate-600 text-sm font-normal font-['Poppins'] leading-5">Setiap sertifikat terikat nomor registrasi tunggal dan terakreditasi resmi instansi terkait.</p>
        </div>

        <div class="self-stretch grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="p-6 bg-white rounded-xl outline outline-1 outline-offset-[-1px] outline-slate-200 flex flex-col gap-4 shadow-xs hover:border-blue-950 transition">
            <div class="size-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-950">
              <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect width="5" height="5" x="3" y="3" rx="1"/>
                <rect width="5" height="5" x="16" y="3" rx="1"/>
                <rect width="5" height="5" x="3" y="16" rx="1"/>
                <path d="M21 16h-3a2 2 0 0 0-2 2v3"/>
                <path d="M21 21v.01"/>
                <path d="M12 7v3a2 2 0 0 1-2 2H7"/>
                <path d="M3 12h.01"/>
                <path d="M12 3h.01"/>
                <path d="M12 16v.01"/>
                <path d="M16 12h1"/>
                <path d="M21 12v.01"/>
                <path d="M12 21v-1"/>
              </svg>
            </div>
            <div class="flex flex-col gap-1.5">
              <h3 class="text-slate-900 text-base font-semibold font-['Poppins']">1. Presensi Terverifikasi</h3>
              <p class="text-slate-600 text-xs font-normal font-['Poppins'] leading-relaxed">Presensi Hari-H via Scan QR Dinamis berenkripsi tinggi untuk mencegah joki kehadiran.</p>
            </div>
          </div>

          <div class="p-6 bg-white rounded-xl outline outline-1 outline-offset-[-1px] outline-slate-200 flex flex-col gap-4 shadow-xs hover:border-blue-950 transition">
            <div class="size-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-950">
              <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <path d="m9 15 2 2 4-4"/>
              </svg>
            </div>
            <div class="flex flex-col gap-1.5">
              <h3 class="text-slate-900 text-base font-semibold font-['Poppins']">2. Validasi Kelayakan</h3>
              <p class="text-slate-600 text-xs font-normal font-['Poppins'] leading-relaxed">Pemenuhan syarat evaluasi, pengisian feedback pemateri, dan minimal jam pembelajaran 80%.</p>
            </div>
          </div>

          <div class="p-6 bg-white rounded-xl outline outline-1 outline-offset-[-1px] outline-slate-200 flex flex-col gap-4 shadow-xs hover:border-blue-950 transition">
            <div class="size-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-950">
              <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="8" r="6"/>
                <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
              </svg>
            </div>
            <div class="flex flex-col gap-1.5">
              <h3 class="text-slate-900 text-base font-semibold font-['Poppins']">3. Dokumen Terlacak</h3>
              <p class="text-slate-600 text-xs font-normal font-['Poppins'] leading-relaxed">Penerbitan E-Sertifikat Resmi ber-QR Code dengan kode hash unik dan metadata terdesentralisasi.</p>
            </div>
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
          <p class="text-slate-300 text-xs font-normal font-['Poppins'] leading-relaxed">Platform terpadu direktori kegiatan ilmiah, simposium, seminar nasional, dan workshop profesi terakreditasi resmi.</p>
          <div class="text-slate-400 text-xs font-normal font-['Poppins']">Sekretariat Eventict • Jakarta, Indonesia</div>
        </div>

        <div class="flex flex-col gap-3">
          <span class="text-white text-sm font-semibold font-['Poppins']">Direktori Sesi</span>
          <a href="#kegiatan" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Konferensi & Simposium</a>
          <a href="#kegiatan" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Seminar Nasional Ber-SKP</a>
          <a href="#kegiatan" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Workshop & Pelatihan Profesi</a>
          <a href="#kegiatan" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Jadwal Kegiatan Mendatang</a>
        </div>

        <div class="flex flex-col gap-3">
          <span class="text-white text-sm font-semibold font-['Poppins']">Regulasi & FAQ SKP</span>
          <a href="#" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Persyaratan Presensi & Evaluasi</a>
          <a href="#" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Alur Penerbitan E-Sertifikat</a>
          <a href="#" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Panduan Nomor SK & Verifikasi</a>
          <a href="#" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Kebijakan Privasi Peserta</a>
        </div>

        <div class="flex flex-col gap-3">
          <span class="text-white text-sm font-semibold font-['Poppins']">Saluran Bantuan / Kontak</span>
          <a href="{{ route('peserta.dashboard') }}" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Pusat Bantuan Peserta</a>
          <a href="{{ route('login') }}" class="text-slate-300 text-xs font-normal font-['Poppins'] hover:text-white transition">Akses Panitia (Internal)</a>
          <span class="text-slate-300 text-xs font-normal font-['Poppins']">help@eventict.id</span>
          <span class="text-slate-400 text-xs font-normal font-['Poppins']">Senin–Jumat, 08:00–17:00 WIB</span>
        </div>
      </div>

      <div class="self-stretch pt-6 border-t border-slate-800 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs font-normal font-['Poppins'] text-slate-400">
        <div>© 2026 Eventict. Seluruh hak dilindungi.</div>
        <div>Desain konseptual • Status akreditasi mengikuti ketetapan organisasi terkait.</div>
      </div>
    </footer>
  </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const phrases = [
    "Sistem terpadu untuk sukseskan setiap seminar dan workshop Anda.",
    "Solusi praktis cari, daftar, dan kelola seminar serta workshop tanpa ribet.",
    "Satu platform untuk semua kebutuhan seminar dan workshop kamu."
  ];
  const el = document.getElementById('typewriter-text');
  if (!el) return;

  let phraseIdx = 0;
  let charIdx = 0;
  let isDeleting = false;

  function type() {
    const current = phrases[phraseIdx];
    if (isDeleting) {
      el.textContent = current.substring(0, charIdx - 1);
      charIdx--;
    } else {
      el.textContent = current.substring(0, charIdx + 1);
      charIdx++;
    }

    let speed = isDeleting ? 25 : 50;

    if (!isDeleting && charIdx === current.length) {
      speed = 2200;
      isDeleting = true;
    } else if (isDeleting && charIdx === 0) {
      isDeleting = false;
      phraseIdx = (phraseIdx + 1) % phrases.length;
      speed = 400;
    }

    setTimeout(type, speed);
  }

  type();
});
</script>
@endpush
@endsection

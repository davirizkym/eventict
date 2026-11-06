@extends('layouts.app')

@section('title', 'Portal Peserta — Eventict')

@section('content')
<div class="min-h-screen flex bg-slate-50 text-slate-800 antialiased font-['Poppins']">
  <div id="sidebar-backdrop" class="fixed inset-0 z-40 bg-black/50 backdrop-blur-xs hidden md:hidden"></div>

  <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 h-screen bg-blue-950 text-slate-300 flex flex-col justify-between transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 md:sticky md:top-0 md:h-screen shrink-0 px-5 pt-8 pb-6 shadow-xl md:shadow-none overflow-y-auto overscroll-contain">
    <div class="flex flex-col justify-start items-start gap-8 shrink-0">
      <div class="w-full px-2 inline-flex justify-between md:justify-start items-center gap-3">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
          <div class="w-10 h-11 bg-white rounded-xl flex justify-center items-center shrink-0 shadow-xs">
            <svg class="w-5 h-5 text-blue-950" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
              <path d="M6 6h10"/>
              <path d="M6 10h7"/>
            </svg>
          </div>
          <div class="inline-flex flex-col justify-start items-start gap-0.5">
            <div class="text-white text-base font-semibold leading-tight font-['Poppins'] group-hover:text-blue-100 transition">Eventict</div>
            <div class="text-slate-300 text-xs font-normal leading-tight font-['Poppins']">Portal Peserta</div>
          </div>
        </a>
        <button id="sidebar-close" aria-label="Tutup menu navigasi" class="md:hidden p-2 rounded-lg text-slate-400 hover:text-white hover:bg-white/10 cursor-pointer">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <div class="w-full flex flex-col justify-start items-start gap-1">
        <a href="{{ route('peserta.dashboard') }}" class="w-full p-3 rounded-lg inline-flex items-center gap-3 transition min-h-12 bg-blue-900 text-white font-semibold">
          <svg class="w-4 h-4 shrink-0 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
            <line x1="16" x2="16" y1="2" y2="6"/>
            <line x1="8" x2="8" y1="2" y2="6"/>
            <line x1="3" x2="21" y1="10" y2="10"/>
          </svg>
          <span class="text-xs leading-5">Dashboard & Jadwal</span>
        </a>

        <a href="#tiket" class="w-full p-3 rounded-lg inline-flex items-center justify-between transition min-h-12 text-slate-300 hover:bg-white/10 font-normal">
          <div class="inline-flex items-center gap-3">
            <svg class="w-4 h-4 shrink-0 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/>
              <path d="M13 5v2"/>
              <path d="M13 17v2"/>
              <path d="M13 11v2"/>
            </svg>
            <span class="text-xs leading-5">Tiket Saya</span>
          </div>
          <span class="px-2 py-0.5 bg-blue-900 text-blue-200 text-[10px] font-semibold rounded-md">
            {{ $registrations->count() }}
          </span>
        </a>

        <a href="#sertifikat" class="w-full p-3 rounded-lg inline-flex items-center justify-between transition min-h-12 text-slate-300 hover:bg-white/10 font-normal">
          <div class="inline-flex items-center gap-3">
            <svg class="w-4 h-4 shrink-0 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="8" r="6"/>
              <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
            </svg>
            <span class="text-xs leading-5">Lemari E-Sertifikat</span>
          </div>
          <span class="px-2 py-0.5 bg-blue-900 text-blue-200 text-[10px] font-semibold rounded-md">
            {{ $certificates->count() }}
          </span>
        </a>

        <a href="{{ route('home') }}#kegiatan" class="w-full p-3 rounded-lg inline-flex items-center gap-3 transition min-h-12 text-slate-300 hover:bg-white/10 font-normal">
          <svg class="w-4 h-4 shrink-0 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/>
            <path d="m21 21-4.35-4.35"/>
          </svg>
          <span class="text-xs leading-5">Jelajahi Kegiatan Baru</span>
        </a>
      </div>
    </div>

    <div class="flex flex-col justify-start items-start gap-4 shrink-0 pt-6 mt-auto">
      <div class="w-full p-4 bg-white/5 border border-white/10 rounded-xl flex flex-col justify-start items-start gap-2.5">
        <div class="inline-flex items-center gap-2">
          <svg class="w-4 h-4 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <span class="text-white text-xs font-semibold">Butuh panduan?</span>
        </div>
        <div class="text-slate-300 text-xs font-normal leading-4">Kenali alur registrasi, presensi, hingga klaim sertifikat ber-SKP.</div>
        <a href="{{ route('home') }}#alur" class="text-white text-xs font-semibold hover:underline inline-flex items-center gap-1">
          <span>Buka panduan</span>
          <span class="text-[10px]">↗</span>
        </a>
      </div>

      <div class="w-full p-2.5 rounded-xl bg-white/5 border border-white/10 flex items-center justify-between gap-2">
        <div class="flex items-center gap-2.5 min-w-0">
          <div class="size-8 rounded-lg bg-blue-900 text-white font-semibold text-xs flex items-center justify-center shrink-0">
            {{ strtoupper(substr($user->name ?? 'P', 0, 2)) }}
          </div>
          <div class="flex flex-col min-w-0">
            <span class="text-white text-xs font-semibold truncate">{{ $user->name ?? 'Peserta' }}</span>
            <span class="text-slate-400 text-[11px] truncate">{{ $user->institution ?? 'Peserta Eventict' }}</span>
          </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="shrink-0">
          @csrf
          <button type="submit" title="Keluar" class="p-1.5 text-rose-300 hover:text-white hover:bg-rose-500/20 rounded-md transition cursor-pointer">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
              <polyline points="16 17 21 12 16 7"/>
              <line x1="21" x2="9" y1="12" y2="12"/>
            </svg>
          </button>
        </form>
      </div>

      <div class="w-full flex justify-between items-center text-slate-400 text-[10px] px-1">
        <span>Eventict</span>
        <span>Versi 1.0</span>
      </div>
    </div>
  </aside>

  <div class="flex-1 flex flex-col min-w-0 bg-slate-50">
    <header class="h-16 md:h-20 px-4 sm:px-6 lg:px-8 bg-white border-b border-slate-200 flex justify-between items-center sticky top-0 z-30">
      <div class="flex items-center gap-2 sm:gap-3 min-w-0 flex-1 mr-3">
        <button id="sidebar-open" aria-label="Buka menu navigasi" class="md:hidden p-1.5 sm:p-2 rounded-lg text-slate-600 hover:bg-slate-100 transition cursor-pointer shrink-0">
          <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
        <div class="min-w-0">
          <h1 class="text-slate-900 text-sm sm:text-base md:text-lg font-semibold leading-tight truncate">Portal Peserta</h1>
        </div>
      </div>

      <div class="flex items-center gap-2 sm:gap-3 shrink-0">
        <div class="hidden sm:flex items-center gap-1.5 text-xs text-slate-500">
          <svg class="size-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
          </svg>
          <span>{{ now()->format('d M Y') }}</span>
        </div>
        <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-medium text-slate-700 hover:bg-slate-50 transition">
          Lihat Beranda
        </a>
      </div>
    </header>

    <main class="flex-1 p-6 lg:p-10 flex flex-col gap-8 overflow-y-auto">
      @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs font-medium flex items-center gap-2">
          <svg class="size-4 shrink-0 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
            <polyline points="22 4 12 14.01 9 11.01"/>
          </svg>
          <span>{{ session('success') }}</span>
        </div>
      @endif

      @if(session('info'))
        <div class="p-4 bg-blue-50 border border-blue-200 text-blue-900 rounded-xl text-xs font-medium flex items-center gap-2">
          <svg class="size-4 shrink-0 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="16" x2="12" y2="12"/>
            <line x1="12" y1="8" x2="12.01" y2="8"/>
          </svg>
          <span>{{ session('info') }}</span>
        </div>
      @endif

      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <div class="text-slate-500 text-xs font-normal font-['Poppins']">Peserta / Dashboard</div>
          <h2 class="text-slate-900 text-2xl lg:text-3xl font-semibold font-['Poppins'] leading-tight">Selamat datang, {{ $user->name }}.</h2>
          <p class="text-slate-600 text-sm font-normal font-['Poppins']">Jadwal, akses sesi, dan dokumen profesi Anda dalam satu tempat.</p>
        </div>
        <div class="text-xs text-slate-500 font-['Poppins'] self-start sm:self-auto flex items-center gap-1.5">
          <svg class="size-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
          </svg>
          <span>Sesi Aktif Terhubung</span>
        </div>
      </div>

      @if($todayRegistration && $todayRegistration->event)
        <div class="bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 p-6 lg:p-8 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8 shadow-xs">
          <div class="flex-1 flex flex-col gap-4">
            <div class="flex items-center gap-2">
              <span class="text-xs font-semibold text-blue-950 font-['Poppins'] tracking-wider uppercase">
                Agenda Kegiatan Utama &bull; {{ substr($todayRegistration->event->start_time, 0, 5) }} WIB
              </span>
              @if($todayRegistration->attendance_status === 'attended')
                <span class="px-2.5 py-0.5 bg-emerald-100 text-emerald-800 text-[11px] font-semibold rounded-md">
                  Sudah Presensi ({{ $todayRegistration->checked_in_at ? $todayRegistration->checked_in_at->format('H:i') : '' }} WIB)
                </span>
              @endif
            </div>

            <h2 class="text-slate-900 text-xl lg:text-2xl font-bold font-['Poppins'] leading-tight">
              {{ $todayRegistration->event->title }}
            </h2>

            <div class="flex items-center gap-2 text-slate-600 text-xs font-normal font-['Poppins']">
              <svg class="size-4 text-slate-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                <circle cx="12" cy="10" r="3"/>
              </svg>
              <span>{{ $todayRegistration->event->location ?? 'Online via Eventict Platform' }}</span>
            </div>

            <div class="flex flex-wrap items-center gap-3 pt-2">
              @if($todayRegistration->event->virtual_meeting_url)
                <a href="{{ $todayRegistration->event->virtual_meeting_url }}" target="_blank" class="px-4 py-2 bg-blue-950 text-white rounded-lg text-xs font-medium font-['Poppins'] hover:bg-blue-900 transition flex items-center gap-2 cursor-pointer">
                  <svg class="size-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <polygon points="10 8 16 12 10 16 10 8"/>
                  </svg>
                  <span>Masuk Ruang Virtual</span>
                </a>
              @endif
              <a href="{{ route('events.show', $todayRegistration->event->slug) }}" class="px-4 py-2 bg-white border border-slate-300 text-slate-800 rounded-lg text-xs font-medium font-['Poppins'] hover:bg-slate-50 transition flex items-center gap-2 cursor-pointer">
                <span>Lihat Detail Sesi</span>
              </a>
            </div>
          </div>

          <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 flex flex-col items-center gap-2.5 text-center shrink-0">
            <div class="size-28 bg-white p-2 rounded-lg border border-slate-300 flex items-center justify-center shadow-2xs">
              <svg class="size-full text-blue-950" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect width="6" height="6" x="2" y="2" rx="1"/>
                <rect width="6" height="6" x="16" y="2" rx="1"/>
                <rect width="6" height="6" x="2" y="16" rx="1"/>
                <path d="M10 2h4"/>
                <path d="M2 10v4"/>
                <path d="M10 6h4"/>
                <path d="M14 10h4"/>
                <path d="M10 14h4"/>
                <path d="M16 14v4"/>
                <path d="M16 20h4"/>
                <path d="M20 16v4"/>
              </svg>
            </div>
            <div class="text-[11px] text-slate-500 font-medium font-['Poppins']">Tunjukkan saat Masuk Aula</div>
            <div class="text-blue-950 font-bold text-xs tracking-wider font-mono">#{{ $todayRegistration->qr_pass }}</div>
          </div>
        </div>
      @else
        <div class="bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 p-8 text-center flex flex-col items-center gap-3 shadow-xs">
          <div class="size-12 rounded-full bg-blue-50 text-blue-950 flex items-center justify-center">
            <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
              <line x1="16" x2="16" y1="2" y2="6"/>
              <line x1="8" x2="8" y1="2" y2="6"/>
              <line x1="3" x2="21" y1="10" y2="10"/>
            </svg>
          </div>
          <h3 class="text-slate-900 font-semibold text-lg font-['Poppins']">Belum Ada Agenda Hari Ini</h3>
          <p class="text-slate-500 text-xs font-normal font-['Poppins'] max-w-md">Jelajahi berbagai seminar dan workshop terakreditasi untuk meningkatkan kompetensi keahlian Anda.</p>
          <a href="{{ route('home') }}#kegiatan" class="mt-2 px-5 py-2.5 bg-blue-950 text-white rounded-lg text-xs font-semibold font-['Poppins'] hover:bg-blue-900 transition">
            Jelajahi Kegiatan
          </a>
        </div>
      @endif

      <div id="tiket" class="bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 p-6 lg:p-8 flex flex-col gap-5 shadow-xs">
        <div class="flex justify-between items-center">
          <h3 class="text-slate-900 text-lg font-semibold font-['Poppins']">Tiket & Pendaftaran Saya ({{ $registrations->count() }})</h3>
          <a href="{{ route('home') }}#kegiatan" class="text-blue-950 text-xs font-medium font-['Poppins'] hover:underline">+ Daftar Kegiatan Lain</a>
        </div>

        <div class="flex flex-col gap-3">
          @forelse($registrations as $reg)
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
              <div class="flex items-center gap-4">
                <div class="size-10 rounded-xl bg-blue-100 text-blue-950 flex items-center justify-center shrink-0 font-mono font-bold text-xs">
                  PASS
                </div>
                <div>
                  <div class="text-slate-500 text-xs font-normal font-['Poppins']">
                    {{ $reg->event->start_date ? $reg->event->start_date->format('d M Y') : '' }} &bull; {{ substr($reg->event->start_time ?? '', 0, 5) }} WIB
                  </div>
                  <a href="{{ route('events.show', $reg->event->slug) }}" class="text-slate-900 text-sm font-semibold font-['Poppins'] hover:text-blue-950 transition">
                    {{ $reg->event->title }}
                  </a>
                  <div class="text-[11px] text-slate-500 font-mono mt-0.5">
                    No. Tiket: {{ $reg->registration_code }} &bull; Pass: #{{ $reg->qr_pass }}
                  </div>
                </div>
              </div>

              <div class="flex items-center gap-2 self-start sm:self-auto">
                @if($reg->attendance_status === 'attended')
                  <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-xs font-medium rounded-full">
                    Hadir ({{ $reg->checked_in_at ? $reg->checked_in_at->format('H:i') : '' }} WIB)
                  </span>
                @else
                  <span class="px-2.5 py-1 bg-slate-200 text-slate-700 text-xs font-medium rounded-full">
                    Belum Check-In
                  </span>
                @endif
                <a href="{{ route('events.show', $reg->event->slug) }}" class="px-3 py-1.5 bg-white border border-slate-300 rounded-lg text-xs font-medium text-slate-700 hover:bg-slate-100 transition">
                  Detail Sesi
                </a>
              </div>
            </div>
          @empty
            <div class="p-6 bg-slate-50 rounded-xl text-center text-xs text-slate-500 font-['Poppins']">
              Anda belum mendaftar kegiatan apapun.
            </div>
          @endforelse
        </div>
      </div>

      <div id="sertifikat" class="bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 p-6 lg:p-8 flex flex-col gap-6 shadow-xs">
        <div class="flex justify-between items-center">
          <h3 class="text-slate-900 text-lg font-semibold font-['Poppins']">E-Sertifikat Resmi Siap Unduh ({{ $certificates->count() }} Sertifikat)</h3>
          <span class="text-slate-400 text-xs font-['Poppins']">Terverifikasi Digital</span>
        </div>

        <div class="flex flex-col gap-4">
          @forelse($certificates as $cert)
            <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
              <div class="flex items-center gap-4">
                <div class="w-24 h-16 bg-white border border-slate-300 rounded flex flex-col items-center justify-center p-1 text-center shrink-0 shadow-2xs">
                  <div class="text-[8px] font-bold text-slate-700 uppercase tracking-widest">SERTIFIKAT</div>
                  <div class="text-[7px] text-slate-500 truncate max-w-[80px]">{{ $user->name }}</div>
                  <div class="px-1 bg-blue-950 text-white text-[7px] font-bold rounded mt-1">VERIFIED</div>
                </div>
                <div>
                  <div class="text-slate-900 text-sm font-semibold font-['Poppins']">{{ $cert->event->title ?? 'Kegiatan Ilmiah' }}</div>
                  <div class="text-slate-500 text-xs font-normal font-['Poppins']">No. Sertifikat: {{ $cert->certificate_number }}</div>
                  <div class="text-slate-400 text-[11px] font-mono mt-0.5">Hash Verifikasi: {{ $cert->verify_hash }}</div>
                  @if($cert->event && $cert->event->skp_points > 0)
                    <span class="inline-block px-2 py-0.5 bg-blue-100 text-blue-950 font-semibold text-[10px] rounded mt-1">
                      {{ $cert->event->skp_points }} SKP Resmi
                    </span>
                  @endif
                </div>
              </div>
              <div class="flex items-center gap-2 self-start sm:self-auto">
                <a href="{{ route('events.show', $cert->event->slug ?? '') }}" class="px-3.5 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-800 text-xs font-medium font-['Poppins'] rounded-lg transition flex items-center gap-1.5 cursor-pointer">
                  <svg class="size-3.5 text-slate-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" x2="12" y1="15" y2="3"/>
                  </svg>
                  <span>Unduh Dokumen</span>
                </a>
              </div>
            </div>
          @empty
            <div class="p-6 bg-slate-50 rounded-xl text-center text-xs text-slate-500 font-['Poppins']">
              Belum ada e-sertifikat yang terbit. Sertifikat akan terbit otomatis setelah Anda menghadiri kegiatan dan mengisi evaluasi.
            </div>
          @endforelse
        </div>
      </div>
    </main>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const sidebar = document.getElementById('sidebar');
  const backdrop = document.getElementById('sidebar-backdrop');
  const openBtn = document.getElementById('sidebar-open');
  const closeBtn = document.getElementById('sidebar-close');

  function openSidebar() {
    if (!sidebar) return;
    sidebar.classList.remove('-translate-x-full');
    sidebar.classList.add('translate-x-0');
    if (backdrop) {
      backdrop.classList.remove('hidden');
      backdrop.classList.add('block');
    }
  }

  function closeSidebar() {
    if (!sidebar) return;
    sidebar.classList.add('-translate-x-full');
    sidebar.classList.remove('translate-x-0');
    if (backdrop) {
      backdrop.classList.add('hidden');
      backdrop.classList.remove('block');
    }
  }

  if (openBtn) openBtn.addEventListener('click', openSidebar);
  if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
  if (backdrop) backdrop.addEventListener('click', closeSidebar);
});
</script>
@endpush

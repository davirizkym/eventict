@extends('layouts.app')

@section('title', $event->title . ' — Eventict')

@section('content')
<div class="w-full min-h-screen bg-slate-50 flex flex-col justify-start items-center">
  @include('partials.navbar')

  <main class="w-full max-w-[1280px] px-4 sm:px-6 lg:px-8 py-8 flex flex-col gap-6">
    <div class="flex items-center gap-2 text-xs text-slate-500 font-['Poppins']">
      <a href="{{ route('home') }}" class="hover:text-blue-950 transition">Beranda</a>
      <span>/</span>
      <a href="{{ route('home') }}#kegiatan" class="hover:text-blue-950 transition">Kegiatan</a>
      <span>/</span>
      <span class="text-slate-800 font-medium truncate max-w-xs sm:max-w-md">{{ $event->title }}</span>
    </div>

    @if(session('error'))
      <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs font-medium flex items-center gap-2">
        <svg class="size-4 shrink-0 text-rose-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/>
          <line x1="12" y1="8" x2="12" y2="12"/>
          <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <span>{{ session('error') }}</span>
      </div>
    @endif

    <div class="bg-gradient-to-r from-blue-950 to-slate-900 text-white rounded-2xl p-6 sm:p-8 lg:p-10 shadow-xs flex flex-col gap-5">
      <div class="flex flex-wrap items-center gap-2.5">
        <span class="px-3 py-1 bg-blue-500/20 border border-blue-400/30 text-blue-200 text-xs font-semibold rounded-md flex items-center gap-1.5">
          <svg class="size-3.5 text-blue-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/>
          </svg>
          <span>Sertifikat Resmi</span>
        </span>
        <span class="px-3 py-1 bg-white/10 text-white/90 text-xs font-medium rounded-md uppercase tracking-wider">
          {{ $event->category }}
        </span>
        <span class="px-3 py-1 bg-white/10 text-white/90 text-xs font-medium rounded-md capitalize">
          Format {{ $event->format }}
        </span>
        @if($event->sk_number)
          <span class="px-3 py-1 bg-white/10 text-slate-300 text-xs font-mono rounded-md">
            No. SK: {{ $event->sk_number }}
          </span>
        @endif
      </div>

      <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold font-['Poppins'] leading-tight">
        {{ $event->title }}
      </h1>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 border-t border-white/10 text-xs text-slate-300">
        <div class="flex items-center gap-2.5">
          <svg class="size-4 text-blue-300 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
            <line x1="16" x2="16" y1="2" y2="6"/>
            <line x1="8" x2="8" y1="2" y2="6"/>
            <line x1="3" x2="21" y1="10" y2="10"/>
          </svg>
          <div>
            <div class="text-[11px] text-slate-400">Tanggal Pelaksanaan</div>
            <div class="text-white font-medium">{{ $event->start_date ? $event->start_date->format('d M Y') : 'Segera' }}</div>
          </div>
        </div>

        <div class="flex items-center gap-2.5">
          <svg class="size-4 text-blue-300 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
          </svg>
          <div>
            <div class="text-[11px] text-slate-400">Waktu Sesi</div>
            <div class="text-white font-medium">{{ substr($event->start_time, 0, 5) }} – {{ substr($event->end_time, 0, 5) }} WIB</div>
          </div>
        </div>

        <div class="flex items-center gap-2.5">
          <svg class="size-4 text-blue-300 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
            <circle cx="12" cy="10" r="3"/>
          </svg>
          <div class="min-w-0">
            <div class="text-[11px] text-slate-400">Lokasi / Platform</div>
            <div class="text-white font-medium truncate">{{ $event->location ?? 'Online' }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
      <div class="lg:col-span-2 flex flex-col gap-8">
        <div class="bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 p-6 sm:p-8 flex flex-col gap-4 shadow-xs">
          <h2 class="text-slate-900 text-lg font-semibold font-['Poppins']">Deskripsi Kegiatan</h2>
          <div class="text-slate-700 text-sm leading-relaxed font-normal font-['Poppins']">
            {{ $event->description ?? 'Kegiatan ilmiah berstandar nasional yang diselenggarakan untuk meningkatkan kompetensi profesional dan pembaruan wawasan keilmuan terkini.' }}
          </div>
        </div>

        <div class="bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 p-6 sm:p-8 flex flex-col gap-6 shadow-xs">
          <div class="flex justify-between items-center">
            <h2 class="text-slate-900 text-lg font-semibold font-['Poppins']">Daftar Narasumber & Panelis</h2>
            <span class="text-xs text-slate-500 font-['Poppins']">{{ $event->speakers->count() }} Narasumber</span>
          </div>

          <div class="flex flex-col gap-4">
            @forelse($event->speakers as $speaker)
              <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                  <div class="size-12 rounded-xl bg-blue-950 text-white font-bold text-sm flex items-center justify-center shrink-0 shadow-xs">
                    {{ strtoupper(substr($speaker->name, 0, 2)) }}
                  </div>
                  <div>
                    <div class="flex items-center gap-2">
                      <h3 class="text-slate-900 text-sm font-semibold font-['Poppins']">{{ $speaker->name }}</h3>
                      @php
                        $spkRole = $speaker->pivot->role ?? 'Pembicara';
                        $roleBadgeColor = match($spkRole) {
                          'Moderator' => 'bg-amber-100 text-amber-800',
                          'MC' => 'bg-purple-100 text-purple-800',
                          default => 'bg-blue-100 text-blue-900',
                        };
                      @endphp
                      <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $roleBadgeColor }}">
                        {{ $spkRole }}
                      </span>
                    </div>
                    <div class="text-slate-600 text-xs font-normal font-['Poppins']">{{ $speaker->institution }}</div>
                    @if($speaker->pivot->topic)
                      <div class="text-blue-950 text-xs font-medium font-['Poppins'] mt-1 flex items-center gap-1.5">
                        <span class="size-1.5 rounded-full bg-blue-950"></span>
                        <span>{{ $speaker->pivot->topic }}</span>
                      </div>
                    @endif
                  </div>
                </div>

                @if($speaker->pivot->session_time)
                  <span class="px-2.5 py-1 bg-white border border-slate-200 rounded-md text-[11px] font-mono text-slate-700 shrink-0">
                    {{ $speaker->pivot->session_time }}
                  </span>
                @endif
              </div>
            @empty
              <div class="p-6 bg-slate-50 rounded-xl border border-slate-200 text-center text-xs text-slate-500">
                Informasi susunan narasumber sedang diperbarui panitia.
              </div>
            @endforelse
          </div>
        </div>

        <div class="bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 p-6 sm:p-8 flex flex-col gap-4 shadow-xs">
          <h2 class="text-slate-900 text-lg font-semibold font-['Poppins']">Ketentuan & Alur Sertifikat</h2>
          <ul class="flex flex-col gap-2.5 text-xs text-slate-700 font-normal font-['Poppins']">
            <li class="flex items-start gap-2">
              <span class="text-blue-950 font-bold">&bull;</span>
              <span>Peserta wajib melakukan presensi kehadiran melalui pemindaian QR Pass pada hari pelaksanaan.</span>
            </li>
            <li class="flex items-start gap-2">
              <span class="text-blue-950 font-bold">&bull;</span>
              <span>Minimal kehadiran 80% dari total sesi untuk memenuhi syarat penerbitan E-Sertifikat resmi.</span>
            </li>
            <li class="flex items-start gap-2">
              <span class="text-blue-950 font-bold">&bull;</span>
              <span>Setelah seluruh sesi berakhir, dokumen E-Sertifikat ber-QR dapat diunduh langsung melalui Portal Peserta.</span>
            </li>
          </ul>
        </div>
      </div>

      <div class="flex flex-col gap-6 lg:sticky lg:top-24">
        <div class="bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 p-6 sm:p-8 flex flex-col gap-5 shadow-xs">
          <div class="flex justify-between items-baseline">
            <div class="text-slate-500 text-xs font-normal font-['Poppins']">Biaya Investasi:</div>
            <div class="text-2xl font-bold text-slate-900 font-['Poppins']">
              {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
            </div>
          </div>

          <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 flex flex-col gap-2">
            <div class="flex justify-between text-xs font-medium text-slate-700">
              <span>Status Ketersediaan</span>
              <span>{{ $registeredCount }} / {{ $event->quota }} Kursi</span>
            </div>
            <div class="w-full bg-slate-200 rounded-full h-1.5 overflow-hidden">
              <div class="bg-blue-950 h-1.5 rounded-full" style="width: {{ min(100, round(($registeredCount / max(1, $event->quota)) * 100)) }}%"></div>
            </div>
            <div class="text-[11px] text-slate-500">
              {{ max(0, $event->quota - $registeredCount) }} kursi tersisa
            </div>
          </div>

          @guest
            <a href="{{ route('login') }}" class="w-full py-3 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold font-['Poppins'] transition text-center shadow-xs">
              Masuk untuk Mendaftar Sesi
            </a>
            <div class="text-center text-[11px] text-slate-500">
              Belum punya akun? <a href="{{ route('register') }}" class="text-blue-950 font-semibold hover:underline">Daftar Peserta</a>
            </div>
          @else
            @if(Auth::user()->role === 'penyelenggara')
              <a href="{{ route('organizer.dashboard') }}" class="w-full py-3 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold font-['Poppins'] transition text-center shadow-xs">
                Buka di Workspace Panitia
              </a>
            @elseif($isRegistered)
              <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex flex-col gap-2">
                <div class="flex items-center gap-2 text-emerald-900 font-semibold text-xs">
                  <svg class="size-4 text-emerald-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="20 6 9 17 4 12"/>
                  </svg>
                  <span>Anda Sudah Terdaftar</span>
                </div>
                <div class="text-[11px] text-emerald-800">
                  Kode Registrasi: <span class="font-mono font-bold">{{ $userRegistration->registration_code }}</span>
                </div>
                <a href="{{ route('peserta.dashboard') }}" class="mt-2 py-2 px-3 bg-emerald-800 hover:bg-emerald-900 text-white rounded-lg text-xs font-semibold text-center transition">
                  Buka E-Tiket di Portal Peserta &rarr;
                </a>
              </div>
            @elseif($isFull)
              <button disabled class="w-full py-3 bg-slate-200 text-slate-500 rounded-xl text-xs font-semibold font-['Poppins'] cursor-not-allowed text-center">
                Kuota Kegiatan Telah Penuh
              </button>
            @else
              <a href="{{ route('events.register.form', $event->slug) }}" class="w-full py-3 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold font-['Poppins'] transition shadow-xs cursor-pointer text-center flex items-center justify-center gap-1.5">
                <span>Daftar Sesi Kegiatan Ini</span>
                <span class="text-sm">&rarr;</span>
              </a>
            @endif
          @endguest
        </div>

        <div class="p-4 bg-white rounded-xl border border-slate-200 flex items-center gap-3 text-xs text-slate-600">
          <svg class="size-5 text-blue-950 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/>
          </svg>
          <div class="leading-relaxed">
            Terhubung langsung dengan basis data sertifikasi nasional dan akreditasi organisasi profesi.
          </div>
        </div>
      </div>
    </div>
  </main>

  @include('partials.footer')
</div>
@endsection

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

    <div class="bg-gradient-to-r from-blue-950 to-slate-900 text-white rounded-2xl p-5 sm:p-8 lg:p-10 shadow-xs flex flex-col gap-5">
      <div class="flex flex-wrap items-center gap-2.5">
        <span class="px-3 py-1 bg-blue-500/20 border border-blue-400/30 text-blue-200 text-xs font-semibold rounded-md flex items-center gap-1.5">
          <svg class="size-3.5 text-blue-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/>
          </svg>
          <span>Sertifikat Resmi</span>
        </span>
        @php
          $remaining = max(0, $event->quota - $registeredCount);
        @endphp
        @if($isFull)
          <span class="px-3 py-1 bg-rose-500/30 text-rose-200 border border-rose-400/40 text-xs font-semibold rounded-md shadow-xs">
            Kuota Penuh
          </span>
        @elseif($remaining <= 5 && $remaining > 0)
          <span class="px-3 py-1 bg-amber-500/30 text-amber-200 border border-amber-400/40 text-xs font-semibold rounded-md shadow-xs">
            Tersisa {{ $remaining }} Tempat Lagi
          </span>
        @endif
        <span class="px-3 py-1 bg-white/10 text-white/90 text-xs font-medium rounded-md uppercase tracking-wider">
          {{ $event->category }}
        </span>
        <span class="px-3 py-1 bg-white/10 text-white/90 text-xs font-medium rounded-md">
          {{ $event->format === 'offline' ? 'Luring' : 'Daring' }}
        </span>
        @if(($event->organizer_type ?? 'internal') === 'partner')
          <span class="px-3 py-1 bg-white/20 text-white text-xs font-semibold rounded-md">
            Penyelenggara: {{ $event->organizer_name }}
          </span>
        @else
          <span class="px-3 py-1 bg-white/10 text-white/90 text-xs font-medium rounded-md">
            Penyelenggara: Laboratorium ICT
          </span>
        @endif
      </div>

      <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold font-['Poppins'] leading-tight">
        {{ $event->title }}
      </h1>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-4 border-t border-white/10 text-xs text-slate-300">
        <div class="flex items-center gap-2.5">
          <svg class="size-4 text-blue-300 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
          <div class="min-w-0">
            <div class="text-[11px] text-slate-400">Penyelenggara</div>
            <div class="text-white font-medium truncate">{{ ($event->organizer_type ?? 'internal') === 'partner' ? $event->organizer_name : 'Laboratorium ICT' }}</div>
          </div>
        </div>

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
        @if($event->banner_url)
          <div class="bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 p-6 sm:p-8 flex flex-col gap-4 shadow-xs">
            <h2 class="text-slate-900 text-lg font-semibold font-['Poppins']">Poster Kegiatan</h2>
            <div class="rounded-xl overflow-hidden bg-slate-50 flex items-center justify-center border border-slate-200">
              <img src="{{ asset($event->banner_url) }}" alt="Poster {{ $event->title }}" class="w-full max-h-[580px] object-contain rounded-lg">
            </div>
          </div>
        @endif

        <div class="bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 p-6 sm:p-8 flex flex-col gap-4 shadow-xs">
          <h2 class="text-slate-900 text-lg font-semibold font-['Poppins']">Deskripsi Kegiatan</h2>
          <div class="text-slate-700 text-sm leading-relaxed font-normal font-['Poppins']">
            {{ $event->description ?? 'Kegiatan ilmiah berstandar nasional yang diselenggarakan untuk meningkatkan kompetensi profesional dan pembaruan wawasan keilmuan terkini.' }}
          </div>
        </div>

        @if(!$event->isExternal() || $event->speakers->isNotEmpty())
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
        @endif

        @if(!$event->isExternal())
        <div class="bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 p-6 sm:p-8 flex flex-col gap-4 shadow-xs">
          <h2 class="text-slate-900 text-lg font-semibold font-['Poppins']">Ketentuan & Alur Sertifikat</h2>
          <ul class="flex flex-col gap-2.5 text-xs text-slate-700 font-normal font-['Poppins']">
            <li class="flex items-start gap-2">
              <span class="text-blue-950 font-bold">&bull;</span>
              @if($event->format === 'offline')
                <span>Tunjukkan QR Pass pada tiket kepada panitia di lokasi acara untuk pencatatan kehadiran.</span>
              @else
                <span>Ikuti sesi melalui ruang virtual dan pastikan kehadiran Anda tercatat selama acara berlangsung.</span>
              @endif
            </li>
            <li class="flex items-start gap-2">
              <span class="text-blue-950 font-bold">&bull;</span>
              <span>E-Sertifikat resmi diterbitkan untuk peserta yang terkonfirmasi hadir mengikuti kegiatan.</span>
            </li>
            <li class="flex items-start gap-2">
              <span class="text-blue-950 font-bold">&bull;</span>
              <span>Setelah seluruh sesi berakhir, dokumen E-Sertifikat dapat diunduh langsung melalui Portal Peserta.</span>
            </li>
          </ul>
        </div>
        @endif

        @if($event->mediaPartners->isNotEmpty())
          <div class="bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 p-6 sm:p-8 flex flex-col gap-4 shadow-xs">
            <h2 class="text-slate-900 text-lg font-semibold font-['Poppins']">Media Partner</h2>
            <div class="flex flex-wrap items-center gap-3 sm:gap-4 pt-1">
              @foreach($event->mediaPartners as $mp)
                @if($mp->website_url)
                  <a href="{{ $mp->website_url }}" target="_blank" rel="noopener noreferrer" class="h-16 w-32 sm:h-20 sm:w-36 rounded-xl bg-slate-50 border border-slate-200/80 p-2.5 flex items-center justify-center hover:border-blue-900 hover:shadow-xs transition" title="{{ $mp->name }} (Buka Tautan Resmi)">
                    @if($mp->logo)
                      <img src="{{ asset($mp->logo) }}" alt="{{ $mp->name }}" class="max-h-full max-w-full object-contain">
                    @else
                      <span class="text-xs font-semibold text-slate-700 text-center line-clamp-2 px-1">{{ $mp->name }}</span>
                    @endif
                  </a>
                @else
                  <div class="h-16 w-32 sm:h-20 sm:w-36 rounded-xl bg-slate-50 border border-slate-200/80 p-2.5 flex items-center justify-center hover:border-slate-300 transition" title="{{ $mp->name }}">
                    @if($mp->logo)
                      <img src="{{ asset($mp->logo) }}" alt="{{ $mp->name }}" class="max-h-full max-w-full object-contain">
                    @else
                      <span class="text-xs font-semibold text-slate-700 text-center line-clamp-2 px-1">{{ $mp->name }}</span>
                    @endif
                  </div>
                @endif
              @endforeach
            </div>
          </div>
        @endif
      </div>

      <div class="flex flex-col gap-6 lg:sticky lg:top-24">
        <div class="bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-slate-200 p-6 sm:p-8 flex flex-col gap-5 shadow-xs">
          <div class="flex justify-between items-baseline">
            <div class="text-slate-500 text-xs font-normal font-['Poppins']">Biaya Investasi:</div>
            <div class="text-2xl font-bold text-slate-900 font-['Poppins']">
              {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
            </div>
          </div>

          @if($event->isExternal())
            <div class="p-3.5 bg-blue-50/80 rounded-xl border border-blue-200/80 flex flex-col gap-1.5">
              <div class="flex justify-between items-center text-xs font-semibold text-blue-950">
                <span>Penyelenggara</span>
                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-900 border border-blue-200">Media Partner</span>
              </div>
              <div class="text-[11px] text-slate-600 leading-relaxed">
                Diselenggarakan oleh <span class="font-semibold text-slate-800">{{ $event->organizer_name }}</span>. Pendaftaran dikelola langsung melalui formulir eksternal mitra.
              </div>
            </div>

            <a href="{{ $event->registration_url ?: '#' }}" target="_blank" rel="noopener noreferrer" class="w-full py-3.5 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold font-['Poppins'] transition shadow-xs text-center flex items-center justify-center gap-2 cursor-pointer">
              <span>Daftar Acara</span>
              <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                <polyline points="15 3 21 3 21 9"/>
                <line x1="10" y1="14" x2="21" y2="3"/>
              </svg>
            </a>

            <div class="text-center text-[11px] text-slate-500 leading-relaxed">
              Tautan di atas akan mengarahkan Anda ke formulir pendaftaran resmi penyelenggara kegiatan.
            </div>
          @else
            @if($isPassed ?? false)
              <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 flex flex-col gap-1.5">
                <div class="flex justify-between items-center text-xs font-medium text-slate-700">
                  <span>Status Pendaftaran</span>
                  <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-200 text-slate-700">Selesai</span>
                </div>
                <div class="text-[11px] text-slate-500">
                  Kegiatan telah selesai diselenggarakan. Pendaftaran ditutup.
                </div>
              </div>
            @elseif($isFull)
              <div class="p-3.5 bg-rose-50 rounded-xl border border-rose-200 flex flex-col gap-1.5">
                <div class="flex justify-between items-center text-xs font-medium text-rose-900">
                  <span>Status Pendaftaran</span>
                  <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-700">Penuh</span>
                </div>
                <div class="text-[11px] text-rose-700 font-medium">
                  Kuota kegiatan telah terpenuhi. Pendaftaran telah ditutup.
                </div>
              </div>
            @elseif($remaining <= 5 && $remaining > 0)
              <div class="p-3.5 bg-amber-50 rounded-xl border border-amber-200 flex flex-col gap-1.5">
                <div class="flex justify-between items-center text-xs font-medium text-amber-900">
                  <span>Status Pendaftaran</span>
                  <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">Segera Habis</span>
                </div>
                <div class="text-[11px] text-amber-800 font-medium">
                  Hampir penuh! Hanya tersisa {{ $remaining }} tempat lagi untuk sesi ini.
                </div>
              </div>
            @else
              <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 flex flex-col gap-1.5">
                <div class="flex justify-between items-center text-xs font-medium text-slate-700">
                  <span>Status Pendaftaran</span>
                  <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Terbuka</span>
                </div>
                <div class="text-[11px] text-slate-500">
                  Pendaftaran masih dibuka untuk peserta umum dan profesional.
                </div>
              </div>
            @endif

            @guest
              @if($isPassed ?? false)
                <button disabled class="w-full py-3 bg-slate-200 text-slate-500 rounded-xl text-xs font-semibold font-['Poppins'] cursor-not-allowed text-center">
                  Pendaftaran Ditutup (Kegiatan Selesai)
                </button>
              @elseif($isFull)
                <button disabled class="w-full py-3 bg-slate-200 text-slate-500 rounded-xl text-xs font-semibold font-['Poppins'] cursor-not-allowed text-center">
                  Pendaftaran Ditutup (Kuota Penuh)
                </button>
              @else
                <a href="{{ route('login') }}" class="w-full py-3 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold font-['Poppins'] transition text-center shadow-xs">
                  Masuk untuk Mendaftar Sesi
                </a>
                <div class="text-center text-[11px] text-slate-500">
                  Belum punya akun? <a href="{{ route('register') }}" class="text-blue-950 font-semibold hover:underline">Daftar Peserta</a>
                </div>
              @endif
            @else
              @if(Auth::user()->role === 'penyelenggara')
                <a href="{{ route('organizer.workspace', ['event' => $event->id]) }}" class="w-full py-3 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold font-['Poppins'] transition text-center shadow-xs">
                  Buka di Workspace Panitia
                </a>
              @elseif($isRegistered)
                @php
                  $isUserRegPendingExpired = $userRegistration->payment_status === 'pending' && $userRegistration->created_at && $userRegistration->created_at->lt(now()->subMinutes(10));
                @endphp
                @if($isUserRegPendingExpired)
                  <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl flex flex-col gap-2.5">
                    <div class="flex items-center gap-2 text-rose-900 font-semibold text-xs">
                      <svg class="size-4 text-rose-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                      </svg>
                      <span>Batas Waktu Pembayaran Habis</span>
                    </div>
                    <div class="text-[11px] text-rose-800 leading-relaxed">
                      Kode: <span class="font-mono font-bold">{{ $userRegistration->registration_code }}</span><br>
                      Waktu pembayaran 10 menit telah kedaluwarsa. Silakan lakukan pendaftaran ulang untuk memilih tiket kembali.
                    </div>
                    @if($isPassed ?? false)
                      <button disabled class="mt-1 py-2 px-3 bg-slate-200 text-slate-500 rounded-lg text-xs font-semibold text-center cursor-not-allowed">
                        Kegiatan Telah Selesai
                      </button>
                    @elseif($isFull)
                      <button disabled class="mt-1 py-2 px-3 bg-slate-200 text-slate-500 rounded-lg text-xs font-semibold text-center cursor-not-allowed">
                        Kuota Penuh
                      </button>
                    @else
                      <a href="{{ route('events.register.form', $event->slug) }}" class="mt-1 py-2 px-3 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-semibold text-center transition shadow-xs">
                        Daftar Ulang Kegiatan &rarr;
                      </a>
                    @endif
                    <form method="POST" action="{{ route('peserta.registration.cancel', $userRegistration->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat pendaftaran ini?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="w-full py-1.5 px-3 bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 rounded-lg text-xs font-semibold text-center transition cursor-pointer">
                        Hapus Pendaftaran
                      </button>
                    </form>
                  </div>
                @elseif($userRegistration->payment_status === 'pending')
                  <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl flex flex-col gap-2.5">
                    <div class="flex items-center gap-2 text-amber-900 font-semibold text-xs">
                      <svg class="size-4 text-amber-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                      </svg>
                      <span>Pendaftaran Menunggu Pembayaran</span>
                    </div>
                    <div class="text-[11px] text-amber-800 leading-relaxed">
                      Kode: <span class="font-mono font-bold">{{ $userRegistration->registration_code }}</span><br>
                      E-Tiket belum aktif. Selesaikan pembayaran untuk mengaktifkan tiket dan QR Pass Anda.
                    </div>
                    <a href="{{ route('payment.invoice', $userRegistration->registration_code) }}" class="mt-1 py-2 px-3 bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg text-xs font-semibold text-center transition">
                      Buka Invoice Pembayaran &rarr;
                    </a>
                    <button type="button" onclick="checkEventPayment('{{ $userRegistration->id }}')" class="py-2 px-3 bg-blue-50 hover:bg-blue-100 text-blue-950 border border-blue-200 rounded-lg text-xs font-semibold text-center transition cursor-pointer flex items-center justify-center gap-1.5">
                      <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                        <path d="M3 3v5h5"/>
                        <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/>
                        <path d="M16 21h5v-5"/>
                      </svg>
                      <span>Cek Status Pembayaran</span>
                    </button>
                    <form method="POST" action="{{ route('peserta.registration.cancel', $userRegistration->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran kegiatan ini?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="w-full py-1.5 px-3 bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 rounded-lg text-xs font-semibold text-center transition cursor-pointer">
                        Batalkan Pendaftaran
                      </button>
                    </form>
                  </div>
                @else
                  <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex flex-col gap-2">
                    <div class="flex items-center gap-2 text-emerald-900 font-semibold text-xs">
                      <svg class="size-4 text-emerald-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12"/>
                      </svg>
                      <span>Anda Sudah Terdaftar (Tiket Aktif)</span>
                    </div>
                    <div class="text-[11px] text-emerald-800">
                      Kode Registrasi: <span class="font-mono font-bold">{{ $userRegistration->registration_code }}</span>
                    </div>
                    <a href="{{ route('peserta.dashboard', ['tab' => 'tiket']) }}" class="mt-2 py-2 px-3 bg-emerald-800 hover:bg-emerald-900 text-white rounded-lg text-xs font-semibold text-center transition">
                      Buka E-Tiket di Portal Peserta &rarr;
                    </a>
                  </div>
                @endif
              @elseif($isPassed ?? false)
                <button disabled class="w-full py-3 bg-slate-200 text-slate-500 rounded-xl text-xs font-semibold font-['Poppins'] cursor-not-allowed text-center">
                  Pendaftaran Ditutup (Kegiatan Selesai)
                </button>
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
          @endif
        </div>
      </div>
    </div>
  </main>

  @include('partials.footer')
</div>

<script>
function checkEventPayment(registrationId) {
  fetch('/pembayaran/' + registrationId + '/check-status', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json'
    }
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'paid') {
      alert(data.message || 'Pembayaran berhasil dikonfirmasi! E-Tiket Anda telah aktif.');
      window.location.reload();
    } else if (data.status === 'expired') {
      alert(data.message || 'Batas waktu pembayaran (10 menit) telah kedaluwarsa. Silakan lakukan pendaftaran ulang.');
      window.location.reload();
    } else {
      alert(data.message || 'Status pembayaran belum terkonfirmasi.');
    }
  })
  .catch(err => {
    alert('Gagal mengecek status pembayaran.');
  });
}
</script>
@endsection

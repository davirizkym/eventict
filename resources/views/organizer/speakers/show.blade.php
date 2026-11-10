@extends('layouts.app')

@section('title', 'Detail Pengisi Acara: ' . $speaker->name . ' — Eventict Lab ICT')

@section('content')
<div class="min-h-screen bg-slate-50 text-slate-800 antialiased font-['Poppins'] flex flex-col">
  <!-- Top Navigation Bar -->
  <header class="bg-blue-950 text-white border-b border-blue-900 sticky top-0 z-30 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-4">
      <div class="flex items-center gap-6 sm:gap-8">
        <a href="{{ route('organizer.dashboard') }}" class="flex items-center gap-3 group">
          <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-blue-950 font-bold shadow-xs">
            <svg class="w-5 h-5 text-blue-950" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
              <path d="M6 6h10"/>
              <path d="M6 10h7"/>
            </svg>
          </div>
          <div class="flex flex-col">
            <span class="text-white text-base font-semibold leading-tight tracking-tight">Eventict</span>
            <span class="text-blue-200 text-xs font-normal">Organizer Hub</span>
          </div>
        </a>

        <nav class="hidden md:flex items-center gap-2">
          <a href="{{ route('organizer.dashboard') }}" class="px-3.5 py-2 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-white/5 transition flex items-center gap-2">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect width="18" height="18" x="3" y="3" rx="2"/>
              <path d="M3 9h18"/>
              <path d="M9 21V9"/>
            </svg>
            <span>Semua Kegiatan</span>
          </a>
          <a href="{{ route('organizer.categories.index') }}" class="px-3.5 py-2 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-white/5 transition flex items-center gap-2">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M4 6h16M4 12h16M4 18h7"/>
            </svg>
            <span>Kategori</span>
          </a>
          <a href="{{ route('organizer.speakers.index') }}" class="px-3.5 py-2 rounded-lg text-xs font-semibold bg-white/10 text-white transition flex items-center gap-2">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <span>Pengisi Acara</span>
          </a>
        </nav>
      </div>

      <div class="flex items-center gap-3">
        <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-lg border border-white/20 text-xs font-medium text-slate-200 hover:bg-white/10 hover:text-white transition hidden sm:inline-flex items-center gap-1.5">
          <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
            <polyline points="15 3 21 3 21 9"/>
            <line x1="10" y1="14" x2="21" y2="3"/>
          </svg>
          <span>Lihat Website</span>
        </a>

        <div class="flex items-center gap-2.5 pl-2 sm:border-l sm:border-white/15">
          <div class="size-8 rounded-lg bg-blue-900 text-white font-semibold text-xs flex items-center justify-center shrink-0">
            {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 2)) }}
          </div>
          <div class="hidden lg:flex flex-col min-w-0">
            <span class="text-white text-xs font-semibold truncate">{{ Auth::user()->name ?? 'Sekretariat Panitia' }}</span>
            <span class="text-slate-400 text-[11px] truncate">Laboratorium ICT</span>
          </div>
          <form method="POST" action="{{ route('logout') }}" class="shrink-0">
            @csrf
            <button type="submit" title="Keluar" class="p-1.5 text-rose-300 hover:text-white hover:bg-rose-500/20 rounded-lg transition cursor-pointer">
              <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                <polyline points="16 17 21 12 16 7"/>
                <line x1="21" x2="9" y1="12" y2="12"/>
              </svg>
            </button>
          </form>
        </div>
      </div>
    </div>
  </header>

  <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 flex flex-col gap-6">
    <!-- Breadcrumb & Back Action -->
    <div class="flex items-center justify-between gap-4">
      <div class="flex items-center gap-2 text-xs text-slate-500">
        <a href="{{ route('organizer.dashboard') }}" class="hover:text-blue-950 font-medium">Portal Pengelola</a>
        <span>/</span>
        <a href="{{ route('organizer.speakers.index') }}" class="hover:text-blue-950 font-medium">Pengisi Acara</a>
        <span>/</span>
        <span class="text-slate-900 font-semibold truncate">{{ $speaker->name }}</span>
      </div>

      <a href="{{ route('organizer.speakers.index') }}" class="px-3 py-1.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold transition flex items-center gap-1.5 shadow-2xs">
        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="15 18 9 12 15 6"/>
        </svg>
        <span>Kembali ke Daftar</span>
      </a>
    </div>

    <!-- Alert Notifications -->
    @if (session('success'))
      <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center justify-between text-xs text-emerald-800 shadow-2xs">
        <div class="flex items-center gap-2.5">
          <svg class="size-4 text-emerald-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="20 6 9 17 4 12"/>
          </svg>
          <span class="font-medium">{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 text-sm cursor-pointer">✕</button>
      </div>
    @endif

    <!-- BAGIAN 1: Rangkuman Profil Lengkap (Ketentuan 3) -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 flex flex-col gap-6 shadow-2xs">
      <!-- Keterangan Detail Profil -->
      <div class="flex-1 flex flex-col justify-between gap-4 min-w-0 w-full">
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
          <div class="min-w-0">
            <div class="flex items-center gap-2 flex-wrap">
              <h1 class="text-xl sm:text-2xl font-bold text-slate-900 leading-snug">
                {{ $speaker->name }}
              </h1>
              @if($speaker->is_verified)
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-blue-50 text-blue-900 border border-blue-200">
                  <svg class="size-3 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                  </svg>
                  <span>Terverifikasi</span>
                </span>
              @endif
            </div>

            <div class="text-xs text-slate-600 mt-1 flex items-center gap-2 flex-wrap">
              <span class="font-semibold text-slate-800">{{ $speaker->institution ?? 'Afiliasi Independen' }}</span>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex items-center gap-2 shrink-0">
            <button type="button" onclick="openAssignModal()" class="px-4 py-2 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold shadow-xs flex items-center gap-1.5 transition cursor-pointer">
              <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
              </svg>
              <span>Tugaskan ke Acara</span>
            </button>

            <button type="button" onclick="openEditSpeakerModal({{ json_encode($speaker) }})" class="px-3.5 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold transition cursor-pointer flex items-center gap-1.5">
              <svg class="size-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
              </svg>
              <span>Edit</span>
            </button>
          </div>
        </div>

        <!-- Bio Singkat -->
        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 text-xs text-slate-600 leading-relaxed">
          <span class="font-semibold text-slate-700 block mb-0.5">Bio &amp; Latar Belakang:</span>
          {{ $speaker->bio ?? 'Belum ada bio atau ringkasan riwayat yang ditambahkan untuk pengisi acara ini.' }}
        </div>

        <!-- Baris Kontak & Statistik -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
          <!-- Email -->
          <div class="p-3 rounded-xl border border-slate-100 bg-slate-50/50 flex flex-col gap-0.5">
            <span class="text-[10px] uppercase font-semibold text-slate-400">Email Arsip</span>
            @if($speaker->email)
              <a href="mailto:{{ $speaker->email }}" class="text-xs font-semibold text-blue-950 hover:underline truncate" title="{{ $speaker->email }}">
                {{ $speaker->email }}
              </a>
            @else
              <span class="text-xs text-slate-400 italic">Tidak tersedia</span>
            @endif
          </div>

          <!-- WhatsApp -->
          <div class="p-3 rounded-xl border border-slate-100 bg-slate-50/50 flex flex-col gap-0.5">
            <span class="text-[10px] uppercase font-semibold text-slate-400">Kontak WhatsApp</span>
            @if($speaker->phone)
              @php
                $cleanPhone = preg_replace('/[^0-9]/', '', $speaker->phone);
                if (str_starts_with($cleanPhone, '0')) {
                  $cleanPhone = '62' . substr($cleanPhone, 1);
                }
              @endphp
              <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="text-xs font-semibold text-emerald-700 hover:underline flex items-center gap-1.5" title="Buka WhatsApp">
                <span>{{ $speaker->phone }}</span>
                <span class="inline-flex items-center gap-0.5 text-[10px] px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-medium">
                  <span>WhatsApp</span>
                  <svg class="size-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M7 17L17 7M17 7H7M17 7V17"/></svg>
                </span>
              </a>
            @else
              <span class="text-xs text-slate-400 italic">Tidak tersedia</span>
            @endif
          </div>

          <!-- Total Partisipasi -->
          <div class="p-3 rounded-xl border border-blue-100 bg-blue-50/40 flex flex-col gap-0.5">
            <span class="text-[10px] uppercase font-semibold text-blue-900">Total Seminar / Workshop</span>
            <span class="text-xs font-bold text-blue-950">{{ $speaker->events->count() }} Kegiatan Diisi</span>
          </div>
        </div>
      </div>
    </div>

    <!-- BAGIAN 2: Tabel Riwayat Partisipasi (Ketentuan 3) -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs">
      <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <h2 class="text-base font-bold text-slate-900">Tabel Riwayat Partisipasi Acara</h2>
          <p class="text-xs text-slate-500 mt-0.5">
            Daftar seminar &amp; workshop apa saja yang pernah/akan dia isi beserta <b>status perannya</b>:
          </p>
        </div>

        <button type="button" onclick="openAssignModal()" class="px-3.5 py-1.5 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold shadow-xs flex items-center gap-1.5 transition cursor-pointer self-start sm:self-auto">
          <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
          </svg>
          <span>Tugaskan ke Acara Lain</span>
        </button>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-700">
          <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase text-[10px] tracking-wider select-none">
            <tr>
              <th scope="col" class="py-3.5 px-4 w-12 text-center">No</th>
              <th scope="col" class="py-3.5 px-4">Nama Kegiatan / Seminar</th>
              <th scope="col" class="py-3.5 px-4">Format &amp; Tanggal</th>
              <th scope="col" class="py-3.5 px-4 text-center">Status Peran</th>
              <th scope="col" class="py-3.5 px-4">Topik Materi / Sesi</th>
              <th scope="col" class="py-3.5 px-4">Waktu Sesi</th>
              <th scope="col" class="py-3.5 px-4 text-center w-28">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 font-['Poppins']">
            @forelse($speaker->events as $ev)
              @php
                $role = $ev->pivot->role ?? 'Pemateri';
                $roleColor = match(strtolower($role)) {
                  'moderator' => 'bg-purple-100 text-purple-900 border-purple-200',
                  'pemateri utama', 'keynote speaker' => 'bg-amber-100 text-amber-900 border-amber-200',
                  default => 'bg-blue-100 text-blue-950 border-blue-200',
                };
              @endphp
              <tr class="hover:bg-blue-50/30 transition">
                <td class="py-4 px-4 text-center font-medium text-slate-400">
                  {{ $loop->iteration }}
                </td>

                <!-- Nama Acara -->
                <td class="py-4 px-4">
                  <a href="{{ route('organizer.workspace', ['event' => $ev->id]) }}" class="font-bold text-slate-900 hover:text-blue-950 hover:underline block leading-snug">
                    {{ $ev->title }}
                  </a>
                  <span class="text-[11px] text-slate-400 block mt-0.5">Kategori: {{ $ev->category }}</span>
                </td>

                <td class="py-4 px-4">
                  <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase inline-block {{ $ev->format === 'online' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-800' }}">
                    {{ $ev->format }}
                  </span>
                  <div class="text-[11px] text-slate-500 mt-1 flex items-center gap-1.5">
                    <svg class="size-3 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                      <line x1="16" y1="2" x2="16" y2="6"/>
                      <line x1="8" y1="2" x2="8" y2="6"/>
                      <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <span>{{ $ev->start_date ? $ev->start_date->format('d M Y') : '-' }}</span>
                  </div>
                </td>

                <!-- Status Peran (Sesuai Ketentuan 3: Berperan sebagai Pemateri / Moderator) -->
                <td class="py-4 px-4 text-center">
                  <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-bold border {{ $roleColor }}">
                    <svg class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>Berperan sebagai {{ $role }}</span>
                  </span>
                </td>

                <!-- Topik Materi -->
                <td class="py-4 px-4 max-w-xs">
                  <span class="font-semibold text-slate-900 block leading-snug">
                    {{ $ev->pivot->topic ?? 'Sesi Pemaparan Materi' }}
                  </span>
                </td>

                <!-- Waktu Sesi -->
                <td class="py-4 px-4">
                  <span class="text-xs text-slate-700 block">
                    {{ $ev->pivot->session_time ?? ($ev->start_time . ' - ' . $ev->end_time . ' WIB') }}
                  </span>
                </td>

                <!-- Aksi: Ruang Kerja Acara -->
                <td class="py-4 px-4 text-center">
                  <a href="{{ route('organizer.workspace', ['event' => $ev->id]) }}" class="px-3 py-1.5 bg-blue-950 hover:bg-blue-900 text-white rounded-lg text-xs font-semibold transition inline-flex items-center gap-1 shadow-2xs">
                    <span>Workspace</span>
                    <svg class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <polyline points="9 18 15 12 9 6"/>
                    </svg>
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="py-12 px-4 text-center text-slate-400">
                  <div class="size-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2">
                    <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                      <line x1="16" y1="2" x2="16" y2="6"/>
                      <line x1="8" y1="2" x2="8" y2="6"/>
                    </svg>
                  </div>
                  <span class="font-semibold text-slate-800 block text-xs">Belum Ada Riwayat Partisipasi</span>
                  <p class="text-[11px] text-slate-400 mt-0.5">Pengisi acara ini belum ditugaskan ke kegiatan seminar atau workshop manapun.</p>
                  <button type="button" onclick="openAssignModal()" class="mt-3 px-4 py-2 bg-blue-950 text-white rounded-xl text-xs font-semibold hover:bg-blue-900 transition">
                    Tugaskan ke Acara Sekarang
                  </button>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <!-- ========================================================================= -->
  <!-- MODAL: PENEMPATAN ACARA & PEMILIHAN PERAN (PEMATERI / MODERATOR)           -->
  <!-- ========================================================================= -->
  <div id="modal-assign-speaker" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-3 sm:p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl max-w-2xl w-full p-5 sm:p-7 flex flex-col gap-5 shadow-2xl my-auto max-h-[90vh]">
      <div class="flex items-start justify-between gap-4 pb-3 border-b border-slate-100">
        <div>
          <div class="text-[10px] font-bold text-blue-900 uppercase tracking-wider">Atur Riwayat &amp; Penugasan</div>
          <h2 class="text-base sm:text-lg font-bold text-slate-900">Penempatan Acara — {{ $speaker->name }}</h2>
          <p class="text-xs text-slate-500 mt-0.5">Tentukan kegiatan yang diisi serta status peran (Pemateri / Moderator).</p>
        </div>
        <button type="button" onclick="closeAssignModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 cursor-pointer">
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>

      <form action="{{ route('organizer.speakers.assign_events', $speaker->id) }}" method="POST" class="flex flex-col gap-4 overflow-y-auto pr-1">
        @csrf
        
        <div class="text-xs font-semibold text-slate-800 flex items-center justify-between">
          <span>Daftar Kegiatan Seminar &amp; Workshop ({{ $allEvents->count() }} Kegiatan):</span>
          <span class="text-slate-400 text-[11px] font-normal">Centang untuk menugaskan</span>
        </div>

        <div class="flex flex-col gap-3 max-h-[46vh] overflow-y-auto pr-1">
          @foreach($allEvents as $ev)
            @php
              $isAssigned = $speaker->events->contains($ev->id);
              $currentPivot = $isAssigned ? $speaker->events->find($ev->id)->pivot : null;
              $currentRole = $currentPivot ? $currentPivot->role : 'Pemateri';
              $currentTopic = $currentPivot ? $currentPivot->topic : '';
              $currentSession = $currentPivot ? $currentPivot->session_time : '';
            @endphp
            <div id="event-card-{{ $ev->id }}" class="p-3.5 rounded-xl border transition-all {{ $isAssigned ? 'bg-blue-50/70 border-blue-300 shadow-2xs' : 'bg-slate-50/60 border-slate-200 hover:border-slate-300' }}">
              <div class="flex items-start gap-3">
                <input type="checkbox" name="event_ids[]" value="{{ $ev->id }}" id="chk-ev-{{ $ev->id }}"
                  {{ $isAssigned ? 'checked' : '' }}
                  onchange="toggleEventAssign({{ $ev->id }}, this.checked)"
                  class="mt-1 size-4 text-blue-950 rounded border-slate-300 focus:ring-blue-900 cursor-pointer shrink-0">

                <label for="chk-ev-{{ $ev->id }}" class="flex-1 cursor-pointer select-none">
                  <div class="flex items-start justify-between gap-2">
                    <span class="text-xs font-semibold text-slate-900 leading-snug hover:text-blue-950 transition">{{ $ev->title }}</span>
                    <span class="px-2 py-0.5 text-[9px] font-bold rounded uppercase shrink-0 {{ $ev->format === 'online' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-900' }}">
                      {{ $ev->format }}
                    </span>
                  </div>
                  <div class="text-[11px] text-slate-500 mt-1 flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1">
                      <svg class="size-3 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                      </svg>
                      <span>{{ $ev->start_date ? $ev->start_date->format('d M Y') : '-' }}</span>
                    </span>
                    <span>•</span>
                    <span class="inline-flex items-center gap-1">
                      <svg class="size-3 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                        <circle cx="12" cy="10" r="3"/>
                      </svg>
                      <span>{{ $ev->location }}</span>
                    </span>
                    @if($isAssigned)
                      <span class="text-blue-900 font-semibold">• Sedang Ditugaskan ({{ $currentRole }})</span>
                    @endif
                  </div>
                </label>
              </div>

              <!-- Input Detail Peran, Topik & Sesi -->
              <div id="details-ev-{{ $ev->id }}" class="mt-3 pt-3 border-t border-slate-200/80 grid grid-cols-1 sm:grid-cols-3 gap-2.5 text-xs {{ $isAssigned ? '' : 'hidden' }}">
                <div>
                  <label class="block text-[10px] font-semibold text-slate-600 uppercase tracking-wide mb-1">Status Peran</label>
                  <select name="roles[{{ $ev->id }}]" class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded-lg text-xs outline-none focus:border-blue-950 font-medium">
                    <option value="Pemateri" {{ $currentRole === 'Pemateri' ? 'selected' : '' }}>Berperan sbg Pemateri</option>
                    <option value="Moderator" {{ $currentRole === 'Moderator' ? 'selected' : '' }}>Berperan sbg Moderator</option>
                    <option value="Pemateri Utama" {{ $currentRole === 'Pemateri Utama' ? 'selected' : '' }}>Berperan sbg Pemateri Utama</option>
                    <option value="Keynote Speaker" {{ $currentRole === 'Keynote Speaker' ? 'selected' : '' }}>Berperan sbg Keynote Speaker</option>
                  </select>
                </div>
                <div>
                  <label class="block text-[10px] font-semibold text-slate-600 uppercase tracking-wide mb-1">Topik Materi</label>
                  <input type="text" name="topics[{{ $ev->id }}]" value="{{ $currentTopic }}" placeholder="Contoh: REST API Modern" class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded-lg text-xs outline-none focus:border-blue-950">
                </div>
                <div>
                  <label class="block text-[10px] font-semibold text-slate-600 uppercase tracking-wide mb-1">Waktu Sesi</label>
                  <input type="text" name="session_times[{{ $ev->id }}]" value="{{ $currentSession }}" placeholder="Contoh: 09:30 - 11:30 WIB" class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded-lg text-xs outline-none focus:border-blue-950">
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
          <button type="button" onclick="closeAssignModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 cursor-pointer">
            Batal
          </button>
          <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-950 hover:bg-blue-900 text-white text-xs font-semibold shadow-xs cursor-pointer flex items-center gap-2">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
              <polyline points="17 21 17 13 7 13 7 21"/>
              <polyline points="7 3 7 8 15 8"/>
            </svg>
            <span>Simpan Riwayat Penempatan</span>
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- ========================================================================= -->
  <!-- MODAL: EDIT PROFIL PENGISI ACARA                                         -->
  <!-- ========================================================================= -->
  <div id="modal-edit-speaker" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-3 sm:p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl max-w-xl w-full p-6 sm:p-8 flex flex-col gap-5 shadow-2xl my-auto max-h-[90vh] overflow-y-auto">
      <div class="flex items-start justify-between gap-4 pb-3 border-b border-slate-100">
        <div>
          <h2 class="text-base sm:text-lg font-bold text-slate-900">Edit Profil Pengisi Acara</h2>
          <p class="text-xs text-slate-500 mt-0.5">Perbarui profil dan kontak arsip narasumber.</p>
        </div>
        <button type="button" onclick="closeEditSpeakerModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 cursor-pointer">
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>

      <form id="form-edit-speaker" method="POST" enctype="multipart/form-data" action="{{ route('organizer.speakers.update', $speaker->id) }}" class="flex flex-col gap-4 text-xs">
        @csrf
        @method('PUT')
        
        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Nama Lengkap &amp; Gelar <span class="text-rose-500">*</span></label>
          <input type="text" id="edit-name" name="name" value="{{ $speaker->name }}" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Instansi / Organisasi <span class="text-rose-500">*</span></label>
          <input type="text" id="edit-institution" name="institution" value="{{ $speaker->institution }}" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Email</label>
            <input type="email" id="edit-email" name="email" value="{{ $speaker->email }}" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
          </div>
          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Nomor Telepon / WhatsApp</label>
            <input type="text" id="edit-phone" name="phone" value="{{ $speaker->phone }}" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
          </div>
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Bio Singkat</label>
          <textarea id="edit-bio" name="bio" rows="3" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition leading-relaxed">{{ $speaker->bio }}</textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
          <button type="button" onclick="closeEditSpeakerModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 cursor-pointer">
            Batal
          </button>
          <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-950 hover:bg-blue-900 text-white font-semibold shadow-xs cursor-pointer">
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
  function openAssignModal() {
    const modal = document.getElementById('modal-assign-speaker');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function closeAssignModal() {
    const modal = document.getElementById('modal-assign-speaker');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }

  function toggleEventAssign(eventId, isChecked) {
    const details = document.getElementById(`details-ev-${eventId}`);
    const card = document.getElementById(`event-card-${eventId}`);
    if (isChecked) {
      details.classList.remove('hidden');
      card.classList.add('bg-blue-50/70', 'border-blue-300', 'shadow-2xs');
      card.classList.remove('bg-slate-50/60', 'border-slate-200');
    } else {
      details.classList.add('hidden');
      card.classList.remove('bg-blue-50/70', 'border-blue-300', 'shadow-2xs');
      card.classList.add('bg-slate-50/60', 'border-slate-200');
    }
  }

  function openEditSpeakerModal() {
    const m = document.getElementById('modal-edit-speaker');
    m.classList.remove('hidden');
    m.classList.add('flex');
  }

  function closeEditSpeakerModal() {
    const m = document.getElementById('modal-edit-speaker');
    m.classList.add('hidden');
    m.classList.remove('flex');
  }
</script>
@endpush
@endsection


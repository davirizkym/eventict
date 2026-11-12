@extends('layouts.app')

@section('title', 'Daftar Pengisi Acara — Eventict Lab ICT')

@section('content')
<div class="min-h-screen bg-slate-50 text-slate-800 antialiased font-['Poppins'] flex flex-col">
  @include('partials.organizer-header')

  <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 pb-24 md:pb-8 flex flex-col gap-6">
    <!-- Breadcrumb & Page Title -->
    <div class="flex items-center gap-2 text-xs text-slate-500">
      <a href="{{ route('organizer.dashboard') }}" class="hover:text-blue-950 font-medium">Portal Pengelola</a>
      <span>/</span>
      <span class="text-slate-900 font-semibold">Pengisi Acara</span>
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

    @if (session('warning'))
      <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-center justify-between text-xs text-amber-800 shadow-2xs">
        <div class="flex items-center gap-2.5">
          <svg class="size-4 text-amber-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
          </svg>
          <span class="font-medium">{{ session('warning') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-amber-500 hover:text-amber-800 text-sm cursor-pointer">✕</button>
      </div>
    @endif

    @if ($errors->any())
      <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl text-xs text-rose-800 shadow-2xs">
        <div class="font-bold mb-1">Gagal Menyimpan Data Pengisi Acara:</div>
        <ul class="list-disc pl-5 space-y-0.5">
          @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- Top Action Header (Sesuai Ketentuan 1: Tombol Aksi Atas) -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-7 flex flex-col sm:flex-row sm:items-center justify-between gap-5 shadow-2xs">
      <div class="flex flex-col gap-1">
        <h1 class="text-xl sm:text-2xl font-bold text-slate-900 font-['Poppins']">Tabel Daftar Pengisi Acara</h1>
        <p class="text-xs text-slate-500 leading-relaxed max-w-2xl">
          Bank data master pemateri, instruktur workshop, dan moderator seminar Lab ICT. Klik nama atau tombol Detail untuk melihat riwayat partisipasi acara.
        </p>
      </div>

      <!-- Tombol Aksi Atas: "+ Tambah Pengisi Acara" -->
      <div class="flex items-center gap-3 shrink-0">
        <button type="button" onclick="openCreateSpeakerModal()" class="px-4 py-2.5 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold shadow-xs flex items-center gap-2 transition cursor-pointer">
          <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
          </svg>
          <span>Tambah Pengisi Acara</span>
        </button>
      </div>
    </div>

    <!-- Bar Pencarian & Filter (Ketentuan 1) -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-5 shadow-2xs">
      <form id="filter-form" method="GET" action="{{ route('organizer.speakers.index') }}" class="flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
        <!-- Input Search untuk mencari nama atau asal instansi -->
        <div class="w-full sm:flex-1 relative">
          <svg class="size-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/>
            <path d="m21 21-4.3-4.3"/>
          </svg>
          <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama pengisi acara atau asal instansi..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 outline-none focus:border-blue-950 focus:bg-white transition">
        </div>

        <div class="w-full sm:w-auto flex flex-wrap items-center gap-2.5 shrink-0">
          <!-- Filter Instansi -->
          @if($institutions->isNotEmpty())
            <select name="institution" onchange="document.getElementById('filter-form').submit()" class="w-full sm:w-auto px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 font-medium outline-none focus:border-blue-950 cursor-pointer transition">
              <option value="">Semua Instansi</option>
              @foreach($institutions as $inst)
                <option value="{{ $inst }}" {{ request('institution') == $inst ? 'selected' : '' }}>
                  {{ Str::limit($inst, 28) }}
                </option>
              @endforeach
            </select>
          @endif

          <!-- Sorting Dropdown -->
          <select name="sort" onchange="document.getElementById('filter-form').submit()" class="w-full sm:w-auto px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 font-medium outline-none focus:border-blue-950 cursor-pointer transition">
            <option value="name_asc" {{ request('sort', 'name_asc') == 'name_asc' ? 'selected' : '' }}>Urut: Nama (A - Z)</option>
            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Urut: Nama (Z - A)</option>
            <option value="events_desc" {{ request('sort') == 'events_desc' ? 'selected' : '' }}>Urut: Jumlah Acara Terbanyak</option>
            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Urut: Terbaru Ditambahkan</option>
          </select>

          <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold transition cursor-pointer">
            Cari
          </button>

          @if(request()->hasAny(['q', 'institution', 'sort']))
            <a href="{{ route('organizer.speakers.index') }}" class="w-full sm:w-auto text-center px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-medium transition">
              Reset
            </a>
          @endif
        </div>
      </form>
    </div>

    <!-- Tabel Data Pengisi Acara (Ketentuan 1) -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs">
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-700">
          <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase text-[10px] tracking-wider select-none">
            <tr>
              <th scope="col" class="py-3.5 px-4 w-12 text-center">No</th>
              <th scope="col" class="py-3.5 px-4">Nama Lengkap &amp; Gelar</th>
              <th scope="col" class="py-3.5 px-4">Instansi / Perusahaan</th>
              <th scope="col" class="py-3.5 px-4">Kontak</th>
              <th scope="col" class="py-3.5 px-4 text-center">Riwayat Acara</th>
              <th scope="col" class="py-3.5 px-4 text-center w-36">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 font-['Poppins']">
            @forelse($speakers as $spk)
              <tr class="hover:bg-blue-50/30 transition">
                <!-- 1. No otomatis urut dengan pagination -->
                <td class="py-4 px-4 text-center font-medium text-slate-400">
                  {{ ($speakers->currentPage() - 1) * $speakers->perPage() + $loop->iteration }}
                </td>

                <!-- 2. Nama Lengkap & Gelar (link klik ke detail) -->
                <td class="py-4 px-4">
                  <a href="{{ route('organizer.speakers.show', $spk->id) }}" class="font-bold text-slate-900 hover:text-blue-950 hover:underline block leading-snug">
                    {{ $spk->name }}
                  </a>
                </td>

                <!-- 3. Instansi / Perusahaan -->
                <td class="py-4 px-4">
                  <span class="font-medium text-slate-700 block">
                    {{ $spk->institution ?? 'Afiliasi Independen' }}
                  </span>
                </td>

                <!-- 6. Kontak (Email & Nomor WhatsApp) -->
                <td class="py-4 px-4">
                  <div class="flex flex-col gap-1">
                    @if($spk->email)
                      <a href="mailto:{{ $spk->email }}" class="text-[11px] text-slate-600 hover:text-blue-950 hover:underline flex items-center gap-1.5 truncate max-w-[170px]" title="Kirim Email">
                        <svg class="size-3 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <rect width="20" height="16" x="2" y="4" rx="2"/>
                          <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                        <span class="truncate">{{ $spk->email }}</span>
                      </a>
                    @else
                      <span class="text-[11px] text-slate-400 italic">Email -</span>
                    @endif

                    @if($spk->phone)
                      @php
                        $cleanPhone = preg_replace('/[^0-9]/', '', $spk->phone);
                        if (str_starts_with($cleanPhone, '0')) {
                          $cleanPhone = '62' . substr($cleanPhone, 1);
                        }
                      @endphp
                      <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="text-[11px] text-emerald-700 hover:text-emerald-800 hover:underline flex items-center gap-1.5" title="Chat WhatsApp">
                        <svg class="size-3 text-emerald-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        <span>{{ $spk->phone }}</span>
                      </a>
                    @else
                      <span class="text-[11px] text-slate-400 italic">No. Telp -</span>
                    @endif
                  </div>
                </td>

                <!-- 7. Riwayat Mengisi Acara (Badge jumlah seminar yang pernah diisi) -->
                <td class="py-4 px-4 text-center">
                  <a href="{{ route('organizer.speakers.show', $spk->id) }}" class="font-semibold text-slate-700 hover:text-blue-950 hover:underline transition" title="Lihat riwayat seminar">
                    {{ $spk->events_count }}
                  </a>
                </td>

                <!-- 8. Aksi: Detail / Riwayat, Edit, dan Hapus -->
                <td class="py-4 px-4 text-center">
                  <div class="flex items-center justify-center gap-1.5">
                    <!-- Tombol Detail / Riwayat -->
                    <a href="{{ route('organizer.speakers.show', $spk->id) }}" class="p-1.5 rounded-lg bg-slate-100 hover:bg-blue-950 hover:text-white text-slate-700 transition" title="Detail &amp; Riwayat Partisipasi">
                      <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                        <circle cx="12" cy="12" r="3"/>
                      </svg>
                    </a>

                    <!-- Tombol Edit -->
                    <button type="button" onclick="openEditSpeakerModal({{ json_encode($spk) }})" class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition cursor-pointer" title="Edit Data">
                      <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                      </svg>
                    </button>

                    <!-- Tombol Hapus -->
                    <form method="POST" action="{{ route('organizer.speakers.destroy', ['speaker' => $spk->id]) }}" onsubmit="return confirm('Hapus profil pengisi acara {{ $spk->name }}?');" class="inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="p-1.5 rounded-lg bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-400 transition cursor-pointer" title="Hapus">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <path d="M3 6h18"/>
                          <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                        </svg>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="py-12 px-4 text-center text-slate-400">
                  <div class="size-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2">
                    <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                      <circle cx="9" cy="7" r="4"/>
                    </svg>
                  </div>
                  <span class="font-semibold text-slate-800 block text-xs">Belum Ada Data Pengisi Acara</span>
                  <p class="text-[11px] text-slate-400 mt-0.5">Silakan gunakan tombol "Tambah Pengisi Acara" di atas untuk menambahkan data baru.</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination Links (Ketentuan 1) -->
      @if($speakers->hasPages())
        <div class="p-4 border-t border-slate-200 bg-slate-50/50 flex items-center justify-between">
          <div class="text-xs text-slate-500">
            Menampilkan {{ $speakers->firstItem() ?? 0 }} - {{ $speakers->lastItem() ?? 0 }} dari {{ $speakers->total() }} pengisi acara
          </div>
          <div>
            {{ $speakers->links() }}
          </div>
        </div>
      @endif
    </div>
  </main>

  <!-- ========================================================================= -->
  <!-- MODAL: FORM TAMBAH PENGISI ACARA (Ketentuan 2)                            -->
  <!-- ========================================================================= -->
  <div id="modal-create-speaker" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-3 sm:p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl max-w-xl w-full p-6 sm:p-8 flex flex-col gap-5 shadow-2xl my-auto max-h-[90vh] overflow-y-auto">
      <div class="flex items-start justify-between gap-4 pb-3 border-b border-slate-100">
        <div>
          <h2 class="text-base sm:text-lg font-bold text-slate-900">Form Tambah Pengisi Acara</h2>
          <p class="text-xs text-slate-500 mt-0.5">Daftarkan pemateri, instruktur, atau narasumber baru ke dalam Bank Master.</p>
        </div>
        <button type="button" onclick="closeCreateSpeakerModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 cursor-pointer">
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>

      <form action="{{ route('organizer.speakers.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4 text-xs">
        @csrf
        
        <!-- Nama Lengkap: Wajib diisi (required|string|max:255) -->
        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Nama Lengkap &amp; Gelar <span class="text-rose-500">*</span></label>
          <input type="text" name="name" required placeholder="Contoh: Dr. Ir. Budi Santoso, M.Kom." class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
        </div>

        <!-- Instansi / Organisasi: Wajib diisi -->
        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Instansi / Organisasi <span class="text-rose-500">*</span></label>
          <input type="text" name="institution" required placeholder="Contoh: PT Telkom Indonesia / Universitas Budi Luhur" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
        </div>

        <!-- Email & No. Telepon / WhatsApp: Arsip Panitia (email|nullable) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Email (Arsip Panitia)</label>
            <input type="email" name="email" placeholder="Contoh: budi.santoso@instansi.id" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
          </div>
          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Nomor Telepon / WhatsApp</label>
            <input type="text" name="phone" placeholder="Contoh: 081234567890" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
          </div>
        </div>

        <!-- Bio Singkat: 2-3 kalimat -->
        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Bio Singkat (Latar Belakang)</label>
          <textarea name="bio" rows="3" placeholder="Tuliskan 2–3 kalimat deskripsi ringkas mengenai latar belakang atau pengalaman pengisi acara..." class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition leading-relaxed"></textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
          <button type="button" onclick="closeCreateSpeakerModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 cursor-pointer">
            Batal
          </button>
          <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-950 hover:bg-blue-900 text-white font-semibold shadow-xs cursor-pointer">
            Simpan Pengisi Acara
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- ========================================================================= -->
  <!-- MODAL: FORM EDIT PENGISI ACARA (Ketentuan 2)                              -->
  <!-- ========================================================================= -->
  <div id="modal-edit-speaker" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-3 sm:p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl max-w-xl w-full p-6 sm:p-8 flex flex-col gap-5 shadow-2xl my-auto max-h-[90vh] overflow-y-auto">
      <div class="flex items-start justify-between gap-4 pb-3 border-b border-slate-100">
        <div>
          <h2 class="text-base sm:text-lg font-bold text-slate-900">Edit Data Pengisi Acara</h2>
          <p class="text-xs text-slate-500 mt-0.5">Perbarui profil pengisi acara dan kontak arsip panitia.</p>
        </div>
        <button type="button" onclick="closeEditSpeakerModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 cursor-pointer">
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>

      <form id="form-edit-speaker" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4 text-xs">
        @csrf
        @method('PUT')
        
        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Nama Lengkap &amp; Gelar <span class="text-rose-500">*</span></label>
          <input type="text" id="edit-name" name="name" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Instansi / Organisasi <span class="text-rose-500">*</span></label>
          <input type="text" id="edit-institution" name="institution" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Email</label>
            <input type="email" id="edit-email" name="email" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
          </div>
          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Nomor Telepon / WhatsApp</label>
            <input type="text" id="edit-phone" name="phone" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
          </div>
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Bio Singkat</label>
          <textarea id="edit-bio" name="bio" rows="3" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition leading-relaxed"></textarea>
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
  function openCreateSpeakerModal() {
    const m = document.getElementById('modal-create-speaker');
    m.classList.remove('hidden');
    m.classList.add('flex');
  }

  function closeCreateSpeakerModal() {
    const m = document.getElementById('modal-create-speaker');
    m.classList.add('hidden');
    m.classList.remove('flex');
  }

  function openEditSpeakerModal(spk) {
    const form = document.getElementById('form-edit-speaker');
    form.action = '/penyelenggara/narasumber/' + spk.id;
    document.getElementById('edit-name').value = spk.name || '';
    document.getElementById('edit-institution').value = spk.institution || '';
    document.getElementById('edit-email').value = spk.email || '';
    document.getElementById('edit-phone').value = spk.phone || '';
    document.getElementById('edit-bio').value = spk.bio || '';

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

@include('partials.organizer-bottom-nav')
@endsection

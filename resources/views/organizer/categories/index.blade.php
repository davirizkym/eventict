@extends('layouts.app')

@section('title', 'Kategori Kegiatan — Eventict Lab ICT')

@section('content')
@php
$presetIcons = [
  'code' => 'Code / Web',
  'cpu' => 'AI / Data',
  'shield' => 'Security',
  'globe' => 'Network',
  'database' => 'Database',
  'palette' => 'UI / Desain',
  'terminal' => 'DevOps',
  'briefcase' => 'Bisnis',
  'book' => 'Akademik',
  'smartphone' => 'Mobile',
  'server' => 'Server',
  'sparkles' => 'Umum',
];
@endphp
<div class="min-h-screen bg-slate-50 text-slate-800 antialiased font-['Poppins'] flex flex-col">
  <header class="bg-blue-950 text-white border-b border-blue-900 sticky top-0 z-30 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-4">
      <div class="flex items-center gap-6 sm:gap-8">
        <a href="{{ route('organizer.dashboard') }}" class="flex items-center gap-3 group">
          <img src="{{ asset('logo_white.svg') }}" alt="Eventict" class="h-8 w-auto">
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
          <a href="{{ route('organizer.categories.index') }}" class="px-3.5 py-2 rounded-lg text-xs font-semibold bg-white/10 text-white transition flex items-center gap-2">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M4 6h16M4 12h16M4 18h7"/>
            </svg>
            <span>Kategori</span>
          </a>
          <a href="{{ route('organizer.speakers.index') }}" class="px-3.5 py-2 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-white/5 transition flex items-center gap-2">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <span>Pengisi Acara</span>
          </a>
          <a href="{{ route('organizer.media_partners.index') }}" class="px-3.5 py-2 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-white/5 transition flex items-center gap-2">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="m3 11 18-5v12L3 14v-3z"/>
              <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>
            </svg>
            <span>Media Partner</span>
          </a>
          @if(Auth::user()->isAdministrator())
            <a href="{{ route('admin.users.index') }}" class="px-3.5 py-2 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-white/5 transition flex items-center gap-2">
              <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
              </svg>
              <span>Kelola User</span>
            </a>
          @endif
        </nav>
      </div>

      <div class="flex items-center gap-3">
        <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-lg border border-white/20 text-xs font-medium text-slate-200 hover:bg-white/10 hover:text-white transition hidden sm:inline-flex items-center gap-1.5">
          <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
            <polyline points="15 3 21 3 21 9"/>
            <line x1="10" y1="14" x2="21" y2="3"/>
          </svg>
          <span>Halaman Publik</span>
        </a>

        <div class="flex items-center gap-2.5 pl-2 sm:border-l sm:border-white/15">
          <div class="size-8 rounded-lg bg-blue-900 text-white font-semibold text-xs flex items-center justify-center shrink-0">
            {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 2)) }}
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

  <main class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-24 md:pb-8 flex-1 flex flex-col gap-6">
    <div class="flex items-center gap-2 text-xs text-slate-500">
      <a href="{{ route('organizer.dashboard') }}" class="hover:text-blue-950 font-medium">Portal Pengelola</a>
      <span>/</span>
      <span class="text-slate-900 font-semibold">Kategori Kegiatan</span>
    </div>

    @if (session('success'))
      <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3 text-xs text-emerald-800 shadow-2xs">
        <svg class="size-4 text-emerald-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="20 6 9 17 4 12"/>
        </svg>
        <span>{{ session('success') }}</span>
      </div>
    @endif

    @if ($errors->any())
      <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl flex flex-col gap-1 text-xs text-rose-800 shadow-2xs">
        <div class="flex items-center gap-2 font-semibold">
          <svg class="size-4 text-rose-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
          </svg>
          <span>Terjadi kendala validasi data:</span>
        </div>
        <ul class="list-disc list-inside pl-6 text-rose-700 space-y-0.5">
          @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-7 flex flex-col sm:flex-row sm:items-center justify-between gap-5 shadow-2xs">
      <div class="flex flex-col gap-1">
        <div class="flex items-center gap-2.5">
          <h1 class="text-xl sm:text-2xl font-bold text-slate-900 font-['Poppins']">Master Kategori Acara</h1>
          <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-950 border border-blue-200">
            {{ $categories->total() }} Kategori
          </span>
        </div>
        <p class="text-xs text-slate-500 leading-relaxed">
          Daftar kategori kegiatan dengan pilihan preset icon atau unggahan icon kustom.
        </p>
      </div>

      <div class="flex items-center gap-3 shrink-0">
        <button type="button" onclick="openCreateCategoryModal()" class="px-4 py-2.5 bg-blue-950 text-white rounded-xl text-xs font-semibold hover:bg-blue-900 transition flex items-center gap-2 shadow-xs cursor-pointer">
          <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
          </svg>
          <span>Tambah Kategori</span>
        </button>
      </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-5 shadow-2xs">
      <form method="GET" action="{{ route('organizer.categories.index') }}" class="flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
        <div class="w-full sm:flex-1 relative">
          <svg class="size-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/>
            <path d="m21 21-4.3-4.3"/>
          </svg>
          <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau deskripsi kategori..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 outline-none focus:border-blue-950 focus:bg-white transition">
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto">
          <button type="submit" class="w-full sm:w-auto px-4 py-2.5 bg-slate-800 text-white rounded-xl text-xs font-semibold hover:bg-slate-900 transition cursor-pointer">
            Cari
          </button>
          @if(request('q'))
            <a href="{{ route('organizer.categories.index') }}" class="px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-600 hover:bg-slate-50 transition">
              Reset
            </a>
          @endif
        </div>
      </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
          <thead>
            <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-semibold text-[11px] uppercase tracking-wider">
              <th class="py-3.5 px-4 w-14 text-center">No</th>
              <th class="py-3.5 px-4 min-w-[220px]">Kategori & Icon</th>
              <th class="py-3.5 px-4 min-w-[150px]">Slug</th>
              <th class="py-3.5 px-4 min-w-[280px]">Deskripsi</th>
              <th class="py-3.5 px-4 w-28 text-center">Jumlah Kegiatan</th>
              <th class="py-3.5 px-4 w-28 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 text-slate-700">
            @forelse($categories as $index => $cat)
              <tr class="hover:bg-slate-50/80 transition">
                <td class="py-3.5 px-4 text-center text-slate-400 font-mono text-[11px]">
                  {{ $categories->firstItem() + $index }}
                </td>
                <td class="py-3.5 px-4">
                  <div class="flex items-center gap-3">
                    <div class="size-9 rounded-xl bg-blue-50 border border-blue-200/60 flex items-center justify-center text-blue-900 shrink-0 overflow-hidden">
                      @include('partials.category-icon', ['icon' => $cat->icon, 'class' => 'size-4'])
                    </div>
                    <div>
                      <span class="font-semibold text-slate-900 block">{{ $cat->name }}</span>
                    </div>
                  </div>
                </td>
                <td class="py-3.5 px-4 text-slate-500 font-mono text-[11px]">
                  {{ $cat->slug }}
                </td>
                <td class="py-3.5 px-4 text-slate-600 leading-relaxed">
                  {{ $cat->description ?: '-' }}
                </td>
                <td class="py-3.5 px-4 text-center">
                  <span class="font-semibold text-slate-700">
                    {{ $cat->events_count }}
                  </span>
                </td>
                <td class="py-3.5 px-4 text-right">
                  <div class="flex items-center justify-end gap-1.5">
                    <button type="button" onclick="openEditCategoryModal({{ json_encode($cat) }})" class="p-1.5 rounded-lg text-slate-600 hover:text-blue-950 hover:bg-slate-100 transition cursor-pointer" title="Edit Kategori">
                      <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                      </svg>
                    </button>

                    <form method="POST" action="{{ route('organizer.categories.destroy', $cat->id) }}" onsubmit="return confirm('Hapus kategori {{ $cat->name }}? Kegiatan yang terhubung tidak akan terhapus.');" class="inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 transition cursor-pointer" title="Hapus">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <polyline points="3 6 5 6 21 6"/>
                          <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        </svg>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="py-12 px-4 text-center text-slate-500">
                  <div class="size-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                  </div>
                  <span class="font-semibold text-slate-800 block text-xs">Belum Ada Data Kategori</span>
                  <p class="text-[11px] text-slate-400 mt-0.5">Gunakan tombol "Tambah Kategori" di atas untuk menambahkan kategori baru.</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($categories->hasPages())
        <div class="p-4 border-t border-slate-200 bg-slate-50/50 flex items-center justify-between">
          <div class="text-xs text-slate-500">
            Menampilkan {{ $categories->firstItem() ?? 0 }} - {{ $categories->lastItem() ?? 0 }} dari {{ $categories->total() }} kategori
          </div>
          <div>
            {{ $categories->links() }}
          </div>
        </div>
      @endif
    </div>
  </main>

  <div id="modal-create-category" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-3 sm:p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 sm:p-7 flex flex-col gap-5 shadow-2xl my-auto">
      <div class="flex items-start justify-between gap-4 pb-3 border-b border-slate-100">
        <div>
          <h2 class="text-base sm:text-lg font-bold text-slate-900">Tambah Kategori Baru</h2>
          <p class="text-xs text-slate-500 mt-0.5">Buat kategori acara baru (misal: Cyber Security, Data Science, dll).</p>
        </div>
        <button type="button" onclick="closeCreateCategoryModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 cursor-pointer">
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>

      <form action="{{ route('organizer.categories.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4 text-xs">
        @csrf
        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Nama Kategori <span class="text-rose-500">*</span></label>
          <input type="text" name="name" required placeholder="Contoh: Cyber Security" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Deskripsi Ringkas</label>
          <textarea name="description" rows="2" placeholder="Tuliskan pokok bidang topik atau cakupan materi kategori ini..." class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition leading-relaxed"></textarea>
        </div>

        <div class="flex flex-col gap-2">
          <label class="font-semibold text-slate-700">Icon Kategori</label>
          
          <div class="flex items-center gap-2 p-1 bg-slate-100 rounded-xl w-fit">
            <button type="button" onclick="switchIconTab('create', 'preset')" id="create-tab-preset" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-white text-blue-950 shadow-2xs transition cursor-pointer">
              Pilih Icon Preset
            </button>
            <button type="button" onclick="switchIconTab('create', 'upload')" id="create-tab-upload" class="px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:text-slate-900 transition cursor-pointer">
              Unggah Gambar Icon
            </button>
          </div>

          <div id="create-panel-preset" class="flex flex-col gap-2">
            <input type="hidden" name="icon" id="create-icon-val" value="code">
            <div class="grid grid-cols-3 sm:grid-cols-4 gap-2 max-h-48 overflow-y-auto p-1">
              @foreach($presetIcons as $pIcon => $pLabel)
                <button type="button" onclick="selectPresetIcon('create', '{{ $pIcon }}')" id="create-preset-{{ $pIcon }}" class="create-preset-btn p-2 rounded-xl border border-slate-200 hover:border-blue-950 flex flex-col items-center gap-1.5 transition text-center cursor-pointer">
                  <div class="size-7 rounded-lg bg-blue-50 text-blue-950 flex items-center justify-center pointer-events-none">
                    @include('partials.category-icon', ['icon' => $pIcon, 'class' => 'size-4'])
                  </div>
                  <span class="text-[10px] font-medium text-slate-700 leading-tight pointer-events-none">{{ $pLabel }}</span>
                </button>
              @endforeach
            </div>
          </div>

          <div id="create-panel-upload" class="hidden flex-col gap-2">
            <div class="border-2 border-dashed border-slate-200 hover:border-blue-950 rounded-xl p-4 flex flex-col items-center justify-center gap-2 transition bg-slate-50/50 cursor-pointer" onclick="document.getElementById('create-icon-file').click()">
              <input type="file" name="icon_file" id="create-icon-file" accept="image/png,image/jpeg,image/webp,image/svg+xml" class="hidden" onchange="previewUploadIcon('create', this)">
              <div id="create-upload-preview" class="size-12 rounded-xl bg-blue-50 border border-blue-200/60 flex items-center justify-center text-blue-900 overflow-hidden">
                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                  <polyline points="17 8 12 3 7 8"/>
                  <line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
              </div>
              <div class="text-center">
                <span class="text-xs font-semibold text-blue-950 block">Klik untuk memilih file gambar</span>
                <span class="text-[11px] text-slate-400">Format SVG, PNG, JPG, atau WebP (Maks. 2MB)</span>
              </div>
            </div>
          </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
          <button type="button" onclick="closeCreateCategoryModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 cursor-pointer">
            Batal
          </button>
          <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-950 hover:bg-blue-900 text-white font-semibold shadow-xs cursor-pointer">
            Simpan Kategori
          </button>
        </div>
      </form>
    </div>
  </div>

  <div id="modal-edit-category" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-3 sm:p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 sm:p-7 flex flex-col gap-5 shadow-2xl my-auto">
      <div class="flex items-start justify-between gap-4 pb-3 border-b border-slate-100">
        <div>
          <h2 class="text-base sm:text-lg font-bold text-slate-900">Edit Kategori Acara</h2>
          <p class="text-xs text-slate-500 mt-0.5">Perbarui nama, deskripsi, atau icon kategori.</p>
        </div>
        <button type="button" onclick="closeEditCategoryModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 cursor-pointer">
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>

      <form id="edit-category-form" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4 text-xs">
        @csrf
        @method('PUT')
        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Nama Kategori <span class="text-rose-500">*</span></label>
          <input type="text" id="edit-name" name="name" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Deskripsi Ringkas</label>
          <textarea id="edit-description" name="description" rows="2" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition leading-relaxed"></textarea>
        </div>

        <div class="flex flex-col gap-2">
          <label class="font-semibold text-slate-700">Icon Kategori</label>
          
          <div class="flex items-center gap-2 p-1 bg-slate-100 rounded-xl w-fit">
            <button type="button" onclick="switchIconTab('edit', 'preset')" id="edit-tab-preset" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-white text-blue-950 shadow-2xs transition cursor-pointer">
              Pilih Icon Preset
            </button>
            <button type="button" onclick="switchIconTab('edit', 'upload')" id="edit-tab-upload" class="px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:text-slate-900 transition cursor-pointer">
              Unggah Gambar Icon
            </button>
          </div>

          <div id="edit-panel-preset" class="flex flex-col gap-2">
            <input type="hidden" name="icon" id="edit-icon-val" value="code">
            <div class="grid grid-cols-3 sm:grid-cols-4 gap-2 max-h-48 overflow-y-auto p-1">
              @foreach($presetIcons as $pIcon => $pLabel)
                <button type="button" onclick="selectPresetIcon('edit', '{{ $pIcon }}')" id="edit-preset-{{ $pIcon }}" class="edit-preset-btn p-2 rounded-xl border border-slate-200 hover:border-blue-950 flex flex-col items-center gap-1.5 transition text-center cursor-pointer">
                  <div class="size-7 rounded-lg bg-blue-50 text-blue-950 flex items-center justify-center pointer-events-none">
                    @include('partials.category-icon', ['icon' => $pIcon, 'class' => 'size-4'])
                  </div>
                  <span class="text-[10px] font-medium text-slate-700 leading-tight pointer-events-none">{{ $pLabel }}</span>
                </button>
              @endforeach
            </div>
          </div>

          <div id="edit-panel-upload" class="hidden flex-col gap-2">
            <div class="border-2 border-dashed border-slate-200 hover:border-blue-950 rounded-xl p-4 flex flex-col items-center justify-center gap-2 transition bg-slate-50/50 cursor-pointer" onclick="document.getElementById('edit-icon-file').click()">
              <input type="file" name="icon_file" id="edit-icon-file" accept="image/png,image/jpeg,image/webp,image/svg+xml" class="hidden" onchange="previewUploadIcon('edit', this)">
              <div id="edit-upload-preview" class="size-12 rounded-xl bg-blue-50 border border-blue-200/60 flex items-center justify-center text-blue-900 overflow-hidden">
                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                  <polyline points="17 8 12 3 7 8"/>
                  <line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
              </div>
              <div class="text-center">
                <span class="text-xs font-semibold text-blue-950 block">Klik untuk memilih file gambar baru</span>
                <span class="text-[11px] text-slate-400">Biarkan kosong jika tidak ingin mengubah icon saat ini</span>
              </div>
            </div>
          </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
          <button type="button" onclick="closeEditCategoryModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 cursor-pointer">
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

<script>
function openCreateCategoryModal() {
  const m = document.getElementById('modal-create-category');
  m.classList.remove('hidden');
  m.classList.add('flex');
  switchIconTab('create', 'preset');
  selectPresetIcon('create', 'code');
}

function closeCreateCategoryModal() {
  const m = document.getElementById('modal-create-category');
  m.classList.add('hidden');
  m.classList.remove('flex');
}

function openEditCategoryModal(cat) {
  const form = document.getElementById('edit-category-form');
  form.action = '/penyelenggara/kategori/' + cat.id;
  document.getElementById('edit-name').value = cat.name || '';
  document.getElementById('edit-description').value = cat.description || '';

  const isCustomImage = cat.icon && (cat.icon.startsWith('storage/') || cat.icon.startsWith('uploads/') || cat.icon.includes('/'));
  if (isCustomImage) {
    switchIconTab('edit', 'upload');
    const preview = document.getElementById('edit-upload-preview');
    preview.innerHTML = '<img src="/' + cat.icon.replace(/^\//, '') + '" class="size-full object-contain p-1" alt="">';
    document.getElementById('edit-icon-val').value = cat.icon;
  } else {
    switchIconTab('edit', 'preset');
    selectPresetIcon('edit', cat.icon || 'sparkles');
  }

  const m = document.getElementById('modal-edit-category');
  m.classList.remove('hidden');
  m.classList.add('flex');
}

function closeEditCategoryModal() {
  const m = document.getElementById('modal-edit-category');
  m.classList.add('hidden');
  m.classList.remove('flex');
}

function switchIconTab(mode, tab) {
  const tabPreset = document.getElementById(mode + '-tab-preset');
  const tabUpload = document.getElementById(mode + '-tab-upload');
  const panelPreset = document.getElementById(mode + '-panel-preset');
  const panelUpload = document.getElementById(mode + '-panel-upload');

  if (tab === 'preset') {
    tabPreset.className = 'px-3 py-1.5 rounded-lg text-xs font-semibold bg-white text-blue-950 shadow-2xs transition cursor-pointer';
    tabUpload.className = 'px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:text-slate-900 transition cursor-pointer';
    panelPreset.classList.remove('hidden');
    panelPreset.classList.add('flex');
    panelUpload.classList.add('hidden');
    panelUpload.classList.remove('flex');
  } else {
    tabUpload.className = 'px-3 py-1.5 rounded-lg text-xs font-semibold bg-white text-blue-950 shadow-2xs transition cursor-pointer';
    tabPreset.className = 'px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:text-slate-900 transition cursor-pointer';
    panelUpload.classList.remove('hidden');
    panelUpload.classList.add('flex');
    panelPreset.classList.add('hidden');
    panelPreset.classList.remove('flex');
  }
}

function selectPresetIcon(mode, iconName) {
  document.getElementById(mode + '-icon-val').value = iconName;
  const buttons = document.querySelectorAll('.' + mode + '-preset-btn');
  buttons.forEach(btn => {
    btn.classList.remove('border-blue-950', 'bg-blue-50/50', 'ring-2', 'ring-blue-950/20');
    btn.classList.add('border-slate-200');
  });
  const selectedBtn = document.getElementById(mode + '-preset-' + iconName);
  if (selectedBtn) {
    selectedBtn.classList.remove('border-slate-200');
    selectedBtn.classList.add('border-blue-950', 'bg-blue-50/50', 'ring-2', 'ring-blue-950/20');
  }
}

function previewUploadIcon(mode, input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const preview = document.getElementById(mode + '-upload-preview');
      preview.innerHTML = '<img src="' + e.target.result + '" class="size-full object-contain p-1" alt="Preview">';
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>

@include('partials.organizer-bottom-nav')
@endsection

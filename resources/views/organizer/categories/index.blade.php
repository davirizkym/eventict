@extends('layouts.app')

@section('title', 'Kategori Kegiatan — Eventict Lab ICT')

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

  <!-- Main Content Container -->
  <main class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-1 flex flex-col gap-6">
    <!-- Breadcrumb -->
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
        <span class="font-medium">{{ session('success') }}</span>
      </div>
    @endif

    @if ($errors->any())
      <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl flex items-start gap-3 text-xs text-rose-800 shadow-2xs">
        <svg class="size-4 text-rose-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/>
          <line x1="15" y1="9" x2="9" y2="15"/>
          <line x1="9" y1="9" x2="15" y2="15"/>
        </svg>
        <div class="flex flex-col gap-1">
          <div class="font-bold">Gagal Menyimpan Data Kategori:</div>
          <ul class="list-disc list-inside">
            @foreach ($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    @endif

    <!-- Top Action Header -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-7 flex flex-col sm:flex-row sm:items-center justify-between gap-5 shadow-2xs">
      <div class="flex flex-col gap-1">
        <div class="flex items-center gap-2.5">
          <h1 class="text-xl sm:text-2xl font-bold text-slate-900 font-['Poppins']">Master Kategori Acara</h1>
          <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-950 border border-blue-200">
            {{ $categories->total() }} Kategori
          </span>
        </div>
        <p class="text-xs text-slate-500 leading-relaxed max-w-2xl">
          Bank data kategori untuk mengelompokkan kegiatan Lab ICT (Cyber Security, AI, Web Development, Cloud Computing, dll).
        </p>
      </div>

      <div class="flex items-center gap-3 shrink-0">
        <button type="button" onclick="openCreateCategoryModal()" class="px-4 py-2.5 bg-blue-950 text-white rounded-xl text-xs font-semibold hover:bg-blue-900 transition flex items-center gap-2 shadow-xs cursor-pointer">
          <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
          </svg>
          <span>+ Tambah Kategori</span>
        </button>
      </div>
    </div>

    <!-- Search Bar -->
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

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
          <thead>
            <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-semibold text-[11px] uppercase tracking-wider">
              <th class="py-3.5 px-4 w-14 text-center">No</th>
              <th class="py-3.5 px-4 min-w-[200px]">Nama Kategori</th>
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
                <td class="py-3.5 px-4 font-bold text-slate-900">
                  <div class="flex items-center gap-2">
                    <span class="size-2 rounded-full bg-blue-600"></span>
                    <span>{{ $cat->name }}</span>
                  </div>
                </td>
                <td class="py-3.5 px-4 text-slate-500 font-mono text-[11px]">
                  {{ $cat->slug }}
                </td>
                <td class="py-3.5 px-4 text-slate-600 leading-relaxed">
                  {{ $cat->description ?: '-' }}
                </td>
                <td class="py-3.5 px-4 text-center">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-900 border border-blue-200">
                    {{ $cat->events_count }} Kegiatan
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
                  <p class="text-[11px] text-slate-400 mt-0.5">Gunakan tombol "+ Tambah Kategori" di atas untuk menambahkan kategori baru.</p>
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

  <!-- MODAL: TAMBAH KATEGORI -->
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

      <form action="{{ route('organizer.categories.store') }}" method="POST" class="flex flex-col gap-4 text-xs">
        @csrf
        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Nama Kategori <span class="text-rose-500">*</span></label>
          <input type="text" name="name" required placeholder="Contoh: Cyber Security" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Deskripsi Ringkas</label>
          <textarea name="description" rows="3" placeholder="Tuliskan pokok bidang topik atau cakupan materi kategori ini..." class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition leading-relaxed"></textarea>
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

  <!-- MODAL: EDIT KATEGORI -->
  <div id="modal-edit-category" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-3 sm:p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 sm:p-7 flex flex-col gap-5 shadow-2xl my-auto">
      <div class="flex items-start justify-between gap-4 pb-3 border-b border-slate-100">
        <div>
          <h2 class="text-base sm:text-lg font-bold text-slate-900">Edit Kategori Acara</h2>
          <p class="text-xs text-slate-500 mt-0.5">Perbarui nama dan deskripsi kategori.</p>
        </div>
        <button type="button" onclick="closeEditCategoryModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 cursor-pointer">
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>

      <form id="edit-category-form" method="POST" class="flex flex-col gap-4 text-xs">
        @csrf
        @method('PUT')
        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Nama Kategori <span class="text-rose-500">*</span></label>
          <input type="text" id="edit-name" name="name" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Deskripsi Ringkas</label>
          <textarea id="edit-description" name="description" rows="3" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition leading-relaxed"></textarea>
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

  const m = document.getElementById('modal-edit-category');
  m.classList.remove('hidden');
  m.classList.add('flex');
}

function closeEditCategoryModal() {
  const m = document.getElementById('modal-edit-category');
  m.classList.add('hidden');
  m.classList.remove('flex');
}
</script>
@endsection

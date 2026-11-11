@extends('layouts.app')

@section('title', 'Media Partner Kegiatan — Eventict Lab ICT')

@section('content')
<div class="min-h-screen bg-slate-50 text-slate-800 antialiased font-['Poppins'] flex flex-col">
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
          <a href="{{ route('organizer.speakers.index') }}" class="px-3.5 py-2 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-white/5 transition flex items-center gap-2">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <span>Pengisi Acara</span>
          </a>
          <a href="{{ route('organizer.media_partners.index') }}" class="px-3.5 py-2 rounded-lg text-xs font-semibold bg-white/10 text-white transition flex items-center gap-2">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="m3 11 18-5v12L3 14v-3z"/>
              <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>
            </svg>
            <span>Media Partner</span>
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

        <div class="flex items-center gap-2 pl-2 border-l border-white/20">
          <div class="size-8 rounded-lg bg-blue-900 border border-blue-700 flex items-center justify-center font-bold text-xs">
            P
          </div>
          <form method="POST" action="{{ route('logout') }}" class="inline">
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

  <main class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-1 flex flex-col gap-6">
    <div class="flex items-center gap-2 text-xs text-slate-500">
      <a href="{{ route('organizer.dashboard') }}" class="hover:text-blue-950 font-medium">Portal Pengelola</a>
      <span>/</span>
      <span class="text-slate-900 font-semibold">Media Partner</span>
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
          <div class="font-bold">Gagal Menyimpan Data Media Partner:</div>
          <ul class="list-disc list-inside">
            @foreach ($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-7 flex flex-col sm:flex-row sm:items-center justify-between gap-5 shadow-2xs">
      <div class="flex flex-col gap-1">
        <div class="flex items-center gap-2.5">
          <h1 class="text-xl sm:text-2xl font-bold text-slate-900 font-['Poppins']">Master Data Media Partner</h1>
          <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
            {{ $mediaPartners->total() }} Mitra
          </span>
        </div>
        <p class="text-xs text-slate-500 leading-relaxed">
          Daftar lembaga, himpunan mahasiswa, dan organisasi partner kerja sama publikasi kegiatan.
        </p>
      </div>

      <div class="flex items-center gap-3 shrink-0">
        <button type="button" onclick="openCreateMediaPartnerModal()" class="px-4 py-2.5 bg-blue-950 text-white rounded-xl text-xs font-semibold hover:bg-blue-900 transition flex items-center gap-2 shadow-xs cursor-pointer">
          <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
          </svg>
          <span>Tambah Media Partner</span>
        </button>
      </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-5 shadow-2xs">
      <form method="GET" action="{{ route('organizer.media_partners.index') }}" class="flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
        <div class="w-full sm:flex-1 relative">
          <svg class="size-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/>
            <path d="m21 21-4.3-4.3"/>
          </svg>
          <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama partner atau institusi..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 outline-none focus:border-blue-950 focus:bg-white transition">
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto">
          <button type="submit" class="px-4 py-2.5 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold transition cursor-pointer shadow-2xs">
            Cari
          </button>
          @if(request('q'))
            <a href="{{ route('organizer.media_partners.index') }}" class="px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-600 hover:bg-slate-50 transition">
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
            <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-600 font-semibold uppercase tracking-wider text-[11px]">
              <th class="py-4 px-6">Nama Media Partner</th>
              <th class="py-4 px-6">Lembaga / Instansi</th>
              <th class="py-4 px-6">Kontak Email</th>
              <th class="py-4 px-6 text-center">Jumlah Acara</th>
              <th class="py-4 px-6 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 font-normal text-slate-800">
            @forelse($mediaPartners as $mp)
              <tr class="hover:bg-slate-50/60 transition">
                <td class="py-4 px-6">
                  <div class="flex items-center gap-3">
                    <div class="size-10 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center shrink-0">
                      @if($mp->logo)
                        <img src="{{ asset($mp->logo) }}" alt="{{ $mp->name }}" class="size-full object-contain p-1">
                      @else
                        <span class="font-bold text-xs text-slate-400 uppercase">{{ substr($mp->name, 0, 2) }}</span>
                      @endif
                    </div>
                    <div>
                      <div class="flex items-center gap-1.5">
                        <span class="font-semibold text-slate-900 text-sm">{{ $mp->name }}</span>
                        @if($mp->website_url)
                          <a href="{{ $mp->website_url }}" target="_blank" rel="noopener noreferrer" class="text-blue-900 hover:text-blue-700" title="Buka tautan website/sosial media: {{ $mp->website_url }}">
                            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                              <path d="M15 3h6v6"/>
                              <path d="M10 14 21 3"/>
                              <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                            </svg>
                          </a>
                        @endif
                      </div>
                      <div class="text-[11px] text-slate-400 font-mono mt-0.5">{{ $mp->slug }}</div>
                    </div>
                  </div>
                </td>
                <td class="py-4 px-6">
                  <span class="text-slate-600 font-medium">{{ $mp->institution ?? '—' }}</span>
                </td>
                <td class="py-4 px-6">
                  <span class="text-slate-500 font-mono">{{ $mp->contact_email ?? '—' }}</span>
                </td>
                <td class="py-4 px-6 text-center">
                  <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                    {{ $mp->events_count }} Acara
                  </span>
                </td>
                <td class="py-4 px-6 text-right">
                  <div class="flex items-center justify-end gap-1.5">
                    <button type="button" onclick="openEditMediaPartnerModal({{ json_encode($mp) }})" class="p-2 text-slate-600 hover:text-blue-950 hover:bg-blue-50 rounded-lg transition cursor-pointer" title="Edit Media Partner">
                      <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                      </svg>
                    </button>
                    <form method="POST" action="{{ route('organizer.media_partners.destroy', $mp->id) }}" onsubmit="return confirm('Hapus media partner {{ $mp->name }}? Kegiatan yang terhubung tidak akan terhapus.');" class="inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition cursor-pointer" title="Hapus Media Partner">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <path d="M3 6h18"/>
                          <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                          <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                        </svg>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="py-12 text-center text-slate-400">
                  Belum ada data media partner yang terdaftar.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($mediaPartners->hasPages())
        <div class="p-4 border-t border-slate-200">
          {{ $mediaPartners->links() }}
        </div>
      @endif
    </div>
  </main>
</div>

<!-- Modal Tambah Media Partner -->
<div id="modal-create-media-partner" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs hidden items-center justify-center p-4">
  <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 flex flex-col gap-6 shadow-2xl">
    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
      <h3 class="text-base font-bold text-slate-900">Tambah Media Partner Baru</h3>
      <button type="button" onclick="closeCreateMediaPartnerModal()" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition cursor-pointer">
        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"/>
          <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>

    <form action="{{ route('organizer.media_partners.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4 text-xs">
      @csrf
      <div class="flex flex-col gap-1.5">
        <label class="font-semibold text-slate-700">Nama Media Partner <span class="text-rose-500">*</span></label>
        <input type="text" name="name" required placeholder="Contoh: Himpunan Mahasiswa Sistem Informasi" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
      </div>

      <div class="flex flex-col gap-1.5">
        <label class="font-semibold text-slate-700">Logo Media Partner</label>
        <input type="file" name="logo" accept="image/png,image/jpeg,image/webp,image/svg+xml" class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition text-xs file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-950 hover:file:bg-blue-100 cursor-pointer">
        <span class="text-[10px] text-slate-400">Format: PNG, JPG, WebP, SVG (Maks. 2MB). Rekomendasi rasio persegi atau horizontal transparan.</span>
      </div>

      <div class="flex flex-col gap-1.5">
        <label class="font-semibold text-slate-700">Lembaga / Instansi</label>
        <input type="text" name="institution" placeholder="Contoh: Fakultas Teknologi Informasi" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
      </div>

      <div class="flex flex-col gap-1.5">
        <label class="font-semibold text-slate-700">Tautan Web / Media Sosial</label>
        <input type="url" name="website_url" placeholder="Contoh: https://instagram.com/hmsi_kampus" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
        <span class="text-[10px] text-slate-400">Opsional. Gunakan tautan lengkap berawalan https://</span>
      </div>

      <div class="flex flex-col gap-1.5">
        <label class="font-semibold text-slate-700">Kontak Email <span class="text-rose-500">*</span></label>
        <input type="email" name="contact_email" required placeholder="Contoh: hmsi@kampus.ac.id" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
      </div>

      <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
        <button type="button" onclick="closeCreateMediaPartnerModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-medium transition cursor-pointer">
          Batal
        </button>
        <button type="submit" class="px-5 py-2.5 bg-blue-950 hover:bg-blue-900 text-white rounded-xl font-semibold shadow-xs transition cursor-pointer">
          Simpan Media Partner
        </button>
      </div>
    </form>
  </div>
</div>

<div id="modal-edit-media-partner" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs hidden items-center justify-center p-4">
  <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 flex flex-col gap-6 shadow-2xl">
    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
      <h3 class="text-base font-bold text-slate-900">Perbarui Media Partner</h3>
      <button type="button" onclick="closeEditMediaPartnerModal()" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition cursor-pointer">
        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"/>
          <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>

    <form id="edit-media-partner-form" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4 text-xs">
      @csrf
      @method('PUT')
      <div class="flex flex-col gap-1.5">
        <label class="font-semibold text-slate-700">Nama Media Partner <span class="text-rose-500">*</span></label>
        <input type="text" id="edit-name" name="name" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
      </div>

      <div class="flex flex-col gap-1.5">
        <label class="font-semibold text-slate-700">Logo Media Partner</label>
        <div id="edit-logo-preview-container" class="hidden items-center gap-3 p-2 bg-slate-50 border border-slate-200 rounded-xl mb-1">
          <img id="edit-logo-preview" src="" alt="Logo" class="size-10 object-contain rounded-lg border border-slate-200 bg-white p-1">
          <span class="text-[11px] text-slate-500">Logo saat ini. Unggah file baru untuk mengganti.</span>
        </div>
        <input type="file" name="logo" accept="image/png,image/jpeg,image/webp,image/svg+xml" class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition text-xs file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-950 hover:file:bg-blue-100 cursor-pointer">
        <span class="text-[10px] text-slate-400">Kosongkan jika tidak ingin mengubah logo. Format: PNG, JPG, WebP, SVG (Maks. 2MB).</span>
      </div>

      <div class="flex flex-col gap-1.5">
        <label class="font-semibold text-slate-700">Lembaga / Instansi</label>
        <input type="text" id="edit-institution" name="institution" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
      </div>

      <div class="flex flex-col gap-1.5">
        <label class="font-semibold text-slate-700">Tautan Web / Media Sosial</label>
        <input type="url" id="edit-website-url" name="website_url" placeholder="Contoh: https://instagram.com/hmsi_kampus" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
        <span class="text-[10px] text-slate-400">Opsional. Gunakan tautan lengkap berawalan https://</span>
      </div>

      <div class="flex flex-col gap-1.5">
        <label class="font-semibold text-slate-700">Kontak Email <span class="text-rose-500">*</span></label>
        <input type="email" id="edit-contact-email" name="contact_email" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 focus:bg-white transition">
      </div>

      <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
        <button type="button" onclick="closeEditMediaPartnerModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-medium transition cursor-pointer">
          Batal
        </button>
        <button type="submit" class="px-5 py-2.5 bg-blue-950 hover:bg-blue-900 text-white rounded-xl font-semibold shadow-xs transition cursor-pointer">
          Perbarui Data
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function openCreateMediaPartnerModal() {
  const m = document.getElementById('modal-create-media-partner');
  m.classList.remove('hidden');
  m.classList.add('flex');
}

function closeCreateMediaPartnerModal() {
  const m = document.getElementById('modal-create-media-partner');
  m.classList.add('hidden');
  m.classList.remove('flex');
}

function openEditMediaPartnerModal(mp) {
  const m = document.getElementById('modal-edit-media-partner');
  const form = document.getElementById('edit-media-partner-form');
  form.action = `/penyelenggara/media-partner/${mp.id}`;
  document.getElementById('edit-name').value = mp.name || '';
  document.getElementById('edit-institution').value = mp.institution || '';
  document.getElementById('edit-website-url').value = mp.website_url || '';
  document.getElementById('edit-contact-email').value = mp.contact_email || '';

  const previewContainer = document.getElementById('edit-logo-preview-container');
  const previewImg = document.getElementById('edit-logo-preview');
  if (mp.logo) {
    previewImg.src = '/' + mp.logo.replace(/^\//, '');
    previewContainer.classList.remove('hidden');
    previewContainer.classList.add('flex');
  } else {
    previewContainer.classList.add('hidden');
    previewContainer.classList.remove('flex');
  }

  m.classList.remove('hidden');
  m.classList.add('flex');
}

function closeEditMediaPartnerModal() {
  const m = document.getElementById('modal-edit-media-partner');
  m.classList.add('hidden');
  m.classList.remove('flex');
}
</script>
@endsection

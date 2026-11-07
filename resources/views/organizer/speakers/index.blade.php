@extends('layouts.app')

@section('title', 'Pengisi Acara — Eventict Lab ICT')

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

  <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col gap-6">
    <div class="flex items-center gap-2 text-xs text-slate-500">
      <a href="{{ route('organizer.dashboard') }}" class="hover:text-blue-950 font-medium">Portal Pengelola</a>
      <span>/</span>
      <span class="text-slate-900 font-semibold">Pengisi Acara</span>
    </div>

    @if (session('success'))
      <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start gap-3 text-xs text-emerald-800">
        <svg class="size-4 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="20 6 9 17 4 12"/>
        </svg>
        <div class="font-medium">{{ session('success') }}</div>
      </div>
    @endif

    @if (session('warning'))
      <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl flex items-start gap-3 text-xs text-amber-800">
        <svg class="size-4 text-amber-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/>
          <line x1="12" y1="8" x2="12" y2="12"/>
          <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <div class="font-medium">{{ session('warning') }}</div>
      </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-xs">
      <div class="flex flex-col gap-1">
        <h1 class="text-lg sm:text-xl font-bold text-slate-900">Data Pengisi Acara & Praktisi</h1>
        <p class="text-xs text-slate-500 leading-relaxed max-w-2xl">
          Katalog instruktur pelatihan, pembicara seminar, dan dosen pengampu Lab ICT.
        </p>
      </div>

      <div class="flex items-center gap-3 shrink-0">
        <button type="button" onclick="openCreateSpeakerModal()" class="px-4 py-2.5 bg-blue-950 text-white rounded-xl text-xs font-semibold hover:bg-blue-900 transition flex items-center gap-2 shadow-xs cursor-pointer">
          <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
          </svg>
          <span>Tambah Pengisi Acara Baru</span>
        </button>
      </div>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <span class="text-xs font-semibold text-slate-600">Total Terdaftar: {{ $speakers->count() }} Pengisi Acara</span>

      <form method="GET" action="{{ route('organizer.speakers.index') }}" class="flex items-center gap-2 max-w-sm w-full">
        <div class="relative w-full">
          <svg class="size-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/>
            <path d="m21 21-4.3-4.3"/>
          </svg>
          <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, gelar, atau instansi..." class="w-full pl-9 pr-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 outline-none focus:border-blue-950 shadow-2xs">
        </div>
        <button type="submit" class="px-3 py-2 bg-slate-900 text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition cursor-pointer">
          Cari
        </button>
      </form>
    </div>

    @if($speakers->isEmpty())
      <div class="p-12 bg-white rounded-2xl border border-slate-200 text-center flex flex-col items-center justify-center gap-3">
        <div class="size-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center">
          <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
        </div>
        <h3 class="text-sm font-semibold text-slate-900">Belum Ada Data Pengisi Acara</h3>
        <p class="text-xs text-slate-500 max-w-md">Tambahkan pembicara atau instruktur pertama untuk mulai menugaskannya ke kegiatan.</p>
        <button type="button" onclick="openCreateSpeakerModal()" class="mt-2 px-4 py-2 bg-blue-950 text-white rounded-lg text-xs font-semibold hover:bg-blue-900 transition">
          Tambah Pengisi Acara
        </button>
      </div>
    @else
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($speakers as $spk)
          <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between gap-5 hover:border-blue-900 transition shadow-2xs">
            <div class="flex flex-col gap-3">
              <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-3">
                  <div class="size-12 rounded-xl bg-blue-50 border border-blue-100 text-blue-950 font-bold text-sm flex items-center justify-center shrink-0">
                    {{ strtoupper(substr($spk->name, 0, 2)) }}
                  </div>
                  <div class="flex flex-col min-w-0">
                    <h3 class="text-sm font-semibold text-slate-900 leading-snug">{{ $spk->name }}</h3>
                    @if($spk->title_degree)
                      <span class="text-slate-500 text-[11px] font-medium">{{ $spk->title_degree }}</span>
                    @endif
                  </div>
                </div>

                <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-blue-50 text-blue-950 border border-blue-200 shrink-0">
                  {{ $spk->events_count }} Kegiatan
                </span>
              </div>

              <div class="text-xs text-slate-600 flex items-center gap-1.5">
                <svg class="size-3.5 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/>
                  <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/>
                  <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/>
                  <path d="M10 6h4"/>
                  <path d="M10 10h4"/>
                  <path d="M10 14h4"/>
                  <path d="M10 18h4"/>
                </svg>
                <span class="truncate">{{ $spk->institution ?? 'Laboratorium ICT' }}</span>
              </div>

              @if($spk->bio)
                <p class="text-xs text-slate-500 leading-relaxed line-clamp-2 mt-1">
                  {{ $spk->bio }}
                </p>
              @endif

              @if($spk->events->isNotEmpty())
                <div class="pt-3 border-t border-slate-100 flex flex-col gap-1.5">
                  <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Kegiatan yang Diampu:</span>
                  <div class="flex flex-col gap-1">
                    @foreach($spk->events->take(2) as $ev)
                      <a href="{{ route('organizer.workspace', ['event' => $ev->id]) }}" class="text-xs text-slate-700 hover:text-blue-950 hover:underline flex items-center gap-1.5 truncate">
                        <span class="size-1.5 rounded-full bg-blue-950 shrink-0"></span>
                        <span class="truncate">{{ $ev->title }}</span>
                      </a>
                    @endforeach
                    @if($spk->events->count() > 2)
                      <span class="text-[10px] text-slate-400 italic">+ {{ $spk->events->count() - 2 }} kegiatan lainnya</span>
                    @endif
                  </div>
                </div>
              @endif
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
              <button type="button" onclick="openEditSpeakerModal({{ json_encode($spk) }})" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer flex items-center gap-1.5">
                <svg class="size-3.5 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                </svg>
                <span>Edit Profil</span>
              </button>

              <form method="POST" action="{{ route('organizer.speakers.destroy', ['speaker' => $spk->id]) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengisi acara ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 transition cursor-pointer" title="Hapus">
                  <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 6h18"/>
                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                  </svg>
                </button>
              </form>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </main>

  <div id="modal-create-speaker" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 sm:p-8 flex flex-col gap-6 shadow-2xl">
      <div class="flex items-start justify-between gap-4 pb-4 border-b border-slate-100">
        <div class="flex flex-col">
          <h2 class="text-base sm:text-lg font-bold text-slate-900">Tambah Pengisi Acara Baru</h2>
          <p class="text-xs text-slate-500 mt-0.5">Daftarkan pengisi acara untuk ditugaskan ke berbagai kegiatan.</p>
        </div>
        <button type="button" onclick="closeCreateSpeakerModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 cursor-pointer">
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>

      <form action="{{ route('organizer.speakers.store') }}" method="POST" class="flex flex-col gap-4 text-xs">
        @csrf
        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Nama Lengkap (Beserta Gelar)</label>
          <input type="text" name="name" required placeholder="Contoh: Dr. Ir. Budi Santoso, M.Kom" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Sertifikasi / Singkatan Gelar</label>
            <input type="text" name="title_degree" placeholder="Contoh: M.Kom, SMIEEE" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
          </div>
          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Instansi / Perusahaan</label>
            <input type="text" name="institution" placeholder="Contoh: FTI Universitas Budi Luhur" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
          </div>
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">URL Foto Profil (Opsional)</label>
          <input type="url" name="photo_url" placeholder="https://..." class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Bio Singkat & Keahlian</label>
          <textarea name="bio" rows="3" placeholder="Tuliskan bidang keahlian, pengalaman profesional, atau riset..." class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 leading-relaxed"></textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
          <button type="button" onclick="closeCreateSpeakerModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 cursor-pointer">
            Batal
          </button>
          <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-950 hover:bg-blue-900 text-white font-semibold shadow-xs cursor-pointer">
            Simpan ke Master Data
          </button>
        </div>
      </form>
    </div>
  </div>

  <div id="modal-edit-speaker" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 sm:p-8 flex flex-col gap-6 shadow-2xl">
      <div class="flex items-start justify-between gap-4 pb-4 border-b border-slate-100">
        <div class="flex flex-col">
          <h2 class="text-base sm:text-lg font-bold text-slate-900">Perbarui Data Pengisi Acara</h2>
          <p class="text-xs text-slate-500 mt-0.5">Perubahan profil akan terbarui di seluruh kegiatan yang diampunya.</p>
        </div>
        <button type="button" onclick="closeEditSpeakerModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 cursor-pointer">
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>

      <form id="form-edit-speaker" method="POST" class="flex flex-col gap-4 text-xs">
        @csrf
        @method('PUT')
        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Nama Lengkap (Beserta Gelar)</label>
          <input type="text" id="edit-name" name="name" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Sertifikasi / Singkatan Gelar</label>
            <input type="text" id="edit-title-degree" name="title_degree" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
          </div>
          <div class="flex flex-col gap-1.5">
            <label class="font-semibold text-slate-700">Instansi / Perusahaan</label>
            <input type="text" id="edit-institution" name="institution" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
          </div>
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">URL Foto Profil (Opsional)</label>
          <input type="url" id="edit-photo-url" name="photo_url" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950">
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="font-semibold text-slate-700">Bio Singkat & Keahlian</label>
          <textarea id="edit-bio" name="bio" rows="3" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-blue-950 leading-relaxed"></textarea>
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
  document.getElementById('edit-title-degree').value = spk.title_degree || '';
  document.getElementById('edit-institution').value = spk.institution || '';
  document.getElementById('edit-photo-url').value = spk.photo_url || '';
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
@endsection

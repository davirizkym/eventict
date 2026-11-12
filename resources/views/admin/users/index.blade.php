@extends('layouts.app')

@section('title', 'Kelola User — Eventict Administrator')

@section('content')
<div class="min-h-screen bg-slate-50 text-slate-800 antialiased font-['Poppins'] flex flex-col">
  @include('partials.organizer-header')

  <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-24 md:pb-8 flex flex-col gap-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
          <a href="{{ route('organizer.dashboard') }}" class="hover:text-blue-950 font-medium">Dashboard</a>
          <span>/</span>
          <span class="text-slate-900 font-semibold">Kelola User</span>
        </div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Manajemen Pengguna Sistem</h1>
        <p class="text-xs text-slate-500 mt-1">Kelola seluruh hak akses pengguna platform Eventict mulai dari administrator, panitia pelaksana, hingga peserta.</p>
      </div>

      <div class="flex items-center gap-2.5 shrink-0 flex-wrap">
        <a href="{{ route('admin.users.export', request()->query()) }}" class="px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold transition flex items-center justify-center gap-2 shadow-2xs cursor-pointer">
          <svg class="size-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
            <polyline points="7 10 12 15 17 10"/>
            <line x1="12" x2="12" y1="15" y2="3"/>
          </svg>
          <span>Ekspor XLSX</span>
        </a>

        <button type="button" onclick="openAddUserModal()" class="px-4 py-2.5 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold transition flex items-center justify-center gap-2 shadow-2xs cursor-pointer">
          <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <line x1="19" y1="8" x2="19" y2="14"/>
            <line x1="22" y1="11" x2="16" y2="11"/>
          </svg>
          <span>Tambah User Baru</span>
        </button>
      </div>
    </div>

    @if(session('success'))
      <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center justify-between gap-3 text-xs text-emerald-800 shadow-2xs">
        <div class="flex items-center gap-2.5">
          <svg class="size-4 text-emerald-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="20 6 9 17 4 12"/>
          </svg>
          <span class="font-medium">{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold text-base leading-none">&times;</button>
      </div>
    @endif

    @if(session('error'))
      <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl flex items-center justify-between gap-3 text-xs text-rose-800 shadow-2xs">
        <div class="flex items-center gap-2.5">
          <svg class="size-4 text-rose-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
          </svg>
          <span class="font-medium">{{ session('error') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900 font-bold text-base leading-none">&times;</button>
      </div>
    @endif

    @if($errors->any())
      <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl flex flex-col gap-1 text-xs text-rose-800 shadow-2xs">
        <span class="font-bold">Mohon perbaiki kendala berikut:</span>
        <ul class="list-disc list-inside">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="p-4 bg-white rounded-2xl border border-slate-200 flex flex-col gap-1 shadow-2xs">
        <span class="text-slate-400 text-xs font-medium">Total Seluruh User</span>
        <span class="text-2xl font-bold text-slate-900">{{ number_format($totalUsers, 0, ',', '.') }}</span>
        <span class="text-[11px] text-slate-500">Semua entitas akun</span>
      </div>

      <div class="p-4 bg-white rounded-2xl border border-slate-200 flex flex-col gap-1 shadow-2xs">
        <span class="text-purple-600 text-xs font-medium">Administrator</span>
        <span class="text-2xl font-bold text-purple-900">{{ number_format($totalAdmins, 0, ',', '.') }}</span>
        <span class="text-[11px] text-slate-500">Akses penuh sistem</span>
      </div>

      <div class="p-4 bg-white rounded-2xl border border-slate-200 flex flex-col gap-1 shadow-2xs">
        <span class="text-blue-600 text-xs font-medium">Panitia Pelaksana</span>
        <span class="text-2xl font-bold text-blue-900">{{ number_format($totalPanitia, 0, ',', '.') }}</span>
        <span class="text-[11px] text-slate-500">Penyelenggara event</span>
      </div>

      <div class="p-4 bg-white rounded-2xl border border-slate-200 flex flex-col gap-1 shadow-2xs">
        <span class="text-emerald-600 text-xs font-medium">Peserta Kegiatan</span>
        <span class="text-2xl font-bold text-emerald-900">{{ number_format($totalPeserta, 0, ',', '.') }}</span>
        <span class="text-[11px] text-slate-500">Peserta umum & mahasiswa</span>
      </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs p-4 sm:p-5 flex flex-col gap-4">
      <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row items-center justify-between gap-3">
        <div class="w-full md:w-96 relative">
          <svg class="size-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/>
            <path d="m21 21-4.3-4.3"/>
          </svg>
          <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Cari nama, email, NIM/NIP, atau instansi..."
            class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder:text-slate-400 focus:outline-none focus:bg-white focus:border-blue-950 transition"
          >
        </div>

        <div class="flex items-center gap-2 w-full md:w-auto flex-wrap sm:flex-nowrap">
          <select
            name="role"
            onchange="this.form.submit()"
            class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 outline-none focus:border-blue-950 transition cursor-pointer"
          >
            <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>Semua Role</option>
            <option value="administrator" {{ request('role') == 'administrator' ? 'selected' : '' }}>Administrator</option>
            <option value="penyelenggara" {{ request('role') == 'penyelenggara' ? 'selected' : '' }}>Panitia (Penyelenggara)</option>
            <option value="peserta" {{ request('role') == 'peserta' ? 'selected' : '' }}>Peserta</option>
          </select>

          <select
            name="status_email"
            onchange="this.form.submit()"
            class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 outline-none focus:border-blue-950 transition cursor-pointer"
          >
            <option value="all" {{ request('status_email') == 'all' ? 'selected' : '' }}>Semua Status Email</option>
            <option value="verified" {{ request('status_email') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
            <option value="unverified" {{ request('status_email') == 'unverified' ? 'selected' : '' }}>Belum Verifikasi</option>
          </select>

          @if(request()->filled('q') || (request()->filled('role') && request('role') !== 'all') || (request()->filled('status_email') && request('status_email') !== 'all'))
            <a href="{{ route('admin.users.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition" title="Reset Filter">
              Reset
            </a>
          @endif
        </div>
      </form>

      <div class="hidden md:block overflow-x-auto rounded-xl border border-slate-200">
        <table class="w-full text-left text-xs text-slate-700">
          <thead class="bg-slate-50/80 text-[11px] font-semibold uppercase text-slate-500 border-b border-slate-200 tracking-wider">
            <tr>
              <th class="px-4 py-3">Pengguna</th>
              <th class="px-4 py-3">NIM / NIP / NIS</th>
              <th class="px-4 py-3">Role</th>
              <th class="px-4 py-3">Instansi & Kontak</th>
              <th class="px-4 py-3">Status Email</th>
              <th class="px-4 py-3">Terdaftar</th>
              <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            @forelse($users as $u)
              <tr class="hover:bg-slate-50/60 transition {{ $u->id === Auth::id() ? 'bg-purple-50/20' : '' }}">
                <td class="px-4 py-3.5">
                  <div class="flex items-center gap-3">
                    <div class="size-8 rounded-lg flex items-center justify-center font-bold text-xs shrink-0 {{ in_array($u->role, ['administrator', 'admin']) ? 'bg-purple-100 text-purple-900 border border-purple-200' : ($u->role === 'penyelenggara' ? 'bg-blue-100 text-blue-950 border border-blue-200' : 'bg-slate-100 text-slate-700 border border-slate-200') }}">
                      {{ strtoupper(substr($u->name, 0, 2)) }}
                    </div>
                    <div class="flex flex-col min-w-0">
                      <div class="font-semibold text-slate-900 flex items-center gap-1.5 truncate">
                        <span>{{ $u->name }}</span>
                        @if($u->id === Auth::id())
                          <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-purple-100 text-purple-800 border border-purple-200">Anda</span>
                        @endif
                      </div>
                      <span class="text-slate-400 text-[11px] truncate">{{ $u->email }}</span>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-3.5 font-mono text-[11px] text-slate-600">
                  {{ $u->identity_no ?? '-' }}
                </td>
                <td class="px-4 py-3.5 whitespace-nowrap">
                  @if(in_array($u->role, ['administrator', 'admin']))
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-purple-50 text-purple-800 border border-purple-200">
                      Administrator
                    </span>
                  @elseif($u->role === 'penyelenggara')
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-900 border border-blue-200">
                      Panitia
                    </span>
                  @else
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                      Peserta
                    </span>
                  @endif
                </td>
                <td class="px-4 py-3.5">
                  <div class="flex flex-col">
                    <span class="font-medium text-slate-800 truncate max-w-[200px]">{{ $u->institution ?? '—' }}</span>
                    <span class="text-[11px] text-slate-400 font-mono">{{ $u->phone ?? '—' }}</span>
                  </div>
                </td>
                <td class="px-4 py-3.5 whitespace-nowrap">
                  <div class="flex items-center gap-2">
                    @if($u->hasVerifiedEmail())
                      <span class="inline-flex items-center gap-1 text-[11px] font-medium text-emerald-700">
                        <svg class="size-3 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                          <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        <span>Terverifikasi</span>
                      </span>
                    @else
                      <span class="inline-flex items-center gap-1 text-[11px] font-medium text-amber-700">
                        <svg class="size-3 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                          <circle cx="12" cy="12" r="10"/>
                          <line x1="12" y1="8" x2="12" y2="12"/>
                          <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        <span>Belum Verifikasi</span>
                      </span>
                    @endif

                    <div class="inline-flex items-center gap-1">
                      @if(! $u->hasVerifiedEmail())
                        <form method="POST" action="{{ route('admin.users.resend_verification', $u->id) }}" class="inline">
                          @csrf
                          <button type="submit" class="p-1 rounded bg-slate-100 hover:bg-blue-100 text-slate-600 hover:text-blue-900 transition cursor-pointer" title="Kirim ulang tautan verifikasi email">
                            <svg class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                              <rect width="20" height="16" x="2" y="4" rx="2"/>
                              <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                            </svg>
                          </button>
                        </form>
                      @endif

                      <form method="POST" action="{{ route('admin.users.toggle_verify', $u->id) }}" class="inline">
                        @csrf
                        <button type="submit" class="p-1 rounded bg-slate-100 hover:bg-slate-200 text-slate-600 transition cursor-pointer" title="{{ $u->hasVerifiedEmail() ? 'Batalkan status verifikasi' : 'Tandai terverifikasi manual' }}">
                          <svg class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 6 9 17l-5-5"/>
                          </svg>
                        </button>
                      </form>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-3.5 whitespace-nowrap text-slate-500 text-[11px]">
                  {{ $u->created_at ? $u->created_at->format('d/m/Y') : '—' }}
                </td>
                <td class="px-4 py-3.5 whitespace-nowrap text-right">
                  <div class="inline-flex items-center gap-1.5">
                    <button
                      type="button"
                      onclick="openEditUserModal({{ json_encode([
                        'id' => $u->id,
                        'name' => $u->name,
                        'email' => $u->email,
                        'identity_no' => $u->identity_no,
                        'role' => $u->role,
                        'institution' => $u->institution,
                        'phone' => $u->phone,
                        'is_verified' => $u->hasVerifiedEmail(),
                        'is_self' => ($u->id === Auth::id()),
                      ]) }})"
                      class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-[11px] font-semibold transition cursor-pointer"
                      title="Edit Pengguna"
                    >
                      Edit
                    </button>

                    @if($u->id === Auth::id())
                      <button
                        type="button"
                        disabled
                        class="px-2.5 py-1.5 bg-slate-100 text-slate-300 rounded-lg text-[11px] font-semibold cursor-not-allowed"
                        title="Anda tidak dapat menghapus akun Anda sendiri"
                      >
                        Hapus
                      </button>
                    @else
                      <button
                        type="button"
                        onclick="openDeleteUserModal({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ $u->role }}')"
                        class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-lg text-[11px] font-semibold transition cursor-pointer"
                        title="Hapus Pengguna"
                      >
                        Hapus
                      </button>
                    @endif
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="px-4 py-12 text-center text-slate-400">
                  <svg class="size-8 mx-auto mb-2 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M16 16s-1.5-2-4-2-4 2-4 2"/>
                    <line x1="9" y1="9" x2="9.01" y2="9"/>
                    <line x1="15" y1="9" x2="15.01" y2="9"/>
                  </svg>
                  <span>Tidak ada data pengguna yang sesuai dengan pencarian atau filter.</span>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="md:hidden flex flex-col gap-3.5">
        @forelse($users as $u)
          <div class="p-5 bg-white rounded-2xl border border-slate-200 flex flex-col gap-3.5 shadow-2xs {{ $u->id === Auth::id() ? 'ring-1 ring-purple-200' : '' }}">
            <div class="flex items-start justify-between gap-2">
              <div class="flex items-center gap-3 min-w-0">
                <div class="size-10 rounded-xl flex items-center justify-center font-bold text-xs shrink-0 {{ in_array($u->role, ['administrator', 'admin']) ? 'bg-purple-100 text-purple-900 border border-purple-200' : ($u->role === 'penyelenggara' ? 'bg-blue-100 text-blue-950 border border-blue-200' : 'bg-slate-100 text-slate-700 border border-slate-200') }}">
                  {{ strtoupper(substr($u->name, 0, 2)) }}
                </div>
                <div class="flex flex-col min-w-0">
                  <div class="flex items-center gap-1.5">
                    <span class="font-bold text-slate-900 text-sm truncate">{{ $u->name }}</span>
                    @if($u->id === Auth::id())
                      <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-purple-100 text-purple-800 border border-purple-200 shrink-0">Anda</span>
                    @endif
                  </div>
                  <span class="text-xs text-slate-500 truncate">{{ $u->email }}</span>
                </div>
              </div>

              <div class="flex items-center gap-1 shrink-0">
                @if(in_array($u->role, ['administrator', 'admin']))
                  <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-purple-50 text-purple-800 border border-purple-200">
                    Administrator
                  </span>
                @elseif($u->role === 'penyelenggara')
                  <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-blue-50 text-blue-900 border border-blue-200">
                    Panitia
                  </span>
                @else
                  <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                    Peserta
                  </span>
                @endif
              </div>
            </div>

            <div class="grid grid-cols-1 gap-2 pt-2 border-t border-slate-100 text-xs">
              <div class="flex items-center justify-between gap-2">
                <span class="text-[11px] text-slate-400 font-medium">NIM / NIP / NIS:</span>
                <span class="text-slate-700 font-mono text-[11px] font-medium">{{ $u->identity_no ?? '-' }}</span>
              </div>
              <div class="flex items-center justify-between gap-2">
                <span class="text-[11px] text-slate-400 font-medium">Instansi:</span>
                <span class="text-slate-700 font-medium truncate">{{ $u->institution ?? '—' }}</span>
              </div>
              <div class="flex items-center justify-between gap-2">
                <span class="text-[11px] text-slate-400 font-medium">Telepon:</span>
                <span class="text-slate-600 font-mono text-[11px]">{{ $u->phone ?? '—' }}</span>
              </div>
              <div class="flex items-center justify-between gap-2">
                <span class="text-[11px] text-slate-400 font-medium">Status Email:</span>
                @if($u->hasVerifiedEmail())
                  <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700">
                    <svg class="size-3 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                      <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Terverifikasi</span>
                  </span>
                @else
                  <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-amber-700">
                    <svg class="size-3 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                      <circle cx="12" cy="12" r="10"/>
                      <line x1="12" y1="8" x2="12" y2="12"/>
                      <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <span>Belum Verifikasi</span>
                  </span>
                @endif
              </div>
              <div class="flex items-center justify-between gap-2">
                <span class="text-[11px] text-slate-400 font-medium">Terdaftar:</span>
                <span class="text-slate-500 text-[11px]">{{ $u->created_at ? $u->created_at->format('d/m/Y') : '—' }}</span>
              </div>
            </div>

            <div class="flex items-center justify-between gap-2 pt-3 border-t border-slate-100">
              <div class="flex items-center gap-1">
                @if(! $u->hasVerifiedEmail())
                  <form method="POST" action="{{ route('admin.users.resend_verification', $u->id) }}" class="inline">
                    @csrf
                    <button type="submit" class="p-1.5 rounded-lg bg-slate-100 hover:bg-blue-100 text-slate-600 hover:text-blue-900 transition cursor-pointer" title="Kirim ulang verifikasi email">
                      <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="20" height="16" x="2" y="4" rx="2"/>
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                      </svg>
                    </button>
                  </form>
                @endif
                <form method="POST" action="{{ route('admin.users.toggle_verify', $u->id) }}" class="inline">
                  @csrf
                  <button type="submit" class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition cursor-pointer" title="{{ $u->hasVerifiedEmail() ? 'Batalkan status verifikasi' : 'Tandai terverifikasi manual' }}">
                    <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M20 6 9 17l-5-5"/>
                    </svg>
                  </button>
                </form>
              </div>

              <div class="flex items-center gap-2">
                <button
                  type="button"
                  onclick="openEditUserModal({{ json_encode([
                    'id' => $u->id,
                    'name' => $u->name,
                    'email' => $u->email,
                    'identity_no' => $u->identity_no,
                    'role' => $u->role,
                    'institution' => $u->institution,
                    'phone' => $u->phone,
                    'is_verified' => $u->hasVerifiedEmail(),
                    'is_self' => ($u->id === Auth::id()),
                  ]) }})"
                  class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition cursor-pointer"
                >
                  Edit
                </button>

                @if($u->id === Auth::id())
                  <button
                    type="button"
                    disabled
                    class="px-3 py-1.5 bg-slate-100 text-slate-300 rounded-lg text-xs font-semibold cursor-not-allowed"
                  >
                    Hapus
                  </button>
                @else
                  <button
                    type="button"
                    onclick="openDeleteUserModal({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ $u->role }}')"
                    class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-lg text-xs font-semibold transition cursor-pointer"
                  >
                    Hapus
                  </button>
                @endif
              </div>
            </div>
          </div>
        @empty
          <div class="p-8 text-center text-slate-400 text-xs bg-white rounded-xl border border-slate-200">
            Tidak ada data pengguna yang sesuai dengan pencarian atau filter.
          </div>
        @endforelse
      </div>

      <div class="mt-2">
        {{ $users->links() }}
      </div>
    </div>
  </main>
</div>

<div id="modal-add-user" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
  <div class="bg-white rounded-3xl border border-slate-200 max-w-lg w-full p-6 sm:p-7 flex flex-col gap-5 shadow-xl max-h-[90vh] overflow-y-auto">
    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
      <div class="flex items-center gap-2.5">
        <div class="size-8 rounded-lg bg-blue-50 text-blue-950 flex items-center justify-center font-bold text-xs">
          <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <line x1="19" y1="8" x2="19" y2="14"/>
            <line x1="22" y1="11" x2="16" y2="11"/>
          </svg>
        </div>
        <h3 class="text-base font-bold text-slate-900">Tambah Pengguna Baru</h3>
      </div>
      <button type="button" onclick="closeAddUserModal()" class="text-slate-400 hover:text-slate-700 text-lg leading-none cursor-pointer">&times;</button>
    </div>

    <form method="POST" action="{{ route('admin.users.store') }}" class="flex flex-col gap-4 text-xs font-['Poppins']">
      @csrf

      <div class="flex flex-col gap-1.5">
        <label for="add-name" class="font-semibold text-slate-700">Nama Lengkap <span class="text-rose-500">*</span></label>
        <input type="text" id="add-name" name="name" required placeholder="Contoh: Budi Santoso, M.Kom" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-950 focus:bg-white transition">
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div class="flex flex-col gap-1.5">
          <label for="add-email" class="font-semibold text-slate-700">Alamat Email <span class="text-rose-500">*</span></label>
          <input type="email" id="add-email" name="email" required placeholder="budi@example.com" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-950 focus:bg-white transition">
        </div>

        <div class="flex flex-col gap-1.5">
          <label for="add-identity" class="font-semibold text-slate-700">NIM / NIP / NIS <span class="text-rose-500">*</span></label>
          <input type="text" id="add-identity" name="identity_no" required maxlength="20" placeholder="Contoh: 2210511001" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 font-mono focus:outline-none focus:border-blue-950 focus:bg-white transition">
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div class="flex flex-col gap-1.5">
          <label for="add-role" class="font-semibold text-slate-700">Role Akun <span class="text-rose-500">*</span></label>
          <select id="add-role" name="role" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-950 focus:bg-white transition cursor-pointer">
            <option value="peserta">Peserta</option>
            <option value="penyelenggara">Panitia (Penyelenggara)</option>
            <option value="administrator">Administrator</option>
          </select>
        </div>

        <div class="flex flex-col gap-1.5">
          <label for="add-phone" class="font-semibold text-slate-700">Nomor WhatsApp / HP</label>
          <input type="text" id="add-phone" name="phone" placeholder="Contoh: 08123456789" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-950 focus:bg-white transition">
        </div>
      </div>

      <div class="flex flex-col gap-1.5">
        <label for="add-institution" class="font-semibold text-slate-700">Asal Instansi / Universitas / Perusahaan</label>
        <input type="text" id="add-institution" name="institution" placeholder="Contoh: Universitas Budi Luhur" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-950 focus:bg-white transition">
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div class="flex flex-col gap-1.5">
          <label for="add-password" class="font-semibold text-slate-700">Kata Sandi <span class="text-rose-500">*</span></label>
          <input type="password" id="add-password" name="password" required minlength="8" placeholder="Minimal 8 karakter" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-950 focus:bg-white transition">
        </div>

        <div class="flex flex-col gap-1.5">
          <label for="add-password-confirmation" class="font-semibold text-slate-700">Konfirmasi Kata Sandi <span class="text-rose-500">*</span></label>
          <input type="password" id="add-password-confirmation" name="password_confirmation" required minlength="8" placeholder="Ketik ulang kata sandi" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-950 focus:bg-white transition">
        </div>
      </div>

      <div class="flex items-center gap-2 pt-1">
        <input type="checkbox" id="add-is-verified" name="is_verified" value="1" checked class="size-4 rounded text-blue-950 focus:ring-blue-950">
        <label for="add-is-verified" class="text-xs text-slate-600 font-medium">Tandai alamat email langsung terverifikasi aktif</label>
      </div>

      <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
        <button type="button" onclick="closeAddUserModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition cursor-pointer">Batal</button>
        <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-950 hover:bg-blue-900 text-xs font-semibold text-white transition shadow-2xs cursor-pointer">Simpan Pengguna</button>
      </div>
    </form>
  </div>
</div>

<div id="modal-edit-user" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
  <div class="bg-white rounded-3xl border border-slate-200 max-w-lg w-full p-6 sm:p-7 flex flex-col gap-5 shadow-xl max-h-[90vh] overflow-y-auto">
    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
      <div class="flex items-center gap-2.5">
        <div class="size-8 rounded-lg bg-blue-50 text-blue-950 flex items-center justify-center font-bold text-xs">
          <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 20h9"/>
            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
          </svg>
        </div>
        <h3 class="text-base font-bold text-slate-900">Perbarui Data Pengguna</h3>
      </div>
      <button type="button" onclick="closeEditUserModal()" class="text-slate-400 hover:text-slate-700 text-lg leading-none cursor-pointer">&times;</button>
    </div>

    <form id="edit-user-form" method="POST" action="" class="flex flex-col gap-4 text-xs font-['Poppins']">
      @csrf
      @method('PUT')

      <div class="flex flex-col gap-1.5">
        <label for="edit-name" class="font-semibold text-slate-700">Nama Lengkap <span class="text-rose-500">*</span></label>
        <input type="text" id="edit-name" name="name" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-950 focus:bg-white transition">
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div class="flex flex-col gap-1.5">
          <label for="edit-email" class="font-semibold text-slate-700">Alamat Email <span class="text-rose-500">*</span></label>
          <input type="email" id="edit-email" name="email" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-950 focus:bg-white transition">
        </div>

        <div class="flex flex-col gap-1.5">
          <label for="edit-identity" class="font-semibold text-slate-700">NIM / NIP / NIS <span class="text-rose-500">*</span></label>
          <input type="text" id="edit-identity" name="identity_no" required maxlength="20" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 font-mono focus:outline-none focus:border-blue-950 focus:bg-white transition">
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div class="flex flex-col gap-1.5">
          <label for="edit-role" class="font-semibold text-slate-700">Role Akun <span class="text-rose-500">*</span></label>
          <select id="edit-role" name="role" required class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-950 focus:bg-white transition cursor-pointer">
            <option value="peserta">Peserta</option>
            <option value="penyelenggara">Panitia (Penyelenggara)</option>
            <option value="administrator">Administrator</option>
          </select>
          <span id="edit-role-note" class="text-[10px] text-amber-600 hidden font-medium">Akun Anda saat ini (role administrator terkunci)</span>
        </div>

        <div class="flex flex-col gap-1.5">
          <label for="edit-phone" class="font-semibold text-slate-700">Nomor WhatsApp / HP</label>
          <input type="text" id="edit-phone" name="phone" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-950 focus:bg-white transition">
        </div>
      </div>

      <div class="flex flex-col gap-1.5">
        <label for="edit-institution" class="font-semibold text-slate-700">Asal Instansi / Universitas / Perusahaan</label>
        <input type="text" id="edit-institution" name="institution" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-950 focus:bg-white transition">
      </div>

      <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex flex-col gap-2">
        <span class="font-semibold text-slate-700 text-[11px]">Ubah Kata Sandi (Kosongkan jika tidak ingin mengubah)</span>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
          <input type="password" name="password" minlength="8" placeholder="Kata sandi baru" class="px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs text-slate-900 focus:outline-none focus:border-blue-950">
          <input type="password" name="password_confirmation" minlength="8" placeholder="Ulangi kata sandi" class="px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs text-slate-900 focus:outline-none focus:border-blue-950">
        </div>
      </div>

      <div class="flex items-center gap-2 pt-1">
        <input type="checkbox" id="edit-is-verified" name="is_verified" value="1" class="size-4 rounded text-blue-950 focus:ring-blue-950">
        <label for="edit-is-verified" class="text-xs text-slate-600 font-medium">Status email terverifikasi aktif</label>
      </div>

      <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
        <button type="button" onclick="closeEditUserModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition cursor-pointer">Batal</button>
        <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-950 hover:bg-blue-900 text-xs font-semibold text-white transition shadow-2xs cursor-pointer">Perbarui Pengguna</button>
      </div>
    </form>
  </div>
</div>

<div id="modal-delete-user" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
  <div class="bg-white rounded-3xl border border-slate-200 max-w-md w-full p-6 sm:p-7 flex flex-col gap-5 shadow-xl">
    <div class="flex items-center gap-3">
      <div class="size-10 rounded-2xl bg-rose-50 border border-rose-200 text-rose-600 flex items-center justify-center shrink-0">
        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M3 6h18"/>
          <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/>
          <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
        </svg>
      </div>
      <div>
        <h3 class="text-base font-bold text-slate-900">Konfirmasi Hapus Pengguna</h3>
        <p class="text-xs text-slate-500">Tindakan ini permanen dan tidak dapat dibatalkan.</p>
      </div>
    </div>

    <p class="text-xs text-slate-600 leading-relaxed">
      Apakah Anda yakin ingin menghapus akun <strong id="delete-user-name" class="text-slate-900"></strong> (<span id="delete-user-role" class="font-medium text-slate-700"></span>)? Seluruh riwayat registrasi dan sertifikat terkait akan ikut terhapus.
    </p>

    <form id="delete-user-form" method="POST" action="" class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
      @csrf
      @method('DELETE')
      <button type="button" onclick="closeDeleteUserModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition cursor-pointer">Batal</button>
      <button type="submit" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-xs font-semibold text-white transition shadow-2xs cursor-pointer">Ya, Hapus Pengguna</button>
    </form>
  </div>
</div>

<script>
function openAddUserModal() {
  const modal = document.getElementById('modal-add-user');
  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closeAddUserModal() {
  const modal = document.getElementById('modal-add-user');
  modal.classList.add('hidden');
  modal.classList.remove('flex');
}

function openEditUserModal(data) {
  const form = document.getElementById('edit-user-form');
  form.action = '/penyelenggara/users/' + data.id;

  document.getElementById('edit-name').value = data.name || '';
  document.getElementById('edit-email').value = data.email || '';
  document.getElementById('edit-identity').value = data.identity_no || '';
  document.getElementById('edit-role').value = data.role || 'peserta';
  document.getElementById('edit-institution').value = data.institution || '';
  document.getElementById('edit-phone').value = data.phone || '';
  document.getElementById('edit-is-verified').checked = !!data.is_verified;

  const roleSelect = document.getElementById('edit-role');
  const roleNote = document.getElementById('edit-role-note');
  if (data.is_self) {
    roleSelect.disabled = true;
    roleNote.classList.remove('hidden');
  } else {
    roleSelect.disabled = false;
    roleNote.classList.add('hidden');
  }

  const modal = document.getElementById('modal-edit-user');
  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closeEditUserModal() {
  const modal = document.getElementById('modal-edit-user');
  modal.classList.add('hidden');
  modal.classList.remove('flex');
}

function openDeleteUserModal(id, name, role) {
  const form = document.getElementById('delete-user-form');
  form.action = '/penyelenggara/users/' + id;
  document.getElementById('delete-user-name').textContent = name;
  document.getElementById('delete-user-role').textContent = role;

  const modal = document.getElementById('modal-delete-user');
  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closeDeleteUserModal() {
  const modal = document.getElementById('modal-delete-user');
  modal.classList.add('hidden');
  modal.classList.remove('flex');
}

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeAddUserModal();
    closeEditUserModal();
    closeDeleteUserModal();
  }
});
</script>

@include('partials.organizer-bottom-nav')
@endsection

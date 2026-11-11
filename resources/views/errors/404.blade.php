<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 — Halaman Tidak Ditemukan | Eventict</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon_blue.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 font-['Poppins'] min-h-screen flex flex-col justify-between antialiased selection:bg-blue-950 selection:text-white">

    <header class="h-16 px-6 lg:px-20 bg-blue-950 border-b border-slate-900 flex justify-between items-center sticky top-0 z-50">
        <a href="{{ route('home') }}" class="flex items-center">
            <img src="{{ asset('logo_white.svg') }}" alt="Eventict" class="h-8 w-auto">
        </a>
        <a href="{{ route('home') }}" class="text-xs text-white/80 hover:text-white font-medium transition">
            Kembali ke Beranda
        </a>
    </header>

    <main class="flex-1 flex items-center justify-center p-6 sm:p-10">
        <div class="max-w-md w-full bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 shadow-xs flex flex-col items-center text-center">
            <div class="size-16 rounded-2xl bg-blue-50 border border-blue-200 text-blue-950 flex items-center justify-center font-black text-2xl font-mono mb-4">
                404
            </div>

            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight leading-snug mb-2">
                Halaman Tidak Ditemukan
            </h1>

            <p class="text-xs text-slate-500 leading-relaxed max-w-sm mb-6">
                Tautan kegiatan atau halaman yang Anda tuju mungkin sudah dipindahkan, dihapus, atau alamat URL yang Anda masukkan kurang tepat.
            </p>

            <div class="flex flex-col sm:flex-row items-center gap-2.5 w-full justify-center">
                <a href="{{ route('home') }}" class="w-full sm:w-auto px-5 py-2.5 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold transition flex items-center justify-center gap-2 shadow-2xs">
                    <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    <span>Ke Halaman Utama</span>
                </a>
                <button type="button" onclick="window.history.back()" class="w-full sm:w-auto px-5 py-2.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-medium transition flex items-center justify-center gap-1.5 cursor-pointer shadow-2xs">
                    <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>
                    <span>Halaman Sebelumnya</span>
                </button>
            </div>
        </div>
    </main>

    <footer class="py-4 text-center text-[11px] text-slate-400 border-t border-slate-200/80 bg-white">
        &copy; {{ date('Y') }} Eventict — Platform Event, Seminar &amp; Workshop Laboratorium ICT.
    </footer>

</body>
</html>
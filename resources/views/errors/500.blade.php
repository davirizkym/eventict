<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 — Kendala Sistem | Eventict</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 font-['Poppins'] min-h-screen flex flex-col justify-between antialiased selection:bg-blue-950 selection:text-white">

    <header class="h-16 px-6 lg:px-20 bg-blue-950 border-b border-slate-900 flex justify-between items-center sticky top-0 z-50">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5">
            <div class="size-8 bg-white rounded flex items-center justify-center text-blue-950 font-bold text-sm">
                <svg class="size-5 text-blue-900" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
                    <path d="M6 6h10"/>
                    <path d="M6 10h7"/>
                </svg>
            </div>
            <span class="text-white text-xl font-semibold leading-7">Eventict</span>
        </a>
        <a href="{{ route('home') }}" class="text-xs text-white/80 hover:text-white font-medium transition">
            Kembali ke Beranda
        </a>
    </header>

    <main class="flex-1 flex items-center justify-center p-6 sm:p-10">
        <div class="max-w-md w-full bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 shadow-xs flex flex-col items-center text-center">
            <div class="size-16 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-center font-black text-2xl font-mono mb-4">
                500
            </div>

            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight leading-snug mb-2">
                Terjadi Kendala pada Sistem
            </h1>

            <p class="text-xs text-slate-500 leading-relaxed max-w-sm mb-6">
                Sistem kami sedang mengalami kendala sementara saat memproses permintaan Anda. Silakan muat ulang halaman beberapa saat lagi.
            </p>

            <div class="flex flex-col sm:flex-row items-center gap-2.5 w-full justify-center">
                <a href="{{ route('home') }}" class="w-full sm:w-auto px-5 py-2.5 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold transition flex items-center justify-center gap-2 shadow-2xs">
                    <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    <span>Ke Halaman Utama</span>
                </a>
                <button type="button" onclick="window.location.reload()" class="w-full sm:w-auto px-5 py-2.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-medium transition flex items-center justify-center gap-1.5 cursor-pointer shadow-2xs">
                    <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                        <path d="M3 3v5h5"/>
                        <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/>
                        <path d="M16 21h5v-5"/>
                    </svg>
                    <span>Muat Ulang Halaman</span>
                </button>
            </div>
        </div>
    </main>

    <footer class="py-4 text-center text-[11px] text-slate-400 border-t border-slate-200/80 bg-white">
        &copy; {{ date('Y') }} Eventict — Platform Event, Seminar &amp; Workshop Laboratorium ICT.
    </footer>

</body>
</html>
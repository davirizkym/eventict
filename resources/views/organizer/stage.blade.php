<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QR Presensi — {{ $event->title }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon_blue.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 font-['Poppins'] min-h-screen flex items-center justify-center p-4 sm:p-8 antialiased selection:bg-blue-950 selection:text-white relative select-none">

    <div class="fixed top-4 right-4 flex items-center gap-2 z-50">
        <button type="button" onclick="toggleFullscreen()" class="px-3.5 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 rounded-xl text-xs font-medium transition flex items-center gap-1.5 shadow-2xs cursor-pointer">
            <svg id="icon-fullscreen" class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M8 3H5a2 2 0 0 0-2 2v3M21 8V5a2 2 0 0 0-2-2h-3M3 16v3a2 2 0 0 0 2 2h3M16 21h3a2 2 0 0 0 2-2v-3"/>
            </svg>
            <span id="fullscreen-text">Layar Penuh (F11)</span>
        </button>
        <a href="{{ route('organizer.workspace', ['event' => $event->id]) }}" class="px-3.5 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 rounded-xl text-xs font-medium transition flex items-center gap-1.5 shadow-2xs cursor-pointer">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m15 18-6-6 6-6"/>
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <div class="p-6 sm:p-8 md:p-10 bg-white rounded-3xl border-2 border-slate-200 shadow-md flex items-center justify-center cursor-pointer" onclick="toggleFullscreen()">
        <img 
            id="qr-image"
            src="https://api.qrserver.com/v1/create-qr-code/?size=600x600&margin=10&data={{ urlencode(route('events.presence', ['slug' => $event->slug, 'token' => $event->presence_token])) }}" 
            alt="QR Code Presensi {{ $event->title }}"
            class="size-72 sm:size-88 md:size-[450px] lg:size-[520px] max-w-[85vw] max-h-[85vh] object-contain rounded-2xl bg-white select-none"
            loading="eager"
        >
    </div>

    <script>
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().then(() => {
                    const text = document.getElementById('fullscreen-text');
                    if (text) text.textContent = 'Keluar Layar Penuh';
                }).catch(() => {});
            } else {
                document.exitFullscreen().then(() => {
                    const text = document.getElementById('fullscreen-text');
                    if (text) text.textContent = 'Layar Penuh (F11)';
                }).catch(() => {});
            }
        }

        document.addEventListener('fullscreenchange', () => {
            const text = document.getElementById('fullscreen-text');
            if (text) {
                text.textContent = document.fullscreenElement ? 'Keluar Layar Penuh' : 'Layar Penuh (F11)';
            }
        });
    </script>
</body>
</html>
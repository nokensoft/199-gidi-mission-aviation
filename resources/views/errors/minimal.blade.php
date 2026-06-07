<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Error') - GIDI Mission Aviation</title>
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    {{-- NAVIGASI MINIMAL --}}
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 md:h-20">
                <a href="{{ url('/') }}" class="flex items-center gap-3 relative z-10 shrink-0">
                    <div class="relative w-14 h-14 md:w-20 md:h-20 lg:w-24 lg:h-24 -mb-4 md:-mb-6 lg:-mb-8">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo GIDI Mission Aviation" class="w-full h-full object-contain drop-shadow-md">
                    </div>
                    <div>
                        <span class="font-bold text-sm sm:text-lg md:text-xl lg:text-2xl tracking-tight text-slate-900 block leading-tight">GIDI Mission Aviation</span>
                        <span class="text-blue-600 font-semibold text-[10px] sm:text-xs md:text-sm tracking-wide block -mt-0.5">"Be The Light"</span>
                    </div>
                </a>
                <div class="hidden md:flex items-center gap-6 lg:gap-8 text-xs lg:text-sm font-bold tracking-widest uppercase text-slate-700">
                    <a href="{{ url('/') }}" class="hover:text-blue-600 transition-colors">BERANDA</a>
                    <a href="{{ url('/') }}#tentang-kami" class="hover:text-blue-600 transition-colors">TENTANG KAMI</a>
                    <a href="{{ url('/') }}#yang-kami-lakukan" class="hover:text-blue-600 transition-colors">LAYANAN</a>
                    <a href="{{ url('/blog') }}" class="hover:text-blue-600 transition-colors">BLOG</a>
                    <a href="{{ url('/') }}#kontak" class="hover:text-blue-600 transition-colors">KONTAK</a>
                </div>
                <a href="{{ url('/') }}#penggalangan-dana"
                    class="hidden sm:flex bg-blue-600 hover:bg-blue-700 text-white px-4 lg:px-5 py-2 lg:py-2.5 rounded-none shadow-sm items-center gap-2 font-bold text-xs lg:text-sm tracking-wide transition-all uppercase">
                    <i class="fa fa-plane"></i> DONASI
                </a>
            </div>
        </div>
    </nav>

    {{-- ERROR CONTENT --}}
    <main class="flex-1 flex items-center justify-center py-16 md:py-24 px-4">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-slate-950 text-slate-400 py-16">
        <div class="max-w-6xl mx-auto px-6 text-center flex flex-col items-center">
            <div class="w-24 h-24 p-2 flex items-center justify-center mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
            </div>
            <div class="mb-6">
                <h3 class="text-2xl font-extrabold text-white tracking-wide">GIDI Mission Aviation</h3>
                <span class="text-xs font-semibold tracking-widest text-sky-400 uppercase block mt-1">Be The Light</span>
            </div>
            <p class="max-w-md mx-auto text-sm text-slate-400/90 leading-relaxed mb-6">
                Serving the people of Papua with aviation, compassion, and the love of Christ.
            </p>
            <div class="w-16 border-t border-slate-800 mb-8"></div>
            <div class="text-xs text-slate-500 space-y-1">
                <p>&copy; {{ date('Y') }} GIDI Mission Aviation. All Rights Reserved.</p>
                <p>Powered by <a href="https://nokensoft.com" target="_blank" class="text-slate-400 hover:text-sky-400 font-medium transition-colors">Nokensoft.com</a></p>
            </div>
        </div>
    </footer>
</body>
</html>

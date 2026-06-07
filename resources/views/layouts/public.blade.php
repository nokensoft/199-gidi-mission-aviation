<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GIDI Mission Aviation - Be The Light')</title>
    @php
        $siteLogo = \App\Models\SiteSetting::get('site_logo');
        $siteFavicon = \App\Models\SiteSetting::get('site_favicon');
        $logoUrl = $siteLogo ? asset('uploads/'.$siteLogo) : asset('images/logo.png');
        $faviconUrl = $siteFavicon ? asset('uploads/'.$siteFavicon) : asset('images/logo.png');
        $defaultDescription = \App\Models\SiteSetting::get('site_description', 'GIDI Mission Aviation - Wujud kemandirian Gereja Injili di Indonesia di bidang penerbangan dalam mendukung pelayanan misi Gereja.');
    @endphp

    {{-- SEO Meta --}}
    <meta name="description" content="@yield('meta_description', $defaultDescription)">
    <meta name="keywords" content="@yield('meta_keywords', 'GIDI, Mission Aviation, Penerbangan Misi, Papua, Gereja Injili, Donasi, Cessna Grand Caravan, PT Sayap Kasih Injili')">
    <meta name="author" content="GIDI Mission Aviation">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="@yield('canonical_url', url()->current())">

    {{-- Open Graph --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="GIDI Mission Aviation">
    <meta property="og:title" content="@yield('title', 'GIDI Mission Aviation - Be The Light')">
    <meta property="og:description" content="@yield('meta_description', $defaultDescription)">
    <meta property="og:url" content="@yield('canonical_url', url()->current())">
    <meta property="og:image" content="@yield('og_image', $logoUrl)">
    <meta property="og:image:alt" content="@yield('title', 'GIDI Mission Aviation')">
    <meta property="og:locale" content="id_ID">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:title" content="@yield('title', 'GIDI Mission Aviation - Be The Light')">
    <meta name="twitter:description" content="@yield('meta_description', $defaultDescription)">
    <meta name="twitter:image" content="@yield('og_image', $logoUrl)">

    <link rel="shortcut icon" href="{{ $faviconUrl }}" type="image/png">
    <link rel="icon" href="{{ $faviconUrl }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    @stack('seo')
</head>
<body class="bg-slate-50 text-slate-800">

    {{-- LOADING SCREEN --}}
    <div id="page-loader" class="fixed inset-0 z-[100] bg-white flex items-center justify-center transition-opacity duration-500">
        <div class="flex flex-col items-center">
            <img src="{{ $logoUrl }}" alt="Loading..." class="w-20 h-20 object-contain animate-spin-slow">
            <div class="mt-4 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-bounce" style="animation-delay:0ms"></span>
                <span class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-bounce" style="animation-delay:150ms"></span>
                <span class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-bounce" style="animation-delay:300ms"></span>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('load', function() {
            var loader = document.getElementById('page-loader');
            loader.style.opacity = '0';
            setTimeout(function() { loader.style.display = 'none'; }, 500);
        });
    </script>

    {{-- NAVIGASI --}}
    @php
        $isHome = request()->routeIs('home');
        $isBlog = request()->routeIs('blog.*');
        $activeClass = 'text-blue-600 border-b-2 border-blue-600 pb-0.5';
        $normalClass = 'text-slate-700 hover:text-blue-600 transition-colors';
    @endphp
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-md"
        x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 md:h-20">

                {{-- LEFT: Logo (besar, melampaui border bawah) + Title + Tagline --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 relative z-10 shrink-0">
                    <div class="relative w-14 h-14 md:w-20 md:h-20 lg:w-24 lg:h-24 -mb-4 md:-mb-6 lg:-mb-8">
                        <img src="{{ $logoUrl }}" alt="Logo GIDI Mission Aviation" class="w-full h-full object-contain drop-shadow-md">
                    </div>
                    <div>
                        <span class="font-bold text-sm sm:text-lg md:text-xl lg:text-2xl tracking-tight text-slate-900 block leading-tight">GIDI Mission Aviation</span>
                        <span class="text-blue-600 font-semibold text-[10px] sm:text-xs md:text-sm tracking-wide block -mt-0.5">"Be The Light"</span>
                    </div>
                </a>

                {{-- CENTER: Desktop Navigation (UPPERCASE + Active) --}}
                <div class="hidden md:flex items-center gap-6 lg:gap-8 text-xs lg:text-sm font-bold tracking-widest uppercase">
                    <a href="{{ route('home') }}" class="{{ $isHome && !request()->is('blog*') ? $activeClass : $normalClass }}">BERANDA</a>
                    <a href="{{ route('home') }}#tentang-kami" class="{{ $normalClass }}">TENTANG KAMI</a>
                    <a href="{{ route('home') }}#yang-kami-lakukan" class="{{ $normalClass }}">LAYANAN</a>
                    <a href="{{ route('blog.index') }}" class="{{ $isBlog ? $activeClass : $normalClass }}">BLOG</a>
                    <a href="{{ route('home') }}#kontak" class="{{ $normalClass }}">KONTAK</a>
                </div>

                {{-- RIGHT: CTA + Mobile hamburger --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}#penggalangan-dana"
                        class="hidden sm:flex bg-blue-600 hover:bg-blue-700 text-white px-4 lg:px-5 py-2 lg:py-2.5 rounded-none shadow-sm items-center gap-2 font-bold text-xs lg:text-sm tracking-wide transition-all uppercase">
                        <i class="fa fa-plane"></i> DONASI
                    </a>
                    <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
                        class="md:hidden text-slate-700 hover:text-blue-600 p-2 focus:outline-none transition-colors">
                        <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                        <svg x-show="mobileMenuOpen" style="display:none;" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileMenuOpen" x-transition style="display:none;" class="md:hidden border-t border-slate-100 bg-slate-50 shadow-inner">
            <div class="px-6 py-4 space-y-1 font-bold text-slate-700 text-sm uppercase tracking-wider">
                <a href="{{ route('home') }}" @click="mobileMenuOpen=false" class="block py-3 border-b border-slate-200/60 {{ $isHome ? 'text-blue-600' : 'hover:text-blue-600' }}">BERANDA</a>
                <a href="{{ route('home') }}#tentang-kami" @click="mobileMenuOpen=false" class="block py-3 border-b border-slate-200/60 hover:text-blue-600">TENTANG KAMI</a>
                <a href="{{ route('home') }}#yang-kami-lakukan" @click="mobileMenuOpen=false" class="block py-3 border-b border-slate-200/60 hover:text-blue-600">LAYANAN</a>
                <a href="{{ route('blog.index') }}" @click="mobileMenuOpen=false" class="block py-3 border-b border-slate-200/60 {{ $isBlog ? 'text-blue-600' : 'hover:text-blue-600' }}">BLOG</a>
                <a href="{{ route('home') }}#kontak" @click="mobileMenuOpen=false" class="block py-3 border-b border-slate-200/60 hover:text-blue-600">KONTAK</a>
                <div class="pt-3">
                    <a href="{{ route('home') }}#penggalangan-dana" @click="mobileMenuOpen=false" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-none flex items-center justify-center gap-2 font-bold text-center tracking-wide">
                        <i class="fa fa-plane"></i> DONASI
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- CONTENT --}}
    @yield('content')

    {{-- FOOTER --}}
    <footer class="bg-slate-950 text-slate-400 py-16">
        <div class="max-w-6xl mx-auto px-6 text-center flex flex-col items-center">
            <div class="w-32 h-32 p-2 flex items-center justify-center mb-4">
                <img src="{{ $logoUrl }}" alt="Logo" class="w-full h-full object-contain">
            </div>
            <div class="mb-6">
                <h3 class="text-2xl font-extrabold text-white tracking-wide">GIDI Mission Aviation</h3>
                <span class="text-xs font-semibold tracking-widest text-sky-400 uppercase block mt-1">Be The Light</span>
            </div>
            <p class="max-w-md mx-auto text-sm text-slate-400/90 leading-relaxed mb-6">
                Serving the people of Papua with aviation, compassion, and the love of Christ.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-6 mb-8">
                <a href="{{ route('page.show', 'kebijakan-privasi') }}" class="text-xs sm:text-sm hover:text-sky-400 transition-colors">Kebijakan Privasi</a>
                <span class="text-slate-700 text-xs hidden sm:inline">|</span>
                <a href="{{ route('page.show', 'faq') }}" class="text-xs sm:text-sm hover:text-sky-400 transition-colors">FAQ</a>
                <span class="text-slate-700 text-xs hidden sm:inline">|</span>
                <a href="{{ route('page.show', 'sitemap') }}" class="text-xs sm:text-sm hover:text-sky-400 transition-colors">Peta Situs</a>
                <span class="text-slate-700 text-xs hidden sm:inline">|</span>
                <a href="{{ route('blog.index') }}" class="text-xs sm:text-sm hover:text-sky-400 transition-colors">Blog</a>
            </div>
            @auth
                <div class="flex items-center justify-center gap-2 text-xs text-slate-500 mb-8">
                    <i class="fa fa-user-circle text-sky-400"></i>
                    <span>{{ Auth::user()->name }}</span>
                    <span class="text-slate-700">|</span>
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-sky-400 transition-colors flex items-center gap-1">
                        <i class="fa fa-tachometer-alt text-[10px]"></i> Dashboard
                    </a>
                </div>
            @else
                <div class="flex items-center justify-center gap-2 text-xs text-slate-500 mb-8">
                    <a href="{{ route('login') }}" class="hover:text-sky-400 transition-colors flex items-center gap-1">
                        <i class="fa fa-sign-in-alt text-[10px]"></i> Login
                    </a>
                </div>
            @endauth
            <div class="w-16 border-t border-slate-800 mb-8"></div>
            <div class="text-xs text-slate-500 space-y-1">
                <p>&copy; {{ date('Y') }} GIDI Mission Aviation. All Rights Reserved.</p>
                <p>Powered by <a href="https://nokensoft.com" target="_blank" class="text-slate-400 hover:text-sky-400 font-medium transition-colors">Nokensoft.com</a></p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

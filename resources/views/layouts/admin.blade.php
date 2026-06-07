<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - GIDI Mission Aviation</title>
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-slate-100 min-h-screen" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">
        {{-- SIDEBAR --}}
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white transform transition-transform duration-200 lg:translate-x-0 lg:static lg:inset-auto"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-800">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                <div>
                    <span class="font-bold text-sm block">GIDI Mission</span>
                    <span class="text-xs text-slate-400">Dashboard</span>
                </div>
            </div>
            <nav class="px-4 py-6 space-y-1 text-sm overflow-y-auto max-h-[calc(100vh-80px)]">
                <a href="{{ route('admin.dashboard') }}" @click.away="" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                    <i class="fa-solid fa-chart-line w-5 text-center"></i> Dashboard
                </a>
                @if(auth()->user()->isAdmin())
                <div class="pt-4 pb-2"><span class="text-xs text-slate-500 uppercase tracking-wider font-bold px-3">Konten</span></div>
                <a href="{{ route('admin.posts.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.posts.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                    <i class="fa-solid fa-newspaper w-5 text-center"></i> Blog
                </a>
                <a href="{{ route('admin.categories.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                    <i class="fa-solid fa-tags w-5 text-center"></i> Kategori
                </a>
                <a href="{{ route('admin.sliders.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.sliders.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                    <i class="fa-solid fa-images w-5 text-center"></i> Slider
                </a>
                <div class="pt-4 pb-2"><span class="text-xs text-slate-500 uppercase tracking-wider font-bold px-3">Donasi & Testimoni</span></div>
                <a href="{{ route('admin.donations.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.donations.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                    <i class="fa-solid fa-hand-holding-heart w-5 text-center"></i> Donasi
                </a>
                <a href="{{ route('admin.testimonials.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.testimonials.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                    <i class="fa-solid fa-quote-right w-5 text-center"></i> Testimoni
                </a>
                <div class="pt-4 pb-2"><span class="text-xs text-slate-500 uppercase tracking-wider font-bold px-3">Lainnya</span></div>
                <a href="{{ route('admin.services.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.services.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                    <i class="fa-solid fa-plane w-5 text-center"></i> Layanan
                </a>
                <a href="{{ route('admin.partners.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.partners.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                    <i class="fa-solid fa-handshake w-5 text-center"></i> Mitra Kerja
                </a>
                <a href="{{ route('admin.settings.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.settings.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                    <i class="fa-solid fa-cog w-5 text-center"></i> Pengaturan
                </a>
                <a href="{{ route('admin.users.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                    <i class="fa-solid fa-users w-5 text-center"></i> Pengguna
                </a>
                @endif
            </nav>
        </aside>

        {{-- OVERLAY --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden" style="display:none;"></div>

        {{-- MAIN --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- TOPBAR --}}
            <header class="bg-white border-b border-slate-200 sticky top-0 z-30">
                <div class="flex items-center justify-between px-4 sm:px-6 py-3">
                    <div class="flex items-center gap-3">
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-slate-600 hover:text-slate-900 p-1">
                            <i class="fa-solid fa-bars text-lg"></i>
                        </button>
                        <h2 class="text-sm sm:text-lg font-bold text-slate-900 truncate max-w-[200px] sm:max-w-none">@yield('page-title', 'Dashboard')</h2>
                    </div>
                    <div class="flex items-center gap-2 sm:gap-4">
                        <a href="{{ route('home') }}" target="_blank" class="text-slate-500 hover:text-blue-600 flex items-center gap-1" title="Lihat Website">
                            <i class="fa-solid fa-external-link text-xs"></i> <span class="hidden sm:inline text-sm">Lihat Website</span>
                        </a>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                            <div class="hidden sm:block">
                                <span class="text-sm font-medium text-slate-900 block leading-tight">{{ auth()->user()->name }}</span>
                                <span class="text-xs text-slate-400 capitalize">{{ auth()->user()->role }}</span>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-slate-400 hover:text-red-500 transition" title="Keluar"><i class="fa-solid fa-right-from-bracket"></i></button>
                        </form>
                    </div>
                </div>
            </header>

            {{-- PAGE CONTENT --}}
            <main class="flex-1 p-4 sm:p-6">
                @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-exclamation-circle"></i> {{ session('error') }}
                </div>
                @endif
                @yield('content')
            </main>

            {{-- FOOTER --}}
            <footer class="bg-white border-t border-slate-200 px-4 sm:px-6 py-3">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-1 text-xs text-slate-400">
                    <span>&copy; {{ date('Y') }} <span class="font-medium text-slate-500">GIDI Mission Aviation</span>. All rights reserved.</span>
                    <span>Powered by <a href="https://nokensoft.com" target="_blank" rel="noopener noreferrer" class="font-medium text-slate-500 hover:text-blue-600 transition">Nokensoft</a></span>
                </div>
            </footer>
        </div>
    </div>
    {{-- GLOBAL CONFIRM MODAL --}}
    <div x-data="confirmModal()" x-on:confirm-delete.window="open($event.detail)" x-show="show" style="display:none;"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[70] flex items-center justify-center p-4" @keydown.escape.window="cancel()">
        <div class="absolute inset-0 bg-black/50" @click="cancel()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 sm:p-8" @click.stop
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-full bg-red-50 text-red-500 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-lg" x-text="title"></h3>
                    <p class="text-sm text-slate-500 mt-1" x-text="message"></p>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 mt-6">
                <button @click="cancel()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-medium transition cursor-pointer">Batal</button>
                <button @click="confirm()" class="px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl text-sm font-bold transition cursor-pointer flex items-center gap-2">
                    <i class="fa-solid fa-trash text-xs"></i> <span x-text="confirmText"></span>
                </button>
            </div>
        </div>
    </div>

    <script>
    function confirmDelete(form, title, message, confirmText) {
        window.dispatchEvent(new CustomEvent('confirm-delete', {
            detail: { form: form, title: title, message: message, confirmText: confirmText }
        }));
    }
    function confirmModal() {
        return {
            show: false,
            title: '',
            message: '',
            confirmText: 'Hapus',
            formEl: null,
            open(detail) {
                this.title = detail.title || 'Konfirmasi Hapus';
                this.message = detail.message || 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.';
                this.confirmText = detail.confirmText || 'Hapus';
                this.formEl = detail.form || null;
                this.show = true;
            },
            confirm() {
                if (this.formEl) this.formEl.submit();
                this.show = false;
            },
            cancel() {
                this.show = false;
                this.formEl = null;
            }
        }
    }
    </script>

    @stack('scripts')
</body>
</html>

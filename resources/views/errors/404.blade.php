@extends('errors.minimal')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
<div class="max-w-2xl mx-auto text-center">
    {{-- Icon --}}
    <div class="w-20 h-20 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-3xl mx-auto mb-8">
        <i class="fa-solid fa-plane-slash"></i>
    </div>

    {{-- Error Code --}}
    <span class="text-blue-600 font-bold text-sm uppercase tracking-widest block mb-3">Error 404</span>

    {{-- Title --}}
    <h1 class="text-4xl sm:text-5xl font-black text-slate-900 tracking-tight mb-4">Halaman Tidak Ditemukan</h1>

    {{-- Description --}}
    <p class="text-slate-500 text-base sm:text-lg leading-relaxed mb-10 max-w-lg mx-auto">
        Maaf, halaman yang Anda cari tidak dapat ditemukan. Mungkin halaman telah dipindahkan atau dihapus.
    </p>

    {{-- Actions --}}
    <div class="flex flex-wrap items-center justify-center gap-4">
        <a href="{{ url('/') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-none transition duration-300 shadow-md shadow-blue-500/10 flex items-center gap-2">
            <i class="fa-solid fa-house text-sm"></i> Kembali ke Beranda
        </a>
        <a href="{{ url('/blog') }}"
            class="border-2 border-slate-200 hover:border-slate-300 text-slate-700 font-bold py-2.5 px-6 rounded-none transition duration-300 flex items-center gap-2 bg-white">
            <i class="fa-solid fa-newspaper text-sm"></i> Lihat Blog
        </a>
    </div>
</div>
@endsection

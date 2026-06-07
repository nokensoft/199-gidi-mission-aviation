@extends('errors.minimal')

@section('title', '419 - Halaman Kedaluwarsa')

@section('content')
<div class="max-w-2xl mx-auto text-center">
    {{-- Icon --}}
    <div class="w-20 h-20 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-3xl mx-auto mb-8">
        <i class="fa-solid fa-clock-rotate-left"></i>
    </div>

    {{-- Error Code --}}
    <span class="text-blue-600 font-bold text-sm uppercase tracking-widest block mb-3">Error 419</span>

    {{-- Title --}}
    <h1 class="text-4xl sm:text-5xl font-black text-slate-900 tracking-tight mb-4">Halaman Kedaluwarsa</h1>

    {{-- Description --}}
    <p class="text-slate-500 text-base sm:text-lg leading-relaxed mb-10 max-w-lg mx-auto">
        Sesi Anda telah berakhir. Silakan muat ulang halaman dan coba lagi.
    </p>

    {{-- Actions --}}
    <div class="flex flex-wrap items-center justify-center gap-4">
        <a href="javascript:location.reload()"
            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-none transition duration-300 shadow-md shadow-blue-500/10 flex items-center gap-2">
            <i class="fa-solid fa-rotate-right text-sm"></i> Muat Ulang Halaman
        </a>
        <a href="{{ url('/') }}"
            class="border-2 border-slate-200 hover:border-slate-300 text-slate-700 font-bold py-2.5 px-6 rounded-none transition duration-300 flex items-center gap-2 bg-white">
            <i class="fa-solid fa-house text-sm"></i> Kembali ke Beranda
        </a>
    </div>
</div>
@endsection

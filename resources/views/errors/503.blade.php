@extends('errors.minimal')

@section('title', '503 - Layanan Tidak Tersedia')

@section('content')
<div class="max-w-2xl mx-auto text-center">
    {{-- Icon --}}
    <div class="w-20 h-20 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-3xl mx-auto mb-8">
        <i class="fa-solid fa-screwdriver-wrench"></i>
    </div>

    {{-- Error Code --}}
    <span class="text-blue-600 font-bold text-sm uppercase tracking-widest block mb-3">Error 503</span>

    {{-- Title --}}
    <h1 class="text-4xl sm:text-5xl font-black text-slate-900 tracking-tight mb-4">Sedang Dalam Pemeliharaan</h1>

    {{-- Description --}}
    <p class="text-slate-500 text-base sm:text-lg leading-relaxed mb-10 max-w-lg mx-auto">
        Situs sedang dalam pemeliharaan untuk peningkatan layanan. Kami akan segera kembali. Terima kasih atas kesabaran Anda.
    </p>

    {{-- Actions --}}
    <div class="flex flex-wrap items-center justify-center gap-4">
        <a href="javascript:location.reload()"
            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-none transition duration-300 shadow-md shadow-blue-500/10 flex items-center gap-2">
            <i class="fa-solid fa-rotate-right text-sm"></i> Coba Lagi
        </a>
    </div>
</div>
@endsection

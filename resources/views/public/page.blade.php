@extends('layouts.public')
@section('title', $page->title . ' - GIDI Mission Aviation')

@section('content')
<section class="section-shell bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="mb-8">
            <a href="{{ route('home') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Beranda</a>
        </div>
        <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight mb-4">{{ $page->title }}</h1>
        @php $shareUrl = url()->current(); $shareTitle = $page->title; @endphp
        <div class="flex items-center gap-2 mb-8 pb-6 border-b border-slate-100" x-data="{ copied: false }">
            <span class="text-xs text-slate-400 mr-1">Bagikan:</span>
            <button @click="navigator.clipboard.writeText('{{ $shareUrl }}'); copied = true; setTimeout(() => copied = false, 2000)"
                class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 flex items-center justify-center transition text-xs" title="Salin Link">
                <i class="fa-solid fa-check text-emerald-500" x-show="copied" style="display:none;"></i>
                <i class="fa-regular fa-copy" x-show="!copied"></i>
            </button>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" rel="noopener"
                class="w-8 h-8 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition text-xs" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="https://wa.me/?text={{ urlencode($shareTitle . ' ' . $shareUrl) }}" target="_blank" rel="noopener"
                class="w-8 h-8 rounded-full bg-slate-100 hover:bg-emerald-500 text-slate-500 hover:text-white flex items-center justify-center transition text-xs" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($shareTitle) }}" target="_blank" rel="noopener"
                class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-900 text-slate-500 hover:text-white flex items-center justify-center transition text-xs" title="X"><i class="fa-brands fa-x-twitter"></i></a>
        </div>
        <div class="prose prose-slate prose-lg max-w-none">{!! $page->content !!}</div>
    </div>
</section>
@endsection

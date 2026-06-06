@extends('layouts.public')
@section('title', $page->title . ' - GIDI Mission Aviation')

@section('content')
<section class="section-shell bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="mb-8">
            <a href="{{ route('home') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Beranda</a>
        </div>
        <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight mb-8">{{ $page->title }}</h1>
        <div class="prose prose-slate prose-lg max-w-none">{!! $page->content !!}</div>
    </div>
</section>
@endsection

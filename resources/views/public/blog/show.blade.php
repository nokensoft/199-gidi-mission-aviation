@extends('layouts.public')
@section('title', $post->title . ' - GIDI Mission Aviation')

@section('content')
<article class="section-shell bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="mb-8">
            <a href="{{ route('blog.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Blog</a>
        </div>

        @if($post->featured_image)
        <div class="aspect-[16/9] rounded-2xl overflow-hidden mb-8 shadow-lg">
            <img src="{{ asset('uploads/'.$post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
        </div>
        @endif

        <div class="flex flex-wrap gap-2 mb-4">
            @foreach($post->categories as $cat)
            <a href="{{ route('blog.index', ['category' => $cat->slug]) }}" class="text-xs bg-blue-50 text-blue-600 px-3 py-1 rounded-full font-medium hover:bg-blue-100 transition">{{ $cat->name }}</a>
            @endforeach
        </div>

        <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight mb-4">{{ $post->title }}</h1>
        <div class="flex items-center gap-4 text-sm text-slate-400 mb-10 pb-6 border-b border-slate-100">
            <span><i class="fa-solid fa-calendar mr-1"></i> {{ $post->published_at?->translatedFormat('d F Y') }}</span>
            <span><i class="fa-solid fa-user mr-1"></i> {{ $post->user?->name }}</span>
        </div>

        <div class="prose prose-slate prose-lg max-w-none mb-12">{!! $post->content !!}</div>

        @if($relatedPosts->count())
        <div class="border-t border-slate-100 pt-10">
            <h3 class="text-xl font-bold text-slate-900 mb-6">Artikel Terkait</h3>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($relatedPosts as $related)
                <a href="{{ route('blog.show', $related->slug) }}" class="bg-slate-50 rounded-xl p-4 hover:bg-slate-100 transition group">
                    <h4 class="font-bold text-slate-900 text-sm group-hover:text-blue-600 transition-colors line-clamp-2">{{ $related->title }}</h4>
                    <p class="text-xs text-slate-400 mt-2">{{ $related->published_at?->translatedFormat('d M Y') }}</p>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</article>
@endsection

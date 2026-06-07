@extends('layouts.public')
@section('title', $selectedCategory ? 'Kategori: '.$selectedCategory->name : 'Blog - GIDI Mission Aviation')

@section('content')
<section class="section-shell bg-white">
    <div class="section-container">
        <div class="text-center max-w-3xl mx-auto mb-10">
            <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider block mb-2">Blog</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">{{ $selectedCategory ? 'Kategori: '.$selectedCategory->name : 'Artikel & Berita' }}</h2>
        </div>

        {{-- SEARCH & FILTER BAR (minimalist, auto-submit) --}}
        <form id="blogFilter" method="GET" action="{{ route('blog.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 mb-8">
            {{-- Search --}}
            <div class="relative flex-1 min-w-0">
                <i class="fa-solid fa-search text-xs text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel..." class="w-full pl-9 pr-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition cursor-text">
            </div>
            {{-- Kategori --}}
            <select name="category" onchange="this.form.submit()" class="px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 transition cursor-pointer">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }} ({{ $cat->posts_count }})</option>
                @endforeach
            </select>
            {{-- Urutkan --}}
            <select name="sort" onchange="this.form.submit()" class="px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 transition cursor-pointer">
                <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>A - Z</option>
                <option value="za" {{ request('sort') == 'za' ? 'selected' : '' }}>Z - A</option>
            </select>
            {{-- Dari --}}
            <input type="date" name="date_from" value="{{ request('date_from') }}" onchange="this.form.submit()" title="Dari tanggal" class="px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 transition cursor-pointer">
            {{-- Sampai --}}
            <input type="date" name="date_to" value="{{ request('date_to') }}" onchange="this.form.submit()" title="Sampai tanggal" class="px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 transition cursor-pointer">
            {{-- Reset --}}
            @if(request()->hasAny(['search', 'category', 'sort', 'date_from', 'date_to']) && (request('search') || request('category') || request('sort', 'terbaru') !== 'terbaru' || request('date_from') || request('date_to')))
            <a href="{{ route('blog.index') }}" class="px-3 py-2 text-slate-400 hover:text-red-500 transition cursor-pointer shrink-0" title="Reset filter">
                <i class="fa-solid fa-times-circle"></i>
            </a>
            @endif
        </form>

        {{-- Result count --}}
        @if(request()->hasAny(['search', 'category', 'date_from', 'date_to']))
        <p class="text-xs text-slate-400 mb-6">{{ $posts->total() }} artikel ditemukan
            @if(request('search')) untuk "<span class="font-medium text-slate-600">{{ request('search') }}</span>"@endif
            @if($selectedCategory) di kategori <span class="font-medium text-slate-600">{{ $selectedCategory->name }}</span>@endif
        </p>
        @endif

        @if($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($posts as $post)
            <article class="bg-white rounded-2xl border border-slate-200/60 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden group cursor-pointer">
                <a href="{{ route('blog.show', $post->slug) }}" class="block">
                    @if($post->featured_image)
                    <div class="aspect-[16/10] overflow-hidden bg-slate-100">
                        <img src="{{ asset('uploads/'.$post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    @else
                    <div class="aspect-[16/10] bg-gradient-to-br from-blue-50 to-slate-100 flex items-center justify-center">
                        <i class="fa-solid fa-newspaper text-4xl text-blue-200"></i>
                    </div>
                    @endif
                </a>
                <div class="p-6">
                    <div class="flex flex-wrap gap-2 mb-3">
                        @foreach($post->categories as $cat)
                        <span class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded-full font-medium">{{ $cat->name }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('blog.show', $post->slug) }}">
                        <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition-colors line-clamp-2">{{ $post->title }}</h3>
                    </a>
                    <p class="text-slate-500 text-sm line-clamp-3 mb-4">{{ $post->excerpt }}</p>
                    <div class="flex items-center justify-between text-xs text-slate-400">
                        <span>{{ $post->published_at?->translatedFormat('d M Y') }}</span>
                        <span><i class="fa-solid fa-eye mr-1"></i> {{ number_format($post->views_count) }}x dibaca</span>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        <div class="mt-10">{{ $posts->links() }}</div>
        @else
        <div class="text-center py-20">
            <i class="fa-solid fa-newspaper text-5xl text-slate-200 mb-4"></i>
            <p class="text-slate-400 text-lg">{{ request()->hasAny(['search', 'category', 'date_from', 'date_to']) ? 'Tidak ada artikel yang cocok dengan filter.' : 'Belum ada artikel yang dipublikasikan.' }}</p>
            @if(request()->hasAny(['search', 'category', 'date_from', 'date_to']))
            <a href="{{ route('blog.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium mt-3 inline-block cursor-pointer"><i class="fa-solid fa-arrow-left mr-1"></i> Lihat semua artikel</a>
            @endif
        </div>
        @endif
    </div>
</section>
@endsection

@extends('layouts.public')
@section('title', $post->title . ' - GIDI Mission Aviation')
@section('meta_description', Str::limit(strip_tags($post->excerpt ?: $post->content), 160))
@section('meta_keywords', $post->categories->pluck('name')->implode(', ') . ', GIDI Mission Aviation, penerbangan misi')
@section('og_type', 'article')
@section('og_image', $post->featured_image ? asset('uploads/'.$post->featured_image) : asset('images/logo.png'))
@section('canonical_url', route('blog.show', $post->slug))

@push('seo')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": "{{ $post->title }}",
    "description": "{{ Str::limit(strip_tags($post->excerpt ?: $post->content), 160) }}",
    "image": "{{ $post->featured_image ? asset('uploads/'.$post->featured_image) : asset('images/logo.png') }}",
    "datePublished": "{{ $post->published_at?->toIso8601String() }}",
    "dateModified": "{{ $post->updated_at->toIso8601String() }}",
    "author": {
        "@type": "Organization",
        "name": "GIDI Mission Aviation"
    },
    "publisher": {
        "@type": "Organization",
        "name": "GIDI Mission Aviation",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('images/logo.png') }}"
        }
    },
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ route('blog.show', $post->slug) }}"
    }
}
</script>
@endpush

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
        <div class="flex items-center justify-between flex-wrap gap-4 text-sm text-slate-400 mb-10 pb-6 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <span><i class="fa-solid fa-calendar mr-1"></i> {{ $post->published_at?->translatedFormat('d F Y') }}</span>
                <span><i class="fa-solid fa-eye mr-1"></i> {{ number_format($post->views_count) }}x dibaca</span>
            </div>
            @php $shareUrl = url()->current(); $shareTitle = $post->title; @endphp
            <div class="flex items-center gap-2" x-data="{ copied: false }">
                <button @click="navigator.clipboard.writeText('{{ $shareUrl }}'); copied = true; setTimeout(() => copied = false, 2000)"
                    class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 flex items-center justify-center transition text-xs" title="Salin Link">
                    <i class="fa-solid fa-check text-emerald-500" x-show="copied" style="display:none;"></i>
                    <i class="fa-regular fa-copy" x-show="!copied"></i>
                </button>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" rel="noopener"
                    class="w-8 h-8 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition text-xs" title="Bagikan ke Facebook">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="https://wa.me/?text={{ urlencode($shareTitle . ' ' . $shareUrl) }}" target="_blank" rel="noopener"
                    class="w-8 h-8 rounded-full bg-slate-100 hover:bg-emerald-500 text-slate-500 hover:text-white flex items-center justify-center transition text-xs" title="Bagikan ke WhatsApp">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($shareTitle) }}" target="_blank" rel="noopener"
                    class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-900 text-slate-500 hover:text-white flex items-center justify-center transition text-xs" title="Bagikan ke X">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
            </div>
        </div>

        <div class="prose prose-slate prose-lg max-w-none mb-12">{!! $post->content !!}</div>

        {{-- Share bottom --}}
        <div class="border-t border-slate-100 pt-8 mb-12">
            <div class="flex items-center justify-between flex-wrap gap-4" x-data="{ copied: false }">
                <span class="text-sm font-semibold text-slate-500"><i class="fa-solid fa-share-nodes mr-1"></i> Bagikan Artikel</span>
                <div class="flex items-center gap-2">
                    <button @click="navigator.clipboard.writeText('{{ $shareUrl }}'); copied = true; setTimeout(() => copied = false, 2000)"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium border transition"
                        :class="copied ? 'border-emerald-200 bg-emerald-50 text-emerald-600' : 'border-slate-200 bg-white text-slate-500 hover:bg-slate-50'">
                        <i class="fa-solid fa-check" x-show="copied" style="display:none;"></i>
                        <i class="fa-regular fa-copy" x-show="!copied"></i>
                        <span x-text="copied ? 'Tersalin!' : 'Salin Link'"></span>
                    </button>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" rel="noopener"
                        class="w-8 h-8 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition text-xs" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://wa.me/?text={{ urlencode($shareTitle . ' ' . $shareUrl) }}" target="_blank" rel="noopener"
                        class="w-8 h-8 rounded-full bg-slate-100 hover:bg-emerald-500 text-slate-500 hover:text-white flex items-center justify-center transition text-xs" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($shareTitle) }}" target="_blank" rel="noopener"
                        class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-900 text-slate-500 hover:text-white flex items-center justify-center transition text-xs" title="X"><i class="fa-brands fa-x-twitter"></i></a>
                </div>
            </div>
        </div>

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

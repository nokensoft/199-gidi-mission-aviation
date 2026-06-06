@extends('layouts.admin')
@section('title', 'Slider')
@section('page-title', 'Manajemen Slider')
@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-slate-500">{{ $sliders->total() }} slider</p>
    <div class="flex items-center gap-3">
        @php $sliderTrashCount = \App\Models\Slider::onlyTrashed()->count(); @endphp
        @if($sliderTrashCount > 0)
        <a href="{{ route('admin.sliders.trash') }}" class="text-sm text-red-500 hover:text-red-600 flex items-center gap-1.5 cursor-pointer">
            <i class="fa-solid fa-trash-can text-xs"></i> Sampah <span class="bg-red-100 text-red-600 text-xs px-1.5 py-0.5 rounded-full font-bold">{{ $sliderTrashCount }}</span>
        </a>
        @endif
        <a href="{{ route('admin.sliders.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2"><i class="fa-solid fa-plus"></i> Tambah Slider</a>
    </div>
</div>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" x-data="{ lightbox: false, lightboxSrc: '', lightboxTitle: '' }">
    @forelse($sliders as $s)
    <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden">
        @if($s->image)
        <div class="aspect-[16/9] bg-slate-100 overflow-hidden relative group"
            @click="lightboxSrc = '{{ asset('uploads/'.$s->image) }}'; lightboxTitle = '{{ addslashes($s->title) }}'; lightbox = true">
            <img src="{{ asset('uploads/'.$s->image) }}" alt="{{ $s->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300 flex items-center justify-center">
                <i class="fa-solid fa-expand text-white text-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 drop-shadow"></i>
            </div>
        </div>
        @else
        <div class="aspect-[16/9] bg-gradient-to-br from-blue-50 to-slate-100 flex items-center justify-center">
            <i class="fa-solid fa-image text-3xl text-slate-200"></i>
        </div>
        @endif
        <div class="p-5">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs px-2 py-1 rounded-full font-medium {{ $s->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-400' }}">{{ $s->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                <span class="text-xs text-slate-400">Urutan: {{ $s->sort_order }}</span>
            </div>
            <h4 class="font-bold text-slate-900 mb-1">{{ $s->title }}</h4>
            <p class="text-xs text-slate-500 line-clamp-2">{{ $s->description }}</p>
            <div class="flex gap-2 mt-4">
                <a href="{{ route('admin.sliders.edit', $s) }}" class="text-blue-600 hover:text-blue-700 text-sm"><i class="fa-solid fa-edit"></i> Edit</a>
                <form method="POST" action="{{ route('admin.sliders.destroy', $s) }}" class="inline" onsubmit="event.preventDefault(); confirmDelete(this, 'Hapus Slider', 'Apakah Anda yakin ingin menghapus slider &quot;{{ addslashes($s->title) }}&quot;?')">@csrf @method('DELETE')<button class="text-red-400 hover:text-red-600 text-sm cursor-pointer"><i class="fa-solid fa-trash"></i> Hapus</button></form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-10 text-slate-400">Belum ada slider.</div>
    @endforelse

    {{-- Lightbox --}}
    <div x-show="lightbox" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        @click="lightbox = false" @keydown.escape.window="lightbox = false"
        class="fixed inset-0 z-[60] bg-black/80 flex items-center justify-center p-4 sm:p-8" style="display:none;">
        <div class="relative max-w-5xl w-full max-h-[90vh] flex flex-col items-center" @click.stop>
            <button @click="lightbox = false" class="absolute -top-2 -right-2 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center text-slate-600 hover:text-red-500 transition z-10">
                <i class="fa-solid fa-times text-lg"></i>
            </button>
            <img :src="lightboxSrc" :alt="lightboxTitle" class="max-w-full max-h-[80vh] object-contain rounded-xl shadow-2xl">
            <p class="text-white text-sm font-medium mt-4 text-center" x-text="lightboxTitle"></p>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')
@section('title', 'Blog')
@section('page-title', 'Manajemen Blog')

@section('content')
{{-- Rekap Data --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 border border-slate-200/60 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center"><i class="fa-solid fa-newspaper"></i></div>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ $totalPosts }}</p>
                <p class="text-xs text-slate-400">Total Artikel</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-slate-200/60 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center"><i class="fa-solid fa-tags"></i></div>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ $totalCategories }}</p>
                <p class="text-xs text-slate-400">Total Kategori</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-slate-200/60 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center"><i class="fa-solid fa-eye"></i></div>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($totalViews) }}</p>
                <p class="text-xs text-slate-400">Total Pembaca</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-slate-200/60 shadow-sm">
        <p class="text-xs font-semibold text-slate-500 mb-2">Artikel per Kategori</p>
        <div class="space-y-1.5 max-h-20 overflow-y-auto">
            @foreach($categoryCounts as $cat)
            <div class="flex items-center justify-between text-xs">
                <span class="text-slate-600">{{ $cat->name }}</span>
                <span class="font-bold text-slate-900">{{ $cat->posts_count }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-slate-500">{{ $posts->total() }} artikel</p>
    <div class="flex items-center gap-3">
        @php $postTrashCount = \App\Models\Post::onlyTrashed()->count(); @endphp
        @if($postTrashCount > 0)
        <a href="{{ route('admin.posts.trash') }}" class="text-sm text-red-500 hover:text-red-600 flex items-center gap-1.5 cursor-pointer">
            <i class="fa-solid fa-trash-can text-xs"></i> Sampah <span class="bg-red-100 text-red-600 text-xs px-1.5 py-0.5 rounded-full font-bold">{{ $postTrashCount }}</span>
        </a>
        @endif
        <a href="{{ route('admin.posts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2"><i class="fa-solid fa-plus"></i> Buat Artikel</a>
    </div>
</div>
<div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200"><tr>
                <th class="text-left px-6 py-3 font-semibold text-slate-600 w-16">Gambar</th>
                <th class="text-left px-6 py-3 font-semibold text-slate-600">Judul</th>
                <th class="text-left px-6 py-3 font-semibold text-slate-600">Kategori</th>
                <th class="text-left px-6 py-3 font-semibold text-slate-600">Status</th>
                <th class="text-left px-6 py-3 font-semibold text-slate-600"><i class="fa-solid fa-eye text-xs mr-1"></i> Dibaca</th>
                <th class="text-left px-6 py-3 font-semibold text-slate-600">Tanggal</th>
                <th class="text-right px-6 py-3 font-semibold text-slate-600">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($posts as $post)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-3">
                        @if($post->featured_image)
                        <img src="{{ asset('uploads/'.$post->featured_image) }}" alt="" class="w-12 h-12 object-cover rounded-lg border border-slate-200">
                        @else
                        <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center"><i class="fa-solid fa-image text-slate-300 text-sm"></i></div>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-medium text-slate-900">{{ Str::limit($post->title, 50) }}</td>
                    <td class="px-6 py-4">
                        @foreach($post->categories as $cat)<span class="text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full mr-1">{{ $cat->name }}</span>@endforeach
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs px-2 py-1 rounded-full font-medium {{ $post->is_published ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }}">{{ $post->is_published ? 'Terbit' : 'Draf' }}</span>
                    </td>
                    <td class="px-6 py-4 text-slate-500 text-xs">{{ number_format($post->views_count) }}</td>
                    <td class="px-6 py-4 text-slate-500">{{ $post->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="text-blue-600 hover:text-blue-700 mr-3"><i class="fa-solid fa-edit"></i></a>
                        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="inline" onsubmit="event.preventDefault(); confirmDelete(this, 'Hapus Artikel', 'Apakah Anda yakin ingin menghapus artikel &quot;{{ addslashes($post->title) }}&quot;?')">@csrf @method('DELETE')<button class="text-red-400 hover:text-red-600 cursor-pointer"><i class="fa-solid fa-trash"></i></button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-10 text-center text-slate-400">Belum ada artikel.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-3 border-t border-slate-100">{{ $posts->links() }}</div>
</div>
@endsection

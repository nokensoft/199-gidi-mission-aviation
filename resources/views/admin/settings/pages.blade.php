@extends('layouts.admin')
@section('title', 'Halaman Statis')
@section('page-title', 'Halaman Statis')
@section('content')
<div class="flex gap-3 mb-6">
    <a href="{{ route('admin.settings.index') }}" class="bg-slate-100 text-slate-600 hover:bg-slate-200 px-4 py-2 rounded-lg text-sm font-medium">Umum</a>
    <a href="{{ route('admin.settings.pages') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium">Halaman Statis</a>
</div>

<div class="flex items-center justify-between mb-4">
    @php $pageTrashCount = \App\Models\Page::onlyTrashed()->count(); @endphp
    <div></div>
    @if($pageTrashCount > 0)
    <a href="{{ route('admin.settings.pages.trash') }}" class="text-sm text-red-500 hover:text-red-600 flex items-center gap-1.5 cursor-pointer">
        <i class="fa-solid fa-trash-can text-xs"></i> Sampah <span class="bg-red-100 text-red-600 text-xs px-1.5 py-0.5 rounded-full font-bold">{{ $pageTrashCount }}</span>
    </a>
    @endif
</div>

<div class="grid lg:grid-cols-3 gap-6">
    {{-- Form Tambah Halaman --}}
    <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
        <h3 class="font-bold text-slate-900 mb-4">Tambah Halaman</h3>
        <form method="POST" action="{{ route('admin.settings.pages.store') }}" class="space-y-3">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Judul</label>
                <input type="text" name="title" required placeholder="Judul halaman" value="{{ old('title') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Slug</label>
                <input type="text" name="slug" required placeholder="contoh: tentang-kami" value="{{ old('slug') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
                <p class="text-xs text-slate-400 mt-1">URL: /halaman/<span class="font-medium">slug-anda</span></p>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl font-medium transition">Tambah</button>
        </form>
    </div>

    {{-- Daftar Halaman --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200"><tr>
                    <th class="text-left px-6 py-3 font-semibold text-slate-600">Judul</th>
                    <th class="text-left px-6 py-3 font-semibold text-slate-600">URL</th>
                    <th class="text-right px-6 py-3 font-semibold text-slate-600">Aksi</th>
                </tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pages as $page)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $page->title }}</td>
                        <td class="px-6 py-4" x-data="{ copied: false }">
                            <div class="flex items-center gap-2">
                                <span class="text-slate-500 text-xs">/halaman/{{ $page->slug }}</span>
                                <button type="button" @click="navigator.clipboard.writeText('{{ url('/halaman/'.$page->slug) }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                    class="text-slate-400 hover:text-blue-600 transition cursor-pointer" title="Salin URL">
                                    <i class="fa-regular fa-copy text-xs" x-show="!copied"></i>
                                    <i class="fa-solid fa-check text-xs text-emerald-500" x-show="copied" style="display:none;"></i>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.settings.pages.edit', $page) }}" class="text-blue-600 hover:text-blue-700 text-sm"><i class="fa-solid fa-edit"></i> Edit</a>
                                <form method="POST" action="{{ route('admin.settings.pages.destroy', $page) }}" class="inline"
                                    onsubmit="event.preventDefault(); confirmDelete(this, 'Hapus Halaman', 'Apakah Anda yakin ingin menghapus halaman &quot;{{ addslashes($page->title) }}&quot;?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-400 hover:text-red-600 text-sm cursor-pointer"><i class="fa-solid fa-trash"></i> Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-16 text-center">
                            <i class="fa-solid fa-file-lines text-4xl text-slate-200 mb-3 block"></i>
                            <p class="text-slate-400">Belum ada halaman.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

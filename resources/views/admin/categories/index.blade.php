@extends('layouts.admin')
@section('title', 'Kategori')
@section('page-title', 'Manajemen Kategori')

@section('content')
<div class="grid lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
        <h3 class="font-bold text-slate-900 mb-4">Tambah Kategori</h3>
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <input type="text" name="name" required placeholder="Nama kategori" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-slate-900 mb-3">
            @error('name')<p class="text-red-500 text-xs mb-2">{{ $message }}</p>@enderror
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl font-medium transition">Tambah</button>
        </form>
    </div>
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200"><tr>
                    <th class="text-left px-6 py-3 font-semibold text-slate-600">Nama</th>
                    <th class="text-left px-6 py-3 font-semibold text-slate-600">Slug</th>
                    <th class="text-left px-6 py-3 font-semibold text-slate-600">Artikel</th>
                    <th class="text-right px-6 py-3 font-semibold text-slate-600">Aksi</th>
                </tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($categories as $cat)
                    <tr class="hover:bg-slate-50" x-data="{ editing: false }">
                        <td class="px-6 py-4">
                            <span x-show="!editing" class="font-medium text-slate-900">{{ $cat->name }}</span>
                            <form x-show="editing" style="display:none;" method="POST" action="{{ route('admin.categories.update', $cat) }}" class="flex gap-2">
                                @csrf @method('PUT')
                                <input type="text" name="name" value="{{ $cat->name }}" class="px-3 py-1 border rounded-lg text-sm flex-1">
                                <button type="submit" class="text-blue-600 text-xs font-medium">Simpan</button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-slate-500">{{ $cat->slug }}</td>
                        <td class="px-6 py-4 text-slate-500">{{ $cat->posts_count }}</td>
                        <td class="px-6 py-4 text-right">
                            <button @click="editing = !editing" class="text-blue-600 hover:text-blue-700 mr-3"><i class="fa-solid fa-edit"></i></button>
                            <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" class="inline" onsubmit="event.preventDefault(); confirmDelete(this, 'Hapus Kategori', 'Apakah Anda yakin ingin menghapus kategori &quot;{{ addslashes($cat->name) }}&quot;?')">@csrf @method('DELETE')<button class="text-red-400 hover:text-red-600 cursor-pointer"><i class="fa-solid fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-10 text-center text-slate-400">Belum ada kategori.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-6 py-3 border-t border-slate-100">{{ $categories->links() }}</div>
        </div>
    </div>
</div>
@endsection

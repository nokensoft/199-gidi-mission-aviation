@extends('layouts.admin')
@section('title', 'Layanan')
@section('page-title', 'Manajemen Layanan')
@section('content')
<div class="flex items-center justify-end mb-4">
    @php $serviceTrashCount = \App\Models\Service::onlyTrashed()->count(); @endphp
    @if($serviceTrashCount > 0)
    <a href="{{ route('admin.services.trash') }}" class="text-sm text-red-500 hover:text-red-600 flex items-center gap-1.5 cursor-pointer">
        <i class="fa-solid fa-trash-can text-xs"></i> Sampah <span class="bg-red-100 text-red-600 text-xs px-1.5 py-0.5 rounded-full font-bold">{{ $serviceTrashCount }}</span>
    </a>
    @endif
</div>
<div class="grid lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm" x-data="{ editing: null }">
        <h3 class="font-bold text-slate-900 mb-4">Tambah Layanan</h3>
        <form method="POST" action="{{ route('admin.services.store') }}" class="space-y-3">
            @csrf
            <input type="text" name="title" required placeholder="Judul layanan" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-sm">
            <textarea name="description" rows="3" required placeholder="Deskripsi" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-sm resize-none"></textarea>
            <input type="text" name="icon" required placeholder="Icon (fa-solid fa-star)" value="fa-solid fa-star" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-sm">
            <select name="color" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm"><option value="blue">Biru</option><option value="indigo">Indigo</option><option value="red">Merah</option><option value="amber">Kuning</option><option value="emerald">Hijau</option></select>
            <input type="number" name="sort_order" value="0" placeholder="Urutan" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl font-medium transition">Tambah</button>
        </form>
    </div>
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200"><tr>
                    <th class="text-left px-6 py-3 font-semibold text-slate-600">Icon</th>
                    <th class="text-left px-6 py-3 font-semibold text-slate-600">Judul</th>
                    <th class="text-left px-6 py-3 font-semibold text-slate-600">Deskripsi</th>
                    <th class="text-right px-6 py-3 font-semibold text-slate-600">Aksi</th>
                </tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($services as $s)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4"><i class="{{ $s->icon }} text-{{ $s->color }}-600 text-lg"></i></td>
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $s->title }}</td>
                        <td class="px-6 py-4 text-slate-500 max-w-xs truncate">{{ Str::limit($s->description, 60) }}</td>
                        <td class="px-6 py-4 text-right">
                            <form method="POST" action="{{ route('admin.services.destroy', $s) }}" class="inline" onsubmit="event.preventDefault(); confirmDelete(this, 'Hapus Layanan', 'Apakah Anda yakin ingin menghapus layanan &quot;{{ addslashes($s->title) }}&quot;?')">@csrf @method('DELETE')<button class="text-red-400 hover:text-red-600 cursor-pointer"><i class="fa-solid fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-10 text-center text-slate-400">Belum ada layanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

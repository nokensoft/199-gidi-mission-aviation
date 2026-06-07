@extends('layouts.admin')
@section('title', 'Layanan')
@section('page-title', 'Manajemen Layanan')
@section('content')
<div x-data="{ editModal: false, editService: {} }">
<div class="flex items-center justify-end mb-4">
    @php $serviceTrashCount = \App\Models\Service::onlyTrashed()->count(); @endphp
    @if($serviceTrashCount > 0)
    <a href="{{ route('admin.services.trash') }}" class="text-sm text-red-500 hover:text-red-600 flex items-center gap-1.5 cursor-pointer">
        <i class="fa-solid fa-trash-can text-xs"></i> Sampah <span class="bg-red-100 text-red-600 text-xs px-1.5 py-0.5 rounded-full font-bold">{{ $serviceTrashCount }}</span>
    </a>
    @endif
</div>
<div class="grid lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
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
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1.5">
                                <button @click="editService = { id: {{ $s->id }}, title: '{{ addslashes($s->title) }}', description: `{{ addslashes($s->description) }}`, icon: '{{ addslashes($s->icon) }}', color: '{{ $s->color }}', sort_order: {{ $s->sort_order ?? 0 }} }; editModal = true" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition cursor-pointer" title="Edit"><i class="fa-solid fa-edit text-xs"></i></button>
                                <form method="POST" action="{{ route('admin.services.destroy', $s) }}" class="inline" onsubmit="event.preventDefault(); confirmDelete(this, 'Hapus Layanan', 'Apakah Anda yakin ingin menghapus layanan &quot;{{ addslashes($s->title) }}&quot;?')">@csrf @method('DELETE')<button class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition cursor-pointer" title="Hapus"><i class="fa-solid fa-trash text-xs"></i></button></form>
                            </div>
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

{{-- Modal Edit Layanan --}}
<div x-show="editModal" x-transition.opacity style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
    <div @click.outside="editModal = false" class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-slate-900 text-lg">Edit Layanan</h3>
            <button @click="editModal = false" class="text-slate-400 hover:text-slate-600 cursor-pointer"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>
        <form method="POST" :action="'/admin/services/' + editService.id" class="space-y-3">
            @csrf @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Judul</label>
                <input type="text" name="title" x-model="editService.title" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" x-model="editService.description" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-sm resize-none"></textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Icon</label>
                <input type="text" name="icon" x-model="editService.icon" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Warna</label>
                <select name="color" x-model="editService.color" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
                    <option value="blue">Biru</option><option value="indigo">Indigo</option><option value="red">Merah</option><option value="amber">Kuning</option><option value="emerald">Hijau</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Urutan</label>
                <input type="number" name="sort_order" x-model="editService.sort_order" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" @click="editModal = false" class="flex-1 py-2.5 rounded-xl font-medium border border-slate-200 text-slate-600 hover:bg-slate-50 transition">Batal</button>
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl font-medium transition">Simpan</button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection

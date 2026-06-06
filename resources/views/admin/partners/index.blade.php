@extends('layouts.admin')
@section('title', 'Mitra Kerja')
@section('page-title', 'Manajemen Mitra Kerja')
@section('content')
<div class="flex items-center justify-end mb-4">
    @php $partnerTrashCount = \App\Models\Partner::onlyTrashed()->count(); @endphp
    @if($partnerTrashCount > 0)
    <a href="{{ route('admin.partners.trash') }}" class="text-sm text-red-500 hover:text-red-600 flex items-center gap-1.5 cursor-pointer">
        <i class="fa-solid fa-trash-can text-xs"></i> Sampah <span class="bg-red-100 text-red-600 text-xs px-1.5 py-0.5 rounded-full font-bold">{{ $partnerTrashCount }}</span>
    </a>
    @endif
</div>
<div class="grid lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
        <h3 class="font-bold text-slate-900 mb-4">Tambah Mitra</h3>
        <form method="POST" action="{{ route('admin.partners.store') }}" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <input type="text" name="name" required placeholder="Singkatan (GIDI)" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
            <input type="text" name="full_name" placeholder="Nama lengkap" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
            <input type="file" name="logo" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-600">
            <input type="number" name="sort_order" value="0" placeholder="Urutan" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl font-medium transition">Tambah</button>
        </form>
    </div>
    <div class="lg:col-span-2">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($partners as $p)
            <div class="bg-white rounded-xl p-4 border border-slate-200/60 shadow-sm text-center">
                @if($p->logo)<img src="{{ asset('images/'.$p->logo) }}" alt="{{ $p->name }}" class="w-16 h-16 object-contain mx-auto mb-2">@endif
                <h4 class="font-bold text-blue-600">{{ $p->name }}</h4>
                <p class="text-xs text-slate-500">{{ $p->full_name }}</p>
                <form method="POST" action="{{ route('admin.partners.destroy', $p) }}" class="mt-3" onsubmit="event.preventDefault(); confirmDelete(this, 'Hapus Mitra', 'Apakah Anda yakin ingin menghapus mitra &quot;{{ addslashes($p->name) }}&quot;?')">@csrf @method('DELETE')<button class="text-red-400 hover:text-red-600 text-xs cursor-pointer"><i class="fa-solid fa-trash"></i> Hapus</button></form>
            </div>
            @empty
            <div class="col-span-full text-center py-10 text-slate-400">Belum ada mitra.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection

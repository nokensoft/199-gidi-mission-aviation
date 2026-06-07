@extends('layouts.admin')
@section('title', 'Donasi')
@section('page-title', 'Manajemen Donasi')

@section('content')
<div class="flex items-center justify-between mb-4">
    <a href="{{ route('admin.donations.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center gap-1.5">
        <i class="fa-solid fa-plus text-xs"></i> Tambah Donasi
    </a>
    @php $donationTrashCount = \App\Models\Donation::onlyTrashed()->count(); @endphp
    @if($donationTrashCount > 0)
    <a href="{{ route('admin.donations.trash') }}" class="text-sm text-red-500 hover:text-red-600 flex items-center gap-1.5 cursor-pointer">
        <i class="fa-solid fa-trash-can text-xs"></i> Sampah <span class="bg-red-100 text-red-600 text-xs px-1.5 py-0.5 rounded-full font-bold">{{ $donationTrashCount }}</span>
    </a>
    @endif
</div>
<form method="GET" class="flex flex-wrap gap-3 mb-6">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/telepon..." class="px-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
    <select name="status" class="px-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
        <option value="">Semua Status</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Terkonfirmasi</option>
        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
    </select>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium"><i class="fa-solid fa-search mr-1"></i> Filter</button>
</form>

<div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200"><tr>
                <th class="text-left px-6 py-3 font-semibold text-slate-600">Donatur</th>
                <th class="text-left px-6 py-3 font-semibold text-slate-600">Paket</th>
                <th class="text-left px-6 py-3 font-semibold text-slate-600">Metode</th>
                <th class="text-left px-6 py-3 font-semibold text-slate-600">Status</th>
                <th class="text-left px-6 py-3 font-semibold text-slate-600">Tanggal</th>
                <th class="text-right px-6 py-3 font-semibold text-slate-600">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($donations as $d)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4"><span class="font-medium text-slate-900">{{ $d->donor_name }}</span><br><span class="text-xs text-slate-400">{{ $d->donor_phone }}</span></td>
                    <td class="px-6 py-4 text-slate-600 text-xs">{{ $d->package_label }}</td>
                    <td class="px-6 py-4"><span class="text-xs px-2 py-1 rounded-full {{ $d->payment_method === 'transfer' ? 'bg-blue-50 text-blue-600' : 'bg-amber-50 text-amber-600' }}">{{ ucfirst($d->payment_method) }}</span></td>
                    <td class="px-6 py-4">
                        <span class="text-xs px-2 py-1 rounded-full font-medium {{ $d->status === 'confirmed' ? 'bg-emerald-50 text-emerald-600' : ($d->status === 'rejected' ? 'bg-red-50 text-red-600' : 'bg-amber-50 text-amber-600') }}">{{ $d->status === 'confirmed' ? 'Dikonfirmasi' : ($d->status === 'rejected' ? 'Ditolak' : 'Pending') }}</span>
                    </td>
                    <td class="px-6 py-4 text-slate-500 text-xs">{{ $d->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.donations.show', $d) }}" class="text-blue-600 hover:text-blue-700" title="Detail"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('admin.donations.edit', $d) }}" class="text-amber-500 hover:text-amber-600" title="Edit"><i class="fa-solid fa-edit"></i></a>
                            @if($d->status === 'pending')
                            <form method="POST" action="{{ route('admin.donations.confirm', $d) }}" class="inline">@csrf<button class="text-emerald-600 hover:text-emerald-700" title="Konfirmasi"><i class="fa-solid fa-check"></i></button></form>
                            <form method="POST" action="{{ route('admin.donations.reject', $d) }}" class="inline">@csrf<button class="text-red-400 hover:text-red-600" title="Tolak"><i class="fa-solid fa-times"></i></button></form>
                            @endif
                            <form method="POST" action="{{ route('admin.donations.destroy', $d) }}" class="inline"
                                onsubmit="event.preventDefault(); confirmDelete(this, 'Hapus Donasi', 'Apakah Anda yakin ingin menghapus donasi dari &quot;{{ addslashes($d->donor_name) }}&quot;?')">
                                @csrf @method('DELETE')
                                <button class="text-red-400 hover:text-red-600" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-10 text-center text-slate-400">Belum ada donasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-3 border-t border-slate-100">{{ $donations->appends(request()->query())->links() }}</div>
</div>
@endsection

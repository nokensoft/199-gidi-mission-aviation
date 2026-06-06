@extends('layouts.admin')
@section('title', 'Testimoni')
@section('page-title', 'Manajemen Testimoni')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-slate-500">{{ $testimonials->total() }} testimoni</p>
    @php $testimonialTrashCount = \App\Models\Testimonial::onlyTrashed()->count(); @endphp
    @if($testimonialTrashCount > 0)
    <a href="{{ route('admin.testimonials.trash') }}" class="text-sm text-red-500 hover:text-red-600 flex items-center gap-1.5 cursor-pointer">
        <i class="fa-solid fa-trash-can text-xs"></i> Sampah <span class="bg-red-100 text-red-600 text-xs px-1.5 py-0.5 rounded-full font-bold">{{ $testimonialTrashCount }}</span>
    </a>
    @endif
</div>
<div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200"><tr>
                <th class="text-left px-6 py-3 font-semibold text-slate-600">Nama</th>
                <th class="text-left px-6 py-3 font-semibold text-slate-600">Testimoni</th>
                <th class="text-left px-6 py-3 font-semibold text-slate-600">Status</th>
                <th class="text-left px-6 py-3 font-semibold text-slate-600">Unggulan</th>
                <th class="text-right px-6 py-3 font-semibold text-slate-600">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($testimonials as $t)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4"><span class="font-medium text-slate-900">{{ $t->display_name }}</span><br><span class="text-xs text-slate-400">{{ $t->role_title }}</span></td>
                    <td class="px-6 py-4 text-slate-600 max-w-xs truncate">{{ Str::limit($t->content, 80) }}</td>
                    <td class="px-6 py-4">
                        <form method="POST" action="{{ route('admin.testimonials.toggle-approval', $t) }}" class="inline">@csrf
                        <button class="text-xs px-2 py-1 rounded-full font-medium {{ $t->is_approved ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">{{ $t->is_approved ? 'Disetujui' : 'Pending' }}</button></form>
                    </td>
                    <td class="px-6 py-4">
                        <form method="POST" action="{{ route('admin.testimonials.toggle-featured', $t) }}" class="inline">@csrf
                        <button class="text-xs px-2 py-1 rounded-full font-medium {{ $t->is_featured ? 'bg-blue-50 text-blue-600' : 'bg-slate-100 text-slate-400' }}">{{ $t->is_featured ? 'Ya' : 'Tidak' }}</button></form>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.testimonials.edit', $t) }}" class="text-blue-600 hover:text-blue-700 mr-3"><i class="fa-solid fa-edit"></i></a>
                        <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" class="inline" onsubmit="event.preventDefault(); confirmDelete(this, 'Hapus Testimoni', 'Apakah Anda yakin ingin menghapus testimoni dari &quot;{{ addslashes($t->name) }}&quot;?')">@csrf @method('DELETE')<button class="text-red-400 hover:text-red-600 cursor-pointer"><i class="fa-solid fa-trash"></i></button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-10 text-center text-slate-400">Belum ada testimoni.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-3 border-t border-slate-100">{{ $testimonials->links() }}</div>
</div>
@endsection

{{--
    Reusable trash view. Pass these variables:
    $title       - e.g. 'Artikel'
    $items       - paginated collection of trashed items
    $columns     - array of ['label' => 'Header', 'field' => 'name'] or closure
    $backRoute   - route name for back link
    $restoreRoute - route name prefix for restore (receives $item->id)
    $forceDeleteRoute - route name prefix for force delete
--}}

@extends('layouts.admin')
@section('title', 'Tempat Sampah - ' . $title)
@section('page-title', 'Tempat Sampah: ' . $title)

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-slate-500"><i class="fa-solid fa-trash-can mr-1"></i> {{ $items->total() }} item di tempat sampah</p>
    <a href="{{ route($backRoute) }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1 cursor-pointer">
        <i class="fa-solid fa-arrow-left text-xs"></i> Kembali
    </a>
</div>

<div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-red-50 border-b border-red-100">
                <tr>
                    @foreach($columns as $col)
                    <th class="text-left px-6 py-3 font-semibold text-red-800">{{ $col['label'] }}</th>
                    @endforeach
                    <th class="text-left px-6 py-3 font-semibold text-red-800">Dihapus</th>
                    <th class="text-right px-6 py-3 font-semibold text-red-800">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($items as $item)
                <tr class="hover:bg-slate-50">
                    @foreach($columns as $col)
                    <td class="px-6 py-4 text-slate-700">
                        @if(isset($col['html']))
                            {!! $col['html']($item) !!}
                        @else
                            {{ data_get($item, $col['field']) }}
                        @endif
                    </td>
                    @endforeach
                    <td class="px-6 py-4 text-slate-400 text-xs">{{ $item->deleted_at->diffForHumans() }}</td>
                    <td class="px-6 py-4 text-right flex items-center justify-end gap-2">
                        <form method="POST" action="{{ route($restoreRoute, $item->id) }}" class="inline">
                            @csrf
                            <button class="text-emerald-600 hover:text-emerald-700 text-sm cursor-pointer" title="Pulihkan">
                                <i class="fa-solid fa-rotate-left mr-1"></i> Pulihkan
                            </button>
                        </form>
                        <form method="POST" action="{{ route($forceDeleteRoute, $item->id) }}" class="inline"
                            onsubmit="event.preventDefault(); confirmDelete(this, 'Hapus Permanen', 'Data akan dihapus permanen dan tidak dapat dipulihkan lagi.', 'Hapus Permanen')">
                            @csrf @method('DELETE')
                            <button class="text-red-400 hover:text-red-600 text-sm cursor-pointer" title="Hapus Permanen">
                                <i class="fa-solid fa-trash mr-1"></i> Hapus Permanen
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ count($columns) + 2 }}" class="px-6 py-16 text-center">
                        <i class="fa-solid fa-trash-can text-4xl text-slate-200 mb-3 block"></i>
                        <p class="text-slate-400">Tempat sampah kosong.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($items->hasPages())
    <div class="px-6 py-3 border-t border-slate-100">{{ $items->links() }}</div>
    @endif
</div>
@endsection

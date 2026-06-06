@extends('layouts.admin')
@section('title', 'Halaman Statis')
@section('page-title', 'Halaman Statis')
@section('content')
<div class="flex gap-3 mb-6">
    <a href="{{ route('admin.settings.index') }}" class="bg-slate-100 text-slate-600 hover:bg-slate-200 px-4 py-2 rounded-lg text-sm font-medium">Umum</a>
    <a href="{{ route('admin.settings.pages') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium">Halaman Statis</a>
</div>
<div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-200"><tr>
            <th class="text-left px-6 py-3 font-semibold text-slate-600">Judul</th>
            <th class="text-left px-6 py-3 font-semibold text-slate-600">Slug</th>
            <th class="text-right px-6 py-3 font-semibold text-slate-600">Aksi</th>
        </tr></thead>
        <tbody class="divide-y divide-slate-100">
            @foreach($pages as $page)
            <tr class="hover:bg-slate-50">
                <td class="px-6 py-4 font-medium text-slate-900">{{ $page->title }}</td>
                <td class="px-6 py-4 text-slate-500">/halaman/{{ $page->slug }}</td>
                <td class="px-6 py-4 text-right"><a href="{{ route('admin.settings.pages.edit', $page) }}" class="text-blue-600 hover:text-blue-700"><i class="fa-solid fa-edit"></i> Edit</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

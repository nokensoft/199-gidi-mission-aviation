@extends('layouts.admin')
@section('title', 'Edit Testimoni')
@section('page-title', 'Edit Testimoni')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm space-y-5">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama</label>
            <input type="text" name="name" value="{{ old('name', $testimonial->name) }}" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Jabatan / Peran</label>
            <input type="text" name="role_title" value="{{ old('role_title', $testimonial->role_title) }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Testimoni</label>
            <textarea name="content" rows="4" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition resize-none">{{ old('content', $testimonial->content) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Visibilitas</label>
            <select name="visibility" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                <option value="public" {{ $testimonial->visibility === 'public' ? 'selected' : '' }}>Publik</option>
                <option value="anonymous" {{ $testimonial->visibility === 'anonymous' ? 'selected' : '' }}>Anonim</option>
            </select>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-bold transition">Perbarui</button>
            <a href="{{ route('admin.testimonials.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-medium transition">Batal</a>
        </div>
    </form>
</div>
@endsection

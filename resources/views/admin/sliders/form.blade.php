@extends('layouts.admin')
@section('title', isset($slider) ? 'Edit Slider' : 'Tambah Slider')
@section('page-title', isset($slider) ? 'Edit Slider' : 'Tambah Slider')
@section('content')
<div class="max-w-2xl">
<form method="POST" action="{{ isset($slider) ? route('admin.sliders.update', $slider) : route('admin.sliders.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm space-y-5">
    @csrf @if(isset($slider)) @method('PUT') @endif
    <div><label class="block text-sm font-semibold text-slate-700 mb-2">Judul</label><input type="text" name="title" value="{{ old('title', $slider->title ?? '') }}" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"></div>
    <div><label class="block text-sm font-semibold text-slate-700 mb-2">Subtitle</label><input type="text" name="subtitle" value="{{ old('subtitle', $slider->subtitle ?? '') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"></div>
    <div><label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label><textarea name="description" rows="3" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition resize-none">{{ old('description', $slider->description ?? '') }}</textarea></div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Teks Tombol</label><input type="text" name="button_text" value="{{ old('button_text', $slider->button_text ?? '') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Link Tombol</label><input type="text" name="button_link" value="{{ old('button_link', $slider->button_link ?? '') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"></div>
    </div>
    <div><label class="block text-sm font-semibold text-slate-700 mb-2">Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order', $slider->sort_order ?? 0) }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"></div>
    <div x-data="dropZone('{{ isset($slider) && $slider->image ? asset('uploads/'.$slider->image) : '' }}')">
        <label class="block text-sm font-semibold text-slate-700 mb-2">Gambar Slider</label>
        <div class="relative border-2 border-dashed rounded-xl p-4 text-center transition-all duration-200"
            :class="dragover ? 'border-blue-500 bg-blue-50' : 'border-slate-200 hover:border-blue-400'"
            @dragover.prevent="dragover = true" @dragleave.prevent="dragover = false"
            @drop.prevent="dragover = false; handleDrop($event)">
            <input type="file" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="handleFile($event)">
            <template x-if="preview">
                <img :src="preview" class="mx-auto max-h-48 object-contain rounded-lg mb-2">
            </template>
            <template x-if="!preview">
                <div class="py-8">
                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-300 mb-3"></i>
                    <p class="text-sm text-slate-500">Seret gambar ke sini atau <span class="text-blue-600 font-medium">pilih file</span></p>
                    <p class="text-xs text-slate-400 mt-1">Otomatis dikonversi ke WebP (Maks 10MB)</p>
                </div>
            </template>
            <template x-if="fileName"><p class="text-xs text-slate-500 mt-1" x-text="fileName"></p></template>
        </div>
    </div>
    <label class="flex items-center gap-3"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $slider->is_active ?? true) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded"><span class="text-sm text-slate-700 font-medium">Aktif</span></label>
    <div class="flex gap-3"><button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-bold transition">{{ isset($slider) ? 'Perbarui' : 'Simpan' }}</button><a href="{{ route('admin.sliders.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-medium transition">Batal</a></div>
</form>
</div>
@push('scripts')
<script>
function dropZone(existing) {
    return {
        preview: existing || null, fileName: null, dragover: false,
        handleFile(e) { this.setPreview(e.target.files[0]); },
        handleDrop(e) {
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                const input = this.$el.querySelector('input[type=file]');
                const dt = new DataTransfer(); dt.items.add(file); input.files = dt.files;
                this.setPreview(file);
            }
        },
        setPreview(file) {
            if (!file) return;
            this.fileName = file.name + ' (' + (file.size / 1024 / 1024).toFixed(1) + ' MB)';
            const reader = new FileReader();
            reader.onload = (e) => { this.preview = e.target.result; };
            reader.readAsDataURL(file);
        }
    }
}
</script>
@endpush
@endsection

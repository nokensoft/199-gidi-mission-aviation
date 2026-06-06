@extends('layouts.admin')
@section('title', isset($post) ? 'Edit Artikel' : 'Buat Artikel')
@section('page-title', isset($post) ? 'Edit Artikel' : 'Buat Artikel Baru')

@section('content')
<form method="POST" action="{{ isset($post) ? route('admin.posts.update', $post) : route('admin.posts.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($post)) @method('PUT') @endif

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Artikel</label>
                <input type="text" name="title" value="{{ old('title', $post->title ?? '') }}" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-slate-900" placeholder="Masukkan judul...">
                @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Konten</label>
                <textarea id="content-editor" name="content" rows="20">{{ old('content', $post->content ?? '') }}</textarea>
                @error('content')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Ringkasan (Opsional)</label>
                <textarea name="excerpt" rows="3" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-slate-900 resize-none" placeholder="Ringkasan singkat...">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
            </div>
        </div>
        <div class="space-y-6">
            <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
                <label class="block text-sm font-semibold text-slate-700 mb-3">Status</label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $post->is_published ?? false) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                    <span class="text-sm text-slate-700 font-medium">Publikasikan</span>
                </label>
            </div>
            <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
                <label class="block text-sm font-semibold text-slate-700 mb-3">Kategori</label>
                <div class="space-y-2 max-h-48 overflow-y-auto">
                    @foreach($categories as $cat)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="categories[]" value="{{ $cat->id }}" {{ in_array($cat->id, old('categories', isset($post) ? $post->categories->pluck('id')->toArray() : [])) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                        <span class="text-sm text-slate-700">{{ $cat->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm" x-data="dropZone('{{ isset($post) && $post->featured_image ? asset('uploads/'.$post->featured_image) : '' }}')">
                <label class="block text-sm font-semibold text-slate-700 mb-3">Gambar Utama</label>
                <div class="relative border-2 border-dashed rounded-xl p-4 text-center transition-all duration-200"
                    :class="dragover ? 'border-blue-500 bg-blue-50' : 'border-slate-200 hover:border-blue-400'"
                    @dragover.prevent="dragover = true" @dragleave.prevent="dragover = false"
                    @drop.prevent="dragover = false; handleDrop($event)">
                    <input type="file" name="featured_image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="handleFile($event)">
                    <template x-if="preview">
                        <img :src="preview" class="mx-auto max-h-40 object-contain rounded-lg mb-2">
                    </template>
                    <template x-if="!preview">
                        <div class="py-6">
                            <i class="fa-solid fa-cloud-arrow-up text-2xl text-slate-300 mb-2"></i>
                            <p class="text-sm text-slate-500">Seret gambar ke sini atau <span class="text-blue-600 font-medium">pilih file</span></p>
                            <p class="text-xs text-slate-400 mt-1">Otomatis dikonversi ke WebP (Maks 10MB)</p>
                        </div>
                    </template>
                    <template x-if="fileName"><p class="text-xs text-slate-500 mt-1" x-text="fileName"></p></template>
                </div>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-bold transition">{{ isset($post) ? 'Perbarui' : 'Simpan' }}</button>
                <a href="{{ route('admin.posts.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-medium transition">Batal</a>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
function dropZone(existing) {
    return {
        preview: existing || null,
        fileName: null,
        dragover: false,
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
tinymce.init({
    selector: '#content-editor',
    height: 500,
    menubar: true,
    plugins: 'lists link image table code wordcount fullscreen preview',
    toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image table | code fullscreen',
    content_style: 'body { font-family: Calibri, sans-serif; font-size: 16px; }',
    branding: false,
    promotion: false,
});
</script>
@endpush
@endsection

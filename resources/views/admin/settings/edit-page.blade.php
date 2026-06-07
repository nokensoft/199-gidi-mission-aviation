@extends('layouts.admin')
@section('title', 'Edit '.$page->title)
@section('page-title', 'Edit Halaman: '.$page->title)
@section('content')
<form method="POST" action="{{ route('admin.settings.pages.update', $page) }}" class="max-w-4xl space-y-6">
    @csrf @method('PUT')
    <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
        <label class="block text-sm font-semibold text-slate-700 mb-2">Judul</label>
        <input type="text" name="title" value="{{ old('title', $page->title) }}" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
    </div>
    <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
        <label class="block text-sm font-semibold text-slate-700 mb-2">Konten</label>
        <textarea id="page-editor" name="content">{{ old('content', $page->content) }}</textarea>
    </div>
    <div class="flex gap-3">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold transition">Perbarui</button>
        <a href="{{ route('admin.settings.pages') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-medium transition">Batal</a>
    </div>
</form>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#page-editor',
    height: 500,
    menubar: true,
    plugins: 'lists link image table code wordcount fullscreen preview',
    toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image table | code fullscreen',
    content_style: 'body { font-family: Calibri, sans-serif; font-size: 16px; }',
    branding: false,
    promotion: false,
    image_title: true,
    automatic_uploads: true,
    file_picker_types: 'image',
    images_upload_handler: (blobInfo) => new Promise((resolve, reject) => {
        const formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        fetch('{{ route("admin.upload-image") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(res => {
            if (!res.ok) throw new Error('Upload gagal');
            return res.json();
        })
        .then(data => resolve(data.location))
        .catch(() => reject('Upload gambar gagal. Pastikan ukuran file tidak melebihi 10MB.'));
    }),
});
</script>
@endpush
@endsection

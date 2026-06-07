@extends('layouts.admin')
@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Situs')
@section('content')
<div class="flex gap-3 mb-6">
    <a href="{{ route('admin.settings.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium">Umum</a>
    <a href="{{ route('admin.settings.pages') }}" class="bg-slate-100 text-slate-600 hover:bg-slate-200 px-4 py-2 rounded-lg text-sm font-medium">Halaman Statis</a>
</div>
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf @method('PUT')

    {{-- Logo & Favicon --}}
    <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
        <h3 class="font-bold text-slate-900 mb-4">Logo & Favicon</h3>
        <div class="grid md:grid-cols-2 gap-6">
            <div x-data="dropZone('{{ $settings['site_logo'] ?? '' ? asset('uploads/'.($settings['site_logo'] ?? '')) : asset('images/logo.png') }}')">
                <label class="block text-sm font-medium text-slate-600 mb-2">Logo Situs</label>
                <div class="relative border-2 border-dashed rounded-xl p-4 text-center transition-all duration-200"
                    :class="dragover ? 'border-blue-500 bg-blue-50' : 'border-slate-200 hover:border-blue-400'"
                    @dragover.prevent="dragover = true" @dragleave.prevent="dragover = false"
                    @drop.prevent="dragover = false; handleDrop($event)">
                    <input type="file" name="site_logo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="handleFile($event)">
                    <img :src="preview" class="mx-auto h-20 object-contain mb-2" x-show="preview">
                    <template x-if="!preview"><div class="py-4"><i class="fa-solid fa-cloud-arrow-up text-xl text-slate-300"></i><p class="text-xs text-slate-400 mt-1">Upload logo</p></div></template>
                    <template x-if="fileName"><p class="text-xs text-slate-400" x-text="fileName"></p></template>
                </div>
            </div>
            <div x-data="dropZone('{{ $settings['site_favicon'] ?? '' ? asset('uploads/'.($settings['site_favicon'] ?? '')) : asset('images/logo.png') }}')">
                <label class="block text-sm font-medium text-slate-600 mb-2">Favicon</label>
                <div class="relative border-2 border-dashed rounded-xl p-4 text-center transition-all duration-200"
                    :class="dragover ? 'border-blue-500 bg-blue-50' : 'border-slate-200 hover:border-blue-400'"
                    @dragover.prevent="dragover = true" @dragleave.prevent="dragover = false"
                    @drop.prevent="dragover = false; handleDrop($event)">
                    <input type="file" name="site_favicon" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="handleFile($event)">
                    <img :src="preview" class="mx-auto h-16 object-contain mb-2" x-show="preview">
                    <template x-if="!preview"><div class="py-4"><i class="fa-solid fa-cloud-arrow-up text-xl text-slate-300"></i><p class="text-xs text-slate-400 mt-1">Upload favicon</p></div></template>
                    <template x-if="fileName"><p class="text-xs text-slate-400" x-text="fileName"></p></template>
                </div>
            </div>
        </div>
    </div>

    @foreach([
        'Informasi Situs' => ['site_name' => 'Nama Situs', 'site_tagline' => 'Tagline', 'site_description' => 'Deskripsi'],
    ] as $section => $fields)
    <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
        <h3 class="font-bold text-slate-900 mb-4">{{ $section }}</h3>
        <div class="grid md:grid-cols-2 gap-4">
            @foreach($fields as $key => $label)
            <div class="{{ Str::contains($key, ['quote','description','address']) ? 'md:col-span-2' : '' }}">
                <label class="block text-sm font-medium text-slate-600 mb-1">{{ $label }}</label>
                @if(Str::contains($key, ['quote','description','address']))
                <textarea name="{{ $key }}" rows="3" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm resize-none">{{ $settings[$key] ?? '' }}</textarea>
                @else
                <input type="text" name="{{ $key }}" value="{{ $settings[$key] ?? '' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    {{-- Kontak 1 --}}
    <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
        <h3 class="font-bold text-slate-900 mb-4">Kontak 1</h3>
        <div class="grid md:grid-cols-3 gap-4">
            <div x-data="contactPhoto('{{ $settings['contact_photo_1'] ?? '' ? asset('uploads/'.($settings['contact_photo_1'] ?? '')) : '' }}')">
                <label class="block text-sm font-medium text-slate-600 mb-2">Foto</label>
                <div class="relative border-2 border-dashed rounded-xl p-4 text-center transition-all duration-200"
                    :class="dragover ? 'border-blue-500 bg-blue-50' : 'border-slate-200 hover:border-blue-400'"
                    @dragover.prevent="dragover = true" @dragleave.prevent="dragover = false"
                    @drop.prevent="dragover = false; handleDrop($event)">
                    <input type="file" name="contact_photo_1" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="handleFile($event)">
                    <img :src="preview" class="mx-auto h-20 w-20 rounded-full object-cover mb-2" x-show="preview">
                    <template x-if="!preview"><div class="py-4"><i class="fa-solid fa-cloud-arrow-up text-xl text-slate-300"></i><p class="text-xs text-slate-400 mt-1">Upload foto</p></div></template>
                    <template x-if="fileName"><p class="text-xs text-slate-400" x-text="fileName"></p></template>
                </div>
                <input type="hidden" name="delete_contact_photo_1" :value="markedForDelete ? '1' : '0'">
                <button type="button" x-show="preview && !fileName" @click="removePhoto()" class="mt-2 w-full text-xs text-red-500 hover:text-red-700 font-medium flex items-center justify-center gap-1 py-1.5 rounded-lg hover:bg-red-50 transition">
                    <i class="fa-solid fa-trash-can text-[10px]"></i> Hapus Foto
                </button>
            </div>
            <div class="md:col-span-2 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Nama</label>
                    <input type="text" name="contact_name_1" value="{{ $settings['contact_name_1'] ?? '' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Jabatan</label>
                    <input type="text" name="contact_title_1" value="{{ $settings['contact_title_1'] ?? '' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Telepon</label>
                    <input type="text" name="contact_phone_1" value="{{ $settings['contact_phone_1'] ?? '' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
                </div>
            </div>
        </div>
    </div>

    {{-- Kontak 2 --}}
    <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
        <h3 class="font-bold text-slate-900 mb-4">Kontak 2</h3>
        <div class="grid md:grid-cols-3 gap-4">
            <div x-data="contactPhoto('{{ $settings['contact_photo_2'] ?? '' ? asset('uploads/'.($settings['contact_photo_2'] ?? '')) : '' }}')">
                <label class="block text-sm font-medium text-slate-600 mb-2">Foto</label>
                <div class="relative border-2 border-dashed rounded-xl p-4 text-center transition-all duration-200"
                    :class="dragover ? 'border-blue-500 bg-blue-50' : 'border-slate-200 hover:border-blue-400'"
                    @dragover.prevent="dragover = true" @dragleave.prevent="dragover = false"
                    @drop.prevent="dragover = false; handleDrop($event)">
                    <input type="file" name="contact_photo_2" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="handleFile($event)">
                    <img :src="preview" class="mx-auto h-20 w-20 rounded-full object-cover mb-2" x-show="preview">
                    <template x-if="!preview"><div class="py-4"><i class="fa-solid fa-cloud-arrow-up text-xl text-slate-300"></i><p class="text-xs text-slate-400 mt-1">Upload foto</p></div></template>
                    <template x-if="fileName"><p class="text-xs text-slate-400" x-text="fileName"></p></template>
                </div>
                <input type="hidden" name="delete_contact_photo_2" :value="markedForDelete ? '1' : '0'">
                <button type="button" x-show="preview && !fileName" @click="removePhoto()" class="mt-2 w-full text-xs text-red-500 hover:text-red-700 font-medium flex items-center justify-center gap-1 py-1.5 rounded-lg hover:bg-red-50 transition">
                    <i class="fa-solid fa-trash-can text-[10px]"></i> Hapus Foto
                </button>
            </div>
            <div class="md:col-span-2 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Nama</label>
                    <input type="text" name="contact_name_2" value="{{ $settings['contact_name_2'] ?? '' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Jabatan</label>
                    <input type="text" name="contact_title_2" value="{{ $settings['contact_title_2'] ?? '' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Telepon</label>
                    <input type="text" name="contact_phone_2" value="{{ $settings['contact_phone_2'] ?? '' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
                </div>
            </div>
        </div>
    </div>

    @foreach([
        'Kantor' => ['office_address' => 'Alamat', 'office_email' => 'Email'],
        'Rekening Bank' => ['bank_name' => 'Nama Bank', 'bank_account' => 'Nomor Rekening', 'bank_holder' => 'Atas Nama'],
        'Media Sosial' => ['facebook_url' => 'Facebook', 'instagram_url' => 'Instagram', 'youtube_url' => 'YouTube'],
        'Presiden GIDI' => ['president_name' => 'Nama', 'president_title' => 'Jabatan', 'president_quote' => 'Kutipan'],
    ] as $section => $fields)
    <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
        <h3 class="font-bold text-slate-900 mb-4">{{ $section }}</h3>
        <div class="grid md:grid-cols-2 gap-4">
            @foreach($fields as $key => $label)
            <div class="{{ Str::contains($key, ['quote','description','address']) ? 'md:col-span-2' : '' }}">
                <label class="block text-sm font-medium text-slate-600 mb-1">{{ $label }}</label>
                @if(Str::contains($key, ['quote','description','address']))
                <textarea name="{{ $key }}" rows="3" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm resize-none">{{ $settings[$key] ?? '' }}</textarea>
                @else
                <input type="text" name="{{ $key }}" value="{{ $settings[$key] ?? '' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold transition">Simpan Pengaturan</button>
</form>
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
function contactPhoto(existing) {
    return {
        ...dropZone(existing),
        markedForDelete: false,
        removePhoto() {
            this.preview = null;
            this.fileName = null;
            this.markedForDelete = true;
            const input = this.$el.querySelector('input[type=file]');
            if (input) { input.value = ''; }
        },
        handleFile(e) {
            this.markedForDelete = false;
            this.setPreview(e.target.files[0]);
        },
        handleDrop(e) {
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                const input = this.$el.querySelector('input[type=file]');
                const dt = new DataTransfer(); dt.items.add(file); input.files = dt.files;
                this.markedForDelete = false;
                this.setPreview(file);
            }
        }
    }
}
</script>
@endpush
@endsection

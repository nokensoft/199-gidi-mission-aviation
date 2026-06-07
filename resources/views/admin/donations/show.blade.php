@extends('layouts.admin')
@section('title', 'Detail Donasi')
@section('page-title', 'Detail Donasi #'.$donation->id)

@section('content')
<a href="{{ route('admin.donations.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium mb-6 inline-block"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali</a>

<div class="grid lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm space-y-4">
        <h3 class="font-bold text-slate-900 text-lg mb-4">Informasi Donatur</h3>
        <div><span class="text-xs text-slate-400 block">Nama</span><span class="font-medium text-slate-900">{{ $donation->donor_name }}</span></div>
        <div><span class="text-xs text-slate-400 block">Telepon</span><span class="font-medium text-slate-900">{{ $donation->donor_phone }}</span></div>
        <div><span class="text-xs text-slate-400 block">Paket</span><span class="font-medium text-slate-900">{{ $donation->package_label }}</span></div>
        <div><span class="text-xs text-slate-400 block">Komitmen</span><span class="font-medium text-slate-900">{{ $donation->commitment_type === 'pledge' ? 'Komitmen Iman' : 'Sudah Transfer' }}</span></div>
        <div><span class="text-xs text-slate-400 block">Metode</span><span class="font-medium text-slate-900">{{ ucfirst($donation->payment_method) }}</span></div>
        <div><span class="text-xs text-slate-400 block">Status</span>
            <span class="text-xs px-2 py-1 rounded-full font-medium {{ $donation->status === 'confirmed' ? 'bg-emerald-50 text-emerald-600' : ($donation->status === 'rejected' ? 'bg-red-50 text-red-600' : 'bg-amber-50 text-amber-600') }}">{{ ucfirst($donation->status) }}</span>
        </div>
        @if($donation->notes)<div><span class="text-xs text-slate-400 block">Catatan</span><p class="text-slate-700">{{ $donation->notes }}</p></div>@endif

        @if($donation->status === 'pending')
        <div class="flex gap-3 pt-4 border-t border-slate-100">
            <form method="POST" action="{{ route('admin.donations.confirm', $donation) }}">@csrf<button class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium"><i class="fa-solid fa-check mr-1"></i> Konfirmasi</button></form>
            <form method="POST" action="{{ route('admin.donations.reject', $donation) }}">@csrf<button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium"><i class="fa-solid fa-times mr-1"></i> Tolak</button></form>
        </div>
        @endif
    </div>
    <div class="space-y-6">
        @if($donation->transfer_proof || $donation->admin_proof)
        <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
            <h3 class="font-bold text-slate-900 mb-4">Bukti Transfer</h3>
            @if($donation->transfer_proof)<p class="text-xs text-slate-400 mb-2">Dari Donatur:</p><img src="{{ asset('uploads/'.$donation->transfer_proof) }}" alt="Bukti" class="rounded-lg max-h-64 object-contain mb-4">@endif
            @if($donation->admin_proof)<p class="text-xs text-slate-400 mb-2">Dari Admin:</p><img src="{{ asset('uploads/'.$donation->admin_proof) }}" alt="Bukti Admin" class="rounded-lg max-h-64 object-contain">@endif
        </div>
        @endif
        <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
            <h3 class="font-bold text-slate-900 mb-4">Upload Bukti Transfer (Admin)</h3>
            <form method="POST" action="{{ route('admin.donations.upload-proof', $donation) }}" enctype="multipart/form-data"
                x-data="dropZone('{{ $donation->admin_proof ? asset('uploads/'.$donation->admin_proof) : '' }}')">
                @csrf
                <div class="relative border-2 border-dashed rounded-xl p-6 text-center transition-all duration-200 mb-3"
                    :class="dragover ? 'border-blue-500 bg-blue-50' : 'border-slate-200 hover:border-blue-400'"
                    @dragover.prevent="dragover = true" @dragleave.prevent="dragover = false"
                    @drop.prevent="dragover = false; handleDrop($event)">
                    <input type="file" name="admin_proof" accept="image/*,application/pdf" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="handleFile($event)">
                    <template x-if="preview">
                        <img :src="preview" class="mx-auto max-h-40 object-contain rounded-lg mb-2">
                    </template>
                    <template x-if="!preview">
                        <div class="py-4">
                            <i class="fa-solid fa-cloud-arrow-up text-2xl text-slate-300 mb-2"></i>
                            <p class="text-sm text-slate-500">Seret gambar ke sini atau <span class="text-blue-600 font-medium">pilih file</span></p>
                            <p class="text-xs text-slate-400 mt-1">JPG, PNG, PDF (Maks 10MB)</p>
                        </div>
                    </template>
                    <template x-if="fileName"><p class="text-xs text-slate-400 mt-1" x-text="fileName"></p></template>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium w-full">Upload</button>
            </form>
        </div>
        @if($donation->testimonial)
        <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
            <h3 class="font-bold text-slate-900 mb-4">Testimoni</h3>
            <p class="text-slate-600 italic">"{{ $donation->testimonial->content }}"</p>
            <p class="text-sm text-slate-400 mt-2">— {{ $donation->testimonial->display_name }}</p>
        </div>
        @endif
    </div>
</div>
@push('scripts')
<script>
function dropZone(existing) {
    return {
        preview: existing || null, fileName: null, dragover: false,
        handleFile(e) { this.setPreview(e.target.files[0]); },
        handleDrop(e) {
            const file = e.dataTransfer.files[0];
            if (file && (file.type.startsWith('image/') || file.type === 'application/pdf')) {
                const input = this.$el.querySelector('input[type=file]');
                const dt = new DataTransfer(); dt.items.add(file); input.files = dt.files;
                this.setPreview(file);
            }
        },
        setPreview(file) {
            if (!file) return;
            this.fileName = file.name + ' (' + (file.size / 1024 / 1024).toFixed(1) + ' MB)';
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => { this.preview = e.target.result; };
                reader.readAsDataURL(file);
            } else {
                this.preview = null;
            }
        }
    }
}
</script>
@endpush
@endsection

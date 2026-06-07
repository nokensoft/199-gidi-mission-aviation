@extends('layouts.admin')
@section('title', isset($donation) ? 'Edit Donasi' : 'Tambah Donasi')
@section('page-title', isset($donation) ? 'Edit Donasi #'.$donation->id : 'Tambah Donasi Baru')

@section('content')
<form method="POST"
    action="{{ isset($donation) ? route('admin.donations.update', $donation) : route('admin.donations.store') }}"
    enctype="multipart/form-data"
    class="max-w-4xl space-y-6"
    x-data="{ package: '{{ old('package', $donation->package ?? '') }}', commitmentType: '{{ old('commitment_type', $donation->commitment_type ?? 'pledge') }}' }">
    @csrf
    @if(isset($donation)) @method('PUT') @endif

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
        <ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
    @endif

    {{-- Informasi Donatur --}}
    <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
        <h3 class="font-bold text-slate-900 mb-4">Informasi Donatur</h3>
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Nama Donatur <span class="text-red-500">*</span></label>
                <input type="text" name="donor_name" value="{{ old('donor_name', $donation->donor_name ?? '') }}" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Telepon / WhatsApp <span class="text-red-500">*</span></label>
                <input type="text" name="donor_phone" value="{{ old('donor_phone', $donation->donor_phone ?? '') }}" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
            </div>
        </div>
    </div>

    {{-- Detail Donasi --}}
    <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
        <h3 class="font-bold text-slate-900 mb-4">Detail Donasi</h3>
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Paket Kemitraan <span class="text-red-500">*</span></label>
                <select name="package" x-model="package" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition appearance-none">
                    <option value="" disabled>Pilih paket...</option>
                    <option value="level_01">Sahabat Misi (Rp 500.000)</option>
                    <option value="level_02">Sayap Kasih (Rp 5.000.000)</option>
                    <option value="level_03">Duta Dirgantara (Rp 10.000.000+)</option>
                    <option value="custom">Mitra Sukarela (Nominal Bebas)</option>
                </select>
            </div>
            <div x-show="package === 'custom'" x-transition>
                <label class="block text-sm font-medium text-slate-600 mb-1">Nominal Sukarela</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500 text-sm">Rp</span>
                    <input type="number" name="custom_amount" value="{{ old('custom_amount', $donation->custom_amount ?? '') }}" class="w-full pl-12 pr-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Status Komitmen <span class="text-red-500">*</span></label>
                <select name="commitment_type" x-model="commitmentType" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition appearance-none">
                    <option value="pledge">Komitmen Iman (Direncanakan)</option>
                    <option value="paid">Sudah Ditransfer</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Metode Pembayaran <span class="text-red-500">*</span></label>
                <select name="payment_method" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition appearance-none">
                    <option value="transfer" {{ old('payment_method', $donation->payment_method ?? '') === 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="cash" {{ old('payment_method', $donation->payment_method ?? '') === 'cash' ? 'selected' : '' }}>Tunai / Cash</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Status Donasi <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition appearance-none">
                    <option value="pending" {{ old('status', $donation->status ?? 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ old('status', $donation->status ?? '') === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                    <option value="rejected" {{ old('status', $donation->status ?? '') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-600 mb-1">Catatan</label>
                <textarea name="notes" rows="3" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm resize-none focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">{{ old('notes', $donation->notes ?? '') }}</textarea>
            </div>
        </div>
    </div>

    {{-- Bukti Transfer --}}
    <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm"
        x-data="dropZone('{{ isset($donation) && $donation->transfer_proof ? asset('uploads/'.$donation->transfer_proof) : '' }}')">
        <h3 class="font-bold text-slate-900 mb-4">Bukti Transfer</h3>
        <div class="relative border-2 border-dashed rounded-xl p-6 text-center transition-all duration-200"
            :class="dragover ? 'border-blue-500 bg-blue-50' : 'border-slate-200 hover:border-blue-400'"
            @dragover.prevent="dragover = true" @dragleave.prevent="dragover = false"
            @drop.prevent="dragover = false; handleDrop($event)">
            <input type="file" name="transfer_proof" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="handleFile($event)">
            <template x-if="preview">
                <img :src="preview" class="mx-auto max-h-48 object-contain rounded-lg mb-2">
            </template>
            <template x-if="!preview">
                <div class="py-6">
                    <i class="fa-solid fa-cloud-arrow-up text-2xl text-slate-300 mb-2"></i>
                    <p class="text-sm text-slate-500">Seret gambar ke sini atau <span class="text-blue-600 font-medium">pilih file</span></p>
                    <p class="text-xs text-slate-400 mt-1">JPG, PNG, WebP (Maks 10MB)</p>
                </div>
            </template>
            <template x-if="fileName"><p class="text-xs text-slate-400 mt-1" x-text="fileName"></p></template>
        </div>
    </div>

    <div class="flex gap-3">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold transition">{{ isset($donation) ? 'Perbarui' : 'Simpan' }}</button>
        <a href="{{ route('admin.donations.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-medium transition">Batal</a>
    </div>
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
</script>
@endpush
@endsection

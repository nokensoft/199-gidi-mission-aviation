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
            <form method="POST" action="{{ route('admin.donations.upload-proof', $donation) }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="admin_proof" accept="image/*,application/pdf" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 mb-3">
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
@endsection

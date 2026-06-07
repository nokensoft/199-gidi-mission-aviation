@extends('layouts.admin')
@section('title', 'Mitra Kerja')
@section('page-title', 'Manajemen Mitra Kerja')
@section('content')
<div x-data="{ editModal: false, editPartner: {} }">
<div class="flex items-center justify-end mb-4">
    @php $partnerTrashCount = \App\Models\Partner::onlyTrashed()->count(); @endphp
    @if($partnerTrashCount > 0)
    <a href="{{ route('admin.partners.trash') }}" class="text-sm text-red-500 hover:text-red-600 flex items-center gap-1.5 cursor-pointer">
        <i class="fa-solid fa-trash-can text-xs"></i> Sampah <span class="bg-red-100 text-red-600 text-xs px-1.5 py-0.5 rounded-full font-bold">{{ $partnerTrashCount }}</span>
    </a>
    @endif
</div>
<div class="grid lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
        <h3 class="font-bold text-slate-900 mb-4">Tambah Mitra</h3>
        <form method="POST" action="{{ route('admin.partners.store') }}" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <input type="text" name="name" required placeholder="Singkatan (GIDI)" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
            <input type="text" name="full_name" placeholder="Nama lengkap" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
            <div x-data="dropZone(null)">
                <div class="relative border-2 border-dashed rounded-xl p-4 text-center transition-all duration-200"
                    :class="dragover ? 'border-blue-500 bg-blue-50' : 'border-slate-200 hover:border-blue-400'"
                    @dragover.prevent="dragover = true" @dragleave.prevent="dragover = false"
                    @drop.prevent="dragover = false; handleDrop($event)">
                    <input type="file" name="logo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="handleFile($event)">
                    <img :src="preview" class="mx-auto h-14 object-contain mb-2 rounded" x-show="preview">
                    <template x-if="!preview">
                        <div class="py-2"><i class="fa-solid fa-cloud-arrow-up text-xl text-slate-300"></i><p class="text-xs text-slate-400 mt-1">Drag & drop atau klik upload logo</p></div>
                    </template>
                    <template x-if="fileName"><p class="text-xs text-slate-400 mt-1" x-text="fileName"></p></template>
                </div>
            </div>
            <input type="number" name="sort_order" value="0" placeholder="Urutan" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl font-medium transition">Tambah</button>
        </form>
    </div>
    <div class="lg:col-span-2">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($partners as $p)
            <div class="bg-white rounded-xl p-4 border border-slate-200/60 shadow-sm text-center">
                @if($p->logo)<img src="{{ asset('uploads/'.$p->logo) }}" alt="{{ $p->name }}" class="w-16 h-16 object-contain mx-auto mb-2">@endif
                <h4 class="font-bold text-blue-600">{{ $p->name }}</h4>
                <p class="text-xs text-slate-500">{{ $p->full_name }}</p>
                <div class="flex items-center justify-center gap-2 mt-3">
                    <button @click="editPartner = { id: {{ $p->id }}, name: '{{ addslashes($p->name) }}', full_name: '{{ addslashes($p->full_name ?? '') }}', url: '{{ addslashes($p->url ?? '') }}', sort_order: {{ $p->sort_order ?? 0 }}, logo: '{{ $p->logo ?? '' }}' }; editModal = true" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 text-xs font-medium transition cursor-pointer"><i class="fa-solid fa-edit"></i> Edit</button>
                    <form method="POST" action="{{ route('admin.partners.destroy', $p) }}" class="inline" onsubmit="event.preventDefault(); confirmDelete(this, 'Hapus Mitra', 'Apakah Anda yakin ingin menghapus mitra &quot;{{ addslashes($p->name) }}&quot;?')">@csrf @method('DELETE')<button class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 text-xs font-medium transition cursor-pointer"><i class="fa-solid fa-trash"></i> Hapus</button></form>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-10 text-slate-400">Belum ada mitra.</div>
            @endforelse
        </div>
    </div>
</div>

{{-- Modal Edit Mitra --}}
<div x-show="editModal" x-transition.opacity style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
    <div @click.outside="editModal = false" class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-slate-900 text-lg">Edit Mitra</h3>
            <button @click="editModal = false" class="text-slate-400 hover:text-slate-600 cursor-pointer"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>
        <form method="POST" :action="'/admin/partners/' + editPartner.id" enctype="multipart/form-data" class="space-y-3">
            @csrf @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Singkatan</label>
                <input type="text" name="name" x-model="editPartner.name" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lengkap</label>
                <input type="text" name="full_name" x-model="editPartner.full_name" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Website URL</label>
                <input type="url" name="url" x-model="editPartner.url" placeholder="https://..." class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Logo</label>
                <div x-data="{ preview: editPartner.logo ? '/uploads/' + editPartner.logo : null, fileName: null, dragover: false }"
                     x-effect="preview = editPartner.logo ? '/uploads/' + editPartner.logo : null; fileName = null"
                     class="relative border-2 border-dashed rounded-xl p-4 text-center transition-all duration-200"
                     :class="dragover ? 'border-blue-500 bg-blue-50' : 'border-slate-200 hover:border-blue-400'"
                     @dragover.prevent="dragover = true" @dragleave.prevent="dragover = false"
                     @drop.prevent="dragover = false; const f = $event.dataTransfer.files[0]; if(f && f.type.startsWith('image/')){ const inp = $el.querySelector('input[type=file]'); const dt = new DataTransfer(); dt.items.add(f); inp.files = dt.files; const r = new FileReader(); r.onload = e => { preview = e.target.result; fileName = f.name; }; r.readAsDataURL(f); }">
                    <input type="file" name="logo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                           @change="const f = $event.target.files[0]; if(f){ const r = new FileReader(); r.onload = e => { preview = e.target.result; fileName = f.name; }; r.readAsDataURL(f); }">
                    <img :src="preview" class="mx-auto h-14 object-contain mb-2 rounded" x-show="preview">
                    <template x-if="!preview">
                        <div class="py-2"><i class="fa-solid fa-cloud-arrow-up text-xl text-slate-300"></i><p class="text-xs text-slate-400 mt-1">Drag & drop atau klik untuk upload logo</p></div>
                    </template>
                    <p x-show="fileName" class="text-xs text-slate-400 mt-1" x-text="fileName"></p>
                    <p x-show="!fileName && preview" class="text-xs text-slate-400 mt-1">Logo saat ini &middot; Klik/drop untuk ganti</p>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Urutan Tampil</label>
                <input type="number" name="sort_order" x-model="editPartner.sort_order" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-sm">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" @click="editModal = false" class="flex-1 py-2.5 rounded-xl font-medium border border-slate-200 text-slate-600 hover:bg-slate-50 transition cursor-pointer">Batal</button>
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl font-medium transition">Simpan</button>
            </div>
        </form>
    </div>
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
            if (file && file.type.startsWith('image/')) {
                const input = this.$el.querySelector('input[type=file]');
                const dt = new DataTransfer(); dt.items.add(file); input.files = dt.files;
                this.setPreview(file);
            }
        },
        setPreview(file) {
            if (!file) return;
            this.fileName = file.name;
            const reader = new FileReader();
            reader.onload = (e) => { this.preview = e.target.result; };
            reader.readAsDataURL(file);
        }
    }
}
</script>
@endpush
@endsection

@extends('layouts.public')
@section('title', 'GIDI Mission Aviation - Be The Light')
@section('meta_description', \App\Models\SiteSetting::get('site_description', 'GIDI Mission Aviation - Wujud kemandirian Gereja Injili di Indonesia di bidang penerbangan dalam mendukung pelayanan misi Gereja.'))
@section('meta_keywords', 'GIDI, Mission Aviation, Penerbangan Misi, Papua, Gereja Injili, Donasi, Cessna Grand Caravan, PT Sayap Kasih Injili, Be The Light')
@section('og_image', asset('images/logo.png'))

@push('seo')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "GIDI Mission Aviation",
    "alternateName": "PT. Sayap Kasih Injili",
    "url": "{{ url('/') }}",
    "logo": "{{ asset('images/logo.png') }}",
    "description": "{{ \App\Models\SiteSetting::get('site_description', 'Wujud kemandirian Gereja Injili di Indonesia di bidang penerbangan dalam mendukung pelayanan misi Gereja.') }}",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "{{ \App\Models\SiteSetting::get('office_address', '') }}"
    },
    "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "{{ \App\Models\SiteSetting::get('contact_phone_1', '') }}",
        "contactType": "customer service"
    },
    "sameAs": [
        "{{ \App\Models\SiteSetting::get('facebook_url', '') }}",
        "{{ \App\Models\SiteSetting::get('instagram_url', '') }}",
        "{{ \App\Models\SiteSetting::get('youtube_url', '') }}"
    ]
}
</script>
@endpush

@section('content')
@php $s = fn($key, $default = '') => \App\Models\SiteSetting::get($key, $default); @endphp

{{-- SLIDER/BANNER --}}
<section class="section-shell bg-white relative overflow-hidden"
    x-data="{ currentSlide: 1, totalSlides: {{ $sliders->count() ?: 2 }}, progress: 0, imgLoading: true, initTimer() { this.progress = 0; this.imgLoading = true; setInterval(() => { this.progress += 1; if(this.progress > 25) { this.imgLoading = false; } if (this.progress >= 100) { this.currentSlide = this.currentSlide === this.totalSlides ? 1 : this.currentSlide + 1; this.progress = 0; this.imgLoading = true; } }, 100); } }"
    x-init="initTimer()">
    <div class="absolute top-0 left-0 h-1 bg-gradient-to-r from-blue-500 via-sky-400 to-blue-600 transition-all ease-linear duration-100" :style="`width: ${progress}%`"></div>
    <div class="section-container relative">
        <div class="relative min-h-[620px] sm:min-h-[500px] md:min-h-[420px]">
            @foreach($sliders as $index => $slider)
            <div x-show="currentSlide === {{ $index + 1 }}"
                x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-300 absolute inset-0" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-8"
                @if($index > 0) style="display:none;" @endif
                class="grid md:grid-cols-2 gap-10 md:gap-16 items-center">
                <div>
                    <span class="uppercase tracking-widest text-blue-600 font-semibold text-sm block mb-1">{{ $slider->subtitle }}</span>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mt-4 mb-6 text-slate-900 tracking-tight">{{ $slider->title }}</h2>
                    <p class="text-base sm:text-lg text-slate-600 leading-relaxed mb-8 sm:mb-10">{{ $slider->description }}</p>
                    @if($slider->button_text)
                    <a href="{{ $slider->button_link }}" class="w-full sm:w-auto justify-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-6 rounded-none transition duration-300 shadow-md inline-flex items-center gap-2">
                        {{ $slider->button_text }} <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                    @endif
                </div>
                <div class="relative flex justify-center lg:justify-end">
                    <div class="absolute w-72 h-72 bg-blue-500/5 blur-[80px] rounded-none pointer-events-none top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>
                    <div class="relative w-full max-w-[380px] aspect-square flex items-center justify-center bg-slate-50 border border-slate-100/50"
                        :class="imgLoading ? 'animate-pulse' : 'bg-transparent border-none'">
                        <img src="{{ $slider->image ? asset('uploads/'.$slider->image) : ($index === 0 ? asset('images/logo.png') : asset('images/Cessna Grand Caravan Logo GIDI.png')) }}"
                            alt="{{ $slider->title }}"
                            class="w-full h-auto object-contain relative z-10 drop-shadow-[0_10px_20px_rgba(0,0,0,0.02)] rounded-none transition-all duration-500"
                            :class="imgLoading ? 'blur-md scale-95 opacity-50' : 'blur-0 scale-100 opacity-100'">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="flex items-center justify-between mt-12 pt-6 border-t border-slate-100">
            <div class="flex items-center gap-2.5">
                @foreach($sliders as $index => $slider)
                <button @click="currentSlide = {{ $index+1 }}; progress = 0; imgLoading = true;"
                    class="h-2.5 transition-all duration-300 rounded-none"
                    :class="currentSlide === {{ $index+1 }} ? 'w-8 bg-blue-600' : 'w-2.5 bg-slate-300 hover:bg-slate-400'"></button>
                @endforeach
            </div>
            <div class="flex items-center gap-2">
                <button @click="currentSlide = currentSlide === 1 ? totalSlides : currentSlide - 1; progress = 0; imgLoading = true;" class="w-11 h-11 border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-blue-600 flex items-center justify-center transition rounded-none"><i class="fa-solid fa-chevron-left text-xs"></i></button>
                <button @click="currentSlide = currentSlide === totalSlides ? 1 : currentSlide + 1; progress = 0; imgLoading = true;" class="w-11 h-11 border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-blue-600 flex items-center justify-center transition rounded-none"><i class="fa-solid fa-chevron-right text-xs"></i></button>
            </div>
        </div>
    </div>
</section>

{{-- TENTANG KAMI --}}
<section id="tentang-kami" class="section-shell relative overflow-hidden bg-slate-950 text-white py-20 md:py-32">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/background/gambar1.jpeg') }}" alt="Background" class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-slate-950/30 backdrop-blur-[2px]"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-slate-950/50"></div>
    </div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10">
        <span class="font-bold tracking-widest text-sm uppercase bg-blue-500/10 px-4 py-2 rounded-full border border-blue-500/20 backdrop-blur-md inline-block">Tentang Kami</span>
        <div class="my-6 text-center flex flex-col items-center">
            <h2 class="text-3xl md:text-5xl font-black tracking-tight leading-tight drop-shadow-md">Penerbangan Misi GIDI <br class="hidden sm:inline"> (GIDI Mission Aviation)</h2>
            <p class="uppercase text-lg md:text-xl font-bold tracking-wider py-3">PT. Sayap Kasih Injili</p>
            <p class="text-slate-300 text-base max-w-2xl mx-auto leading-relaxed">Wujud kemandirian Gereja Injili di Indonesia di bidang penerbangan untuk mendukung pelayanan misi gereja di mulai dari Tanah Papua, Indonesia dan Go Internasional bagi Kemuliaan Nama Tuhan.</p>
            <div class="mt-4 max-w-[120px] md:max-w-[150px] transition-transform duration-300 hover:scale-105">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-auto object-contain drop-shadow-sm">
            </div>
        </div>
        <div class="max-w-2xl mx-auto bg-slate-900/60 backdrop-blur-md p-8 rounded-2xl border border-slate-700/40 shadow-2xl">
            <p class="text-xl italic text-slate-200 leading-relaxed">"{{ $s('about_verse', 'Tetapi kamu akan menerima kuasa...') }}" (TB)</p>
            <div class="mt-4 font-semibold text-blue-400 tracking-wide">— {{ $s('about_verse_ref', 'Kisah Para Rasul 1:8') }}</div>
        </div>
    </div>
</section>

{{-- YANG KAMI LAKUKAN --}}
<section id="yang-kami-lakukan" class="section-shell bg-slate-50 border-t border-b border-slate-100">
    <div class="section-container">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider block mb-2">Yang Kami Lakukan</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">Layanan Penerbangan</h2>
            <p class="text-slate-500 mt-4 text-base">Menembus awan, menjangkau jiwa-jiwa: Sayap Kasih Papua Bagi Bangsa-Bangsa.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-6 lg:gap-8">
            @foreach($services as $service)
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/60 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col items-center text-center group">
                <div class="w-14 h-14 rounded-2xl bg-{{ $service->color }}-50 text-{{ $service->color }}-600 flex items-center justify-center text-xl mb-6 group-hover:bg-{{ $service->color }}-600 group-hover:text-white transition-all duration-300 mx-auto">
                    <i class="{{ $service->icon }}"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-3">{{ $service->title }}</h3>
                <p class="text-slate-600 leading-relaxed max-w-md">{{ $service->description }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- PENGGALANGAN DANA --}}
<section id="penggalangan-dana" class="section-shell bg-white overflow-hidden py-16 md:py-24">
    <div class="section-container max-w-5xl mx-auto px-4 sm:px-6">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-blue-600 font-bold text-xs md:text-sm uppercase tracking-widest block mb-2">Penggalangan Dana</span>
            <h2 class="text-3xl md:text-5xl font-black text-slate-900 tracking-tight">Program Pembelian Pesawat</h2>
            <p class="text-slate-500 mt-4 text-base max-w-2xl mx-auto">Program strategis GIDI untuk mengadakan armada pesawat misi guna menjangkau daerah terpencil di Papua.</p>
        </div>
        <div class="flex flex-col items-center text-center">
            <div class="w-full flex justify-center items-center mb-10 relative group max-w-3xl mx-auto">
                <div class="absolute w-4/5 h-32 md:h-48 bg-blue-500/10 blur-[80px] rounded-full -z-10 pointer-events-none"></div>
                <img src="{{ asset('images/Cessna Grand Caravan Logo GIDI.png') }}" alt="Cessna Grand Caravan" class="w-full h-auto object-contain drop-shadow-[0_25px_35px_rgba(59,130,246,0.18)] transform group-hover:scale-[1.01] transition-transform duration-700 ease-out">
            </div>
            <div class="max-w-3xl mx-auto bg-slate-50 border border-slate-100 rounded-3xl p-8 md:p-10 shadow-sm">
                <p class="text-slate-700 text-lg md:text-xl font-medium leading-relaxed">"{{ $s('fundraising_description') }}"</p>
            </div>
        </div>
    </div>
</section>

{{-- PERNYATAAN PRESIDEN GIDI --}}
<section id="presiden-gidi" class="section-shell bg-white overflow-hidden">
    <div class="section-container">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider block mb-2">Pimpinan Gereja</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">Pernyataan Presiden GIDI</h2>
            <p class="text-slate-500 mt-4 text-base">Pesan dan komitmen dari pimpinan tertinggi Gereja Injili di Indonesia untuk penerbangan misi.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-8 items-center max-w-6xl mx-auto">
            <div class="bg-slate-50 border border-slate-100 rounded-3xl p-6 sm:p-8 md:p-10 flex flex-col justify-center h-full relative">
                <div class="absolute top-4 left-6 text-6xl text-slate-200 font-serif select-none pointer-events-none">&ldquo;</div>
                <p class="text-slate-700 leading-relaxed text-base md:text-lg font-medium relative z-10 pt-4">"{{ $s('president_quote') }}"</p>
                <div class="mt-6 pt-4 border-t border-slate-200">
                    <p class="text-blue-600 font-bold text-base">{{ $s('president_name') }}</p>
                    <p class="text-slate-500 text-sm font-medium">{{ $s('president_title') }}</p>
                </div>
            </div>
            <div class="rounded-3xl overflow-hidden shadow-xl md:h-full flex items-center justify-center bg-slate-100 relative group aspect-[4/3] md:aspect-auto">
                <img src="{{ asset('images/Pdt. Usman Kobak, S.Th, MA.jpg') }}" alt="{{ $s('president_name') }}" class="w-full h-full object-cover object-top transform group-hover:scale-[1.03] transition-transform duration-500 ease-out">
                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950/70 via-slate-950/20 to-transparent p-6 flex flex-col justify-end text-white">
                    <p class="text-lg font-bold tracking-wide">{{ $s('president_name') }}</p>
                    <p class="text-xs text-slate-300">Presiden GIDI</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- INFO PESAWAT & PAKET --}}
<section class="section-shell bg-white">
    <div class="section-container">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider block mb-2">Armada Pesawat</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">Spesifikasi & Paket Donasi</h2>
            <p class="text-slate-500 mt-4 text-base">Informasi pesawat yang akan diadakan dan berbagai pilihan paket kemitraan untuk mendukung program ini.</p>
        </div>
        <div class="bg-slate-900 text-white rounded-3xl shadow-xl mb-16 relative overflow-hidden group">
            <div class="absolute right-0 bottom-0 opacity-5 pointer-events-none select-none"><span class="text-[150px] md:text-[220px] font-black">C208B</span></div>
            <div class="text-center pt-9"><h3 class="text-3xl md:text-6xl font-bold tracking-tight mb-4 text-blue-600">{{ $s('aircraft_title', 'Cessna Grand Caravan (C208B)') }}</h3></div>
            <div class="grid lg:grid-cols-12 gap-8 items-center p-6 sm:p-8 md:p-12 relative z-10">
                <div class="lg:col-span-7">
                    <h3 class="text-2xl font-bold mb-3 text-blue-200">Mengapa Kita Membutuhkan Pesawat Ini?</h3>
                    <p class="text-blue-200 text-xl leading-relaxed">{{ $s('aircraft_description') }}</p>
                </div>
                <div class="lg:col-span-5 flex justify-center relative mt-6 lg:mt-0">
                    <img src="{{ asset('images/Cessna Grand Caravan Logo GIDI.png') }}" alt="Cessna" class="w-full max-w-[340px] md:max-w-[400px] lg:max-w-full h-auto object-contain drop-shadow-[0_20px_30px_rgba(59,130,246,0.25)] transform group-hover:scale-105 transition-transform duration-700 ease-out">
                </div>
            </div>
        </div>

        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider block mb-2">Paket Kemitraan</span>
            <h3 class="text-2xl sm:text-3xl font-bold text-slate-900">Pilihan Paket Penggalangan Dana</h3>
            <p class="text-slate-500 mt-3">Bergabunglah sebagai mitra misi melalui berbagai pilihan nominal yang tersedia.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 items-stretch mb-20">
            @foreach([['01','Sahabat Misi','Rp 500.000','Pilihan yang tepat untuk dukungan personal atau individu.'],['02','Sayap Kasih','Rp 5.000.000','Paket bersama yang ideal untuk kelompok persekutuan atau keluarga.'],['03','Duta Dirgantara','Rp 10.000.000+','Sangat sesuai bagi lembaga, organisasi, atau sektor bisnis.'],['Sukarela','Mitra Sukarela','Bebas','Berapa pun nominal persembahan kasih sukarela.']] as $pkg)
            <div class="border border-slate-200 rounded-3xl p-6 sm:p-8 flex flex-col justify-between hover:border-blue-500 transition-all duration-300 bg-white shadow-sm {{ $loop->last ? 'border-dashed' : '' }}">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">{{ $loop->last ? 'Sukarela' : 'Pilihan '.$pkg[0] }}</span>
                    <h4 class="text-xl font-bold text-slate-900 mb-4">{{ $pkg[1] }}</h4>
                    <div class="text-2xl font-black text-blue-600 mb-4">{{ $pkg[2] }}</div>
                    <p class="text-slate-500 text-sm leading-relaxed">{{ $pkg[3] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- INFO REKENING --}}
<section class="section-shell bg-slate-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-blue-600 opacity-5 bg-[radial-gradient(circle_at_bottom_left,rgba(59,130,246,0.3),transparent_40%)]"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 relative z-10">
        <div class="text-center mb-12">
            <span class="text-blue-400 font-semibold text-sm uppercase tracking-wider block mb-2">Informasi Rekening</span>
            <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-4">Menjadi Bagian Cerita Misi</h2>
            <p class="text-slate-400 max-w-xl mx-auto text-base">Kirim dukungan Anda langsung melalui akun bank resmi tim Aviasi GIDI. Setiap kontribusi akan dikelola secara transparan.</p>
        </div>
        <div class="bg-slate-800/80 backdrop-blur border border-slate-700 rounded-3xl p-6 sm:p-8 max-w-xl mx-auto shadow-2xl mb-12">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-700 pb-4 mb-6">
                <span class="text-sm font-semibold tracking-wider uppercase text-blue-400">Akun Resmi Penggalangan Dana</span>
                <img src="{{ asset('images/Bank_Mandiri_logo.png') }}" alt="Bank Mandiri" class="h-7 w-auto object-contain opacity-90">
            </div>
            <div class="space-y-4">
                <div><span class="text-xs text-slate-400 block uppercase font-medium">Bank</span><span class="text-lg font-semibold text-white">{{ $s('bank_name') }}</span></div>
                <div x-data="{ copied: false, accountNum: '{{ $s('bank_account') }}' }">
                    <span class="text-xs text-slate-400 block uppercase font-medium">Nomor Rekening</span>
                    <div class="flex items-center gap-3 my-1">
                        <span class="text-2xl md:text-3xl font-mono font-bold tracking-wider text-blue-400" x-text="accountNum"></span>
                        <button @click="navigator.clipboard.writeText(accountNum); copied = true; setTimeout(() => copied = false, 2000)"
                            :class="copied ? 'border-emerald-500/50 text-emerald-400 bg-emerald-950/20' : 'border-slate-700 text-slate-300 bg-slate-800 hover:bg-slate-700'"
                            class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium border rounded-lg transition-all duration-200 cursor-pointer">
                            <i class="fa-regular fa-copy" x-show="!copied"></i>
                            <i class="fa-solid fa-check" x-show="copied" style="display:none;"></i>
                            <span x-text="copied ? 'Tersalin!' : 'Salin'">Salin</span>
                        </button>
                    </div>
                </div>
                <div><span class="text-xs text-slate-400 block uppercase font-medium">Atas Nama</span><span class="text-lg font-semibold text-white">{{ $s('bank_holder') }}</span></div>
            </div>
        </div>
    </div>
</section>

{{-- FORMULIR DONASI --}}
<section class="section-shell bg-white">
    <div class="section-container">
        <div id="donation-form-container" x-data="{ package: '', commitmentType: 'pledge', paymentMethod: 'transfer', testimoType: 'public' }" class="max-w-3xl mx-auto bg-slate-50 rounded-3xl border border-slate-200/80 p-6 sm:p-8 md:p-12 shadow-sm">
            <div class="text-center mb-10">
                <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-lg mx-auto mb-4"><i class="fa-solid fa-paper-plane"></i></div>
                <h3 class="text-2xl font-bold text-slate-900">Formulir Penggalangan Dana</h3>
                <p class="text-slate-500 text-sm mt-2">Kirimkan komitmen iman atau bukti konfirmasi donasi Anda.</p>
            </div>

            @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('success') }}</div>
            @endif
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm">
                <ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif

            <form action="{{ route('donation.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="req-label block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap / Majelis Jemaat</label>
                        <input type="text" name="donor_name" value="{{ old('donor_name') }}" required placeholder="Contoh: John Doe" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-slate-900">
                    </div>
                    <div>
                        <label class="req-label block text-sm font-semibold text-slate-700 mb-2">Nomor WhatsApp / Telepon</label>
                        <input type="tel" name="donor_phone" value="{{ old('donor_phone') }}" required placeholder="Contoh: 08123456789" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-slate-900">
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="req-label block text-sm font-semibold text-slate-700 mb-2">Pilih Paket Kemitraan</label>
                        <select name="donation_program" x-model="package" required class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-slate-900 appearance-none cursor-pointer">
                            <option value="" disabled selected>Pilih paket...</option>
                            <option value="level_01">Sahabat Misi (Rp 500.000)</option>
                            <option value="level_02">Sayap Kasih (Rp 5.000.000)</option>
                            <option value="level_03">Duta Dirgantara (Rp 10.000.000+)</option>
                            <option value="custom">Mitra Sukarela (Nominal Bebas)</option>
                        </select>
                    </div>
                    <div x-show="package === 'custom'" x-transition>
                        <label class="req-label block text-sm font-semibold text-slate-700 mb-2">Nominal Sukarela</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500 font-medium text-sm">Rp</span>
                            <input type="number" name="custom_value" :required="package === 'custom'" placeholder="2500000" class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-slate-900">
                        </div>
                    </div>
                </div>
                <div>
                    <label class="req-label block text-sm font-semibold text-slate-700 mb-2">Status Komitmen</label>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <label class="border border-slate-200 bg-white p-4 rounded-xl flex items-center gap-3 cursor-pointer hover:bg-slate-50 transition">
                            <input type="radio" name="commitment_type" value="pledge" x-model="commitmentType" required class="w-4 h-4 text-blue-600">
                            <span class="text-sm text-slate-700 font-medium">Komitmen Iman (Direncanakan)</span>
                        </label>
                        <label class="border border-slate-200 bg-white p-4 rounded-xl flex items-center gap-3 cursor-pointer hover:bg-slate-50 transition">
                            <input type="radio" name="commitment_type" value="paid" x-model="commitmentType" required class="w-4 h-4 text-blue-600">
                            <span class="text-sm text-slate-700 font-medium">Sudah Ditransfer</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="req-label block text-sm font-semibold text-slate-700 mb-2">Metode Pembayaran</label>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <label class="border border-slate-200 bg-white p-4 rounded-xl flex items-center gap-3 cursor-pointer hover:bg-slate-50 transition">
                            <input type="radio" name="payment_method" value="transfer" x-model="paymentMethod" required class="w-4 h-4 text-blue-600">
                            <span class="text-sm text-slate-700 font-medium">Transfer Bank</span>
                        </label>
                        <label class="border border-slate-200 bg-white p-4 rounded-xl flex items-center gap-3 cursor-pointer hover:bg-slate-50 transition">
                            <input type="radio" name="payment_method" value="cash" x-model="paymentMethod" required class="w-4 h-4 text-blue-600">
                            <span class="text-sm text-slate-700 font-medium">Tunai / Cash</span>
                        </label>
                    </div>
                </div>
                <div x-show="commitmentType === 'paid'" x-transition>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Upload Bukti Transfer</label>
                    <div class="relative group/zone border-2 border-dashed border-slate-200 hover:border-blue-500 bg-white rounded-2xl p-6 transition-all duration-300 text-center cursor-pointer flex flex-col items-center justify-center">
                        <input type="file" name="transfer_proof" accept="image/*,application/pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                        <div class="w-12 h-12 rounded-full bg-slate-50 text-slate-400 group-hover/zone:bg-blue-50 group-hover/zone:text-blue-600 flex items-center justify-center text-lg mb-3 transition-colors duration-300"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                        <p class="text-sm font-medium text-slate-700">Tarik dan lepas berkas di sini, atau <span class="text-blue-600 underline font-semibold">pilih berkas</span></p>
                        <p class="text-xs text-slate-400 mt-1">JPG, PNG, atau PDF (Maks 5MB)</p>
                    </div>
                </div>
                <div>
                    <label class="req-label block text-sm font-semibold text-slate-700 mb-2">Testimoni / Catatan</label>
                    <textarea name="donor_notes" rows="3" required placeholder="Tuliskan testimoni Anda..." class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-slate-900 resize-none">{{ old('donor_notes') }}</textarea>
                </div>
                <div>
                    <label class="req-label block text-sm font-semibold text-slate-700 mb-2">Pengaturan Publikasi Testimoni</label>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <label class="border border-slate-200 bg-white p-4 rounded-xl flex items-center gap-3 cursor-pointer hover:bg-slate-50 transition">
                            <input type="radio" name="testimonial_visibility" value="public" x-model="testimoType" required class="w-4 h-4 text-blue-600">
                            <span class="text-sm text-slate-700 font-medium">Tampilkan Nama Publik</span>
                        </label>
                        <label class="border border-slate-200 bg-white p-4 rounded-xl flex items-center gap-3 cursor-pointer hover:bg-slate-50 transition">
                            <input type="radio" name="testimonial_visibility" value="anonymous" x-model="testimoType" required class="w-4 h-4 text-blue-600">
                            <span class="text-sm text-slate-700 font-medium">Sembunyikan Nama (Anonim)</span>
                        </label>
                    </div>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-xl transition-all shadow-md shadow-blue-500/10 flex items-center justify-center gap-2 tracking-wide text-base">
                    Kirim Komitmen Kemitraan <i class="fa-solid fa-arrow-right text-sm"></i>
                </button>
            </form>
        </div>
        <div class="text-center mt-12 italic text-slate-400 text-sm">*Berapa pun nominal persembahan kasih yang Anda bagikan, sangat bernilai bagi keberlangsungan pelayanan pekerjaan Tuhan.</div>
    </div>
</section>

{{-- KONTAK --}}
<section id="kontak" class="section-shell bg-slate-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-blue-600 opacity-5 bg-[radial-gradient(circle_at_bottom_left,rgba(59,130,246,0.3),transparent_40%)]"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 relative z-10">
        <div class="text-center mb-12">
            <span class="text-blue-400 font-semibold text-sm uppercase tracking-wider block mb-2">Hubungi Kami</span>
            <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-4">Kontak</h2>
            <p class="text-slate-400 max-w-xl mx-auto text-base">Hubungi tim kami untuk konsultasi, informasi lebih lanjut, atau peluang kerja sama dalam pelayanan misi penerbangan.</p>
        </div>
        @php
            $contact1HasData = $s('contact_name_1') || $s('contact_title_1') || $s('contact_phone_1') || $s('contact_photo_1');
            $contact2HasData = $s('contact_name_2') || $s('contact_title_2') || $s('contact_phone_2') || $s('contact_photo_2');
            $hasAnyContact = $contact1HasData || $contact2HasData;
        @endphp
        <div class="border-t border-slate-800 pt-12 grid grid-cols-1 {{ $hasAnyContact ? 'lg:grid-cols-2' : '' }} gap-8 lg:gap-12 max-w-6xl mx-auto text-left text-sm text-slate-400 mb-12">
            @if($hasAnyContact)
            <div class="space-y-4">
                <span class="text-xs font-bold tracking-wider uppercase text-blue-400 block mb-2">Hubungi Tim Kami</span>
                @if($contact1HasData)
                <div class="bg-slate-800/30 p-4 rounded-xl border border-slate-800/50 flex items-center gap-4 hover:border-slate-700 transition">
                    @if($s('contact_photo_1'))
                    <img src="{{ asset('uploads/'.$s('contact_photo_1')) }}" alt="Foto" class="w-16 h-16 rounded-full object-cover border-2 border-slate-700 shrink-0">
                    @else
                    <div class="w-16 h-16 rounded-full bg-slate-700 border-2 border-slate-600 shrink-0 flex items-center justify-center"><i class="fa-solid fa-user text-slate-400 text-xl"></i></div>
                    @endif
                    <div>
                        <span class="text-xs text-slate-400">{{ $s('contact_title_1') }}</span>
                        <p class="text-base text-slate-200 font-bold tracking-wide">{{ $s('contact_phone_1') }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $s('contact_name_1') }}</p>
                    </div>
                </div>
                @endif
                @if($contact2HasData)
                <div class="bg-slate-800/30 p-4 rounded-xl border border-slate-800/50 flex items-center gap-4 hover:border-slate-700 transition">
                    @if($s('contact_photo_2'))
                    <img src="{{ asset('uploads/'.$s('contact_photo_2')) }}" alt="Foto" class="w-16 h-16 rounded-full object-cover border-2 border-slate-700 shrink-0">
                    @else
                    <div class="w-16 h-16 rounded-full bg-slate-700 border-2 border-slate-600 shrink-0 flex items-center justify-center"><i class="fa-solid fa-user text-slate-400 text-xl"></i></div>
                    @endif
                    <div>
                        <span class="text-xs text-slate-400">{{ $s('contact_title_2') }}</span>
                        <p class="text-base text-slate-200 font-bold tracking-wide">{{ $s('contact_phone_2') }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $s('contact_name_2') }}</p>
                    </div>
                </div>
                @endif
            </div>
            @endif
            <div class="bg-slate-800/20 border border-slate-800/40 p-6 md:p-8 rounded-2xl flex flex-col justify-between gap-6">
                <div>
                    <span class="text-xs font-bold tracking-wider uppercase text-blue-400 block mb-4">Informasi Kantor & Layanan</span>
                    <div class="flex gap-3 items-start mb-5">
                        <i class="fa-solid fa-location-dot text-blue-400 mt-0.5"></i>
                        <div><span class="font-semibold text-white block mb-1">Alamat Kantor:</span><p class="text-slate-300 leading-relaxed">{{ $s('office_address') }}</p></div>
                    </div>
                    <div class="flex gap-3 items-start">
                        <i class="fa-solid fa-envelope text-blue-400 mt-0.5"></i>
                        <div><span class="font-semibold text-white block mb-1">Email Resmi:</span><p class="text-slate-300 font-medium">{{ $s('office_email') }}</p></div>
                    </div>
                </div>
                <div class="border-t border-slate-800/80 pt-4 flex items-center justify-between sm:justify-start gap-6">
                    <span class="text-xs font-medium text-slate-500">Ikuti pelayanan kami:</span>
                    <div class="flex items-center gap-3">
                        <a href="{{ $s('facebook_url', '#') }}" target="_blank" class="w-8 h-8 rounded-lg bg-slate-800 text-slate-400 hover:bg-blue-600 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                        <a href="{{ $s('instagram_url', '#') }}" target="_blank" class="w-8 h-8 rounded-lg bg-slate-800 text-slate-400 hover:bg-pink-600 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-instagram text-sm"></i></a>
                        <a href="{{ $s('youtube_url', '#') }}" target="_blank" class="w-8 h-8 rounded-lg bg-slate-800 text-slate-400 hover:bg-red-600 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-youtube text-sm"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- TESTIMONI --}}
<section id="testimoni" class="section-shell bg-slate-50 border-t border-slate-100">
    <div class="section-container">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider block mb-2">Testimoni</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">Testimoni Mitra</h2>
            <p class="text-slate-500 mt-3">Dengarkan kata mereka yang telah mendukung pengadaan armada pesawat misi.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($testimonials as $testi)
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm flex flex-col justify-between hover:shadow-md transition duration-300">
                <p class="text-slate-600 text-sm leading-relaxed italic">"{{ $testi->content }}"</p>
                <div class="mt-6 pt-4 border-t border-slate-100">
                    <h4 class="font-bold text-slate-900 text-sm">{{ $testi->display_name }}</h4>
                    @if($testi->role_title)<p class="text-xs italic">{{ $testi->role_title }}</p>@endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- MITRA KERJA --}}
<section id="mitra-kerja" class="section-shell bg-slate-50 border-t border-slate-100">
    <div class="section-container">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider block mb-2">Sinergi Pelayanan</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">Mitra Kerja</h2>
            <p class="text-slate-500 mt-3">Lembaga dan institusi yang bergerak bersama dalam pelayanan aviasi misi.</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-6">
            @foreach($partners as $partner)
            <div class="p-6 rounded-2xl flex flex-col items-center text-center hover:border-blue-500/30 transition duration-300 group">
                <div class="w-20 h-20 mb-4 flex items-center justify-center p-2 rounded-xl bg-slate-50 group-hover:bg-blue-50/50 transition duration-300">
                    @if($partner->logo)
                    <img src="{{ asset('images/'.$partner->logo) }}" alt="{{ $partner->name }}" class="w-full h-full object-contain">
                    @else
                    <i class="fa-solid fa-building text-3xl text-slate-300"></i>
                    @endif
                </div>
                <h4 class="font-extrabold text-blue-600 text-lg tracking-wide mb-1">{{ $partner->name }}</h4>
                <p class="text-slate-600 text-sm font-medium leading-relaxed">{{ $partner->full_name }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

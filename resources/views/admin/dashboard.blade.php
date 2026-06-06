@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
{{-- Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl p-5 border border-slate-200/60 shadow-sm">
        <div class="flex items-center gap-3 mb-3"><div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center"><i class="fa-solid fa-hand-holding-heart"></i></div></div>
        <p class="text-2xl font-black text-slate-900">{{ $stats['total_donations'] }}</p>
        <p class="text-xs text-slate-400 mt-1">Total Donasi</p>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-200/60 shadow-sm">
        <div class="flex items-center gap-3 mb-3"><div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center"><i class="fa-solid fa-clock"></i></div></div>
        <p class="text-2xl font-black text-slate-900">{{ $stats['pending_donations'] }}</p>
        <p class="text-xs text-slate-400 mt-1">Menunggu Konfirmasi</p>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-200/60 shadow-sm">
        <div class="flex items-center gap-3 mb-3"><div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center"><i class="fa-solid fa-check-circle"></i></div></div>
        <p class="text-2xl font-black text-slate-900">Rp {{ number_format($stats['total_amount'], 0, ',', '.') }}</p>
        <p class="text-xs text-slate-400 mt-1">Total Terkonfirmasi</p>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-200/60 shadow-sm">
        <div class="flex items-center gap-3 mb-3"><div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center"><i class="fa-solid fa-newspaper"></i></div></div>
        <p class="text-2xl font-black text-slate-900">{{ $stats['published_posts'] }}</p>
        <p class="text-xs text-slate-400 mt-1">Artikel Terpublikasi</p>
    </div>
</div>

{{-- Visitor Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    @foreach([['Hari Ini', $visitorStats['today'], 'fa-calendar-day', 'blue'], ['Minggu Ini', $visitorStats['week'], 'fa-calendar-week', 'indigo'], ['Bulan Ini', $visitorStats['month'], 'fa-calendar', 'purple'], ['Tahun Ini', $visitorStats['year'], 'fa-calendar-check', 'emerald'], ['Total', $visitorStats['total'], 'fa-users', 'slate']] as $vs)
    <div class="bg-white rounded-xl p-4 border border-slate-200/60 shadow-sm text-center">
        <i class="fa-solid {{ $vs[2] }} text-{{ $vs[3] }}-500 mb-2"></i>
        <p class="text-xl font-black text-slate-900">{{ number_format($vs[1]) }}</p>
        <p class="text-xs text-slate-400">{{ $vs[0] }}</p>
    </div>
    @endforeach
</div>

{{-- Visitor Chart --}}
<div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm mb-8" x-data="visitorChart()">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-bold text-slate-900">Grafik Pengunjung</h3>
        <div class="flex gap-2">
            @foreach(['daily' => 'Harian', 'weekly' => 'Mingguan', 'monthly' => 'Bulanan', 'yearly' => 'Tahunan'] as $key => $label)
            <button @click="loadData('{{ $key }}')" :class="period === '{{ $key }}' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-3 py-1.5 rounded-lg text-xs font-medium transition">{{ $label }}</button>
            @endforeach
        </div>
    </div>
    <canvas id="visitorChart" height="100"></canvas>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
function visitorChart() {
    return {
        period: 'daily',
        chart: null,
        init() { this.loadData('daily'); },
        async loadData(period) {
            this.period = period;
            const res = await fetch(`{{ route('admin.visitor.data') }}?period=${period}`);
            const data = await res.json();
            if (this.chart) this.chart.destroy();
            this.chart = new Chart(document.getElementById('visitorChart'), {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{ label: 'Pengunjung', data: data.values, backgroundColor: 'rgba(59, 130, 246, 0.5)', borderColor: 'rgb(59, 130, 246)', borderWidth: 1, borderRadius: 6 }]
                },
                options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
            });
        }
    }
}
</script>
@endpush
@endsection

@extends('layouts.admin')

@section('title', 'Dashboard Admin - KlikAset')

@push('styles')
<style>
    /* Canvas height — tidak bisa diset via Tailwind pada element canvas */
    .bar-canvas-wrap { position: relative; width: 100%; height: 256px; }
    @media (min-width: 640px)  { .bar-canvas-wrap { height: 288px; } }
    @media (min-width: 1024px) { .bar-canvas-wrap { height: 320px; } }

    .donut-canvas-wrap { position: relative; width: 220px; height: 220px; flex-shrink: 0; }
    @media (min-width: 768px)  { .donut-canvas-wrap { width: 240px; height: 240px; } }

    /* Peak month pulse */
    @keyframes peak-pulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(37,99,235,.45); }
        60%       { box-shadow: 0 0 0 8px rgba(37,99,235,0); }
    }
    .peak-pulse { animation: peak-pulse 2.4s ease-out infinite; }
</style>
@endpush

@section('content')

@php
    $months    = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
    $totalBar  = array_sum($barChartData);
    $maxBar    = $totalBar > 0 ? max($barChartData) : 1;
    $peakIdx   = $totalBar > 0 ? array_search(max($barChartData), $barChartData) : null;
    $pctYear   = ($totalBar > 0 && $peakIdx !== null) ? round(max($barChartData) / $totalBar * 100) : 0;
    $yearLabel = $filterTahun === 'lalu' ? now()->year - 1 : now()->year;
@endphp

{{-- ══════════════════════════════════════════════
     BAR CHART CARD
══════════════════════════════════════════════ --}}
<div class="bg-white rounded-[24px] shadow-sm border border-gray-100 p-5 lg:p-7 mb-5">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
        <div>
            <h2 class="text-base lg:text-lg font-bold text-gray-800">Statistik Peminjaman Bulanan</h2>
            <p class="text-xs text-gray-400 mt-0.5">
                {{ $yearLabel }} · Total
                <span class="font-semibold text-gray-600">{{ array_sum($barChartData) }}</span> peminjaman
            </p>
        </div>

        {{-- Year toggle --}}
        <div class="flex gap-1.5 bg-gray-100 p-1 rounded-full flex-shrink-0">
            <a href="?tahun=ini"
               class="px-4 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 whitespace-nowrap
                      {{ $filterTahun !== 'lalu' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                Tahun Ini
            </a>
            <a href="?tahun=lalu"
               class="px-4 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 whitespace-nowrap
                      {{ $filterTahun === 'lalu' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                Tahun Lalu
            </a>
        </div>
    </div>

    {{-- Peak month callout (hanya tampil bila ada data) --}}
    @if($totalBar > 0 && $peakIdx !== null)
    <div class="inline-flex items-center gap-3 bg-blue-50 border border-blue-200 rounded-2xl px-4 py-2.5 mb-5">
        <div class="peak-pulse w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center flex-shrink-0">
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24"
                 stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/>
                <polyline points="16 7 22 7 22 13"/>
            </svg>
        </div>
        <div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-blue-400 leading-none">Bulan Tersibuk</p>
            <p class="text-sm font-bold text-blue-900 mt-0.5">
                {{ $months[$peakIdx] }}
                <span class="text-blue-600 mx-1">·</span>
                {{ number_format(max($barChartData)) }} peminjaman
                <span class="text-xs font-normal text-gray-400 ml-1">({{ $pctYear }}% tahun ini)</span>
            </p>
        </div>
    </div>
    @endif

    {{-- EMPTY STATE --}}
    @if($totalBar === 0)
        <div class="flex flex-col items-center justify-center h-64 gap-4">
            <div class="flex items-end gap-2 opacity-15">
                @foreach([40,65,30,80,55,45,70,35,60,50,75,45] as $h)
                <div class="w-5 bg-gray-400 rounded-t-md" style="height: {{ $h }}px"></div>
                @endforeach
            </div>
            <div class="text-center">
                <p class="text-sm font-semibold text-gray-500">Belum ada data peminjaman</p>
                <p class="text-xs text-gray-400 mt-1">Data akan muncul setelah ada peminjaman di tahun ini</p>
            </div>
        </div>

    {{-- DATA STATE --}}
    @else
        <div class="bar-canvas-wrap">
            <canvas id="barChart"></canvas>
        </div>

        {{-- Month pills --}}
        <div class="mt-4 flex flex-wrap gap-2">
            @foreach($barChartData as $i => $val)
                @if($val > 0)
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-medium
                             {{ $i === $peakIdx ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600' }}">
                    {{ $months[$i] }}
                    <span class="font-bold">{{ $val }}</span>
                </span>
                @endif
            @endforeach
        </div>
    @endif

</div>


{{-- ══════════════════════════════════════════════
     STATS CARDS + DONUT CHART
══════════════════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-12 gap-4 lg:gap-5">

    {{-- ── Stat Cards ── --}}
    {{-- FIX: grid-cols-2 selalu (bukan grid-cols-1 sm:grid-cols-2) --}}
    <div class="lg:col-span-5 grid grid-cols-2 gap-3 lg:gap-4">

        {{-- Total Aset --}}
        <div class="bg-white rounded-[24px] shadow-sm p-4 lg:p-5 border border-gray-100
                    flex items-center gap-3 lg:gap-4
                    hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="w-12 h-12 lg:w-16 lg:h-16 bg-blue-50 rounded-2xl flex items-center justify-center shrink-0">
                <x-icon-box class="w-6 h-6 lg:w-7 lg:h-7 text-[#4169E1]"/>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-gray-400 font-medium truncate">Total Aset</p>
                <p class="text-2xl lg:text-3xl font-bold text-gray-900 leading-tight">{{ number_format($totalAset) }}</p>
            </div>
        </div>

        {{-- Pengajuan Baru --}}
        <div class="bg-white rounded-[24px] shadow-sm p-4 lg:p-5 border border-gray-100
                    flex items-center gap-3 lg:gap-4
                    hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="w-12 h-12 lg:w-16 lg:h-16 bg-orange-50 rounded-2xl flex items-center justify-center shrink-0">
                <x-icon-notification-unread class="w-6 h-6 lg:w-7 lg:h-7 text-[#FF832B]"/>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-gray-400 font-medium truncate">Pengajuan Baru</p>
                <p class="text-2xl lg:text-3xl font-bold text-gray-900 leading-tight">{{ number_format($pengajuanBaru) }}</p>
                @if($pengajuanBaru > 0)
                    <span class="inline-block mt-1 text-[10px] font-semibold bg-orange-100 text-orange-600 px-2 py-0.5 rounded-full">
                        Perlu ditinjau
                    </span>
                @endif
            </div>
        </div>

        {{-- Sedang Dipinjam --}}
        <div class="bg-white rounded-[24px] shadow-sm p-4 lg:p-5 border border-gray-100
                    flex items-center gap-3 lg:gap-4
                    hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="w-12 h-12 lg:w-16 lg:h-16 bg-yellow-50 rounded-2xl flex items-center justify-center shrink-0">
                <x-icon-danger-circle class="w-6 h-6 lg:w-7 lg:h-7 text-[#FFCC00]"/>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-gray-400 font-medium truncate">Sedang Dipinjam</p>
                <p class="text-2xl lg:text-3xl font-bold text-gray-900 leading-tight">{{ number_format($sedangDipinjam) }}</p>
            </div>
        </div>

        {{-- Peminjaman Bulan Ini --}}
        <div class="bg-white rounded-[24px] shadow-sm p-4 lg:p-5 border border-gray-100
                    flex items-center gap-3 lg:gap-4
                    hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="w-12 h-12 lg:w-16 lg:h-16 bg-red-50 rounded-2xl flex items-center justify-center shrink-0">
                <x-icon-calendar class="w-6 h-6 lg:w-7 lg:h-7 text-[#F32727]"/>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-gray-400 font-medium leading-tight">Peminjaman<br>Bulan Ini</p>
                <p class="text-2xl lg:text-3xl font-bold text-gray-900 leading-tight">{{ number_format($totalPeminjamanBulanIni) }}</p>
            </div>
        </div>

    </div>{{-- /stat cards --}}


    {{-- ── Donut Chart ── --}}
    <div class="lg:col-span-7 bg-white rounded-[24px] shadow-sm p-5 lg:p-7 border border-gray-100">
        <div class="mb-5">
            <h2 class="text-base lg:text-lg font-bold text-gray-800">Jenis Barang Sering Dipinjam</h2>
            <p class="text-xs text-gray-400 mt-0.5">
                Berdasarkan kategori · {{ $yearLabel }}
            </p>
        </div>

        {{-- EMPTY STATE --}}
        @if(empty($donutData) || array_sum($donutData) === 0)
            <div class="flex flex-col items-center justify-center py-6 gap-4">
                <div class="relative w-40 h-40">
                    <svg viewBox="0 0 100 100" class="w-full h-full -rotate-90">
                        <circle cx="50" cy="50" r="38" fill="none" stroke="#F3F4F6" stroke-width="16"/>
                        <circle cx="50" cy="50" r="38" fill="none" stroke="#E5E7EB" stroke-width="16"
                                stroke-dasharray="60 180" stroke-linecap="round" class="opacity-40"/>
                        <circle cx="50" cy="50" r="38" fill="none" stroke="#D1D5DB" stroke-width="16"
                                stroke-dasharray="40 200" stroke-dashoffset="-65" stroke-linecap="round" class="opacity-25"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-2xl font-bold text-gray-300">0</span>
                        <span class="text-[10px] text-gray-300">data</span>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-sm font-semibold text-gray-500">Belum ada data kategori</p>
                    <p class="text-xs text-gray-400 mt-1">Statistik kategori akan tampil setelah ada peminjaman</p>
                </div>
            </div>

        {{-- DATA STATE --}}
        @else
            @php $totalDonut = array_sum($donutData); @endphp
            <div class="flex flex-col sm:flex-row items-center justify-between gap-6 lg:gap-8">

                {{-- Legend --}}
                <div class="space-y-2.5 w-full sm:max-w-[200px]">
                    @foreach($donutLabels as $index => $label)
                        @php
                            $pct   = $totalDonut > 0 ? round(($donutData[$index] / $totalDonut) * 100) : 0;
                            $color = $donutColors[$index] ?? '#ccc';
                        @endphp
                        <div class="flex items-center gap-2.5">
                            <div class="w-3.5 h-3.5 rounded-[4px] shrink-0" style="background-color: {{ $color }}"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-700 truncate">{{ $label }}</p>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <div class="h-1 rounded-full bg-gray-100 flex-1">
                                        <div class="h-1 rounded-full transition-all duration-500"
                                             style="width: {{ $pct }}%; background-color: {{ $color }}"></div>
                                    </div>
                                    <span class="text-[10px] font-semibold text-gray-400 shrink-0">{{ $pct }}%</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Canvas --}}
                <div class="donut-canvas-wrap mx-auto sm:mx-0">
                    <canvas id="donutChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-2xl font-bold text-gray-800">{{ $totalDonut }}</span>
                        <span class="text-[10px] text-gray-400 font-medium mt-0.5">Total Item</span>
                    </div>
                </div>

            </div>
        @endif
    </div>

</div>{{-- /bottom grid --}}

@endsection


@push('scripts')
<script>
const BAR_DATA   = @json($barChartData);
const DONUT_DATA = @json($donutData  ?? []);
const DONUT_LBLS = @json($donutLabels ?? []);
const DONUT_COLS = @json($donutColors ?? []);

const BAR_TOTAL  = BAR_DATA.reduce((a,b) => a+b, 0);
const BAR_MAX    = BAR_TOTAL > 0 ? Math.max(...BAR_DATA) : 0;
const PEAK_IDX   = BAR_TOTAL > 0 ? BAR_DATA.indexOf(BAR_MAX) : -1;

/* ── Bar Chart ─────────────────────────────────── */
if (BAR_TOTAL > 0) {
    const el = document.getElementById('barChart');
    if (el) {
        const PALETTE = [
            '#3B82F6','#EC4899','#8B5CF6','#06B6D4',
            '#10B981','#F59E0B','#F97316','#14B8A6',
            '#84CC16','#EF4444','#64748B','#1E293B'
        ];
        const bg = BAR_DATA.map((_,i) =>
            i === PEAK_IDX ? '#2563eb' : PALETTE[i % PALETTE.length]
        );

        const labelPlugin = {
            id: 'lbl',
            afterDatasetsDraw(chart) {
                const { ctx, data } = chart;
                ctx.save();
                data.datasets[0].data.forEach((val, i) => {
                    if (!val) return;
                    const bar = chart.getDatasetMeta(0).data[i];
                    ctx.fillStyle    = i === PEAK_IDX ? '#1d4ed8' : '#6B7280';
                    ctx.font         = `${i === PEAK_IDX ? '700' : '500'} 10px Inter, sans-serif`;
                    ctx.textAlign    = 'center';
                    ctx.textBaseline = 'bottom';
                    ctx.fillText(val, bar.x, bar.y - 5);
                });
                ctx.restore();
            }
        };

        const peakPlugin = {
            id: 'peak',
            afterDatasetsDraw(chart) {
                if (PEAK_IDX < 0) return;
                const { ctx } = chart;
                const bar = chart.getDatasetMeta(0).data[PEAK_IDX];
                if (!bar) return;
                const W=22, H=13, R=6.5, X=bar.x-W/2, Y=bar.y-H-20;
                ctx.save();
                ctx.fillStyle = '#2563eb';
                ctx.beginPath();
                ctx.moveTo(X+R,Y); ctx.lineTo(X+W-R,Y);
                ctx.quadraticCurveTo(X+W,Y,X+W,Y+R);
                ctx.lineTo(X+W,Y+H-R);
                ctx.quadraticCurveTo(X+W,Y+H,X+W-R,Y+H);
                ctx.lineTo(X+R,Y+H);
                ctx.quadraticCurveTo(X,Y+H,X,Y+H-R);
                ctx.lineTo(X,Y+R);
                ctx.quadraticCurveTo(X,Y,X+R,Y);
                ctx.closePath(); ctx.fill();
                ctx.beginPath();
                ctx.moveTo(bar.x-4,Y+H); ctx.lineTo(bar.x+4,Y+H); ctx.lineTo(bar.x,Y+H+5);
                ctx.closePath(); ctx.fill();
                ctx.fillStyle='#fff'; ctx.font='bold 8px system-ui';
                ctx.textAlign='center'; ctx.textBaseline='middle';
                ctx.fillText('★', bar.x, Y+H/2);
                ctx.restore();
            }
        };

        new Chart(el, {
            type: 'bar',
            plugins: [labelPlugin, peakPlugin],
            data: {
                labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],
                datasets: [{
                    label: 'Peminjaman',
                    data: BAR_DATA,
                    backgroundColor: bg,
                    borderRadius: 10,
                    borderSkipped: false,
                    barPercentage: 0.62,
                    categoryPercentage: 0.85,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: { top: 36 } },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(15,23,42,0.9)',
                        padding: 12, cornerRadius: 10,
                        titleFont: { size: 12, weight: '600', family: 'Inter' },
                        bodyFont:  { size: 12, family: 'Inter' },
                        callbacks: {
                            title: items => items[0].label,
                            label: ctx => {
                                const pct = BAR_TOTAL ? Math.round(ctx.parsed.y / BAR_TOTAL * 100) : 0;
                                return [` ${ctx.parsed.y} peminjaman`, ` ${pct}% dari total tahun`];
                            },
                            afterLabel: ctx => ctx.dataIndex === PEAK_IDX ? ' ★ Bulan tersibuk!' : ''
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 5, font: { size: 11, family: 'Inter' }, color: '#9CA3AF', callback: v => v===0?'':v },
                        grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                        border: { dash: [4,4], display: false }
                    },
                    x: {
                        ticks: { font: { size: 11, family: 'Inter' }, color: '#9CA3AF' },
                        grid: { display: false },
                        border: { display: false }
                    }
                }
            }
        });
    }
}

/* ── Donut Chart ───────────────────────────────── */
const DONUT_TOTAL = DONUT_DATA.reduce((a,b)=>a+b,0);
if (DONUT_TOTAL > 0) {
    const el = document.getElementById('donutChart');
    if (el) {
        new Chart(el, {
            type: 'doughnut',
            data: {
                labels: DONUT_LBLS,
                datasets: [{
                    data: DONUT_DATA,
                    backgroundColor: DONUT_COLS,
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverOffset: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(15,23,42,0.9)',
                        padding: 12, cornerRadius: 10,
                        titleFont: { size: 12, weight: '600', family: 'Inter' },
                        bodyFont:  { size: 12, family: 'Inter' },
                        callbacks: {
                            label(ctx) {
                                const total = ctx.dataset.data.reduce((a,b)=>a+b,0);
                                const pct   = total > 0 ? Math.round(ctx.parsed/total*100) : 0;
                                return ` ${ctx.parsed} item (${pct}%)`;
                            }
                        }
                    }
                },
                animation: { animateRotate: true, duration: 800, easing: 'easeInOutQuart' }
            }
        });
    }
}
</script>
@endpush

@extends('layouts.admin')

@section('title', 'Dashboard Admin - KlikAset')

@push('styles')
<style>
    .bar-canvas-wrap {
        position: relative;
        width: 100%;
        height: 200px;
    }
    @media (min-width: 640px)  { .bar-canvas-wrap { height: 220px; } }
    @media (min-width: 1024px) { .bar-canvas-wrap { height: 240px; } }

    .donut-canvas-wrap {
        position: relative;
        width: 180px;
        height: 180px;
        flex-shrink: 0;
    }
    @media (min-width: 768px)  { .donut-canvas-wrap { width: 200px; height: 200px; } }

    @keyframes peak-pulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(37,99,235,.45); }
        60%       { box-shadow: 0 0 0 8px rgba(37,99,235,0); }
    }
    .peak-pulse { animation: peak-pulse 2.4s ease-out infinite; }

    /* Container untuk month pills dengan posisi relatif terhadap canvas */
    .month-pills-absolute {
        position: relative;
        width: 100%;
        height: 40px;
        margin-top: 8px;
    }
    .month-pill {
        position: absolute;
        transform: translateX(-50%);
        white-space: nowrap;
        cursor: default;
        transition: all 0.1s ease;
    }
</style>
@endpush

@section('content')

@php
    $months    = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
    $barChartData = [100,125,150,175,200,225,250,275,300,325,350,375];

    $donutLabels = ['Prasaran','Media Pendidikan','Perlengkapan Kelas','Fasilitas Penunjang','Elektronik','Alat Kantor','Alat Laboratorium'];
    $donutData   = [48, 35, 42, 30, 58, 26, 20];
    $donutColors = ['#3B82F6','#10B981','#F59E0B','#8B5CF6','#EC4899','#06B6D4','#EF4444'];

    $totalAset               = 1250;
    $pengajuanBaru           = 8;
    $sedangDipinjam          = 42;
    $totalPeminjamanBulanIni = 28;

    $totalBar  = array_sum($barChartData);
    $peakIdx   = $totalBar > 0 ? array_search(max($barChartData), $barChartData) : null;

    $filterTahun = request('tahun', 'ini');
    $yearLabel = $filterTahun === 'lalu' ? now()->year - 1 : now()->year;
@endphp

<div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6">

{{-- BAR CHART CARD --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 lg:p-5 mb-4">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2.5 mb-4">
        <div>
            <h2 class="text-sm lg:text-base font-bold text-gray-800">Statistik Peminjaman Bulanan</h2>
            <p class="text-[11px] text-gray-400 mt-0.5">
                {{ $yearLabel }} · Total
                <span class="font-semibold text-gray-600">{{ $totalBar }}</span> peminjaman
            </p>
        </div>
        <div class="flex gap-1 bg-gray-100 p-0.5 rounded-full flex-shrink-0">
            <a href="?tahun=ini"
               class="px-3 py-1 rounded-full text-[11px] font-semibold transition-all duration-200 whitespace-nowrap
                      {{ $filterTahun !== 'lalu' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                Tahun Ini
            </a>
            <a href="?tahun=lalu"
               class="px-3 py-1 rounded-full text-[11px] font-semibold transition-all duration-200 whitespace-nowrap
                      {{ $filterTahun === 'lalu' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                Tahun Lalu
            </a>
        </div>
    </div>

    <div class="bar-canvas-wrap">
        <canvas id="barChart"></canvas>
    </div>

    {{-- Month pills dengan posisi absolut (akan diatur oleh JS agar tepat di tengah bar) --}}
    <div id="monthPillsContainer" class="month-pills-absolute">
        @foreach($barChartData as $i => $val)
            <div class="month-pill" data-index="{{ $i }}">
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium
                             {{ $i === $peakIdx ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600' }}">
                    {{ $months[$i] }}
                    <span class="font-bold">{{ $val }}</span>
                </span>
            </div>
        @endforeach
    </div>

</div>

{{-- STATS CARDS + DONUT CHART --}}
<div class="grid grid-cols-1 lg:grid-cols-12 gap-3 lg:gap-4">
    <div class="lg:col-span-5 grid grid-cols-2 gap-2.5 lg:gap-3">
        {{-- Total Aset --}}
        <div class="bg-white rounded-2xl shadow-sm p-3 lg:p-4 border border-gray-100 flex items-center gap-2.5 lg:gap-3 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-blue-50 rounded-xl flex items-center justify-center shrink-0">
                <x-icon-box class="w-5 h-5 lg:w-6 lg:h-6 text-[#4169E1]"/>
            </div>
            <div class="min-w-0">
                <p class="text-[10px] text-gray-400 font-medium truncate">Total Aset</p>
                <p class="text-xl lg:text-2xl font-bold text-gray-900 leading-tight">{{ number_format($totalAset) }}</p>
            </div>
        </div>
        {{-- Pengajuan Baru --}}
        <div class="bg-white rounded-2xl shadow-sm p-3 lg:p-4 border border-gray-100 flex items-center gap-2.5 lg:gap-3 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-orange-50 rounded-xl flex items-center justify-center shrink-0">
                <x-icon-notification-unread class="w-5 h-5 lg:w-6 lg:h-6 text-[#FF832B]"/>
            </div>
            <div class="min-w-0">
                <p class="text-[10px] text-gray-400 font-medium truncate">Pengajuan Baru</p>
                <p class="text-xl lg:text-2xl font-bold text-gray-900 leading-tight">{{ number_format($pengajuanBaru) }}</p>
                @if($pengajuanBaru > 0)
                    <span class="inline-block mt-0.5 text-[9px] font-semibold bg-orange-100 text-orange-600 px-1.5 py-0.5 rounded-full">Perlu ditinjau</span>
                @endif
            </div>
        </div>
        {{-- Sedang Dipinjam --}}
        <div class="bg-white rounded-2xl shadow-sm p-3 lg:p-4 border border-gray-100 flex items-center gap-2.5 lg:gap-3 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-yellow-50 rounded-xl flex items-center justify-center shrink-0">
                <x-icon-danger-circle class="w-5 h-5 lg:w-6 lg:h-6 text-[#FFCC00]"/>
            </div>
            <div class="min-w-0">
                <p class="text-[10px] text-gray-400 font-medium truncate">Sedang Dipinjam</p>
                <p class="text-xl lg:text-2xl font-bold text-gray-900 leading-tight">{{ number_format($sedangDipinjam) }}</p>
            </div>
        </div>
        {{-- Peminjaman Bulan Ini --}}
        <div class="bg-white rounded-2xl shadow-sm p-3 lg:p-4 border border-gray-100 flex items-center gap-2.5 lg:gap-3 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-red-50 rounded-xl flex items-center justify-center shrink-0">
                <x-icon-calendar class="w-5 h-5 lg:w-6 lg:h-6 text-[#F32727]"/>
            </div>
            <div class="min-w-0">
                <p class="text-[10px] text-gray-400 font-medium leading-tight">Peminjaman<br>Bulan Ini</p>
                <p class="text-xl lg:text-2xl font-bold text-gray-900 leading-tight">{{ number_format($totalPeminjamanBulanIni) }}</p>
            </div>
        </div>
    </div>

    {{-- Donut Chart --}}
    <div class="lg:col-span-7 bg-white rounded-2xl shadow-sm p-4 lg:p-5 border border-gray-100">
        <div class="mb-4">
            <h2 class="text-sm lg:text-base font-bold text-gray-800">Jenis Barang Sering Dipinjam</h2>
            <p class="text-[11px] text-gray-400 mt-0.5">Berdasarkan kategori · {{ $yearLabel }}</p>
        </div>
        @php $totalDonut = array_sum($donutData); @endphp
        <div class="flex flex-col sm:flex-row items-center justify-between gap-5 lg:gap-6">
            <div class="space-y-2 w-full sm:max-w-[180px]">
                @foreach($donutLabels as $index => $label)
                    @php
                        $pct   = $totalDonut > 0 ? round(($donutData[$index] / $totalDonut) * 100) : 0;
                        $color = $donutColors[$index] ?? '#ccc';
                    @endphp
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded flex-shrink-0" style="background-color: {{ $color }}"></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[11px] font-medium text-gray-700 truncate">{{ $label }}</p>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <div class="h-1 rounded-full bg-gray-100 flex-1">
                                    <div class="h-1 rounded-full transition-all duration-500" style="width: {{ $pct }}%; background-color: {{ $color }}"></div>
                                </div>
                                <span class="text-[9px] font-semibold text-gray-400 shrink-0">{{ $pct }}%</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="donut-canvas-wrap mx-auto sm:mx-0">
                <canvas id="donutChart"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                    <span class="text-xl font-bold text-gray-800">{{ $totalDonut }}</span>
                    <span class="text-[9px] text-gray-400 font-medium mt-0.5">Total Item</span>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const BAR_DATA   = @json($barChartData);
    const DONUT_DATA = @json($donutData);
    const DONUT_LBLS = @json($donutLabels);
    const DONUT_COLS = @json($donutColors);

    const BAR_TOTAL  = BAR_DATA.reduce((a,b) => a+b, 0);
    const PEAK_IDX   = BAR_TOTAL > 0 ? BAR_DATA.indexOf(Math.max(...BAR_DATA)) : -1;

    let barChart = null;

    // Fungsi untuk mengatur posisi month pills berdasarkan koordinat bar
    function alignMonthPills(chart) {
        const container = document.getElementById('monthPillsContainer');
        if (!container) return;
        const pills = document.querySelectorAll('.month-pill');
        if (!pills.length) return;

        // Ambil koordinat setiap bar (tengah bar)
        const meta = chart.getDatasetMeta(0);
        if (!meta.data || !meta.data.length) return;

        const canvasRect = chart.canvas.getBoundingClientRect();
        const containerRect = container.getBoundingClientRect();
        const relativeLeft = canvasRect.left - containerRect.left;

        pills.forEach(pill => {
            const idx = parseInt(pill.getAttribute('data-index'));
            const bar = meta.data[idx];
            if (bar && bar.x) {
                // Posisi tengah bar dalam koordinat canvas
                const centerXCanvas = bar.x;
                // Konversi ke koordinat relatif container
                const centerXContainer = centerXCanvas + relativeLeft;
                pill.style.left = centerXContainer + 'px';
                pill.style.top = '0px';
            }
        });
    }

    // Bar Chart
    if (BAR_TOTAL > 0) {
        const el = document.getElementById('barChart');
        if (el) {
            const PALETTE = ['#3B82F6','#EC4899','#8B5CF6','#06B6D4','#10B981','#F59E0B','#F97316','#14B8A6','#84CC16','#EF4444','#64748B','#1E293B'];
            const bg = BAR_DATA.map((_,i) => i === PEAK_IDX ? '#2563eb' : PALETTE[i % PALETTE.length]);

            const labelPlugin = {
                id: 'lbl',
                afterDatasetsDraw(chart) {
                    const { ctx, data } = chart;
                    ctx.save();
                    data.datasets[0].data.forEach((val, i) => {
                        if (!val) return;
                        const bar = chart.getDatasetMeta(0).data[i];
                        if (bar && bar.y) {
                            ctx.fillStyle    = i === PEAK_IDX ? '#1d4ed8' : '#6B7280';
                            ctx.font         = `${i === PEAK_IDX ? '700' : '500'} 9px Inter, sans-serif`;
                            ctx.textAlign    = 'center';
                            ctx.textBaseline = 'bottom';
                            ctx.fillText(val, bar.x, bar.y - 4);
                        }
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
                    if (!bar || !bar.y) return;
                    const W=20, H=12, R=6, X=bar.x-W/2, Y=bar.y-H-16;
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
                    ctx.moveTo(bar.x-3.5,Y+H); ctx.lineTo(bar.x+3.5,Y+H); ctx.lineTo(bar.x,Y+H+4);
                    ctx.closePath(); ctx.fill();
                    ctx.fillStyle='#fff'; ctx.font='bold 7px system-ui';
                    ctx.textAlign='center'; ctx.textBaseline='middle';
                    ctx.fillText('★', bar.x, Y+H/2);
                    ctx.restore();
                }
            };

            barChart = new Chart(el, {
                type: 'bar',
                plugins: [labelPlugin, peakPlugin],
                data: {
                    labels: BAR_DATA.map(() => ''),
                    datasets: [{
                        data: BAR_DATA,
                        backgroundColor: bg,
                        borderRadius: 8,
                        borderSkipped: false,
                        barPercentage: 0.65,
                        categoryPercentage: 0.85,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: { padding: { top: 30 } },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(15,23,42,0.9)',
                            padding: 10,
                            cornerRadius: 8,
                            titleFont: { size: 11, weight: '600', family: 'Inter' },
                            bodyFont:  { size: 11, family: 'Inter' },
                            callbacks: {
                                title: (items) => {
                                    const idx = items[0].dataIndex;
                                    const months = @json($months);
                                    return months[idx];
                                },
                                label: (ctx) => {
                                    const pct = BAR_TOTAL ? Math.round(ctx.raw / BAR_TOTAL * 100) : 0;
                                    return [` ${ctx.raw} peminjaman`, ` ${pct}% dari total tahun`];
                                },
                                afterLabel: (ctx) => ctx.dataIndex === PEAK_IDX ? ' ★ Bulan tersibuk!' : ''
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 5,
                                font: { size: 10, family: 'Inter' },
                                color: '#9CA3AF',
                                callback: v => v===0?'':v
                            },
                            grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                            border: { dash: [4,4], display: false }
                        },
                        x: {
                            ticks: { display: false },
                            grid: { display: false },
                            border: { display: false }
                        }
                    }
                }
            });

            // Setelah chart selesai digambar, atur posisi pill
            setTimeout(() => {
                alignMonthPills(barChart);
            }, 100);

            // Atur ulang saat resize window
            window.addEventListener('resize', () => {
                setTimeout(() => {
                    if (barChart) alignMonthPills(barChart);
                }, 200);
            });
        }
    }

    // Donut Chart
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
                        hoverOffset: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(15,23,42,0.9)',
                            padding: 10,
                            cornerRadius: 8,
                            titleFont: { size: 11, weight: '600', family: 'Inter' },
                            bodyFont:  { size: 11, family: 'Inter' },
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
});
</script>
@endpush

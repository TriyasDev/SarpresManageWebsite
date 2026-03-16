@extends('layouts.admin')

@section('title', 'Dashboard Admin - KlikAset')

@section('content')
<div class="bg-white rounded-[24px] shadow-sm border border-gray-100 p-5 lg:p-7 mb-5">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
        <div>
            <h2 class="text-base lg:text-lg font-bold text-gray-800">Statistik Peminjaman Bulanan</h2>
            <p class="text-xs text-gray-400 mt-0.5">
                {{ $filterTahun === 'lalu' ? now()->year - 1 : now()->year }} · Total
                <span class="font-semibold text-gray-600">{{ array_sum($barChartData) }}</span> peminjaman
            </p>
        </div>

        <div class="flex gap-1.5 bg-gray-100 p-1 rounded-full">
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

    {{-- Empty State Bar Chart --}}
    @if(array_sum($barChartData) === 0)
        <div class="flex flex-col items-center justify-center h-64 gap-4">
            {{-- Skeleton bars --}}
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
    @else
        {{-- Chart + Y-axis label --}}
        <div class="flex items-start gap-2">
            <p class="text-[10px] text-gray-400 -rotate-90 translate-y-16 shrink-0 w-3 select-none">Jumlah</p>
            <div class="relative w-full h-64 sm:h-72 lg:h-80">
                <canvas id="barChart"></canvas>
            </div>
        </div>
        {{-- Monthly summary pills --}}
        <div class="mt-4 flex flex-wrap gap-2">
            @php
                $months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
                $maxVal = max($barChartData) ?: 1;
            @endphp
            @foreach($barChartData as $i => $val)
                @if($val > 0)
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-medium
                             {{ $val === $maxVal ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600' }}">
                    {{ $months[$i] }}
                    <span class="font-bold">{{ $val }}</span>
                </span>
                @endif
            @endforeach
        </div>
    @endif
</div>

{{-- ═══════════════════════════════════════════
     STATS CARDS + DONUT CHART
═══════════════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-12 gap-4 lg:gap-5">

    {{-- Stats Cards --}}
    <div class="lg:col-span-5 grid grid-cols-1 sm:grid-cols-2 gap-3 lg:gap-4">

        <div class="bg-white rounded-[24px] shadow-sm p-4 lg:p-5 border border-gray-100 flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="w-14 h-14 lg:w-16 lg:h-16 bg-blue-50 rounded-2xl flex items-center justify-center shrink-0">
                <x-icon-box class="w-7 h-7 text-[#4169E1]"/>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Total Aset</p>
                <p class="text-2xl lg:text-3xl font-bold text-gray-900 leading-tight">{{ number_format($totalAset) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-[24px] shadow-sm p-4 lg:p-5 border border-gray-100 flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="w-14 h-14 lg:w-16 lg:h-16 bg-orange-50 rounded-2xl flex items-center justify-center shrink-0">
                <x-icon-notification-unread class="w-7 h-7 text-[#FF832B]"/>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Pengajuan Baru</p>
                <p class="text-2xl lg:text-3xl font-bold text-gray-900 leading-tight">{{ number_format($pengajuanBaru) }}</p>
                @if($pengajuanBaru > 0)
                    <span class="inline-block mt-1 text-[10px] font-semibold bg-orange-100 text-orange-600 px-2 py-0.5 rounded-full">Perlu ditinjau</span>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-[24px] shadow-sm p-4 lg:p-5 border border-gray-100 flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="w-14 h-14 lg:w-16 lg:h-16 bg-yellow-50 rounded-2xl flex items-center justify-center shrink-0">
                <x-icon-danger-circle class="w-7 h-7 text-[#FFCC00]"/>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Sedang Dipinjam</p>
                <p class="text-2xl lg:text-3xl font-bold text-gray-900 leading-tight">{{ number_format($sedangDipinjam) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-[24px] shadow-sm p-4 lg:p-5 border border-gray-100 flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="w-14 h-14 lg:w-16 lg:h-16 bg-red-50 rounded-2xl flex items-center justify-center shrink-0">
                <x-icon-calendar class="w-7 h-7 text-[#F32727]"/>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Peminjaman Bulan Ini</p>
                <p class="text-2xl lg:text-3xl font-bold text-gray-900 leading-tight">{{ number_format($totalPeminjamanBulanIni) }}</p>
            </div>
        </div>
    </div>

    {{-- Donut Chart --}}
    <div class="lg:col-span-7 bg-white rounded-[24px] shadow-sm p-5 lg:p-7 border border-gray-100">
        <div class="mb-5">
            <h2 class="text-base lg:text-lg font-bold text-gray-800">Jenis Barang Sering Dipinjam</h2>
            <p class="text-xs text-gray-400 mt-0.5">
                Berdasarkan kategori · {{ $filterTahun === 'lalu' ? now()->year - 1 : now()->year }}
            </p>
        </div>

        @if(empty($donutData) || array_sum($donutData) === 0)
            {{-- Empty State Donut --}}
            <div class="flex flex-col items-center justify-center py-6 gap-4">
                <div class="relative w-40 h-40">
                    {{-- Ghost donut ring --}}
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
        @else
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 lg:gap-8">
                {{-- Legend (dinamis dari controller) --}}
                <div class="space-y-2.5 w-full md:max-w-[200px]">
                    @php $totalDonut = array_sum($donutData); @endphp
                    @foreach($donutLabels as $index => $label)
                        @php
                            $pct = $totalDonut > 0 ? round(($donutData[$index] / $totalDonut) * 100) : 0;
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
                <div class="relative w-full max-w-[260px] h-64 lg:h-72 flex items-center justify-center mx-auto">
                    <canvas id="donutChart"></canvas>
                    {{-- Center label --}}
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-2xl font-bold text-gray-800">{{ array_sum($donutData) }}</span>
                        <span class="text-[10px] text-gray-400 font-medium mt-0.5">Total Item</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// ── Helpers ──────────────────────────────────────────────────
const hasBarData  = {{ array_sum($barChartData) > 0 ? 'true' : 'false' }};
const hasDonutData = {{ (!empty($donutData) && array_sum($donutData) > 0) ? 'true' : 'false' }};

// ── Bar Chart ─────────────────────────────────────────────────
if (hasBarData) {
    const barCtx = document.getElementById('barChart');
    if (barCtx) {
        // Data label plugin (show value above each bar)
        const dataLabelPlugin = {
            id: 'dataLabel',
            afterDatasetsDraw(chart) {
                const { ctx, data } = chart;
                ctx.save();
                data.datasets[0].data.forEach((val, i) => {
                    if (val === 0) return;
                    const meta = chart.getDatasetMeta(0);
                    const bar  = meta.data[i];
                    ctx.fillStyle = '#6B7280';
                    ctx.font      = 'bold 10px Inter, sans-serif';
                    ctx.textAlign = 'center';
                    ctx.fillText(val, bar.x, bar.y - 6);
                });
                ctx.restore();
            }
        };

        new Chart(barCtx, {
            type: 'bar',
            plugins: [dataLabelPlugin],
            data: {
                labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],
                datasets: [{
                    label: 'Peminjaman',
                    data: @json($barChartData),
                    backgroundColor: [
                        '#3B82F6','#EC4899','#8B5CF6','#06B6D4',
                        '#10B981','#F59E0B','#F97316','#14B8A6',
                        '#84CC16','#EF4444','#64748B','#1E293B'
                    ],
                    borderRadius: 10,
                    borderSkipped: false,
                    barPercentage: 0.62,
                    categoryPercentage: 0.85,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: { top: 20 } },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(15,23,42,0.9)',
                        padding: 12,
                        cornerRadius: 10,
                        titleFont: { size: 12, weight: '600', family: 'Inter' },
                        bodyFont:  { size: 12, family: 'Inter' },
                        callbacks: {
                            title: (items) => items[0].label,
                            label: (ctx)   => ` ${ctx.parsed.y} peminjaman`,
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5,
                            font: { size: 11, family: 'Inter' },
                            color: '#9CA3AF',
                            callback: (v) => v === 0 ? '' : v,
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)',
                            drawBorder: false,
                        },
                        border: { dash: [4, 4], display: false }
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

// ── Donut Chart ───────────────────────────────────────────────
if (hasDonutData) {
    const donutCtx = document.getElementById('donutChart');
    if (donutCtx) {
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: @json($donutLabels),
                datasets: [{
                    data: @json($donutData),
                    backgroundColor: @json($donutColors),
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
                        padding: 12,
                        cornerRadius: 10,
                        titleFont: { size: 12, weight: '600', family: 'Inter' },
                        bodyFont:  { size: 12, family: 'Inter' },
                        callbacks: {
                            label: function(ctx) {
                                const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                const pct   = total > 0 ? Math.round(ctx.parsed / total * 100) : 0;
                                return ` ${ctx.parsed} item (${pct}%)`;
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    duration: 800,
                    easing: 'easeInOutQuart',
                }
            }
        });
    }
}

// ── Mobile Sidebar ────────────────────────────────────────────
const mobileMenuBtn   = document.getElementById('mobileMenuBtn');
const sidebar         = document.getElementById('sidebar');
const closeSidebarBtn = document.getElementById('closeSidebarBtn');
const overlay         = document.getElementById('overlay');

if (mobileMenuBtn && sidebar && closeSidebarBtn && overlay) {
    mobileMenuBtn.addEventListener('click', () => {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    });
    closeSidebarBtn.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });
    overlay.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });
}
</script>
@endpush

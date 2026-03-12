@extends('layouts.admin')

@section('title', 'Dashboard Admin - KlikAset')

@section('content')
<!-- Chart Section -->
<div class="bg-white rounded-[30px] shadow-sm p-5 lg:p-6 mb-5 border border-gray-100">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-5">
        <h2 class="text-base lg:text-lg font-bold text-gray-800">
            Statistik Peminjaman Sarpras Bulanan
        </h2>
<div class="flex gap-2">
    <a href="?tahun=ini"
       class="px-4 py-2 border rounded-[30px] text-xs lg:text-sm font-medium transition-colors duration-200 whitespace-nowrap
              {{ $filterTahun === 'ini' ? 'bg-blue-600 text-white border-blue-600' : 'border-gray-200 text-gray-700 hover:bg-gray-50' }}">
        Tahun Ini
    </a>
    <a href="?tahun=lalu"
       class="px-4 py-2 border rounded-[30px] text-xs lg:text-sm font-medium transition-colors duration-200 whitespace-nowrap
              {{ $filterTahun === 'lalu' ? 'bg-blue-600 text-white border-blue-600' : 'border-gray-200 text-gray-700 hover:bg-gray-50' }}">
        Tahun Lalu
    </a>
</div>
    </div>
    <div class="relative h-64 sm:h-72 lg:h-80">
        <canvas id="barChart"></canvas>
    </div>
</div>

<!-- Statistics Grid with Better Proportions -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-4 lg:gap-5">
    <!-- Statistics Cards Column -->
    <div class="lg:col-span-5 grid grid-cols-1 sm:grid-cols-2 gap-3 lg:gap-4">
        <!-- Total Barang -->
        <div class="bg-white rounded-[30px] shadow-sm p-4 lg:p-5 border border-gray-100 flex items-center gap-3 lg:gap-4 hover:shadow-md transition-all duration-200">
            <div class="w-12 h-12 lg:w-20 lg:h-20 bg-blue-50 rounded-[30px] flex items-center justify-center shrink-0">
              <x-icon-box class="w-16 h-16 shrink-0 text-[#4169E1]"/>
            </div>
            <div>
                <p class="text-xs lg:text-sm text-gray-500 font-medium mb-0.5">Total Aset</p>
                <p class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $totalAset }}</p>
            </div>
        </div>

        <!-- Pengajuan Baru -->
        <div class="bg-white rounded-[30px] shadow-sm p-4 lg:p-5 border border-gray-100 flex items-center gap-3 lg:gap-4 hover:shadow-md transition-all duration-200">
            <div class="w-12 h-12 lg:w-20 lg:h-20 bg-orange-50 rounded-[30px] flex items-center justify-center shrink-0">
              <x-icon-notification-unread class="w-16 h-16 shrink-0 text-[#FF832B]"/>
            </div>
            <div>
                <p class="text-xs lg:text-sm text-gray-500 font-medium mb-0.5">Pengajuan Baru</p>
                <p class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $pengajuanBaru }}</p>
            </div>
        </div>

        <!-- Barang Sedang Dipinjam -->
        <div class="bg-white rounded-[30px] shadow-sm p-4 lg:p-5 border border-gray-100 flex items-center gap-3 lg:gap-4 hover:shadow-md transition-all duration-200">
            <div class="w-12 h-12 lg:w-20 lg:h-20 bg-yellow-50 rounded-[30px] flex items-center justify-center shrink-0">
              <x-icon-danger-circle class="w-16 h-16 shrink-0 text-[#FFCC00]"/>
            </div>
            <div>
                <p class="text-xs lg:text-sm text-gray-500 font-medium mb-0.5">Sedang Dipinjam</p>
                <p class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $sedangDipinjam }}</p>
            </div>
        </div>

        <!-- Total Peminjaman -->
        <div class="bg-white rounded-[30px] shadow-sm p-4 lg:p-5 border border-gray-100 flex items-center gap-3 lg:gap-4 hover:shadow-md transition-all duration-200">
            <div class="w-12 h-12 lg:w-20 lg:h-20 bg-red-50 rounded-[30px] flex items-center justify-center shrink-0">
              <x-icon-calendar class="w-16 h-16 shrink-0 text-[#F32727]"/>
            </div>
            <div>
                <p class="text-xs lg:text-sm text-gray-500 font-medium mb-0.5">Total Peminjaman Bulan Ini</p>
                <p class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $totalPeminjamanBulanIni }}</p>
            </div>
        </div>
    </div>

    <!-- Donut Chart Section -->
    <div class="lg:col-span-7 bg-white rounded-[30px] shadow-sm p-5 lg:p-6 border border-gray-100">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-5">
            <h2 class="text-base lg:text-lg font-bold text-gray-800">
                Jenis Barang Yang Sering Di Pinjam
            </h2>
<div class="space-y-3 min-w-45">
    @php
        $legendColors = ['bg-teal-400', 'bg-orange-400', 'bg-blue-500', 'bg-purple-600', 'bg-rose-500', 'bg-yellow-400'];
    @endphp
    @foreach($donutLabels as $index => $label)
    <div class="flex items-center gap-3">
        <div class="w-4 h-4 rounded-md shrink-0"
             style="background-color: {{ $donutColors[$index] ?? '#ccc' }}"></div>
        <span class="text-xs lg:text-sm font-medium text-gray-700">{{ $label }}</span>
    </div>
    @endforeach

    @if(empty($donutLabels))
    <p class="text-xs text-gray-400">Belum ada data</p>
    @endif
</div>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-between gap-6 lg:gap-8">
            <!-- Legend -->
            <div class="space-y-3 min-w-45">
                <div class="flex items-center gap-3">
                    <div class="w-4 h-4 bg-teal-400 rounded-md shrink-0"></div>
                    <span class="text-xs lg:text-sm font-medium text-gray-700">Prasarana</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-4 h-4 bg-orange-400 rounded-md shrink-0"></div>
                    <span class="text-xs lg:text-sm font-medium text-gray-700">Media Pendidikan</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-4 h-4 bg-blue-500 rounded-md shrink-0"></div>
                    <span class="text-xs lg:text-sm font-medium text-gray-700">Perlengkapan Kelas</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-4 h-4 bg-purple-600 rounded-md shrink-0"></div>
                    <span class="text-xs lg:text-sm font-medium text-gray-700">Fasilitas Penunjang</span>
                </div>
            </div>

            <!-- Chart Container -->
            <div class="relative w-full max-w-[320px] h-64 lg:h-72 flex items-center justify-center">
                <canvas id="donutChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // ── Bar Chart ─────────────────────────────────────────────
    const barCtx = document.getElementById('barChart');
    if (barCtx) {
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                         'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Peminjaman',
                    data: @json($barChartData),
                    backgroundColor: [
                        '#3B82F6', '#EC4899', '#8B5CF6', '#06B6D4',
                        '#10B981', '#F59E0B', '#F97316', '#F97316',
                        '#84CC16', '#EF4444', '#64748B', '#1E293B'
                    ],
                    borderRadius: 10,
                    borderSkipped: false,
                    barPercentage: 0.65,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 12,
                        borderRadius: 8,
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 12 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 25, font: { size: 11 }, color: '#6B7280' },
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: {
                        ticks: { font: { size: 11 }, color: '#6B7280' },
                        grid: { display: false }
                    }
                }
            }
        });
    }

    // ── Donut Chart ───────────────────────────────────────────
    const donutCtx = document.getElementById('donutChart');
    if (donutCtx) {
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: @json($donutLabels),
                datasets: [{
                    data: @json($donutData),
                    backgroundColor: @json($donutColors),
                    borderWidth: 0,
                    spacing: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 12,
                        borderRadius: 8,
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 12 },
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const pct = total > 0 ? Math.round(context.parsed / total * 100) : 0;
                                return context.label + ': ' + context.parsed + ' (' + pct + '%)';
                            }
                        }
                    }
                }
            }
        });
    }

    // ── Mobile Menu ───────────────────────────────────────────
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

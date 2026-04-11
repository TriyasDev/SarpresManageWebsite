<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DashboardExport;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    private $masterCategories = [
        'Prasaran',
        'Media Pendidikan',
        'Perlengkapan Kelas',
        'Fasilitas Penunjang',
        'Elektronik',
        'Alat Kantor',
        'Alat Laboratorium'
    ];

    public function index()
    {
        $this->autoBackupAndCleanOldYears();

        // Filter tahun
        $filterInput = request('tahun', 'ini');
        if (is_numeric($filterInput)) {
            $tahun = (int) $filterInput;
            $filterTahun = $tahun;
        } elseif ($filterInput === 'lalu') {
            $tahun = now()->year - 1;
            $filterTahun = 'lalu';
        } else {
            $tahun = now()->year;
            $filterTahun = 'ini';
        }

        // Stat cards
        $totalAset = Barang::count();
        $pengajuanBaru = Peminjaman::where('status', 'menunggu')->count();
        $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();
        $totalPeminjamanBulanIni = Peminjaman::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Data grafik
        $barChartData = $this->getBarChartData($tahun);
        [$donutLabels, $donutData] = $this->getDonutData($tahun);

        $donutColors = [
            '#3B82F6',
            '#10B981',
            '#F59E0B',
            '#8B5CF6',
            '#EC4899',
            '#06B6D4',
            '#EF4444'
        ];

        $availableYears = $this->getAvailableYears();

        return view('admin.dashboard', compact(
            'totalAset',
            'pengajuanBaru',
            'sedangDipinjam',
            'totalPeminjamanBulanIni',
            'barChartData',
            'donutLabels',
            'donutData',
            'donutColors',
            'filterTahun',
            'tahun',
            'availableYears'
        ));
    }

    // ========== BACKUP & CLEAN ==========
    private function autoBackupAndCleanOldYears(): void
    {
        $batasAman = now()->year - 1;
        $yearsToArchive = Peminjaman::selectRaw('YEAR(created_at) as tahun')
            ->groupBy('tahun')
            ->pluck('tahun')
            ->map(fn($y) => (int) $y)
            ->filter(fn($y) => $y < $batasAman)
            ->values();

        foreach ($yearsToArchive as $tahun) {
            try {
                $this->createYearlyBackup($tahun);
                $this->deleteYearFromDb($tahun);
                Log::info("Dashboard: tahun {$tahun} diarsipkan dan dihapus dari DB.");
            } catch (\Exception $e) {
                Log::error("Dashboard arsip tahun {$tahun} gagal: " . $e->getMessage());
            }
        }
    }

    private function createYearlyBackup(int $tahun): void
    {
        $path = "backups/dashboard_{$tahun}.json";
        if (Storage::exists($path)) return;

        $rawBar = Peminjaman::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $tahun)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $barData = [];
        for ($i = 1; $i <= 12; $i++) {
            $barData[] = (int) ($rawBar[$i] ?? 0);
        }

        $rawDonut = DetailPeminjaman::join('tb_barang', 'tb_detail_peminjaman.id_barang', '=', 'tb_barang.id_barang')
            ->join('tb_peminjaman', 'tb_detail_peminjaman.id_peminjaman', '=', 'tb_peminjaman.id_peminjaman')
            ->whereYear('tb_peminjaman.created_at', $tahun)
            ->selectRaw('tb_barang.kategori, SUM(tb_detail_peminjaman.jumlah) as total')
            ->groupBy('tb_barang.kategori')
            ->get();

        $backup = [
            'tahun' => $tahun,
            'dibuat_pada' => now()->toDateTimeString(),
            'total_peminjaman' => Peminjaman::whereYear('created_at', $tahun)->count(),
            'bar_chart' => $barData,
            'donut_labels' => $rawDonut->pluck('kategori')->toArray(),
            'donut_data' => $rawDonut->pluck('total')->map(fn($v) => (int) $v)->toArray(),
        ];

        Storage::put($path, json_encode($backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    private function deleteYearFromDb(int $tahun): void
    {
        DB::transaction(function () use ($tahun) {
            $ids = Peminjaman::whereYear('created_at', $tahun)->pluck('id_peminjaman');
            DetailPeminjaman::whereIn('id_peminjaman', $ids)->delete();
            Peminjaman::whereYear('created_at', $tahun)->delete();
        });
    }

    // ========== DATA GETTER ==========
    private function getBarChartData(int $tahun): array
    {
        if (Peminjaman::whereYear('created_at', $tahun)->exists()) {
            $rawBar = Peminjaman::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
                ->whereYear('created_at', $tahun)
                ->groupBy('bulan')
                ->pluck('total', 'bulan');
            $result = [];
            for ($i = 1; $i <= 12; $i++) {
                $result[] = (int) ($rawBar[$i] ?? 0);
            }
            return $result;
        }

        $path = "backups/dashboard_{$tahun}.json";
        if (Storage::exists($path)) {
            $data = json_decode(Storage::get($path), true);
            return $data['bar_chart'] ?? array_fill(0, 12, 0);
        }
        return array_fill(0, 12, 0);
    }

    private function getDonutData(int $tahun): array
    {
        $realData = [];
        if (Peminjaman::whereYear('created_at', $tahun)->exists()) {
            $realData = DetailPeminjaman::join('tb_barang', 'tb_detail_peminjaman.id_barang', '=', 'tb_barang.id_barang')
                ->join('tb_peminjaman', 'tb_detail_peminjaman.id_peminjaman', '=', 'tb_peminjaman.id_peminjaman')
                ->whereYear('tb_peminjaman.created_at', $tahun)
                ->selectRaw('tb_barang.kategori, SUM(tb_detail_peminjaman.jumlah) as total')
                ->groupBy('tb_barang.kategori')
                ->pluck('total', 'kategori')
                ->toArray();
        } else {
            $path = "backups/dashboard_{$tahun}.json";
            if (Storage::exists($path)) {
                $data = json_decode(Storage::get($path), true);
                if (isset($data['donut_labels'], $data['donut_data'])) {
                    $realData = array_combine($data['donut_labels'], $data['donut_data']) ?: [];
                }
            }
        }

        $labels = $this->masterCategories;
        $data = [];
        foreach ($labels as $cat) {
            $data[] = (int) ($realData[$cat] ?? 0);
        }
        return [$labels, $data];
    }

    private function getAvailableYears(): array
    {
        $fromDb = Peminjaman::selectRaw('YEAR(created_at) as tahun')
            ->groupBy('tahun')
            ->pluck('tahun')
            ->map(fn($y) => (int) $y)
            ->toArray();

        $fromBackup = collect(Storage::files('backups'))
            ->map(fn($f) => basename($f))
            ->filter(fn($f) => preg_match('/^dashboard_(\d{4})\.json$/', $f))
            ->map(fn($f) => (int) preg_replace('/\D/', '', $f))
            ->toArray();

        return collect(array_merge($fromDb, $fromBackup))
            ->unique()
            ->sortDesc()
            ->values()
            ->toArray();
    }

    // Export Excel
    public function exportExcel(Request $request)
    {
        $tahun = $request->get('tahun', 'ini');
        if ($tahun === 'lalu') {
            $tahunInt = now()->year - 1;
        } elseif (is_numeric($tahun)) {
            $tahunInt = (int) $tahun;
        } else {
            $tahunInt = now()->year;
        }

        $barChartData = $this->getBarChartData($tahunInt);
        [$donutLabels, $donutData] = $this->getDonutData($tahunInt);

        $data = [
            'barChart' => $barChartData,
            'donutLabels' => $donutLabels,
            'donutData' => $donutData,
            'totalAset' => Barang::count(),
            'pengajuanBaru' => Peminjaman::where('status', 'menunggu')->count(),
            'sedangDipinjam' => Peminjaman::where('status', 'dipinjam')->count(),
            'peminjamanBulanIni' => Peminjaman::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'totalPeminjaman' => Peminjaman::whereYear('created_at', $tahunInt)->count(),
        ];

        return Excel::download(new DashboardExport($data, $tahunInt), 'dashboard_' . $tahunInt . '.xlsx');
    }

    // Export PDF
    public function exportPdf(Request $request)
    {
        $tahunParam = $request->get('tahun', 'ini');
        if ($tahunParam === 'lalu') {
            $tahun = now()->year - 1;
        } elseif (is_numeric($tahunParam)) {
            $tahun = (int) $tahunParam;
        } else {
            $tahun = now()->year;
        }

        $barChartData = $this->getBarChartData($tahun);
        [$donutLabels, $donutData] = $this->getDonutData($tahun);

        $totalAset = Barang::count();
        $pengajuanBaru = Peminjaman::where('status', 'menunggu')->count();
        $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();
        $peminjamanBulanIni = Peminjaman::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];

        $pdf = Pdf::loadView('admin.dashboard_export_pdf', compact(
            'tahun',
            'barChartData',
            'donutLabels',
            'donutData',
            'totalAset',
            'pengajuanBaru',
            'sedangDipinjam',
            'peminjamanBulanIni',
            'months'
        ));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->download('dashboard_' . $tahun . '.pdf');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        // Auto backup tahun lama + hapus dari DB kalau sudah > 1 tahun lalu
        $this->autoBackupAndCleanOldYears();

        // Resolve filter tahun: ?tahun=ini | ?tahun=lalu | ?tahun=2024
        $filterInput = request('tahun', 'ini');

        if (is_numeric($filterInput)) {
            $tahun       = (int) $filterInput;
            $filterTahun = $tahun;
        } elseif ($filterInput === 'lalu') {
            $tahun       = now()->year - 1;
            $filterTahun = 'lalu';
        } else {
            $tahun       = now()->year;
            $filterTahun = 'ini';
        }

        // Stat cards — selalu real-time
        $totalAset               = Barang::count();
        $pengajuanBaru           = Peminjaman::where('status', 'menunggu')->count();
        $sedangDipinjam          = Peminjaman::where('status', 'dipinjam')->count();
        $totalPeminjamanBulanIni = Peminjaman::whereMonth('created_at', now()->month)
                                             ->whereYear('created_at', now()->year)
                                             ->count();

        // Bar & donut — baca dari DB, fallback ke JSON backup kalau sudah diarsip
        $barChartData              = $this->getBarChartData($tahun);
        [$donutLabels, $donutData] = $this->getDonutData($tahun);
        $donutColors               = ['#2DD4BF', '#FB923C', '#3B82F6', '#9333EA', '#F43F5E', '#EAB308'];

        // Daftar tahun tersedia (DB + file backup JSON) untuk filter view
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
            'availableYears',
        ));
    }

    // =========================================================================
    //  BACKUP + CLEAN
    // =========================================================================

    /**
     * Simpan maksimal 2 tahun di DB (tahun ini + tahun lalu).
     * Tahun yang lebih lama: backup ke JSON dulu → baru hapus dari DB.
     */
    private function autoBackupAndCleanOldYears(): void
    {
        // Tahun tertua yang masih boleh ada di DB adalah tahun lalu
        $batasAman = now()->year - 1;

        $yearsToArchive = Peminjaman::selectRaw('YEAR(created_at) as tahun')
            ->groupBy('tahun')
            ->pluck('tahun')
            ->map(fn($y) => (int) $y)
            ->filter(fn($y) => $y < $batasAman) // lebih tua dari tahun lalu
            ->values();

        foreach ($yearsToArchive as $tahun) {
            try {
                // 1. Backup dulu — kalau gagal, data TIDAK akan dihapus
                $this->createYearlyBackup($tahun);

                // 2. Baru hapus dari DB
                $this->deleteYearFromDb($tahun);

                Log::info("Dashboard: tahun {$tahun} diarsipkan dan dihapus dari DB.");
            } catch (\Exception $e) {
                // Jangan crash dashboard, cukup catat di log
                Log::error("Dashboard arsip tahun {$tahun} gagal: " . $e->getMessage());
            }
        }
    }

    /**
     * Buat file JSON backup untuk satu tahun.
     * Jika file sudah ada → skip, tidak overwrite.
     */
    private function createYearlyBackup(int $tahun): void
    {
        $path = "backups/dashboard_{$tahun}.json";

        if (Storage::exists($path)) {
            return;
        }

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
            ->orderByDesc('total')
            ->get();

        $backup = [
            'tahun'            => $tahun,
            'dibuat_pada'      => now()->toDateTimeString(),
            'total_peminjaman' => (int) Peminjaman::whereYear('created_at', $tahun)->count(),
            'bar_chart'        => $barData,
            'donut_labels'     => $rawDonut->pluck('kategori')->toArray(),
            'donut_data'       => $rawDonut->pluck('total')->map(fn($v) => (int) $v)->toArray(),
        ];

        // Jika Storage::put gagal akan throw exception,
        // ditangkap di autoBackupAndCleanOldYears supaya delete tidak jalan
        Storage::put($path, json_encode($backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Hapus data peminjaman + detail untuk satu tahun dari DB.
     * Dibungkus transaction: kalau gagal di tengah, rollback otomatis.
     */
    private function deleteYearFromDb(int $tahun): void
    {
        DB::transaction(function () use ($tahun) {
            $ids = Peminjaman::whereYear('created_at', $tahun)
                ->pluck('id_peminjaman');

            DetailPeminjaman::whereIn('id_peminjaman', $ids)->delete();
            Peminjaman::whereYear('created_at', $tahun)->delete();
        });
    }

    // =========================================================================
    //  DATA GETTER (DB dulu, fallback ke JSON backup kalau sudah diarsip)
    // =========================================================================

    private function getBarChartData(int $tahun): array
    {
        // Masih ada di DB?
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

        // Fallback: baca dari JSON backup
        $path = "backups/dashboard_{$tahun}.json";
        if (Storage::exists($path)) {
            $data = json_decode(Storage::get($path), true);
            return $data['bar_chart'] ?? array_fill(0, 12, 0);
        }

        return array_fill(0, 12, 0);
    }

    private function getDonutData(int $tahun): array
    {
        // Masih ada di DB?
        if (Peminjaman::whereYear('created_at', $tahun)->exists()) {
            $rawDonut = DetailPeminjaman::join('tb_barang', 'tb_detail_peminjaman.id_barang', '=', 'tb_barang.id_barang')
                ->join('tb_peminjaman', 'tb_detail_peminjaman.id_peminjaman', '=', 'tb_peminjaman.id_peminjaman')
                ->whereYear('tb_peminjaman.created_at', $tahun)
                ->selectRaw('tb_barang.kategori, SUM(tb_detail_peminjaman.jumlah) as total')
                ->groupBy('tb_barang.kategori')
                ->orderByDesc('total')
                ->get();

            return [
                $rawDonut->pluck('kategori')->toArray(),
                $rawDonut->pluck('total')->map(fn($v) => (int) $v)->toArray(),
            ];
        }

        // Fallback: baca dari JSON backup
        $path = "backups/dashboard_{$tahun}.json";
        if (Storage::exists($path)) {
            $data = json_decode(Storage::get($path), true);
            return [
                $data['donut_labels'] ?? [],
                $data['donut_data']   ?? [],
            ];
        }

        return [[], []];
    }

    /**
     * Gabungan tahun dari DB + file JSON backup, diurutkan terbaru dulu.
     * Dipakai view untuk render filter dropdown tahun.
     */
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
}

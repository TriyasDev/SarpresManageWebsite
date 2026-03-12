<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengajuan;
use App\Models\DetailPeminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $filterTahun = request('tahun', 'ini');
        $tahun = $filterTahun === 'lalu' ? now()->year - 1 : now()->year;
        $totalAset = Barang::count();
        $pengajuanBaru = Peminjaman::where('status', 'menunggu')->count();
        $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();
        $totalPeminjamanBulanIni = Peminjaman::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $rawBar = Peminjaman::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $tahun)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $barChartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $barChartData[] = $rawBar[$i] ?? 0;
        }

        $rawDonut = DetailPeminjaman::join('tb_barang', 'tb_detail_peminjaman.id_barang', '=', 'tb_barang.id_barang')
            ->join('tb_peminjaman', 'tb_detail_peminjaman.id_peminjaman', '=', 'tb_peminjaman.id_peminjaman')
            ->whereYear('tb_peminjaman.created_at', $tahun)
            ->selectRaw('tb_barang.kategori, SUM(tb_detail_peminjaman.jumlah) as total')
            ->groupBy('tb_barang.kategori')
            ->orderByDesc('total')
            ->get();

        $donutColors = ['#2DD4BF', '#FB923C', '#3B82F6', '#9333EA', '#F43F5E', '#EAB308'];

        return view('admin.dashboard', compact(
            'totalAset',
            'pengajuanBaru',
            'sedangDipinjam',
            'totalPeminjamanBulanIni',
            'barChartData',
            'donutLabels',
            'donutData',
            'donutColors',
            'filterTahun'
        ));
    }
}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DashboardExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize, WithStyles
{
    protected array $data;
    protected int $tahun;

    public function __construct(array $data, int $tahun)
    {
        $this->data = $data;
        $this->tahun = $tahun;
    }

    public function headings(): array
    {
        return [
            'Statistik Dashboard',
            'Tahun ' . $this->tahun,
        ];
    }

    public function array(): array
    {
        $rows = [];

        // Baris kosong
        $rows[] = [''];

        // Data Bar Chart (per bulan)
        $rows[] = ['Peminjaman per Bulan'];
        $rows[] = ['Bulan', 'Jumlah Peminjaman'];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        foreach ($this->data['barChart'] as $i => $value) {
            $rows[] = [$months[$i], $value];
        }

        $rows[] = [''];
        $rows[] = [''];

        // Data Donut Chart (kategori)
        $rows[] = ['Jenis Barang Sering Dipinjam'];
        $rows[] = ['Kategori', 'Jumlah Dipinjam', 'Persentase'];
        $total = array_sum($this->data['donutData']);
        foreach ($this->data['donutLabels'] as $i => $label) {
            $jumlah = $this->data['donutData'][$i];
            $persen = $total > 0 ? round(($jumlah / $total) * 100, 1) : 0;
            $rows[] = [$label, $jumlah, $persen . '%'];
        }

        $rows[] = [''];
        $rows[] = ['Total Peminjaman Tahun Ini', $this->data['totalPeminjaman']];
        $rows[] = ['Total Aset', $this->data['totalAset']];
        $rows[] = ['Pengajuan Baru', $this->data['pengajuanBaru']];
        $rows[] = ['Sedang Dipinjam', $this->data['sedangDipinjam']];
        $rows[] = ['Peminjaman Bulan Ini', $this->data['peminjamanBulanIni']];

        return $rows;
    }

    public function title(): string
    {
        return 'Dashboard ' . $this->tahun;
    }

    public function styles(Worksheet $sheet)
    {
        // Style header utama
        $sheet->mergeCells('A1:B1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => 'center'],
        ]);

        // Style sub-header (Peminjaman per Bulan)
        $sheet->getStyle('A3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
        ]);
        $sheet->getStyle('A4:B4')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FFE0E0E0']],
        ]);

        // Style sub-header (Kategori)
        $sheet->getStyle('A' . (count($this->data['barChart']) + 7))->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
        ]);
        $sheet->getStyle('A' . (count($this->data['barChart']) + 8) . ':C' . (count($this->data['barChart']) + 8))->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FFE0E0E0']],
        ]);

        // Style statistik ringkasan
        $lastRowStart = count($this->data['barChart']) + count($this->data['donutData']) + 12;
        for ($i = $lastRowStart; $i <= $lastRowStart + 5; $i++) {
            $sheet->getStyle("A{$i}")->applyFromArray([
                'font' => ['bold' => true],
            ]);
        }

        return [];
    }
}

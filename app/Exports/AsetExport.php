<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AsetExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $barangs;

    public function __construct($barangs)
    {
        $this->barangs = $barangs;
    }

    public function collection()
    {
        return $this->barangs;
    }

    public function headings(): array
    {
        return [
            'No',
            'ID Barang',
            'Nama Barang',
            'Kategori',
            'Kondisi',
            'Jumlah Total',
            'Jumlah Tersedia',
            'Deskripsi',
            'Dibuat Pada',
        ];
    }

    public function map($barang): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $barang->id_barang,
            $barang->nama_barang,
            $barang->kategori,
            $barang->kondisi,
            $barang->jumlah_total,
            $barang->jumlah_tersedia,
            $barang->deskripsi,
            $barang->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF2563EB']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}

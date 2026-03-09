<?php

namespace App\Exports;

use App\Models\Laporan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Laporan::with(['peminjam.user', 'peminjam.aset', 'admin'])->latest();

        if (!empty($this->filters['jenis_laporan'])) {
            $query->where('jenis_laporan', $this->filters['jenis_laporan']);
        }

        if (!empty($this->filters['kondisi_barang'])) {
            $query->where('kondisi_barang', $this->filters['kondisi_barang']);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No',
            'ID Laporan',
            'Nama Peminjam',
            'Email Peminjam',
            'Nama Aset',
            'Kode Aset',
            'Jenis Laporan',
            'Kondisi Barang',
            'Tgl. Dipinjam',
            'Tgl. Dikembalikan',
            'Admin',
            'Dibuat Pada',
        ];
    }

    public function map($laporan): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $laporan->id_laporan,
            $laporan->peminjam?->user?->nama    ?? '-',
            $laporan->peminjam?->user?->email   ?? '-',
            $laporan->peminjam?->aset?->nama_aset  ?? '-',
            $laporan->peminjam?->aset?->kode_aset  ?? '-',
            ucwords($laporan->jenis_laporan),
            ucwords($laporan->kondisi_barang),
            $laporan->tanggal_dipinjam?->format('d/m/Y H:i')     ?? '-',
            $laporan->tanggal_dikembalikan?->format('d/m/Y H:i') ?? '-',
            $laporan->admin?->nama ?? '-',
            $laporan->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Baris header (baris 1) — bold + background biru muda
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF2563EB']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}

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
        $query = Laporan::with(['peminjaman.user', 'peminjaman.detailPeminjaman.barang', 'admin'])
            ->latest();

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
            'Kategori Aset',
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

        $peminjaman = $laporan->peminjaman;
        $user = $peminjaman?->user;
        $barang = $peminjaman?->detailPeminjaman->first()?->barang;

        return [
            $no,
            $laporan->id_laporan,
            $user?->nama ?? $user?->username ?? '-',
            $user?->email ?? '-',
            $barang?->nama_barang ?? '-',
            $barang?->kategori ?? '-',
            $laporan->label_jenis,
            $laporan->label_kondisi,
            $laporan->tanggal_dipinjam?->format('d/m/Y H:i') ?? '-',
            $laporan->tanggal_dikembalikan?->format('d/m/Y H:i') ?? '-',
            $laporan->admin?->nama ?? '-',
            $laporan->created_at->format('d/m/Y H:i'),
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

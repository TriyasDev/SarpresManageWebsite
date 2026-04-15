<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Http\Request;

class PengajuanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $pengajuans;

    public function __construct($pengajuans)
    {
        $this->pengajuans = $pengajuans;
    }

    public function collection()
    {
        return $this->pengajuans;
    }

    public function headings(): array
    {
        return [
            'No',
            'ID Peminjaman',
            'Nama Peminjam',
            'NIPD',
            'Email',
            'Nama Barang',
            'Jumlah',
            'Tanggal Pinjam',
            'Tanggal Kembali (Jadwal)',
            'Status',
            'Catatan',
            'Disetujui Oleh',
            'Approved At',
            'Dibuat Pada',
        ];
    }

    public function map($peminjaman): array
    {
        static $no = 0;
        $no++;

        // Ambil barang pertama (karena bisa multiple)
        $firstDetail = $peminjaman->firstDetail;
        $namaBarang = $firstDetail?->barang?->nama_barang ?? '-';
        $jumlah = $firstDetail?->jumlah ?? 0;
        $totalItems = $peminjaman->detailPeminjaman->count();
        if ($totalItems > 1) {
            $namaBarang .= " (+" . ($totalItems - 1) . " lainnya)";
        }

        return [
            $no,
            $peminjaman->id_peminjaman,
            $peminjaman->user?->username ?? '-',
            $peminjaman->user?->nipd ?? '-',
            $peminjaman->user?->email ?? '-',
            $namaBarang,
            $jumlah,
            $peminjaman->tanggal_pinjam?->format('d/m/Y H:i') ?? '-',
            $peminjaman->tanggal_kembali?->format('d/m/Y H:i') ?? '-',
            $peminjaman->label_status,
            $peminjaman->catatan ?? '-',
            $peminjaman->approver?->username ?? '-',
            $peminjaman->approved_at?->format('d/m/Y H:i') ?? '-',
            $peminjaman->created_at->format('d/m/Y H:i'),
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

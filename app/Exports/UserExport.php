<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return $this->users;
    }

    public function headings(): array
    {
        return [
            'No',
            'ID User',
            'Username',
            'Email',
            'Role',
            'NIPD',
            'Kelas',
            'No Telpon',
            'Alamat',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Points',
            'Tier',
            'Status Banned',
            'Dibuat Pada',
        ];
    }

    public function map($user): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $user->id_user,
            $user->username,
            $user->email,
            $user->role_name,
            $user->nipd ?? '-',
            $user->kelas ?? '-',
            $user->no_telpon ?? '-',
            $user->alamat ?? '-',
            $user->tanggal_lahir?->format('d/m/Y') ?? '-',
            $user->jenis_kelamin ?? '-',
            $user->points,
            $user->tier ?? '-',
            $user->is_banned ? 'Ya' : 'Tidak',
            $user->created_at->format('d/m/Y H:i'),
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

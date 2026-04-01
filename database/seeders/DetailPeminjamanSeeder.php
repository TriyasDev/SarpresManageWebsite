<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailPeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $details = [
            // Peminjaman #1 - Budi (Overdue 5 hari)
            [
                'id_peminjaman' => 1,
                'id_barang' => 1,
                'jumlah' => 2,
                'kondisi_pinjam' => 'baik',
                'kondisi_kembali' => null,
                'keterangan' => 'Untuk praktikum pemrograman',
            ],
            [
                'id_peminjaman' => 1,
                'id_barang' => 5,
                'jumlah' => 2,
                'kondisi_pinjam' => 'baik',
                'kondisi_kembali' => null,
                'keterangan' => 'Pelengkap laptop',
            ],
            // ... rest of the data unchanged (just ensure no extra columns)
        ];

        foreach ($details as $detail) {
            // Using composite key (id_peminjaman, id_barang) to avoid duplicates
            DB::table('tb_detail_peminjaman')->updateOrInsert(
                [
                    'id_peminjaman' => $detail['id_peminjaman'],
                    'id_barang' => $detail['id_barang'],
                ],
                $detail
            );
        }

        $this->command->info('✅ Detail Peminjaman seeded successfully!');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $barang = [
            [
                'id_barang' => 1,
                'nama_barang' => 'Laptop Dell XPS 15',
                'kategori' => 'Elektronik',
                'kondisi' => 'baik',
                'jumlah_total' => 10,
                'jumlah_tersedia' => 7,
                'deskripsi' => 'Laptop untuk kegiatan pembelajaran',
            ],
            [
                'id_barang' => 2,
                'nama_barang' => 'Proyektor Epson EB-X41',
                'kategori' => 'Elektronik',
                'kondisi' => 'baik',
                'jumlah_total' => 5,
                'jumlah_tersedia' => 3,
                'deskripsi' => 'Proyektor untuk presentasi',
            ],
            [
                'id_barang' => 3,
                'nama_barang' => 'Kamera DSLR Canon EOS 80D',
                'kategori' => 'Elektronik',
                'kondisi' => 'baik',
                'jumlah_total' => 3,
                'jumlah_tersedia' => 2,
                'deskripsi' => 'Kamera untuk dokumentasi kegiatan',
            ],
            [
                'id_barang' => 4,
                'nama_barang' => 'Microphone Wireless Shure',
                'kategori' => 'Elektronik',
                'kondisi' => 'baik',
                'jumlah_total' => 8,
                'jumlah_tersedia' => 5,
                'deskripsi' => 'Microphone untuk acara',
            ],
            [
                'id_barang' => 5,
                'nama_barang' => 'Mouse Wireless Logitech',
                'kategori' => 'Elektronik',
                'kondisi' => 'baik',
                'jumlah_total' => 20,
                'jumlah_tersedia' => 15,
                'deskripsi' => 'Mouse wireless untuk praktikum',
            ],
            [
                'id_barang' => 6,
                'nama_barang' => 'Speaker Bluetooth JBL',
                'kategori' => 'Elektronik',
                'kondisi' => 'baik',
                'jumlah_total' => 4,
                'jumlah_tersedia' => 3,
                'deskripsi' => 'Speaker portable untuk acara',
            ],
            [
                'id_barang' => 7,
                'nama_barang' => 'Tablet Samsung Galaxy Tab',
                'kategori' => 'Elektronik',
                'kondisi' => 'baik',
                'jumlah_total' => 6,
                'jumlah_tersedia' => 4,
                'deskripsi' => 'Tablet untuk membaca e-book',
            ],
            [
                'id_barang' => 8,
                'nama_barang' => 'Keyboard Mechanical Gaming',
                'kategori' => 'Elektronik',
                'kondisi' => 'baik',
                'jumlah_total' => 12,
                'jumlah_tersedia' => 10,
                'deskripsi' => 'Keyboard untuk praktikum pemrograman',
            ],
        ];

        foreach ($barang as $item) {
            DB::table('tb_barang')->updateOrInsert(
                ['id_barang' => $item['id_barang']],
                $item
            );
        }

        $this->command->info('✅ Barang seeded successfully!');
    }
}

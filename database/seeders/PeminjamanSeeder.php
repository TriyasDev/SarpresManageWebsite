<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $peminjaman = [
            // 1. OVERDUE - Terlambat 5 hari (URGENT - untuk testing email overdue)
            [
                'id_user' => 3, // Budi Santoso
                'id_admin' => 1,
                'tanggal_pinjam' => $now->copy()->subDays(12),
                'tanggal_kembali' => $now->copy()->subDays(5), // Sudah lewat 5 hari
                'tanggal_kembali_aktual' => null,
                'status' => 'dipinjam',
                'approved_at' => $now->copy()->subDays(12),
                'rejected_at' => null,
                'catatan' => 'Untuk kegiatan praktikum',
                'disetujui_oleh' => 1,
                'return_condition' => null,
                'is_late' => false,
                'point_earned' => 0,
                'created_at' => $now->copy()->subDays(12),
                'updated_at' => $now->copy()->subDays(12),
            ],
            // 2. OVERDUE - Terlambat 3 hari
            [
                'id_user' => 6, // Dewi Lestari
                'id_admin' => 1,
                'tanggal_pinjam' => $now->copy()->subDays(10),
                'tanggal_kembali' => $now->copy()->subDays(3), // Sudah lewat 3 hari
                'tanggal_kembali_aktual' => null,
                'status' => 'dipinjam',
                'approved_at' => $now->copy()->subDays(10),
                'rejected_at' => null,
                'catatan' => 'Untuk dokumentasi event',
                'disetujui_oleh' => 1,
                'return_condition' => null,
                'is_late' => false,
                'point_earned' => 0,
                'created_at' => $now->copy()->subDays(10),
                'updated_at' => $now->copy()->subDays(10),
            ],
            // 3. DUE SOON - Jatuh tempo besok (1 hari lagi)
            [
                'id_user' => 7, // Rina Wati
                'id_admin' => 1,
                'tanggal_pinjam' => $now->copy()->subDays(6),
                'tanggal_kembali' => $now->copy()->addDay(), // Besok
                'tanggal_kembali_aktual' => null,
                'status' => 'dipinjam',
                'approved_at' => $now->copy()->subDays(6),
                'rejected_at' => null,
                'catatan' => 'Untuk presentasi kelas',
                'disetujui_oleh' => 1,
                'return_condition' => null,
                'is_late' => false,
                'point_earned' => 0,
                'created_at' => $now->copy()->subDays(6),
                'updated_at' => $now->copy()->subDays(6),
            ],
            // 4. DUE SOON - Jatuh tempo 2 hari lagi
            [
                'id_user' => 4, // Siti Nurhaliza
                'id_admin' => 1,
                'tanggal_pinjam' => $now->copy()->subDays(5),
                'tanggal_kembali' => $now->copy()->addDays(2), // 2 hari lagi
                'tanggal_kembali_aktual' => null,
                'status' => 'dipinjam',
                'approved_at' => $now->copy()->subDays(5),
                'rejected_at' => null,
                'catatan' => 'Untuk tugas akhir',
                'disetujui_oleh' => 1,
                'return_condition' => null,
                'is_late' => false,
                'point_earned' => 0,
                'created_at' => $now->copy()->subDays(5),
                'updated_at' => $now->copy()->subDays(5),
            ],
            // 5. UPCOMING - Jatuh tempo 4 hari lagi
            [
                'id_user' => 5, // Ahmad Pratama
                'id_admin' => 1,
                'tanggal_pinjam' => $now->copy()->subDays(3),
                'tanggal_kembali' => $now->copy()->addDays(4), // 4 hari lagi
                'tanggal_kembali_aktual' => null,
                'status' => 'dipinjam',
                'approved_at' => $now->copy()->subDays(3),
                'rejected_at' => null,
                'catatan' => 'Untuk praktikum jaringan',
                'disetujui_oleh' => 1,
                'return_condition' => null,
                'is_late' => false,
                'point_earned' => 0,
                'created_at' => $now->copy()->subDays(3),
                'updated_at' => $now->copy()->subDays(3),
            ],
            // 6. UPCOMING - Jatuh tempo 5 hari lagi
            [
                'id_user' => 3, // Budi Santoso
                'id_admin' => 1,
                'tanggal_pinjam' => $now->copy()->subDays(2),
                'tanggal_kembali' => $now->copy()->addDays(5), // 5 hari lagi
                'tanggal_kembali_aktual' => null,
                'status' => 'dipinjam',
                'approved_at' => $now->copy()->subDays(2),
                'rejected_at' => null,
                'catatan' => 'Untuk kegiatan OSIS',
                'disetujui_oleh' => 1,
                'return_condition' => null,
                'is_late' => false,
                'point_earned' => 0,
                'created_at' => $now->copy()->subDays(2),
                'updated_at' => $now->copy()->subDays(2),
            ],
            // 7. SUDAH DIKEMBALIKAN - Tepat waktu
            [
                'id_user' => 4, // Siti Nurhaliza
                'id_admin' => 1,
                'tanggal_pinjam' => $now->copy()->subDays(14),
                'tanggal_kembali' => $now->copy()->subDays(7),
                'tanggal_kembali_aktual' => $now->copy()->subDays(8),
                'status' => 'dikembalikan',
                'approved_at' => $now->copy()->subDays(14),
                'rejected_at' => null,
                'catatan' => 'Untuk lomba desain',
                'disetujui_oleh' => 1,
                'return_condition' => 'baik',
                'is_late' => false,
                'point_earned' => 15,
                'created_at' => $now->copy()->subDays(14),
                'updated_at' => $now->copy()->subDays(8),
            ],
            // 8. SUDAH DIKEMBALIKAN - Terlambat
            [
                'id_user' => 5, // Ahmad Pratama
                'id_admin' => 1,
                'tanggal_pinjam' => $now->copy()->subDays(20),
                'tanggal_kembali' => $now->copy()->subDays(13),
                'tanggal_kembali_aktual' => $now->copy()->subDays(10), // Terlambat 3 hari
                'status' => 'dikembalikan',
                'approved_at' => $now->copy()->subDays(20),
                'rejected_at' => null,
                'catatan' => 'Untuk praktikum web',
                'disetujui_oleh' => 1,
                'return_condition' => 'rusak_ringan',
                'is_late' => true,
                'point_earned' => -11, // -6 (telat 3 hari) + -5 (rusak ringan)
                'created_at' => $now->copy()->subDays(20),
                'updated_at' => $now->copy()->subDays(10),
            ],
            // 9. MENUNGGU APPROVAL
            [
                'id_user' => 6, // Dewi Lestari
                'id_admin' => null,
                'tanggal_pinjam' => $now->copy()->subHours(2),
                'tanggal_kembali' => null,
                'tanggal_kembali_aktual' => null,
                'status' => 'menunggu',
                'approved_at' => null,
                'rejected_at' => null,
                'catatan' => 'Untuk acara sekolah minggu depan',
                'disetujui_oleh' => null,
                'return_condition' => null,
                'is_late' => false,
                'point_earned' => 0,
                'created_at' => $now->copy()->subHours(2),
                'updated_at' => $now->copy()->subHours(2),
            ],
            // 10. DISETUJUI - Belum dipinjam
            [
                'id_user' => 7, // Rina Wati
                'id_admin' => 1,
                'tanggal_pinjam' => $now->copy()->subHours(5),
                'tanggal_kembali' => $now->copy()->addDays(7),
                'tanggal_kembali_aktual' => null,
                'status' => 'disetujui',
                'approved_at' => $now->copy()->subHours(4),
                'rejected_at' => null,
                'catatan' => 'Disetujui, silakan ambil barang',
                'disetujui_oleh' => 1,
                'return_condition' => null,
                'is_late' => false,
                'point_earned' => 0,
                'created_at' => $now->copy()->subHours(5),
                'updated_at' => $now->copy()->subHours(4),
            ],
            // 11. DITOLAK
            [
                'id_user' => 3, // Budi Santoso
                'id_admin' => 1,
                'tanggal_pinjam' => $now->copy()->subDays(1),
                'tanggal_kembali' => null,
                'tanggal_kembali_aktual' => null,
                'status' => 'ditolak',
                'approved_at' => null,
                'rejected_at' => $now->copy()->subDays(1),
                'catatan' => 'Barang tidak tersedia untuk tanggal tersebut',
                'disetujui_oleh' => 1,
                'return_condition' => null,
                'is_late' => false,
                'point_earned' => 0,
                'created_at' => $now->copy()->subDays(1),
                'updated_at' => $now->copy()->subDays(1),
            ],
        ];

        DB::table('tb_peminjaman')->insert($peminjaman);

        $this->command->info('✅ Peminjaman seeded successfully!');
        $this->command->info('');
        $this->command->info('📊 Summary:');
        $this->command->info('   🚨 Overdue (terlambat): 2 peminjaman');
        $this->command->info('   ⏰ Due soon (1-2 hari): 2 peminjaman');
        $this->command->info('   📅 Upcoming (3-5 hari): 2 peminjaman');
        $this->command->info('   ✅ Dikembalikan: 2 peminjaman');
        $this->command->info('   ⏳ Menunggu approval: 1 peminjaman');
        $this->command->info('   👍 Disetujui: 1 peminjaman');
        $this->command->info('   ❌ Ditolak: 1 peminjaman');
    }
}

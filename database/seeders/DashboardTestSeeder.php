<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DashboardTestSeeder extends Seeder
{
    public function run(): void
    {
        // ── 0. Disable foreign key check sementara ────────────────────────
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('tb_detail_peminjaman')->truncate();
        DB::table('tb_peminjaman')->truncate();
        DB::table('tb_barang')->truncate();
        DB::table('tb_user')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->command->info('🗑️  Tabel lama dibersihkan.');

        // ── 1. Seed tb_user ───────────────────────────────────────────────
        $userIds = [];
        for ($i = 1; $i <= 10; $i++) {
            $userIds[] = DB::table('tb_user')->insertGetId([
                'username'   => 'user_test_' . $i,
                'email'      => 'user' . $i . '@test.com',
                'password'   => Hash::make('password'),
                'no_telpon'  => '08' . rand(100000000, 999999999),
                'role'       => 'peminjam',
                'rank'       => 'Steward',
                'point'      => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('👤 10 user dummy dibuat.');

        // ── 2. Seed tb_barang ─────────────────────────────────────────────
        $kategoris = [
            'Prasarana'          => ['Meja', 'Kursi', 'Lemari', 'Papan Tulis'],
            'Media Pendidikan'   => ['Proyektor', 'Layar Proyektor', 'Speaker'],
            'Perlengkapan Kelas' => ['Spidol', 'Penghapus', 'Penggaris', 'Buku Tulis'],
            'Fasilitas Penunjang'=> ['Kamera', 'Tripod', 'Mikrofon'],
        ];

        $barangIds = []; // ['kategori' => [id, id, ...]]

        foreach ($kategoris as $kat => $namaBarangs) {
            $barangIds[$kat] = [];
            foreach ($namaBarangs as $nama) {
                $barangIds[$kat][] = DB::table('tb_barang')->insertGetId([
                    'nama_barang'     => $nama,
                    'kategori'        => $kat,
                    'kondisi'         => 'baik',
                    'jumlah_total'    => 10,
                    'jumlah_tersedia' => 10,
                    'deskripsi'       => 'Data dummy untuk testing',
                    'foto'            => 'default.jpg',
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
            }
        }

        $this->command->info('📦 ' . array_sum(array_map('count', $barangIds)) . ' barang dummy dibuat.');

        // ── 3. Seed tb_peminjaman + tb_detail_peminjaman ──────────────────
        $tahuns   = [now()->year - 1, now()->year];
        $statuses = ['menunggu', 'disetujui', 'dipinjam', 'dikembalikan', 'dikembalikan', 'dikembalikan'];
        $kondisis = ['baik', 'rusak ringan', 'rusak berat'];
        $allKategoris = array_keys($kategoris);

        $totalPeminjaman = 0;

        foreach ($tahuns as $tahun) {
            for ($bulan = 1; $bulan <= 12; $bulan++) {

                // Skip bulan yang belum terjadi di tahun ini
                if ($tahun === now()->year && $bulan > now()->month) {
                    continue;
                }

                // Jumlah peminjaman per bulan (variatif biar grafik menarik)
                $jumlahPerBulan = rand(8, 35);

                for ($j = 0; $j < $jumlahPerBulan; $j++) {
                    $tanggal       = Carbon::create($tahun, $bulan, rand(1, 28), rand(7, 17));
                    $status        = $statuses[array_rand($statuses)];
                    $userId        = $userIds[array_rand($userIds)];

                    $peminjamanId = DB::table('tb_peminjaman')->insertGetId([
                        'id_user'               => $userId,
                        'id_admin'              => null,
                        'tanggal_pinjam'        => $tanggal,
                        'tanggal_kembali'       => (clone $tanggal)->addDays(rand(1, 7)),
                        'tanggal_kembali_aktual'=> $status === 'dikembalikan'
                                                    ? (clone $tanggal)->addDays(rand(1, 8))
                                                    : null,
                        'status'                => $status,
                        'catatan'               => null,
                        'disetujui_oleh'        => null,
                        'point'                 => 0,
                        'created_at'            => $tanggal,
                        'updated_at'            => $tanggal,
                    ]);

                    // 1–2 barang per peminjaman
                    $jumlahItem = rand(1, 2);
                    $usedBarang = [];

                    for ($k = 0; $k < $jumlahItem; $k++) {
                        // Pilih kategori & barang acak (hindari duplikat dalam 1 peminjaman)
                        $kat      = $allKategoris[array_rand($allKategoris)];
                        $idBarang = $barangIds[$kat][array_rand($barangIds[$kat])];

                        if (in_array($idBarang, $usedBarang)) continue;
                        $usedBarang[] = $idBarang;

                        DB::table('tb_detail_peminjaman')->insert([
                            'id_peminjaman'  => $peminjamanId,
                            'id_barang'      => $idBarang,
                            'jumlah'         => rand(1, 3),
                            'kondisi_pinjam' => 'baik',
                            'kondisi_kembali'=> $status === 'dikembalikan'
                                                ? $kondisis[array_rand($kondisis)]
                                                : null,
                            'keterangan'     => null,
                        ]);
                    }

                    $totalPeminjaman++;
                }
            }
        }

        $this->command->info("📋 {$totalPeminjaman} peminjaman dummy dibuat.");

        // ── 4. Tampilkan ringkasan ─────────────────────────────────────────
        $this->command->newLine();
        $this->command->table(
            ['Tahun', 'Total Peminjaman', 'Menunggu', 'Dipinjam', 'Dikembalikan'],
            collect($tahuns)->map(fn($y) => [
                $y,
                DB::table('tb_peminjaman')->whereYear('created_at', $y)->count(),
                DB::table('tb_peminjaman')->whereYear('created_at', $y)->where('status', 'menunggu')->count(),
                DB::table('tb_peminjaman')->whereYear('created_at', $y)->where('status', 'dipinjam')->count(),
                DB::table('tb_peminjaman')->whereYear('created_at', $y)->where('status', 'dikembalikan')->count(),
            ])->toArray()
        );

        $this->command->newLine();
        $this->command->table(
            ['Kategori', 'Total Item Dipinjam'],
            DB::table('tb_detail_peminjaman')
                ->join('tb_barang', 'tb_detail_peminjaman.id_barang', '=', 'tb_barang.id_barang')
                ->selectRaw('tb_barang.kategori, SUM(tb_detail_peminjaman.jumlah) as total')
                ->groupBy('tb_barang.kategori')
                ->orderByDesc('total')
                ->get()
                ->map(fn($r) => [$r->kategori, $r->total])
                ->toArray()
        );

        $this->command->newLine();
        $this->command->info('✅ Seeder selesai! Buka dashboard untuk melihat hasilnya.');
    }
}

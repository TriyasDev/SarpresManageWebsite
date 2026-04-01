<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin (id_user = 1)
        User::updateOrCreate(
            ['username' => 'superadmin'],
            [
                'email' => 'superadmin@sekolah.test',
                'password' => Hash::make('password123'),
                'no_telpon' => '081234567890',
                'role' => 'super-admin',
                'nama' => 'Ketua Sarpras',
                'is_banned' => false,
            ]
        );

        // Admin (id_user = 2)
        User::updateOrCreate(
            ['username' => 'admin1'],
            [
                'email' => 'admin@sekolah.test',
                'password' => Hash::make('password123'),
                'no_telpon' => '081234567891',
                'role' => 'admin',
                'nama' => 'Staff Administrasi',
                'is_banned' => false,
            ]
        );

        // Existing peminjam: Budi Santoso (id_user = 3)
        User::updateOrCreate(
            ['username' => 'siswa1'],
            [
                'email' => 'siswa@sekolah.test',
                'password' => Hash::make('password123'),
                'no_telpon' => '081234567892',
                'role' => 'peminjam',
                'nama' => 'Budi Santoso',
                'kelas' => 'XII IPA 1',
                'nipd' => '20210001',
                'alamat' => 'Jl. Pendidikan No. 123',
                'tanggal_lahir' => '2006-05-15',
                'jenis_kelamin' => 'laki-laki',
                'points' => 50,
                'tier' => 'Reliant',
                'is_banned' => false,
            ]
        );

        // Additional users needed for PeminjamanSeeder
        $additional = [
            [
                'username' => 'sitihaliza',
                'nama' => 'Siti Nurhaliza',
                'email' => 'siti@sekolah.test',
                'nipd' => '20210002',
                'jenis_kelamin' => 'perempuan',
                'no_telpon' => '081234567893',
            ],
            [
                'username' => 'ahmadp',
                'nama' => 'Ahmad Pratama',
                'email' => 'ahmad@sekolah.test',
                'nipd' => '20210003',
                'jenis_kelamin' => 'laki-laki',
                'no_telpon' => '081234567894',
            ],
            [
                'username' => 'dewi',
                'nama' => 'Dewi Lestari',
                'email' => 'dewi@sekolah.test',
                'nipd' => '20210004',
                'jenis_kelamin' => 'perempuan',
                'no_telpon' => '081234567895',
            ],
            [
                'username' => 'rina',
                'nama' => 'Rina Wati',
                'email' => 'rina@sekolah.test',
                'nipd' => '20210005',
                'jenis_kelamin' => 'perempuan',
                'no_telpon' => '081234567896',
            ],
        ];

        foreach ($additional as $data) {
            User::updateOrCreate(
                ['username' => $data['username']],
                [
                    'email' => $data['email'],
                    'password' => Hash::make('password123'),
                    'no_telpon' => $data['no_telpon'],
                    'role' => 'peminjam',
                    'nama' => $data['nama'],
                    'kelas' => 'XII IPA 2',
                    'nipd' => $data['nipd'],
                    'alamat' => 'Jl. Pendidikan No. ' . rand(1, 100),
                    'tanggal_lahir' => '2006-01-01',
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'points' => 50,
                    'tier' => 'Reliant',
                    'is_banned' => false,
                ]
            );
        }
    }
}

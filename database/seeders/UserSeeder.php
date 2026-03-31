<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'superadmin',
            'email' => 'superadmin@sekolah.test',
            'password' => Hash::make('password123'),
            'no_telpon' => '081234567890',
            'role' => 'super-admin',
            'nama' => 'Ketua Sarpras',
            'is_banned' => false,
        ]);

        User::create([
            'username' => 'admin1',
            'email' => 'admin@sekolah.test',
            'password' => Hash::make('password123'),
            'no_telpon' => '081234567891',
            'role' => 'admin',
            'nama' => 'Staff Administrasi',
            'is_banned' => false,
        ]);

        User::create([
            'username' => 'siswa1',
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
        ]);
    }
}

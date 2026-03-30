<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_user')->insert([
            [
                'username' => 'atmin triyas',
                'email' => 'iyastriyas2@gmail.com',
                'password' => Hash::make('admin001#'),
                'no_telpon' => '08123456789',
                'role' => 'super-admin',
                'nama' => 'triyas',
                'kelas' => null,
                'nipd' => '12345678910123456789123',
                'alamat' => 'bandung',
                'tier' => null,
                'points' => null,
                'created_at' => now(),
            ],
            [
                'username' => 'atmin',
                'email' => 'blek@gmail.com',
                'password' => Hash::make('admin002#'),
                'no_telpon' => '08123456489',
                'role' => 'admin',
                'nama' => 'blek',
                'kelas' => null,
                'nipd' => '12345678910123478683',
                'alamat' => 'bandung',
                'tier' => null,
                'points' => null,
                'created_at' => now(),
            ],
            [
                'username' => 'atmin',
                'email' => 'blek@gmail.com',
                'password' => Hash::make('admin002#'),
                'no_telpon' => '08123456489',
                'role' => 'peminjam',
                'nama' => 'blek',
                'kelas' => null,
                'nipd' => '12345678910123478683',
                'alamat' => 'bandung',
                'tier' => null,
                'points' => null,
                'created_at' => now(),
            ]
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('tb_user')->insert([
            [
                'username' => 'admin001',
                'password' => Hash::make('admin001#'),
                'email' => 'admin1@gmail.com',
                'no_telpon' => '08123456789',
                'role' => 'admin',
                'rank' => null,
                'point' => null,
                'created_at' => now(),
            ],
            [
                'username' => 'admin002',
                'password' => Hash::make('admin002#'),
                'email' => 'admin2@gmail.com',
                'no_telpon' => '08123456789',
                'role' => 'admin',
                'rank' => null,
                'point' => null,
                'created_at' => now(),
            ],
            [
                'username' => 'Yudika Raja Sawit',
                'password' => Hash::make('user123'),
                'email' => 'nyudika@gmail.com',
                'no_telpon' => '08987654321',
                'role' => 'peminjam',
                'rank' => 'Reliant',
                'point' => 50,
                'created_at' => now(),
            ],
            [
                'username' => 'Ikbal Penjaga Sawit',
                'password' => Hash::make('user1234'),
                'email' => 'nyeikbal@gmail.com',
                'no_telpon' => '08123456789',
                'role' => 'peminjam',
                'rank' => 'Reliant',
                'point' => 50,
                'created_at' => now(),
            ]
        ]);
    }
}

@extends('layouts.admin')

@section('title', 'Kelola Data User - KlikAset')

@section('content')
{{-- SECTION 1: Form Input User --}}
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-6 lg:p-10 mb-6">
        <h2 class="text-lg lg:text-xl font-bold text-gray-800 mb-6">Tambah User Baru</h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
{{-- Kolom Kiri --}}
            <div class="space-y-5">
{{-- Nama Lengkap --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">
                        Nama Lengkap:
                    </label>
                    <input
                        type="text"
                        id="namaLengkap"
                        placeholder="Masukkan nama lengkap"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"
                    />
                </div>

{{-- Password --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">
                        Password:
                    </label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            placeholder="Masukkan password"
                            class="w-full px-5 py-3 pr-12 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"
                        />
                        <button
                            type="button"
                            id="togglePassword"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition focus:outline-none"
                        >
                            <x-icon-eye-closed id="eyeIcon" class="w-5 h-5"/>
                            <x-icon-eye id="eyeSlashIcon" class="w-5 h-5 hidden"/>
                        </button>
                    </div>
                </div>

{{-- NIPD --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">
                        NIPD:
                    </label>
                    <input
                        type="text"
                        id="nipd"
                        placeholder="Masukkan NIPD"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"
                    />
                </div>

{{-- Alamat --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">
                        Alamat:
                    </label>
                    <input
                        type="text"
                        id="alamat"
                        placeholder="Masukkan alamat"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"
                    />
                </div>
            </div>

{{-- Kolom Kanan --}}
            <div class="space-y-5">
{{-- Tanggal Lahir --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">
                        Tanggal Lahir:
                    </label>
                    <input
                        type="date"
                        id="tanggalLahir"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"
                    />
                </div>

{{-- Jenis Kelamin --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">
                        Jenis Kelamin:
                    </label>
                    <div class="relative">
                        <select
                            id="jenisKelamin"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition"
                        >
                            <option value="">Pilih jenis kelamin</option>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                            <x-icon-alt-arrow-down class="fill-current h-6 w-6"/>
                        </div>
                    </div>
                </div>

{{-- Rank (Read-only) --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">
                        Rank:
                    </label>
                    <input
                        type="text"
                        value="Reliant"
                        readonly
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] bg-gray-50 text-gray-600 text-sm cursor-not-allowed"
                    />
                </div>

{{-- Tombol Simpan --}}
                <div class="pt-7">
                    <button
                        type="button"
                        id="simpanBtn"
                        class="w-full bg-costume-primary text-white px-5 py-3 rounded-[30px] font-semibold text-sm hover:bg-blue-700 active:bg-blue-800 transition"
                    >
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

{{-- SECTION 2: Search Bar --}}
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-5 mb-6">
        <div class="relative">
            <input
                type="text"
                placeholder="Cari Nama User atau NIPD ..."
                class="w-full px-5 py-3 pr-12 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"
            />
            <x-icon-magnifer class="w-5 h-5 absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"/>
        </div>
    </div>

{{-- SECTION 3: Tabel Data User --}}
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 overflow-hidden">
{{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/80">
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Nama Lengkap</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">NIPD</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Alamat</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Tanggal Lahir</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Rank</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Jenis Kelamin</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
{{-- Row 1 --}}
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Ahmad Rizki</p>
                            <p class="text-xs text-gray-500 text-center">rizki@gmail.com</p>
                        </td>
                        <td class="p-4 text-center text-sm">12345678</td>
                        <td class="p-4 text-center text-xs text-gray-600">Jl. Merdeka No. 123, Ngawi</td>
                        <td class="p-4 text-center text-sm">12 Feb 1990</td>
                        <td class="p-4">
                            <div class="flex justify-center">
                                <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-[30px] border border-blue-200 shadow-sm">
                                    Reliant
                                </span>
                            </div>
                        </td>
                        <td class="p-4 text-center text-sm">Laki-laki</td>
                        <td class="p-4">
                            <div class="flex gap-2 justify-center">
                                <button class="px-4 py-1.5 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-[30px] border border-yellow-200 shadow-sm hover:bg-yellow-200 transition">
                                    Edit
                                </button>
                                <button class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm hover:bg-red-200 transition">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

{{-- Row 2 --}}
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Siti Nurhaliza</p>
                            <p class="text-xs text-gray-500 text-center">siti@gmail.com</p>
                        </td>
                        <td class="p-4 text-center text-sm">87654321</td>
                        <td class="p-4 text-center text-xs text-gray-600">Jl. Sudirman No. 45, Madiun</td>
                        <td class="p-4 text-center text-sm">15 Mar 1995</td>
                        <td class="p-4">
                            <div class="flex justify-center">
                                <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-[30px] border border-blue-200 shadow-sm">
                                    Reliant
                                </span>
                            </div>
                        </td>
                        <td class="p-4 text-center text-sm">Perempuan</td>
                        <td class="p-4">
                            <div class="flex gap-2 justify-center">
                                <button class="px-4 py-1.5 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-[30px] border border-yellow-200 shadow-sm hover:bg-yellow-200 transition">
                                    Edit
                                </button>
                                <button class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm hover:bg-red-200 transition">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

{{-- Row 3 --}}
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Budi Santoso</p>
                            <p class="text-xs text-gray-500 text-center">budi@gmail.com</p>
                        </td>
                        <td class="p-4 text-center text-sm">11223344</td>
                        <td class="p-4 text-center text-xs text-gray-600">Jl. Gatot Subroto No. 78, Solo</td>
                        <td class="p-4 text-center text-sm">20 Jun 1992</td>
                        <td class="p-4">
                            <div class="flex justify-center">
                                <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-[30px] border border-blue-200 shadow-sm">
                                    Reliant
                                </span>
                            </div>
                        </td>
                        <td class="p-4 text-center text-sm">Laki-laki</td>
                        <td class="p-4">
                            <div class="flex gap-2 justify-center">
                                <button class="px-4 py-1.5 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-[30px] border border-yellow-200 shadow-sm hover:bg-yellow-200 transition">
                                    Edit
                                </button>
                                <button class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm hover:bg-red-200 transition">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

{{-- Row 4 --}}
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Dewi Lestari</p>
                            <p class="text-xs text-gray-500 text-center">dewi@gmail.com</p>
                        </td>
                        <td class="p-4 text-center text-sm">44332211</td>
                        <td class="p-4 text-center text-xs text-gray-600">Jl. Ahmad Yani No. 90, Yogyakarta</td>
                        <td class="p-4 text-center text-sm">08 Aug 1998</td>
                        <td class="p-4">
                            <div class="flex justify-center">
                                <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-[30px] border border-blue-200 shadow-sm">
                                    Reliant
                                </span>
                            </div>
                        </td>
                        <td class="p-4 text-center text-sm">Perempuan</td>
                        <td class="p-4">
                            <div class="flex gap-2 justify-center">
                                <button class="px-4 py-1.5 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-[30px] border border-yellow-200 shadow-sm hover:bg-yellow-200 transition">
                                    Edit
                                </button>
                                <button class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm hover:bg-red-200 transition">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

{{-- Row 5 --}}
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Eko Prasetyo</p>
                            <p class="text-xs text-gray-500 text-center">eko@gmail.com</p>
                        </td>
                        <td class="p-4 text-center text-sm">55667788</td>
                        <td class="p-4 text-center text-xs text-gray-600">Jl. Diponegoro No. 12, Semarang</td>
                        <td class="p-4 text-center text-sm">25 Nov 1993</td>
                        <td class="p-4">
                            <div class="flex justify-center">
                                <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-[30px] border border-blue-200 shadow-sm">
                                    Reliant
                                </span>
                            </div>
                        </td>
                        <td class="p-4 text-center text-sm">Laki-laki</td>
                        <td class="p-4">
                            <div class="flex gap-2 justify-center">
                                <button class="px-4 py-1.5 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-[30px] border border-yellow-200 shadow-sm hover:bg-yellow-200 transition">
                                    Edit
                                </button>
                                <button class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm hover:bg-red-200 transition">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

{{-- Row 6 --}}
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Fitri Handayani</p>
                            <p class="text-xs text-gray-500 text-center">fitri@gmail.com</p>
                        </td>
                        <td class="p-4 text-center text-sm">99887766</td>
                        <td class="p-4 text-center text-xs text-gray-600">Jl. Pahlawan No. 34, Surabaya</td>
                        <td class="p-4 text-center text-sm">10 Jan 1997</td>
                        <td class="p-4">
                            <div class="flex justify-center">
                                <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-[30px] border border-blue-200 shadow-sm">
                                    Reliant
                                </span>
                            </div>
                        </td>
                        <td class="p-4 text-center text-sm">Perempuan</td>
                        <td class="p-4">
                            <div class="flex gap-2 justify-center">
                                <button class="px-4 py-1.5 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-[30px] border border-yellow-200 shadow-sm hover:bg-yellow-200 transition">
                                    Edit
                                </button>
                                <button class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm hover:bg-red-200 transition">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

{{-- Row 7 --}}
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Hari Wijaya</p>
                            <p class="text-xs text-gray-500 text-center">hari@gmail.com</p>
                        </td>
                        <td class="p-4 text-center text-sm">22334455</td>
                        <td class="p-4 text-center text-xs text-gray-600">Jl. Veteran No. 56, Malang</td>
                        <td class="p-4 text-center text-sm">18 Apr 1991</td>
                        <td class="p-4">
                            <div class="flex justify-center">
                                <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-[30px] border border-blue-200 shadow-sm">
                                    Reliant
                                </span>
                            </div>
                        </td>
                        <td class="p-4 text-center text-sm">Laki-laki</td>
                        <td class="p-4">
                            <div class="flex gap-2 justify-center">
                                <button class="px-4 py-1.5 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-[30px] border border-yellow-200 shadow-sm hover:bg-yellow-200 transition">
                                    Edit
                                </button>
                                <button class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm hover:bg-red-200 transition">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

{{-- Row 8 --}}
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Indah Permata</p>
                            <p class="text-xs text-gray-500 text-center">indah@gmail.com</p>
                        </td>
                        <td class="p-4 text-center text-sm">66778899</td>
                        <td class="p-4 text-center text-xs text-gray-600">Jl. Kartini No. 67, Bandung</td>
                        <td class="p-4 text-center text-sm">22 Sep 1996</td>
                        <td class="p-4">
                            <div class="flex justify-center">
                                <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-[30px] border border-blue-200 shadow-sm">
                                    Reliant
                                </span>
                            </div>
                        </td>
                        <td class="p-4 text-center text-sm">Perempuan</td>
                        <td class="p-4">
                            <div class="flex gap-2 justify-center">
                                <button class="px-4 py-1.5 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-[30px] border border-yellow-200 shadow-sm hover:bg-yellow-200 transition">
                                    Edit
                                </button>
                                <button class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm hover:bg-red-200 transition">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

{{-- Row 9 --}}
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Joko Susilo</p>
                            <p class="text-xs text-gray-500 text-center">joko@gmail.com</p>
                        </td>
                        <td class="p-4 text-center text-sm">33445566</td>
                        <td class="p-4 text-center text-xs text-gray-600">Jl. Pemuda No. 89, Jakarta</td>
                        <td class="p-4 text-center text-sm">05 Dec 1994</td>
                        <td class="p-4">
                            <div class="flex justify-center">
                                <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-[30px] border border-blue-200 shadow-sm">
                                    Reliant
                                </span>
                            </div>
                        </td>
                        <td class="p-4 text-center text-sm">Laki-laki</td>
                        <td class="p-4">
                            <div class="flex gap-2 justify-center">
                                <button class="px-4 py-1.5 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-[30px] border border-yellow-200 shadow-sm hover:bg-yellow-200 transition">
                                    Edit
                                </button>
                                <button class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm hover:bg-red-200 transition">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

{{-- Row 10 --}}
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Kartika Sari</p>
                            <p class="text-xs text-gray-500 text-center">kartika@gmail.com</p>
                        </td>
                        <td class="p-4 text-center text-sm">77889900</td>
                        <td class="p-4 text-center text-xs text-gray-600">Jl. Proklamasi No. 101, Bekasi</td>
                        <td class="p-4 text-center text-sm">30 May 1999</td>
                        <td class="p-4">
                            <div class="flex justify-center">
                                <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-[30px] border border-blue-200 shadow-sm">
                                    Reliant
                                </span>
                            </div>
                        </td>
                        <td class="p-4 text-center text-sm">Perempuan</td>
                        <td class="p-4">
                            <div class="flex gap-2 justify-center">
                                <button class="px-4 py-1.5 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-[30px] border border-yellow-200 shadow-sm hover:bg-yellow-200 transition">
                                    Edit
                                </button>
                                <button class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm hover:bg-red-200 transition">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

{{-- Pagination --}}
        <div class="flex flex-col sm:flex-row items-center justify-between p-4 bg-white gap-4">
{{-- Info Halaman --}}
            <p class="text-xs lg:text-sm text-gray-600">
                Menampilkan 1–10 user dari 50
            </p>

{{-- Navigasi Halaman --}}
            <div class="flex items-center gap-2 flex-wrap justify-center">
                <span class="text-xs lg:text-sm font-medium mr-1">Ke halaman:</span>
                <button class="w-8 h-8 lg:w-10 lg:h-10 rounded-[30px] border-2 border-gray-100 flex items-center justify-center hover:bg-gray-100 transition text-xs lg:text-sm">
                    1
                </button>
                <button class="h-8 lg:h-10 px-3 lg:px-4 rounded-[30px] border-2 border-gray-100 flex items-center justify-center hover:bg-gray-100 transition text-xs lg:text-sm">
                    Pergi
                </button>
                <button class="h-8 lg:h-10 px-3 rounded-[30px] border-2 border-gray-100 flex items-center justify-center hover:bg-gray-100 transition text-xs lg:text-sm">
                    &laquo; Sebelumnya
                </button>
                <button class="w-8 h-8 lg:w-10 lg:h-10 rounded-[30px] border-2 border-gray-100 flex items-center justify-center hover:bg-gray-100 transition text-xs lg:text-sm">
                    1
                </button>
                <button class="w-8 h-8 lg:w-10 lg:h-10 rounded-[30px] border-2 border-costume-primary bg-costume-primary text-white flex items-center justify-center shadow-sm text-xs lg:text-sm">
                    2
                </button>
                <button class="w-8 h-8 lg:w-10 lg:h-10 rounded-[30px] border-2 border-gray-100 flex items-center justify-center hover:bg-gray-100 transition text-xs lg:text-sm">
                    3
                </button>
                <button class="h-8 lg:h-10 px-3 rounded-[30px] border-2 border-gray-100 flex items-center justify-center hover:bg-gray-100 transition text-xs lg:text-sm">
                    Selanjutnya &raquo;
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
{{-- JavaScript untuk handle form submit dan CRUD operations --}}
<script>
    // Password Toggle Visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeSlashIcon = document.getElementById('eyeSlashIcon');

    togglePassword?.addEventListener('click', function() {
        // Toggle password visibility
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Toggle icon
        eyeIcon.classList.toggle('hidden');
        eyeSlashIcon.classList.toggle('hidden');
    });

    // Form handling
    document.getElementById('simpanBtn')?.addEventListener('click', function() {
        // Logic untuk simpan data user
        console.log('Simpan user clicked');
    });
</script>
@endpush

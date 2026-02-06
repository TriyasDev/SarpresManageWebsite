@extends('layouts.laporan')
@section('title', 'Laporan')
@section('laporan')
<main class="flex-1 p-4 lg:p-8 pt-20 lg:pt-8">
            <div class="bg-white rounded-2xl lg:rounded-3xl shadow-lg p-6 lg:p-8 mb-6 lg:mb-8 border-2 border-gray-300">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                    <div class="space-y-4 lg:space-y-6">
                        <div>
                            <label class="block text-black font-semibold mb-2 text-sm lg:text-base">Masukan ID Peminjaman</label>
                            <input type="text" class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm lg:text-base">
                        </div>

                        <div>
                            <label class="block text-black font-semibold mb-2 text-sm lg:text-base">Apakah Telat Dalam Pengembalian ?</label>
                            <select class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none bg-white text-sm lg:text-base">
                                <option></option>
                                <option>Ya</option>
                                <option>Tidak</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-black font-semibold mb-2 text-sm lg:text-base">Bagaimana Kondisi Barang ?</label>
                            <textarea rows="4" class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none text-sm lg:text-base"></textarea>
                        </div>

                        <div>
                            <label class="block text-black font-semibold mb-2 text-sm lg:text-base">Tambahkan Gambar Sebagai Bukti</label>
                            <button class="w-full border-2 border-black rounded-xl py-3 font-semibold text-black hover:bg-gray-50 transition text-sm lg:text-base">
                                Pilih File
                            </button>
                        </div>
                    </div>

                    <div class="space-y-4 flex flex-col">
                        <div class="flex-1 border-2 border-dashed border-gray-400 rounded-xl p-8 flex items-center justify-center bg-gray-50">
                            <div class="text-center">
                                <p class="text-lg lg:text-xl font-bold text-gray-700">Preview Gambar<br>Drag File Disini</p>
                            </div>
                        </div>

                        <button class="w-full bg-white border-2 border-black rounded-xl py-3 font-bold text-black hover:bg-gray-50 transition text-sm lg:text-base">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl lg:rounded-3xl shadow-lg p-6 lg:p-8 mb-6 border-2 border-gray-300">
                <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between">
                    <div class="flex flex-wrap gap-2 lg:gap-4">
                        <div class="flex gap-2">
                            <select class="border-2 border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs lg:text-sm font-medium">
                                <option>Cetak PDF</option>
                            </select>
                            <select class="border-2 border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs lg:text-sm font-medium">
                                <option>Cetak Excel</option>
                            </select>
                        </div>
                        
                        <div class="flex flex-wrap gap-2">
                            <select class="border-2 border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs lg:text-sm">
                                <option>Semua Barang</option>
                            </select>
                            <span class="self-center text-xs lg:text-sm font-medium text-gray-600 hidden lg:inline">Pilih Jenis Barang</span>
                            
                            <select class="border-2 border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs lg:text-sm">
                                <option>Semua Status</option>
                            </select>
                            <span class="self-center text-xs lg:text-sm font-medium text-gray-600 hidden lg:inline">Pilih Jenis Status</span>
                            
                            <button class="border-2 border-gray-300 rounded-xl px-6 py-2 hover:bg-gray-50 transition text-xs lg:text-sm font-medium">
                                Filter
                            </button>
                        </div>
                    </div>

                    <div class="relative w-full lg:w-auto lg:min-w-[300px]">
                        <input type="text" placeholder="Pencarian :" class="w-full bg-white border-2 border-gray-300 rounded-xl px-4 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs lg:text-sm">
                        <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl lg:rounded-3xl shadow-lg border-2 border-gray-300 overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-300">
                            <th class="p-4 text-center font-semibold text-sm lg:text-base">Nama Peminjam</th>
                            <th class="p-4 text-center font-semibold text-sm lg:text-base">Nama Barang</th>
                            <th class="p-4 text-center font-semibold text-sm lg:text-base">Keperluan</th>
                            <th class="p-4 text-center font-semibold text-sm lg:text-base">Tanggal<br>Peminjaman</th>
                            <th class="p-4 text-center font-semibold text-sm lg:text-base">Tanggal<br>Pengembalian</th>
                            <th class="p-4 text-center font-semibold text-sm lg:text-base">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b-2 border-gray-300">
                            <td class="p-4">
                                <p class="font-medium text-center text-sm lg:text-base">John Doe</p>
                                <p class="text-xs lg:text-sm text-gray-600 text-center">john@gmail.com</p>
                            </td>
                            <td class="p-4">
                                <p class="font-medium text-center text-sm lg:text-base">Laptop Dell XPS 15</p>
                                <p class="text-xs lg:text-sm text-gray-600 text-center">Kode: LPT-001</p>
                            </td>
                            <td class="p-4 text-center text-xs lg:text-sm">
                                Untuk keperluan<br>presentasi project
                            </td>
                            <td class="p-4">
                                <p class="font-semibold text-center text-sm lg:text-base">15 Feb 2024</p>
                                <p class="text-xs lg:text-sm text-gray-600 text-center">09:00 WIB</p>
                            </td>
                            <td class="p-4">
                                <p class="font-semibold text-center text-sm lg:text-base">29 Feb 2024</p>
                                <p class="text-xs lg:text-sm text-gray-600 text-center">17:00 WIB</p>
                            </td>
                            <td class="p-4">
                                <div class="flex flex-col gap-2 items-center">
                                    <button class="w-32 lg:w-36 bg-green-500 text-white border-2 border-green-600 rounded-full py-1.5 text-xs lg:text-sm font-medium hover:bg-green-600 transition shadow-md">
                                        Sudah Di Kembalikan
                                    </button>
                                    <button class="w-32 lg:w-36 bg-yellow-400 text-white border-2 border-yellow-500 rounded-full py-1.5 text-xs lg:text-sm font-medium hover:bg-yellow-500 transition shadow-md">
                                        Masih Di Pinjam
                                    </button>
                                    <button class="w-32 lg:w-36 bg-orange-500 text-white border-2 border-orange-600 rounded-full py-1.5 text-xs lg:text-sm font-medium hover:bg-orange-600 transition shadow-md">
                                        Terlambat
                                    </button>
                                    <button class="w-32 lg:w-36 bg-red-500 text-white border-2 border-red-600 rounded-full py-1.5 text-xs lg:text-sm font-medium hover:bg-red-600 transition shadow-md">
                                        Rusak
                                    </button>
                                    <button class="w-32 lg:w-36 bg-red-600 text-white border-2 border-red-700 rounded-full py-1.5 text-xs lg:text-sm font-medium hover:bg-red-700 transition shadow-md">
                                        Hilang
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="flex flex-col sm:flex-row items-center justify-between p-4 gap-4 border-t-2 border-gray-300">
                    <p class="text-xs lg:text-sm text-gray-600">Menampilkan 1-10 data dari 50</p>
                    
                    <div class="flex items-center gap-2 flex-wrap justify-center">
                        <span class="text-xs lg:text-sm font-medium mr-2">Kehalaman :</span>
                        <button class="w-8 h-8 lg:w-10 lg:h-10 rounded-full border-2 border-gray-300 flex items-center justify-center hover:bg-gray-100 transition text-xs lg:text-sm">
                            1
                        </button>
                        <button class="w-auto px-3 lg:px-4 h-8 lg:h-10 rounded-full border-2 border-gray-300 flex items-center justify-center hover:bg-gray-100 transition text-xs lg:text-sm">
                            Pergi
                        </button>
                        <button class="w-auto px-2 lg:px-3 h-8 lg:h-10 rounded-full border-2 border-gray-300 flex items-center justify-center hover:bg-gray-100 transition text-xs lg:text-sm">
                            &lt;&lt; Sebelumnya
                        </button>
                        <button class="w-8 h-8 lg:w-10 lg:h-10 rounded-full border-2 border-gray-300 flex items-center justify-center hover:bg-gray-100 transition text-xs lg:text-sm">
                            1
                        </button>
                        <button class="w-8 h-8 lg:w-10 lg:h-10 rounded-full border-2 border-gray-300 bg-blue-500 text-white flex items-center justify-center shadow-md text-xs lg:text-sm">
                            2
                        </button>
                        <button class="w-8 h-8 lg:w-10 lg:h-10 rounded-full border-2 border-gray-300 flex items-center justify-center hover:bg-gray-100 transition text-xs lg:text-sm">
                            3
                        </button>
                        <button class="w-auto px-2 lg:px-3 h-8 lg:h-10 rounded-full border-2 border-gray-300 flex items-center justify-center hover:bg-gray-100 transition text-xs lg:text-sm">
                            Selanjutnya &gt;&gt;
                        </button>
                    </div>
                </div>
            </div>
        </main>


@endsection
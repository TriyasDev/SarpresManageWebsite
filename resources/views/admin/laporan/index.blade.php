@extends('layouts.admin')
@section('title', 'Laporan - KlikAset')
@section('content')
{{-- SECTION 1: Form Input & Upload Foto --}}
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-6 lg:p-10 mb-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
{{-- Kolom Kiri: Form Input --}}
            <div class="space-y-5">
{{-- ID Peminjaman --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">
                        Masukan ID Peminjaman:
                    </label>
                    <input
                        type="text"
                        id="namaMerek"
                        placeholder="Masukkan ID peminjaman"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"
                    />
                </div>
{{-- Status Pengembalian --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">
                        Apakah Telat Mengembalikannya:
                    </label>
                    <div class="relative">
                        <select
                            id="statusPengembalian"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition"
                        >
                            <option value="tepat">Tepat Waktu</option>
                            <option value="telat">Telat Mengembalikan</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </div>
                    </div>
                </div>
{{-- Kondisi Barang --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">
                        Kondisi Barang:
                    </label>
                    <div class="relative">
                        <select
                            id="kondisi"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition"
                        >
                            <option value="baik">Baik</option>
                            <option value="rusak-ringan">Rusak Ringan</option>
                            <option value="rusak-berat">Rusak Berat</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </div>
                    </div>
                </div>
{{-- Catatan --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">
                        Catatan:
                    </label>
                    <input
                        type="text"
                        id="catatan"
                        placeholder="Masukkan catatan"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"
                    />
                </div>
            </div>
{{-- Kolom Kanan: Upload Foto & Tombol Simpan --}}
            <div class="flex flex-col">
{{-- Area Upload Foto --}}
                <div class="flex flex-col mb-7">
{{-- Header Upload --}}
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-gray-800 font-medium text-sm">
                            Tambahkan Foto
                        </label>
                        <button
                            type="button"
                            id="removeImage"
                            class="hidden px-4 py-1 bg-red-500 text-white text-xs font-medium rounded-[30px] hover:bg-red-600 transition"
                        >
                            Hapus Foto
                        </button>
                    </div>
{{-- Drop Zone --}}
                    <div
                        id="uploadArea"
                        class="border-2 border-dashed border-gray-300 rounded-[30px] bg-white hover:bg-gray-50 transition cursor-pointer h-[260px] flex items-center justify-center overflow-hidden"
                    >
                        <input type="file" id="photoInput" accept="image/*" class="hidden" />
{{-- Placeholder --}}
                        <div id="uploadPlaceholder" class="w-full text-center px-8">
                            <x-icon-gallery-add class="w-16 h-16 mx-auto text-gray-300"/>
                            <p class="text-lg font-bold text-gray-700 mb-1">Tambahkan Foto</p>
                            <p class="text-sm text-gray-400">Klik atau Drag Foto ke sini</p>
                        </div>
{{-- Preview Image --}}
                        <div id="imagePreview" class="hidden w-full h-full">
                            <img
                                id="previewImg"
                                src=""
                                alt="Preview"
                                class="w-full h-full object-cover"
                            />
                        </div>
                    </div>
                </div>
{{-- Tombol Simpan --}}
                <button
                    type="button"
                    id="simpanBtn"
                    class="w-full bg-costume-primary text-white px-5 py-3 rounded-[30px] font-semibold text-sm hover:bg-blue-700 active:bg-blue-800 transition shadow-md hover:shadow-lg"
                >
                    Simpan
                </button>
            </div>
        </div>
    </div>
{{-- SECTION 2: Filter & Pencarian --}}
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-5 mb-6">
        <div class="flex flex-col lg:flex-row gap-4">
{{-- Pencarian --}}
            <div class="flex-1 relative">
                <input
                    type="text"
                    placeholder="Cari peminjam / barang ..."
                    class="w-full px-5 py-3 pr-12 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition"
                />
                <x-icon-magnifer class="w-5 h-5 absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"/>
            </div>
{{-- Filter Jenis Barang --}}
            <div class="lg:w-44">
                <div class="relative">
                    <select
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition"
                    >
                        <option value="">Jenis</option>
                        <option>Semua Barang</option>
                        <option>Laptop</option>
                        <option>Proyektor</option>
                        <option>Kamera</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                        </svg>
                    </div>
                </div>
            </div>
{{-- Filter Status --}}
            <div class="lg:w-44">
                <div class="relative">
                    <select
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition"
                    >
                        <option value="">Status</option>
                        <option>Semua Status</option>
                        <option>Dipinjam</option>
                        <option>Dikembalikan</option>
                        <option>Terlambat</option>
                        <option>Rusak</option>
                        <option>Hilang</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                        </svg>
                    </div>
                </div>
            </div>
{{-- Tombol Filter & Download --}}
            <div class="lg:w-auto flex gap-3">
                <button
                    class="px-5 py-3 border-2 border-gray-300 rounded-[30px] bg-white text-sm font-medium hover:bg-gray-50 transition flex items-center gap-2"
                >
                    <x-icon-filter class="w-4 h-4"/>
                    Filter
                </button>
                <button
                    id="downloadPdfBtn"
                    class="px-5 py-3 border-2 border-blue-300 rounded-[30px] bg-blue-50 text-blue-700 text-sm font-medium hover:bg-blue-100 transition flex items-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download PDF
                </button>
            </div>
        </div>
    </div>
{{-- SECTION 3: Tabel Data Peminjaman --}}
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 overflow-hidden">
{{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/80">
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Nama Peminjam</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Barang</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Keperluan</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Tgl Pinjam</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Tgl Kembali</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody>
{{-- Row 1 --}}
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">John Doe</p>
                            <p class="text-xs text-gray-500 text-center">john@gmail.com</p>
                        </td>
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Laptop Dell XPS 15</p>
                            <p class="text-xs text-gray-500 text-center">LPT-001</p>
                        </td>
                        <td class="p-4 text-center text-xs text-gray-600">
                            Presentasi project akhir
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-center text-sm">15/02/2024</p>
                            <p class="text-xs text-gray-500 text-center">09:00</p>
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-center text-sm">29/02/2024</p>
                            <p class="text-xs text-gray-500 text-center">17:00</p>
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center">
                                <span class="px-3 py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-[30px] border border-green-200 shadow-sm">
                                    Dikembalikan
                                </span>
                            </div>
                        </td>
                    </tr>
{{-- Row 2 --}}
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Sarah Williams</p>
                            <p class="text-xs text-gray-500 text-center">sarah.w@gmail.com</p>
                        </td>
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Proyektor Epson EB-X41</p>
                            <p class="text-xs text-gray-500 text-center">PRY-003</p>
                        </td>
                        <td class="p-4 text-center text-xs text-gray-600">
                            Seminar mahasiswa
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-center text-sm">10/02/2024</p>
                            <p class="text-xs text-gray-500 text-center">08:00</p>
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-center text-sm">15/02/2024</p>
                            <p class="text-xs text-gray-500 text-center">16:00</p>
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center">
                                <span class="px-3 py-1.5 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-[30px] border border-yellow-200 shadow-sm">
                                    Dipinjam
                                </span>
                            </div>
                        </td>
                    </tr>
{{-- Row 3 --}}
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Michael Chen</p>
                            <p class="text-xs text-gray-500 text-center">mchen@gmail.com</p>
                        </td>
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Kamera Canon EOS 90D</p>
                            <p class="text-xs text-gray-500 text-center">CAM-012</p>
                        </td>
                        <td class="p-4 text-center text-xs text-gray-600">
                            Dokumentasi acara kampus
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-center text-sm">05/02/2024</p>
                            <p class="text-xs text-gray-500 text-center">10:00</p>
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-center text-sm">08/02/2024</p>
                            <p class="text-xs text-gray-500 text-center">15:00</p>
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center">
                                <span class="px-3 py-1.5 bg-orange-100 text-orange-700 text-xs font-semibold rounded-[30px] border border-orange-200 shadow-sm">
                                    Terlambat
                                </span>
                            </div>
                        </td>
                    </tr>
{{-- Row 4 --}}
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Amanda Rodriguez</p>
                            <p class="text-xs text-gray-500 text-center">amanda.r@gmail.com</p>
                        </td>
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Laptop HP Pavilion 14</p>
                            <p class="text-xs text-gray-500 text-center">LPT-005</p>
                        </td>
                        <td class="p-4 text-center text-xs text-gray-600">
                            Tugas kuliah
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-center text-sm">20/02/2024</p>
                            <p class="text-xs text-gray-500 text-center">13:00</p>
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-center text-sm">22/02/2024</p>
                            <p class="text-xs text-gray-500 text-center">17:00</p>
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center">
                                <span class="px-3 py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-[30px] border border-green-200 shadow-sm">
                                    Dikembalikan
                                </span>
                            </div>
                        </td>
                    </tr>
{{-- Row 5 --}}
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">David Kim</p>
                            <p class="text-xs text-gray-500 text-center">david.kim@gmail.com</p>
                        </td>
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Tablet iPad Pro 12.9"</p>
                            <p class="text-xs text-gray-500 text-center">TAB-007</p>
                        </td>
                        <td class="p-4 text-center text-xs text-gray-600">
                            Rapat organisasi
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-center text-sm">18/02/2024</p>
                            <p class="text-xs text-gray-500 text-center">14:00</p>
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-center text-sm">20/02/2024</p>
                            <p class="text-xs text-gray-500 text-center">12:00</p>
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center">
                                <span class="px-3 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm">
                                    Rusak
                                </span>
                            </div>
                        </td>
                    </tr>
{{-- Row 6 --}}
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Emily Johnson</p>
                            <p class="text-xs text-gray-500 text-center">emily.j@gmail.com</p>
                        </td>
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Speaker JBL Flip 6</p>
                            <p class="text-xs text-gray-500 text-center">SPK-015</p>
                        </td>
                        <td class="p-4 text-center text-xs text-gray-600">
                            Acara musik kampus
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-center text-sm">12/02/2024</p>
                            <p class="text-xs text-gray-500 text-center">11:00</p>
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-center text-sm">14/02/2024</p>
                            <p class="text-xs text-gray-500 text-center">18:00</p>
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center">
                                <span class="px-3 py-1.5 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-[30px] border border-yellow-200 shadow-sm">
                                    Dipinjam
                                </span>
                            </div>
                        </td>
                    </tr>
{{-- Row 7 --}}
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Robert Taylor</p>
                            <p class="text-xs text-gray-500 text-center">rtaylor@gmail.com</p>
                        </td>
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Kamera Sony A7 III</p>
                            <p class="text-xs text-gray-500 text-center">CAM-008</p>
                        </td>
                        <td class="p-4 text-center text-xs text-gray-600">
                            Liputan berita kampus
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-center text-sm">01/02/2024</p>
                            <p class="text-xs text-gray-500 text-center">07:00</p>
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-center text-sm">03/02/2024</p>
                            <p class="text-xs text-gray-500 text-center">19:00</p>
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center">
                                <span class="px-3 py-1.5 bg-red-200 text-red-800 text-xs font-semibold rounded-[30px] border border-red-300 shadow-sm">
                                    Hilang
                                </span>
                            </div>
                        </td>
                    </tr>
{{-- Row 8 --}}
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Jessica Martinez</p>
                            <p class="text-xs text-gray-500 text-center">jmartinez@gmail.com</p>
                        </td>
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Laptop Asus ROG Zephyrus</p>
                            <p class="text-xs text-gray-500 text-center">LPT-010</p>
                        </td>
                        <td class="p-4 text-center text-xs text-gray-600">
                            Rendering video
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-center text-sm">25/02/2024</p>
                            <p class="text-xs text-gray-500 text-center">10:00</p>
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-center text-sm">28/02/2024</p>
                            <p class="text-xs text-gray-500 text-center">16:00</p>
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center">
                                <span class="px-3 py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-[30px] border border-green-200 shadow-sm">
                                    Dikembalikan
                                </span>
                            </div>
                        </td>
                    </tr>
{{-- Row 9 --}}
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Daniel Anderson</p>
                            <p class="text-xs text-gray-500 text-center">d.anderson@gmail.com</p>
                        </td>
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Proyektor BenQ MW535A</p>
                            <p class="text-xs text-gray-500 text-center">PRY-002</p>
                        </td>
                        <td class="p-4 text-center text-xs text-gray-600">
                            Workshop desain grafis
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-center text-sm">08/02/2024</p>
                            <p class="text-xs text-gray-500 text-center">09:30</p>
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-center text-sm">10/02/2024</p>
                            <p class="text-xs text-gray-500 text-center">14:00</p>
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center">
                                <span class="px-3 py-1.5 bg-orange-100 text-orange-700 text-xs font-semibold rounded-[30px] border border-orange-200 shadow-sm">
                                    Terlambat
                                </span>
                            </div>
                        </td>
                    </tr>
{{-- Row 10 --}}
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Linda Brown</p>
                            <p class="text-xs text-gray-500 text-center">linda.b@gmail.com</p>
                        </td>
                        <td class="p-4">
                            <p class="font-medium text-center text-sm">Microphone Shure SM58</p>
                            <p class="text-xs text-gray-500 text-center">MIC-020</p>
                        </td>
                        <td class="p-4 text-center text-xs text-gray-600">
                            Podcast kampus
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-center text-sm">22/02/2024</p>
                            <p class="text-xs text-gray-500 text-center">15:00</p>
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-center text-sm">25/02/2024</p>
                            <p class="text-xs text-gray-500 text-center">13:00</p>
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center">
                                <span class="px-3 py-1.5 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-[30px] border border-yellow-200 shadow-sm">
                                    Dipinjam
                                </span>
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
                Menampilkan 1–10 pengajuan dari 50
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
<script>
// =============================================
// UPLOAD FOTO - DRAG & DROP + CLICK
// =============================================
const uploadArea        = document.getElementById('uploadArea');
const photoInput        = document.getElementById('photoInput');
const uploadPlaceholder = document.getElementById('uploadPlaceholder');
const imagePreview      = document.getElementById('imagePreview');
const previewImg        = document.getElementById('previewImg');
const removeImageBtn    = document.getElementById('removeImage');

// Klik area → buka file dialog
uploadArea.addEventListener('click', () => photoInput.click());

// Pilih file → tampilkan preview + munculkan tombol Hapus
photoInput.addEventListener('change', () => {
    const file = photoInput.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = (e) => {
        previewImg.src = e.target.result;
        uploadPlaceholder.classList.add('hidden');
        imagePreview.classList.remove('hidden');
        removeImageBtn.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
});

// Hapus foto → reset ke placeholder + sembunyikan tombol Hapus
removeImageBtn.addEventListener('click', (e) => {
    e.stopPropagation(); // Prevent triggering uploadArea click
    previewImg.src   = '';
    photoInput.value = '';
    imagePreview.classList.add('hidden');
    uploadPlaceholder.classList.remove('hidden');
    removeImageBtn.classList.add('hidden');
});

// Drag & Drop handlers
uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.classList.add('border-blue-400', 'bg-blue-50');
});

uploadArea.addEventListener('dragleave', () => {
    uploadArea.classList.remove('border-blue-400', 'bg-blue-50');
});

uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.classList.remove('border-blue-400', 'bg-blue-50');

    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        const dt = new DataTransfer();
        dt.items.add(file);
        photoInput.files = dt.files;
        photoInput.dispatchEvent(new Event('change'));
    }
});

// =============================================
// SIMPAN BUTTON
// =============================================
document.getElementById('simpanBtn')?.addEventListener('click', () => {
    // Ambil semua data form
    const idPeminjaman = document.getElementById('namaMerek').value.trim();
    const statusPengembalian = document.getElementById('statusPengembalian').value;
    const kondisi = document.getElementById('kondisi').value;
    const catatan = document.getElementById('catatan').value.trim();
    const foto = previewImg.src;

    // Validasi
    if (!idPeminjaman) {
        alert('ID Peminjaman wajib diisi!');
        return;
    }

    // Logic simpan ke backend bisa ditambahkan di sini
    console.log({
        idPeminjaman,
        statusPengembalian,
        kondisi,
        catatan,
        foto
    });

    alert('Data laporan berhasil disimpan!');

    // Reset form setelah simpan (opsional)
    // document.getElementById('namaMerek').value = '';
    // document.getElementById('catatan').value = '';
    // removeImageBtn.click();
});
</script>
@endpush

@extends('layouts.admin')

@section('title', 'Kelola Pengajuan - KlikAset')

@section('content')
    {{-- SECTION 1: Statistik Cards --}}
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-6 lg:p-10 mb-6">

        {{-- 3 Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 lg:gap-6">

            {{-- Card: Total Persetujuan --}}
            <div class="bg-white rounded-[30px] shadow-sm p-4 lg:p-6 border-2 border-gray-100 flex items-center gap-4 lg:gap-6">
                <div class="w-14 h-14 lg:w-16 lg:h-16 bg-blue-100 rounded-[30px] flex items-center justify-center shrink-0">
                    <x-icon-checklist-minimalistic class="w-8 h-8 lg:w-10 lg:h-10 text-blue-500"/>
                </div>
                <div>
                    <p class="text-xs text-gray-600 font-medium">Total Persetujuan<br>Bulan ini</p>
                    <p class="text-3xl lg:text-4xl font-bold">50</p>
                </div>
            </div>

            {{-- Card: Total Penolakan --}}
            <div class="bg-white rounded-[30px] shadow-sm p-4 lg:p-6 border-2 border-gray-100 flex items-center gap-4 lg:gap-6">
                <div class="w-14 h-14 lg:w-16 lg:h-16 bg-red-100 rounded-[30px] flex items-center justify-center shrink-0">
                    <x-icon-forbidden-circle class="w-8 h-8 lg:w-10 lg:h-10 text-red-500"/>
                </div>
                <div>
                    <p class="text-xs text-gray-600 font-medium">Total Penolakan<br>Pengajuan Bulan ini</p>
                    <p class="text-3xl lg:text-4xl font-bold">50</p>
                </div>
            </div>

            {{-- Card: Menunggu Persetujuan --}}
            <div class="bg-white rounded-[30px] shadow-sm p-4 lg:p-6 border-2 border-gray-100 flex items-center gap-4 lg:gap-6">
                <div class="w-14 h-14 lg:w-16 lg:h-16 bg-yellow-100 rounded-[30px] flex items-center justify-center shrink-0">
                    <x-icon-hourglass class="w-8 h-8 lg:w-10 lg:h-10 text-yellow-400"/>
                </div>
                <div>
                    <p class="text-xs text-gray-600 font-medium">Menunggu<br>Persetujuan</p>
                    <p class="text-3xl lg:text-4xl font-bold">50</p>
                </div>
            </div>

        </div>

        {{-- Search Bar --}}
        <div class="mt-6 relative">
            <input
                type="text"
                placeholder="Cari Nama Peminjam Atau Barang :"
                class="w-full bg-white border-2 border-gray-300 rounded-[30px] px-6 py-3 pr-12 outline-none focus:ring-2 focus:ring-costume-second text-sm lg:text-base transition"
            />
            <x-icon-magnifer class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"/>
        </div>

    </div>

    {{-- SECTION 2: Tabel Pengajuan --}}
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
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Aksi</th>
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
                            <div class="flex gap-2 justify-center">
                                <button class="px-4 py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-[30px] border border-green-200 shadow-sm hover:bg-green-200 transition">
                                    Terima
                                </button>
                                <button class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm hover:bg-red-200 transition">
                                    Tolak
                                </button>
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
                            <div class="flex gap-2 justify-center">
                                <button class="px-4 py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-[30px] border border-green-200 shadow-sm hover:bg-green-200 transition">
                                    Terima
                                </button>
                                <button class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm hover:bg-red-200 transition">
                                    Tolak
                                </button>
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
                            <div class="flex gap-2 justify-center">
                                <button class="px-4 py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-[30px] border border-green-200 shadow-sm hover:bg-green-200 transition">
                                    Terima
                                </button>
                                <button class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm hover:bg-red-200 transition">
                                    Tolak
                                </button>
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
                            <div class="flex gap-2 justify-center">
                                <button class="px-4 py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-[30px] border border-green-200 shadow-sm hover:bg-green-200 transition">
                                    Terima
                                </button>
                                <button class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm hover:bg-red-200 transition">
                                    Tolak
                                </button>
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
                            <div class="flex gap-2 justify-center">
                                <button class="px-4 py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-[30px] border border-green-200 shadow-sm hover:bg-green-200 transition">
                                    Terima
                                </button>
                                <button class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm hover:bg-red-200 transition">
                                    Tolak
                                </button>
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
                            <div class="flex gap-2 justify-center">
                                <button class="px-4 py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-[30px] border border-green-200 shadow-sm hover:bg-green-200 transition">
                                    Terima
                                </button>
                                <button class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm hover:bg-red-200 transition">
                                    Tolak
                                </button>
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
                            <div class="flex gap-2 justify-center">
                                <button class="px-4 py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-[30px] border border-green-200 shadow-sm hover:bg-green-200 transition">
                                    Terima
                                </button>
                                <button class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm hover:bg-red-200 transition">
                                    Tolak
                                </button>
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
                            <div class="flex gap-2 justify-center">
                                <button class="px-4 py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-[30px] border border-green-200 shadow-sm hover:bg-green-200 transition">
                                    Terima
                                </button>
                                <button class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm hover:bg-red-200 transition">
                                    Tolak
                                </button>
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
                            <div class="flex gap-2 justify-center">
                                <button class="px-4 py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-[30px] border border-green-200 shadow-sm hover:bg-green-200 transition">
                                    Terima
                                </button>
                                <button class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm hover:bg-red-200 transition">
                                    Tolak
                                </button>
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
                            <div class="flex gap-2 justify-center">
                                <button class="px-4 py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-[30px] border border-green-200 shadow-sm hover:bg-green-200 transition">
                                    Terima
                                </button>
                                <button class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm hover:bg-red-200 transition">
                                    Tolak
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
    {{-- JavaScript untuk handle terima/tolak pengajuan --}}
@endpush

@extends('layouts.pengajuan')
@section('title', 'pengajuan')
@section('pengajuan')
  <main class="flex-1 p-4 lg:p-8 pt-20 lg:pt-8">
            <div class="bg-white rounded-2xl lg:rounded-3xl shadow-lg p-4 lg:p-8 mb-6 lg:mb-8 border-2 border-gray-300">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 lg:gap-6">
                    <div class="bg-white rounded-xl lg:rounded-2xl shadow-md p-4 lg:p-6 border-2 border-gray-300 flex items-center gap-4 lg:gap-6">
                        <div class="w-14 h-14 lg:w-16 lg:h-16 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-8 h-8 lg:w-10 lg:h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-medium">Total Penyetuaan<br>Bulan ini</p>
                            <p class="text-3xl lg:text-4xl font-bold">50</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl lg:rounded-2xl shadow-md p-4 lg:p-6 border-2 border-gray-300 flex items-center gap-4 lg:gap-6">
                        <div class="w-14 h-14 lg:w-16 lg:h-16 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-8 h-8 lg:w-10 lg:h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-medium">Total Penolakan<br>Pengajuan Bulan ini</p>
                            <p class="text-3xl lg:text-4xl font-bold">50</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl lg:rounded-2xl shadow-md p-4 lg:p-6 border-2 border-gray-300 flex items-center gap-4 lg:gap-6">
                        <div class="w-14 h-14 lg:w-16 lg:h-16 bg-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-8 h-8 lg:w-10 lg:h-10 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-medium">Menunggu<br>Persetujuan</p>
                            <p class="text-3xl lg:text-4xl font-bold">50</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 relative">
                    <input type="text" placeholder="Cari Peminjam Atau Nama Barang" class="w-full bg-white border-2 border-gray-300 rounded-xl px-6 py-3 pl-12 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm lg:text-base">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-2xl lg:rounded-3xl shadow-lg border-2 border-gray-300 overflow-hidden">
                <div class="grid grid-cols-6 gap-4 p-4 border-b-2 border-gray-300 bg-white font-semibold text-sm lg:text-base">
                    <div class="text-center">Nama Peminjam</div>
                    <div class="text-center">Nama Barang</div>
                    <div class="text-center">Keperluan</div>
                    <div class="text-center">Tanggal<br>Peminjaman</div>
                    <div class="text-center">Tanggal<br>Pengembalian</div>
                    <div class="text-center">Status</div>
                </div>

                <div class="grid grid-cols-6 gap-4 p-4 items-center border-b-2 border-gray-300">
                    <div class="text-center">
                        <p class="font-medium text-sm lg:text-base">John Doe</p>
                        <p class="text-xs lg:text-sm text-gray-600">john@gmail.com</p>
                    </div>
                    <div class="text-center">
                        <p class="font-medium text-sm lg:text-base">Laptop Dell XPS 15</p>
                        <p class="text-xs lg:text-sm text-gray-600">Kode: LPT-001</p>
                    </div>
                    <div class="text-center">
                        <p class="text-xs lg:text-sm">Untuk keperluan<br>presentasi project</p>
                    </div>
                    <div class="text-center">
                        <p class="font-semibold text-sm lg:text-base">15 Feb 2024</p>
                        <p class="text-xs lg:text-sm text-gray-600">09:00 WIB</p>
                    </div>
                    <div class="text-center">
                        <p class="font-semibold text-sm lg:text-base">29 Feb 2024</p>
                        <p class="text-xs lg:text-sm text-gray-600">17:00 WIB</p>
                    </div>
                    <div class="text-center space-y-2">
                        <button class="w-20 lg:w-24 bg-green-500 text-white border-2 border-green-600 rounded-full py-1 text-xs lg:text-sm font-medium hover:bg-green-600 transition shadow-md">
                            Setuju
                        </button>
                        <button class="w-20 lg:w-24 bg-red-500 text-white border-2 border-red-600 rounded-full py-1 text-xs lg:text-sm font-medium hover:bg-red-600 transition shadow-md">
                            Tolak
                        </button>
                    </div>
                </div>


                <div class="flex flex-col sm:flex-row items-center justify-between p-4 bg-white gap-4">
                    <p class="text-xs lg:text-sm text-gray-600">Menampilkan 1-10 pengajuan dari 50</p>
                    
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
        </main>
    </div>

@endsection
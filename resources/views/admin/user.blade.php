@extends('layouts.user')
@section('title', 'Kelola User')
@section('konten-utama')

  
     <main class="flex-1 p-4 lg:p-8 pt-20 lg:pt-8">
            <div class="bg-white rounded-2xl lg:rounded-3xl shadow-lg p-6 lg:p-8 mb-6 lg:mb-8 border-2 border-gray-300">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                    <div class="space-y-4 lg:space-y-5">
                        <div>
                            <label class="block text-black font-semibold mb-2 text-sm lg:text-base">Masukan Nama Pengguna</label>
                            <input type="text" class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm lg:text-base">
                        </div>

                        <div>
                            <label class="block text-black font-semibold mb-2 text-sm lg:text-base">NIPD</label>
                            <select class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none bg-white text-sm lg:text-base">
                                <option></option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-black font-semibold mb-2 text-sm lg:text-base">Alamat</label>
                            <textarea rows="4" class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none text-sm lg:text-base"></textarea>
                        </div>
                    </div>

                    <div class="space-y-4 lg:space-y-5">
                        <div>
                            <label class="block text-black font-semibold mb-2 text-sm lg:text-base">Tanggal Lahir</label>
                            <input type="date" class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm lg:text-base">
                        </div>

                        <div>
                            <label class="block text-black font-semibold mb-2 text-sm lg:text-base">Jenis Kelamin</label>
                            <select class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none bg-white text-sm lg:text-base">
                                <option></option>
                                <option>Laki-laki</option>
                                <option>Perempuan</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4 pt-6">
                            <button class="w-full border-2 border-black rounded-xl py-3 font-semibold text-black hover:bg-gray-50 transition text-sm lg:text-base">
                                Pilih File
                            </button>
                            <button class="w-full bg-blue-500 text-white border-2 border-blue-600 rounded-xl py-3 font-semibold hover:bg-blue-600 transition shadow-md text-sm lg:text-base">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl lg:rounded-3xl shadow-lg border-2 border-gray-300 overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-300">
                            <th class="p-4 text-center font-semibold text-sm lg:text-base">Nama<br>Peminjam</th>
                            <th class="p-4 text-center font-semibold text-sm lg:text-base">NIPD</th>
                            <th class="p-4 text-center font-semibold text-sm lg:text-base">Alamat</th>
                            <th class="p-4 text-center font-semibold text-sm lg:text-base">Tanggal<br>Lahir</th>
                            <th class="p-4 text-center font-semibold text-sm lg:text-base">Rank</th>
                            <th class="p-4 text-center font-semibold text-sm lg:text-base">Jenis<br>Kelamin</th>
                            <th class="p-4 text-center font-semibold text-sm lg:text-base">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b-2 border-gray-300">
                            <td class="p-4 text-center text-sm lg:text-base">nama siapa aja</td>
                            <td class="p-4 text-center text-sm lg:text-base">12345678</td>
                            <td class="p-4 text-center text-sm lg:text-base">Ngawi</td>
                            <td class="p-4 text-center text-sm lg:text-base">12 Feb 1990</td>
                            <td class="p-4 text-center text-sm lg:text-base">Paragon</td>
                            <td class="p-4 text-center text-sm lg:text-base">Lelaki</td>
                            <td class="p-4">
                                <div class="flex gap-2 justify-center">
                                    <button class="px-4 lg:px-6 py-1.5 bg-red-500 text-white border-2 border-red-600 rounded-lg text-xs lg:text-sm font-medium hover:bg-red-600 transition shadow-md">
                                        Hapus
                                    </button>
                                    <button class="px-4 lg:px-6 py-1.5 bg-blue-500 text-white border-2 border-blue-600 rounded-lg text-xs lg:text-sm font-medium hover:bg-blue-600 transition shadow-md">
                                        Edit
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="flex flex-col sm:flex-row items-center justify-between p-4 gap-4 border-t-2 border-gray-300">
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
            </div>
        </main>

        @endsection
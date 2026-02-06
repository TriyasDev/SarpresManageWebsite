@extends('layouts.aset')

@section('title', 'kelola aset')
@section('konten_utama')
<button id="mobileMenuBtn" class="lg:hidden fixed top-4 left-4 z-50 bg-blue-600 text-white p-3 rounded-lg shadow-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
      <aside id="sidebar" class=" fixed inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40 w-64 bg-gradient-to-b from-blue-800 to-blue-800 p-4 lg:p-6 flex flex-col">
   
            <button id="closeSidebarBtn" class="lg:hidden absolute top-4 right-4 text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="flex items-center gap-2 lg:gap-3 mb-6 lg:mb-8 mt-2">
                <div class="w-16 h-16  bg-white rounded-full flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('Backend/bbc.jpg') }}" alt="" class="w-12 h-12 object-contain" >
                </div>
                <h1 class="text-white text-xl lg:text-2xl font-bold">BiBiSi.</h1>
            </div>
         @include('partials.sidebar')
            <a href="#" class="flex items-center gap-3 lg:gap-4 px-4 lg:px-6 py-2.5 lg:py-3 text-white font-medium hover:bg-blue-400 rounded-xl transition mt-auto text-sm lg:text-base">
                <svg class="w-5 h-5 lg:w-6 lg:h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span>Logout</span>
            </a>
        </aside> 
    <div class="lg:ml-64 min-h-screen">
        <div class=" p-6 lg:p-10">
            <div class="bg-white rounded-2xl shadow-2xl p-6 lg:p-10 max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-gray-800 font-medium mb-3 text-base">Masukan Nama Merek:</label>
                            <input type="text" id="namaMerek" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan nama merek">
                        </div>
                        
                        <div>
                            <label class="block text-gray-800 font-medium mb-3 text-base">Kategori Barang:</label>
                            <div class="relative">
                                <select id="kategori" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none bg-white cursor-pointer">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Elektronik">Elektronik</option>
                                    <option value="Furniture">Furniture</option>
                                    <option value="Alat Tulis">Alat Tulis</option>
                                    <option value="Kendaraan">Kendaraan</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                                    <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-800 font-medium mb-3 text-base">Deskripsi barang:</label>
                            <input type="text" id="deskripsi" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan deskripsi">
                        </div>
                        
                        <div>
                            <label class="block text-gray-800 font-medium mb-3 text-base">Kondisi Barang:</label>
                            <input type="text" id="kondisi" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan kondisi">
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div class="mb-6">
                            <label class="block text-gray-800 font-medium mb-3 text-base">Tambahkan Foto</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-12 lg:p-16 text-center bg-white hover:bg-gray-50 transition cursor-pointer min-h-[300px] flex items-center justify-center" id="uploadArea">
                                <input type="file" id="photoInput" accept="image/*" class="hidden">
                                <div id="uploadPlaceholder" class="w-full">
                                    <svg class="w-20 h-20 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-2xl font-bold text-gray-700 mb-2">Tambahkan Foto</p>
                                    <div class="text-5xl text-gray-400 font-light">+</div>
                                </div>
                                <div id="imagePreview" class="hidden w-full">
                                    <img id="previewImg" src="" alt="Preview" class="max-h-72 mx-auto rounded-lg shadow-md">
                                    <button type="button" id="removeImage" class="mt-4 px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">Hapus Foto</button>
                                </div>
                            </div>
                        </div>
                        <!-- samet dieu ku ente -->
                        
                        <button type="button" id="simpanBtn" class="w-full bg-blue-600 text-white py-4 rounded-xl font-semibold text-lg hover:bg-blue-700 active:bg-blue-800 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-6 lg:p-10">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white rounded-2xl  p-6 mb-8">
                    <div class="flex flex-col lg:flex-row gap-4">
                        <div class="flex-1 relative">
                            <input type="text" id="searchInput" placeholder="Pencarian :" class="w-full px-6 py-3 pr-14 border-2 border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <svg class="w-6 h-6 absolute right-5 top-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <div class="lg:w-72">
                            <div class="relative">
                                <select id="filterKategori" class="w-full px-6 py-3 border-2 border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none bg-white cursor-pointer">
                                    <option value="">Kategori :</option>
                                    <option value="Elektronik">Elektronik</option>
                                    <option value="Furniture">Furniture</option>
                                    <option value="Alat Tulis">Alat Tulis</option>
                                    <option value="Kendaraan">Kendaraan</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-700">
                                    <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="cardsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                </div>
            </div>
        </div>
    </div>

    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Edit Aset</h2>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Nama Merek:</label>
                        <input type="text" id="editNamaMerek" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Kategori:</label>
                        <select id="editKategori" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="Elektronik">Elektronik</option>
                            <option value="Furniture">Furniture</option>
                            <option value="Alat Tulis">Alat Tulis</option>
                            <option value="Kendaraan">Kendaraan</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Deskripsi:</label>
                        <input type="text" id="editDeskripsi" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Kondisi:</label>
                        <input type="text" id="editKondisi" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div class="flex gap-4 pt-4">
                        <button id="saveEdit" class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Simpan
                        </button>
                        <button id="cancelEdit" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-400 transition">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    



@endsection
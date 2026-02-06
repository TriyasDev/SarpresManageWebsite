    @extends('layouts.master')

    @section('title', 'dashboard admin' )

    @section('konten_utama')
     <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"></div>   
      <main class="flex-1 p-4 lg:p-8 pt-20 lg:pt-8">
           
            <div class="bg-white rounded-2xl lg:rounded-3xl shadow-lg p-4 lg:p-8 mb-6 lg:mb-8 border-2 border-gray-300">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-center sm:text-left flex-1">
                        Statistik Peminjaman<br class="hidden sm:inline">Sarpras Bulanan
                    </h2>
                    <button class="px-3 lg:px-4 py-2 border-2 border-gray-300 rounded-lg text-xs sm:text-sm whitespace-nowrap">Tahun ini ▼</button>
                </div>
                <div class="relative h-64 sm:h-72 lg:h-80">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

            
            <div class="grid grid-cols-1 gap-4   lg:flex lg:gap-6">
              
                <div class="space-y-3 lg:space-y-4">
                    
                    <div class="bg-white rounded-xl lg:rounded-2xl shadow-md p-4 lg:p-6 border-2 border-gray-300 flex items-center gap-4 lg:gap-6">
                        <div class="w-14 h-14 lg:w-16 lg:h-16 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-8 h-8 lg:w-10 lg:h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-medium">Total Barang</p>
                            <p class="text-4xl lg:text-5xl font-bold">50</p>
                        </div>
                    </div>
     
                    <div class="bg-white rounded-xl lg:rounded-2xl shadow-md p-4 lg:p-6 border-2 border-gray-300 flex items-center gap-4 lg:gap-6">
                        <div class="w-14 h-14 lg:w-16 lg:h-16 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-8 h-8 lg:w-10 lg:h-10 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-medium">Pengajuan Baru</p>
                            <p class="text-4xl lg:text-5xl font-bold">50</p>
                        </div>
                    </div>
   
                    <div class="bg-white rounded-xl lg:rounded-2xl shadow-md p-4 lg:p-6 border-2 border-gray-300 flex items-center gap-4 lg:gap-6">
                        <div class="w-14 h-14 lg:w-16 lg:h-16 bg-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-8 h-8 lg:w-10 lg:h-10 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-medium">Jumlah Barang<br>Sedang Dipinjam</p>
                            <p class="text-4xl lg:text-5xl font-bold">50</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl lg:rounded-2xl shadow-md p-4 lg:p-6 border-2 border-gray-300 flex items-center gap-4 lg:gap-6">
                        <div class="w-14 h-14 lg:w-16 lg:h-16 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-8 h-8 lg:w-10 lg:h-10 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-medium">Jumlah Barang<br>Sedang Dipinjam</p>
                            <p class="text-4xl lg:text-5xl font-bold">500</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl lg:rounded-3xl shadow-lg p-4 lg:p-8 border-2 border-gray-300">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                        <h2 class="text-base sm:text-lg lg:text-xl font-bold">Jenis Barang Yang<br>Sering Di Pinjam</h2>
                        <button class="px-3 lg:px-4 py-2 border-2 border-gray-300 rounded-lg text-xs sm:text-sm whitespace-nowrap">Tahun ini ▼</button>
                    </div>
                    <div class="flex flex-col md:flex-row items-center gap-6 lg:gap-8">
                        
                        <div class="space-y-2 lg:space-y-3 w-full md:w-auto">
                            <div class="flex items-center gap-3">
                                <div class="w-4 h-4 lg:w-5 lg:h-5 bg-teal-400 rounded flex-shrink-0"></div>
                                <span class="text-xs lg:text-sm font-medium">Prasarana</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-4 h-4 lg:w-5 lg:h-5 bg-orange-400 rounded flex-shrink-0"></div>
                                <span class="text-xs lg:text-sm font-medium">Media Pendidikan</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-4 h-4 lg:w-5 lg:h-5 bg-blue-500 rounded flex-shrink-0"></div>
                                <span class="text-xs lg:text-sm font-medium">Perlengkapan Kelas</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-4 h-4 lg:w-5 lg:h-5 bg-purple-600 rounded flex-shrink-0"></div>
                                <span class="text-xs lg:text-sm font-medium">Fasilitas Penunjang</span>
                            </div>
                        </div>
                        <!-- Kolecer -->
                        <div class="flex-1 relative h-320px sm:h-64 lg:h-72 w-full flex justify-center items-center overflow-hidden">
                            
                            <canvas id="donutChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    
    

    
    
    
    
    
    @endsection
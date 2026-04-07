<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="assets-grid">
    @forelse($barangs as $barang)
        <div class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:border-costume-primary hover:shadow-xl transition-all duration-300"
            data-animate>
            <div class="relative h-48 bg-gradient-to-br from-slate-100 to-slate-200 overflow-hidden">
                @if($barang->foto && $barang->foto !== 'default.jpg')
                    <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
                <div class="absolute top-3 right-3 px-3 py-1.5 text-white text-xs font-bold rounded-full shadow-lg
                    @if($barang->jumlah_tersedia > 10) bg-emerald-500
                    @elseif($barang->jumlah_tersedia > 3) bg-amber-500
                    @elseif($barang->jumlah_tersedia > 0) bg-orange-500
                    @else bg-red-500 @endif">
                    {{ $barang->jumlah_tersedia > 0 ? $barang->jumlah_tersedia . ' Tersedia' : 'Habis' }}
                </div>
            </div>
            <div class="p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="px-3 py-1 bg-blue-50 text-costume-primary text-xs font-semibold rounded-full">
                        {{ $barang->kategori }}
                    </span>
                    <span class="text-xs font-medium
                        @if($barang->kondisi === 'baik') text-emerald-600
                        @elseif($barang->kondisi === 'rusak ringan') text-amber-600
                        @else text-red-600 @endif">
                        {{ ucfirst($barang->kondisi) }}
                    </span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2 truncate">{{ $barang->nama_barang }}</h3>
                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="truncate">{{ $barang->deskripsi }}</span>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-4 py-16 text-center text-slate-400">
            <p class="font-medium">Belum ada aset di kategori ini.</p>
        </div>
    @endforelse
</div>

<div class="mt-12" id="pagination-container">
    {{ $barangs->links('pagination::tailwind') }}
</div>

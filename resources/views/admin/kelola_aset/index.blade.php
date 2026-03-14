@extends('layouts.admin')
@section('title', 'Kelola Aset - KlikAset')

@section('content')

    {{-- Alert --}}
    @if(session('success'))
        <div id="flashMsg" class="mb-5 px-5 py-3 bg-green-100 text-green-700 border border-green-200 rounded-[30px] text-sm font-medium flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('flashMsg').remove()" class="ml-4 text-green-500 hover:text-green-700 text-lg leading-none">&times;</button>
        </div>
    @endif

    {{-- Header & Tombol Aksi --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Kelola Aset</h1>
            <p class="text-sm text-gray-500 mt-0.5">Manajemen sarana dan prasarana sekolah</p>
        </div>
        <div class="flex items-center gap-2">
            {{-- Tombol Tempat Sampah --}}
            <a href="{{ route('admin.kelola_aset.trash') }}"
               class="relative flex items-center gap-2 px-4 py-2.5 border-2 border-gray-300 text-gray-600 text-sm font-semibold rounded-[30px] hover:bg-gray-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Sampah
                @if($trashedCount > 0)
                    <span class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center">
                        {{ $trashedCount > 99 ? '99+' : $trashedCount }}
                    </span>
                @endif
            </a>

            {{-- Tombol Tambah Aset --}}
            <a href="{{ route('admin.kelola_aset.create') }}"
               class="flex items-center gap-2 px-5 py-2.5 bg-costume-primary text-white text-sm font-semibold rounded-[30px] hover:bg-blue-700 transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Aset
            </a>
        </div>
    </div>

    {{-- Search & Filter --}}
    <div class="bg-white rounded-[30px] border border-gray-100 shadow-sm p-5 mb-6">
        <div class="flex flex-col lg:flex-row gap-4">
            <div class="flex-1 relative">
                <input type="text" id="searchInput" placeholder="Cari nama barang..."
                    class="w-full px-5 py-3 pr-12 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"/>
                <x-icon-magnifer class="w-5 h-5 absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"/>
            </div>
            <div class="lg:w-64">
                <div class="relative">
                    <select id="filterKategori"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition">
                        <option value="">Semua Kategori</option>
                        @foreach(['Prasaran','Media Pendidikan','Perlengkapan Kelas','Fasilitas Penunjang'] as $kat)
                            <option value="{{ $kat }}">{{ $kat }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card Grid --}}
    <div id="cardsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @forelse($barangs as $barang)
        <div class="card-item bg-white rounded-[30px] shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200 flex flex-col"
             data-nama="{{ strtolower($barang->nama_barang) }}"
             data-kategori="{{ $barang->kategori }}">

            {{-- Gambar --}}
            <div class="h-44 bg-gray-100 flex items-center justify-center overflow-hidden rounded-t-[30px]">
                @if($barang->foto)
                    <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}" class="w-full h-full object-cover"/>
                @else
                    <svg class="w-14 h-14 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                @endif
            </div>

            {{-- Info --}}
            <div class="p-5 flex flex-col flex-1">
                <h3 class="font-bold text-gray-900 text-sm mb-1 truncate">{{ $barang->nama_barang }}</h3>
                <span class="inline-block text-xs bg-blue-100 text-blue-700 font-semibold px-3 py-0.5 rounded-[30px] mb-2 w-fit">{{ $barang->kategori }}</span>
                <p class="text-xs text-gray-500 truncate mb-1">{{ $barang->deskripsi }}</p>

                <div class="flex items-center justify-between mt-auto pt-3">
                    <div class="flex items-center gap-1.5">
                        <span class="text-xs text-gray-400">Kondisi:</span>
                        <span class="text-xs font-semibold
                            @if($barang->kondisi == 'baik') text-green-600
                            @elseif($barang->kondisi == 'rusak ringan') text-yellow-600
                            @else text-red-600 @endif">
                            {{ ucfirst($barang->kondisi) }}
                        </span>
                    </div>
                    <span class="text-xs text-gray-400">Jml: <span class="font-semibold text-gray-600">{{ $barang->jumlah_total }}</span></span>
                </div>

                {{-- Aksi --}}
                <div class="flex gap-2 mt-4">
                    <a href="{{ route('admin.kelola_aset.edit', $barang->id_barang) }}"
                        class="flex-1 py-2 text-xs font-semibold bg-costume-primary text-white rounded-[30px] hover:bg-blue-700 transition text-center">
                        Edit
                    </a>
                    <form method="POST" action="{{ route('admin.kelola_aset.destroy', $barang->id_barang) }}"
                        onsubmit="return confirm('Pindahkan aset \'{{ addslashes($barang->nama_barang) }}\' ke tempat sampah?')" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full py-2 text-xs font-semibold bg-red-100 text-red-600 rounded-[30px] hover:bg-red-200 transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 flex flex-col items-center text-gray-400">
            <svg class="w-14 h-14 mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
            <p class="text-base font-medium">Belum ada aset</p>
            <a href="{{ route('admin.kelola_aset.create') }}"
               class="mt-4 px-5 py-2 bg-costume-primary text-white text-sm font-semibold rounded-[30px] hover:bg-blue-700 transition">
                Tambah Aset Pertama
            </a>
        </div>
        @endforelse
    </div>

    {{-- Empty state saat filter tidak menemukan hasil --}}
    <div id="emptyFilter" class="hidden col-span-full py-12 flex flex-col items-center text-gray-400 mt-4">
        <svg class="w-12 h-12 mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <p class="text-sm font-medium">Tidak ada aset yang sesuai pencarian.</p>
    </div>

@endsection

@push('scripts')
<script>
    function filterCards() {
        const keyword  = document.getElementById('searchInput').value.toLowerCase().trim();
        const kategori = document.getElementById('filterKategori').value;
        let visible    = 0;

        document.querySelectorAll('.card-item').forEach(card => {
            const namaMatch     = card.dataset.nama.includes(keyword);
            const kategoriMatch = kategori === '' || card.dataset.kategori === kategori;
            const show          = namaMatch && kategoriMatch;
            card.style.display  = show ? '' : 'none';
            if (show) visible++;
        });

        document.getElementById('emptyFilter').style.display = visible === 0 ? 'flex' : 'none';
    }

    document.getElementById('searchInput').addEventListener('input', filterCards);
    document.getElementById('filterKategori').addEventListener('change', filterCards);
</script>
@endpush

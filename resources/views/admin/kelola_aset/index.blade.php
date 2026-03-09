@extends('layouts.admin')
@section('title', 'Kelola Aset - KlikAset')

@section('content')

cd{{-- Flash Message --}}
@if(session('success'))
<div id="flashMsg" class="mb-5 px-5 py-3 bg-green-100 text-green-700 border border-green-200 rounded-[30px] text-sm font-medium flex items-center justify-between">
    <span>{{ session('success') }}</span>
    <button onclick="document.getElementById('flashMsg').remove()" class="ml-4 text-green-500 hover:text-green-700">&times;</button>
</div>
@endif

{{-- ===================================================== --}}
{{-- SECTION 1 : FORM TAMBAH ASET                         --}}
{{-- ===================================================== --}}
<form method="POST" action="{{ route('admin.kelola_aset.store') }}" enctype="multipart/form-data">
@csrf
<div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-6 lg:p-10 mb-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

        {{-- Kolom Kiri : Input --}}
        <div class="space-y-5">

            {{-- Nama Barang --}}
            <div>
                <label class="block text-gray-800 font-medium mb-2 text-sm">Masukan Nama Barang:</label>
                <input type="text" name="nama_barang" value="{{ old('nama_barang') }}"
                    placeholder="Masukkan nama barang"
                    class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('nama_barang') border-red-400 @enderror"/>
                @error('nama_barang')<p class="text-red-500 text-xs mt-1 px-2">{{ $message }}</p>@enderror
            </div>

            {{-- Kategori Barang --}}
            <div>
                <label class="block text-gray-800 font-medium mb-2 text-sm">Kategori Barang:</label>
                <div class="relative">
                    <select name="kategori"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition @error('kategori') border-red-400 @enderror">
                        <option value="">Pilih Kategori</option>
                        @foreach(['Prasaran','Media Pendidikan','Perlengkapan Kelas','Fasilitas Penunjang'] as $kat)
                            <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                        </svg>
                    </div>
                </div>
                @error('kategori')<p class="text-red-500 text-xs mt-1 px-2">{{ $message }}</p>@enderror
            </div>

            {{-- Kondisi Barang --}}
            <div>
                <label class="block text-gray-800 font-medium mb-2 text-sm">Kondisi Barang:</label>
                <div class="relative">
                    <select name="kondisi"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition @error('kondisi') border-red-400 @enderror">
                        <option value="">Pilih Kondisi</option>
                        @foreach(['baik','rusak ringan','rusak berat'] as $kond)
                            <option value="{{ $kond }}" {{ old('kondisi') == $kond ? 'selected' : '' }}>{{ ucfirst($kond) }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                        </svg>
                    </div>
                </div>
                @error('kondisi')<p class="text-red-500 text-xs mt-1 px-2">{{ $message }}</p>@enderror
            </div>

            {{-- Jumlah --}}
            <div>
                <label class="block text-gray-800 font-medium mb-2 text-sm">Jumlah Barang:</label>
                <input type="number" name="jumlah" value="{{ old('jumlah') }}" min="1"
                    placeholder="0"
                    class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('jumlah') border-red-400 @enderror"/>
                @error('jumlah')<p class="text-red-500 text-xs mt-1 px-2">{{ $message }}</p>@enderror
            </div>

            {{-- Deskripsi Barang --}}
            <div>
                <label class="block text-gray-800 font-medium mb-2 text-sm">Deskripsi Barang:</label>
                <input type="text" name="deskripsi" value="{{ old('deskripsi') }}"
                    placeholder="Masukkan deskripsi"
                    class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('deskripsi') border-red-400 @enderror"/>
                @error('deskripsi')<p class="text-red-500 text-xs mt-1 px-2">{{ $message }}</p>@enderror
            </div>

        </div>
        {{-- END Kolom Kiri --}}

        {{-- Kolom Kanan : Upload Foto + Simpan --}}
        <div class="flex flex-col">

            {{-- Area Upload --}}
            <div class="flex flex-col mb-7">
                <div class="flex items-center justify-between mb-2">
                    <label class="text-gray-800 font-medium text-sm">Tambahkan Foto</label>
                    <button type="button" id="removeImage"
                        class="hidden px-4 py-1 bg-red-500 text-white text-xs font-medium rounded-[30px] hover:bg-red-600 transition">
                        Hapus Foto
                    </button>
                </div>

                <div id="uploadArea"
                    class="border-2 border-dashed border-gray-300 rounded-[30px] bg-white hover:bg-gray-50 transition cursor-pointer h-[260px] flex items-center justify-center overflow-hidden">
                    <input type="file" id="photoInput" name="foto" accept="image/*" class="hidden"/>

                    <div id="uploadPlaceholder" class="w-full text-center px-8">
                        <x-icon-gallery-add class="w-16 h-16 mx-auto text-gray-300"/>
                        <p class="text-lg font-bold text-gray-700 mb-1">Tambahkan Foto</p>
                        <p class="text-sm text-gray-400">Klik atau Drag Foto ke sini</p>
                    </div>

                    <div id="imagePreview" class="hidden w-full h-full">
                        <img id="previewImg" src="" alt="Preview" class="w-full h-full object-cover"/>
                    </div>
                </div>
                @error('foto')<p class="text-red-500 text-xs mt-1 px-2">{{ $message }}</p>@enderror
            </div>

            {{-- Tombol Simpan --}}
            <button type="submit"
                class="w-full bg-costume-primary text-white px-5 py-3 rounded-[30px] font-semibold text-sm hover:bg-blue-700 active:bg-blue-800 transition shadow-sm hover:shadow-lg">
                Simpan
            </button>

        </div>
        {{-- END Kolom Kanan --}}

    </div>
</div>
</form>
{{-- END SECTION 1 --}}


{{-- ===================================================== --}}
{{-- SECTION 2 : SEARCH & FILTER                          --}}
{{-- ===================================================== --}}
<div class="bg-white rounded-[30px] border border-gray-100 shadow-sm p-5 mb-6">
    <div class="flex flex-col lg:flex-row gap-4">

        <div class="flex-1 relative">
            <input type="text" id="searchInput" placeholder="Cari Nama Barang :"
                class="w-full px-5 py-3 pr-12 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"/>
            <x-icon-magnifer class="w-5 h-5 absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"/>
        </div>

        <div class="lg:w-64">
            <div class="relative">
                <select id="filterKategori"
                    class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition">
                    <option value="">Kategori :</option>
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
{{-- END SECTION 2 --}}


{{-- ===================================================== --}}
{{-- SECTION 3 : CARDS GRID                               --}}
{{-- ===================================================== --}}
<div id="cardsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
    @forelse($barangs as $barang)
    <div class="card-item bg-white rounded-[30px] shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200 flex flex-col"
         data-nama="{{ strtolower($barang->nama_barang) }}"
         data-kategori="{{ $barang->kategori }}">

        <div class="h-44 bg-gray-100 flex items-center justify-center overflow-hidden rounded-t-[30px]">
            @if($barang->foto)
                <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}" class="w-full h-full object-cover"/>
            @else
                <svg class="w-14 h-14 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            @endif
        </div>

        <div class="p-5 flex flex-col flex-1">
            <h3 class="font-bold text-gray-900 text-sm mb-1 truncate">{{ $barang->nama_barang }}</h3>
            <span class="inline-block text-xs bg-blue-100 text-blue-700 font-semibold px-3 py-0.5 rounded-[30px] mb-2 w-fit">{{ $barang->kategori }}</span>
            <p class="text-xs text-gray-500 truncate">{{ $barang->deskripsi }}</p>
            <div class="flex items-center gap-2 mt-1">
                <span class="text-xs text-gray-400">Kondisi:</span>
                <span class="text-xs font-semibold
                    @if($barang->kondisi == 'baik') text-green-600
                    @elseif($barang->kondisi == 'rusak ringan') text-yellow-600
                    @else text-red-600 @endif">
                    {{ ucfirst($barang->kondisi) }}
                </span>
            </div>
            <p class="text-xs text-gray-400 mt-1">Jumlah: {{ $barang->jumlah_total }}</p>

            <div class="flex gap-2 mt-4">
                <button type="button"
                    onclick="openEdit(
                        {{ $barang->id_barang }},
                        '{{ addslashes($barang->nama_barang) }}',
                        '{{ $barang->kategori }}',
                        '{{ $barang->kondisi }}',
                        {{ $barang->jumlah_total }},
                        '{{ addslashes($barang->deskripsi) }}'
                    )"
                    class="flex-1 py-2 text-xs font-semibold bg-costume-primary text-white rounded-[30px] hover:bg-blue-700 transition">
                    Edit
                </button>

                <form method="POST" action="{{ route('admin.kelola_aset.destroy', $barang->id_barang) }}"
                    onsubmit="return confirm('Hapus aset ini secara permanen?')" class="flex-1">
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
    <div class="col-span-full text-center py-16 text-gray-400">
        <svg class="w-14 h-14 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
        </svg>
        <p class="text-base font-medium">Belum ada aset</p>
    </div>
    @endforelse
</div>
{{-- END SECTION 3 --}}


{{-- ===================================================== --}}
{{-- MODAL EDIT ASET                                       --}}
{{-- ===================================================== --}}
<div id="editModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-[30px] shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-8">

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Edit Aset</h2>
                <button type="button" id="closeModal" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-4">

                    <div>
                        <label class="block text-gray-700 font-medium mb-2 text-sm">Nama Barang:</label>
                        <input type="text" name="nama_barang" id="editNamaBarang"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"/>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2 text-sm">Kategori:</label>
                        <div class="relative">
                            <select name="kategori" id="editKategori"
                                class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white text-sm transition">
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

                    <div>
                        <label class="block text-gray-700 font-medium mb-2 text-sm">Kondisi:</label>
                        <div class="relative">
                            <select name="kondisi" id="editKondisi"
                                class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white text-sm transition">
                                <option value="baik">Baik</option>
                                <option value="rusak ringan">Rusak Ringan</option>
                                <option value="rusak berat">Rusak Berat</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2 text-sm">Jumlah Barang:</label>
                        <input type="number" name="jumlah" id="editJumlah" min="1"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"/>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2 text-sm">Deskripsi:</label>
                        <input type="text" name="deskripsi" id="editDeskripsi"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"/>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2 text-sm">Ganti Foto (opsional):</label>
                        <input type="file" name="foto" accept="image/*"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none text-sm transition file:mr-4 file:py-1 file:px-4 file:rounded-[30px] file:border-0 file:text-sm file:bg-costume-primary file:text-white hover:file:bg-blue-700"/>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                            class="flex-1 bg-costume-primary text-white px-5 py-3 rounded-[30px] font-semibold text-sm hover:bg-blue-700 transition">
                            Simpan
                        </button>
                        <button type="button" id="cancelEdit"
                            class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-[30px] font-semibold text-sm hover:bg-gray-300 transition">
                            Batal
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>
{{-- END MODAL --}}

@endsection

@push('scripts')
<script>
    // =============================================
    // UPLOAD FOTO (Form Tambah)
    // =============================================
    const uploadArea        = document.getElementById('uploadArea');
    const photoInput        = document.getElementById('photoInput');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const imagePreview      = document.getElementById('imagePreview');
    const previewImg        = document.getElementById('previewImg');
    const removeImageBtn    = document.getElementById('removeImage');

    uploadArea.addEventListener('click', () => photoInput.click());

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

    removeImageBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        previewImg.src   = '';
        photoInput.value = '';
        imagePreview.classList.add('hidden');
        uploadPlaceholder.classList.remove('hidden');
        removeImageBtn.classList.add('hidden');
    });

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
    // SEARCH & FILTER (Client-side)
    // =============================================
    function filterCards() {
        const keyword  = document.getElementById('searchInput').value.toLowerCase();
        const kategori = document.getElementById('filterKategori').value;

        document.querySelectorAll('.card-item').forEach(card => {
            const namaMatch     = card.dataset.nama.includes(keyword);
            const kategoriMatch = kategori === '' || card.dataset.kategori === kategori;
            card.style.display  = (namaMatch && kategoriMatch) ? '' : 'none';
        });
    }

    document.getElementById('searchInput').addEventListener('input', filterCards);
    document.getElementById('filterKategori').addEventListener('change', filterCards);

    // =============================================
    // MODAL EDIT
    // =============================================
    function openEdit(id, nama, kategori, kondisi, jumlah, deskripsi) {
        document.getElementById('editNamaBarang').value = nama;
        document.getElementById('editKategori').value   = kategori;
        document.getElementById('editKondisi').value    = kondisi;
        document.getElementById('editJumlah').value     = jumlah;
        document.getElementById('editDeskripsi').value  = deskripsi;

        const baseUrl = "{{ url('admin/kelola_aset') }}";
        document.getElementById('editForm').action = baseUrl + '/' + id;

        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    document.getElementById('closeModal').addEventListener('click', closeModal);
    document.getElementById('cancelEdit').addEventListener('click', closeModal);
    document.getElementById('editModal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('editModal')) closeModal();
    });
</script>
@endpush

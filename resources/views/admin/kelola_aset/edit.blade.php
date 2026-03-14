@extends('layouts.admin')
@section('title', 'Edit Aset - KlikAset')

@section('content')

    {{-- Breadcrumb / Back --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.kelola_aset.index') }}"
           class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <span class="text-gray-300">/</span>
        <span class="text-sm font-semibold text-gray-700">Edit Aset</span>
    </div>

    <form method="POST" action="{{ route('admin.kelola_aset.update', $barang->id_barang) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-6 lg:p-10">
        <h2 class="text-lg lg:text-xl font-bold text-gray-800 mb-6">Edit Data Aset</h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

            {{-- Kolom Kiri --}}
            <div class="space-y-5">

                {{-- Nama Barang --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">Nama Barang <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}"
                        placeholder="Masukkan nama barang"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('nama_barang') border-red-400 @enderror"/>
                    @error('nama_barang')<p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p>@enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">Kategori Barang <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="kategori"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition @error('kategori') border-red-400 @enderror">
                            <option value="">Pilih Kategori</option>
                            @foreach(['Prasaran','Media Pendidikan','Perlengkapan Kelas','Fasilitas Penunjang'] as $kat)
                                <option value="{{ $kat }}" {{ old('kategori', $barang->kategori) == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </div>
                    </div>
                    @error('kategori')<p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p>@enderror
                </div>

                {{-- Kondisi --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">Kondisi Barang <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="kondisi"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition @error('kondisi') border-red-400 @enderror">
                            <option value="">Pilih Kondisi</option>
                            @foreach(['baik','rusak ringan','rusak berat'] as $kond)
                                <option value="{{ $kond }}" {{ old('kondisi', $barang->kondisi) == $kond ? 'selected' : '' }}>{{ ucfirst($kond) }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </div>
                    </div>
                    @error('kondisi')<p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p>@enderror
                </div>

                {{-- Jumlah --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">Jumlah Barang <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah" value="{{ old('jumlah', $barang->jumlah_total) }}" min="1"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('jumlah') border-red-400 @enderror"/>
                    @error('jumlah')<p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p>@enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">Deskripsi Barang <span class="text-red-500">*</span></label>
                    <input type="text" name="deskripsi" value="{{ old('deskripsi', $barang->deskripsi) }}"
                        placeholder="Masukkan deskripsi"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('deskripsi') border-red-400 @enderror"/>
                    @error('deskripsi')<p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Kolom Kanan – Foto & Tombol --}}
            <div class="flex flex-col">
                <div class="flex flex-col mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-gray-800 font-medium text-sm">Foto Barang</label>
                        <button type="button" id="removeImage"
                            class="{{ $barang->foto ? '' : 'hidden' }} px-4 py-1 bg-red-500 text-white text-xs font-medium rounded-[30px] hover:bg-red-600 transition">
                            Hapus Foto
                        </button>
                    </div>

                    <div id="uploadArea"
                        class="border-2 border-dashed border-gray-300 rounded-[30px] bg-white hover:bg-gray-50 transition cursor-pointer h-[260px] flex items-center justify-center overflow-hidden">
                        <input type="file" id="photoInput" name="foto" accept="image/*" class="hidden"/>

                        {{-- Placeholder (tampil kalau tidak ada foto) --}}
                        <div id="uploadPlaceholder" class="{{ $barang->foto ? 'hidden' : '' }} w-full text-center px-8">
                            <x-icon-gallery-add class="w-16 h-16 mx-auto text-gray-300"/>
                            <p class="text-lg font-bold text-gray-700 mb-1">Ganti Foto</p>
                            <p class="text-sm text-gray-400">Klik atau drag foto ke sini</p>
                        </div>

                        {{-- Preview (tampil kalau ada foto) --}}
                        <div id="imagePreview" class="{{ $barang->foto ? '' : 'hidden' }} w-full h-full">
                            <img id="previewImg"
                                 src="{{ $barang->foto ? asset('storage/' . $barang->foto) : '' }}"
                                 alt="Preview" class="w-full h-full object-cover"/>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1 pl-3">Kosongkan jika tidak ingin mengubah foto.</p>
                    @error('foto')<p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p>@enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex gap-3 mt-auto">
                    <a href="{{ route('admin.kelola_aset.index') }}"
                       class="flex-1 px-5 py-3 border-2 border-gray-300 rounded-[30px] text-sm font-semibold text-gray-600 hover:bg-gray-50 transition text-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex-1 bg-costume-primary text-white px-5 py-3 rounded-[30px] font-semibold text-sm hover:bg-blue-700 active:bg-blue-800 transition shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>
    </form>

@endsection

@push('scripts')
<script>
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
</script>
@endpush

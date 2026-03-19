@extends('layouts.admin')
@section('title', 'Tambah Laporan - KlikAset')
@section('content')

{{-- Breadcrumb / Back --}}
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('reports.index') }}"
       class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali
    </a>
    <span class="text-gray-300">/</span>
    <span class="text-sm font-semibold text-gray-700">Tambah Laporan</span>
</div>

@if($errors->any())
    <div class="mb-4 px-5 py-3 bg-red-100 text-red-700 border border-red-200 rounded-[30px] text-sm">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-6 lg:p-10">
        <h2 class="text-lg lg:text-xl font-bold text-gray-800 mb-6">Data Laporan Baru</h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

            {{-- Kolom Kiri --}}
            <div class="space-y-5">

                {{-- ID Peminjaman --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">ID Peminjaman <span class="text-red-500">*</span></label>
                    <input type="text" name="id_peminjaman" value="{{ old('id_peminjaman') }}"
                        placeholder="Masukkan ID peminjaman"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('id_peminjaman') border-red-400 @enderror"/>
                    @error('id_peminjaman')<p class="text-red-500 text-xs mt-1 ml-3">{{ $message }}</p>@enderror
                </div>

                {{-- Jenis Laporan --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">Jenis Laporan <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="jenis_laporan"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition @error('jenis_laporan') border-red-400 @enderror">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="dikembalikan"        {{ old('jenis_laporan') === 'dikembalikan'        ? 'selected' : '' }}>Dikembalikan</option>
                            <option value="telat mengembalikan" {{ old('jenis_laporan') === 'telat mengembalikan' ? 'selected' : '' }}>Telat Mengembalikan</option>
                            <option value="hilang"              {{ old('jenis_laporan') === 'hilang'              ? 'selected' : '' }}>Hilang</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </div>
                    </div>
                    @error('jenis_laporan')<p class="text-red-500 text-xs mt-1 ml-3">{{ $message }}</p>@enderror
                </div>

                {{-- Kondisi Barang --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">Kondisi Barang <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="kondisi_barang"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition @error('kondisi_barang') border-red-400 @enderror">
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="baik"            {{ old('kondisi_barang') === 'baik'            ? 'selected' : '' }}>Baik</option>
                            <option value="masih di pinjam" {{ old('kondisi_barang') === 'masih di pinjam' ? 'selected' : '' }}>Masih Di Pinjam</option>
                            <option value="rusak"           {{ old('kondisi_barang') === 'rusak'           ? 'selected' : '' }}>Rusak</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </div>
                    </div>
                    @error('kondisi_barang')<p class="text-red-500 text-xs mt-1 ml-3">{{ $message }}</p>@enderror
                </div>

                {{-- Tanggal --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Tgl. Dipinjam:</label>
                        <input type="datetime-local" name="tanggal_dipinjam" value="{{ old('tanggal_dipinjam') }}"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"/>
                    </div>
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Tgl. Dikembalikan:</label>
                        <input type="datetime-local" name="tanggal_dikembalikan" value="{{ old('tanggal_dikembalikan') }}"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"/>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Foto & Tombol --}}
            <div class="flex flex-col">
                <div class="flex flex-col mb-7">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-gray-800 font-medium text-sm">Foto Bukti</label>
                        <button type="button" id="removeImage"
                            class="hidden px-4 py-1 bg-red-500 text-white text-xs font-medium rounded-[30px] hover:bg-red-600 transition">
                            Hapus Foto
                        </button>
                    </div>
                    <div id="uploadArea"
                        class="border-2 border-dashed border-gray-300 rounded-[30px] bg-white hover:bg-gray-50 transition cursor-pointer h-[220px] flex items-center justify-center overflow-hidden">
                        <input type="file" name="foto_bukti" id="photoInput" accept="image/*" class="hidden"/>
                        <div id="uploadPlaceholder" class="w-full text-center px-8">
                            <x-icon-gallery-add class="w-16 h-16 mx-auto text-gray-300"/>
                            <p class="text-base font-bold text-gray-700 mb-1">Tambahkan Foto Bukti</p>
                            <p class="text-sm text-gray-400">Klik atau drag foto ke sini</p>
                        </div>
                        <div id="imagePreview" class="hidden w-full h-full">
                            <img id="previewImg" src="" alt="Preview" class="w-full h-full object-cover rounded-[28px]"/>
                        </div>
                    </div>
                    @error('foto_bukti')<p class="text-red-500 text-xs mt-1 ml-3">{{ $message }}</p>@enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex gap-3 mt-auto">
                    <a href="{{ route('reports.index') }}"
                       class="flex-1 text-center border-2 border-gray-300 text-gray-700 px-5 py-3 rounded-[30px] font-semibold text-sm hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex-1 bg-costume-primary text-white px-5 py-3 rounded-[30px] font-semibold text-sm hover:bg-blue-700 active:bg-blue-800 transition shadow-sm">
                        Simpan Laporan
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

    uploadArea.addEventListener('dragover',  (e) => { e.preventDefault(); uploadArea.classList.add('border-blue-400', 'bg-blue-50'); });
    uploadArea.addEventListener('dragleave', ()  => { uploadArea.classList.remove('border-blue-400', 'bg-blue-50'); });
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

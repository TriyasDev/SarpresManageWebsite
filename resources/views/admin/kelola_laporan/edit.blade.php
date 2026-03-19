@extends('layouts.admin')
@section('title', 'Edit Laporan - KlikAset')
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
    <span class="text-sm font-semibold text-gray-700">Edit Laporan #{{ $laporan->id_laporan }}</span>
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

<form action="{{ route('reports.update', $laporan->id_laporan) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-6 lg:p-10">
        <h2 class="text-lg lg:text-xl font-bold text-gray-800 mb-6">Edit Data Laporan</h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

            {{-- Kolom Kiri --}}
            <div class="space-y-5">

                {{-- ID Peminjaman (readonly) --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">ID Peminjaman:</label>
                    <input type="text" value="{{ $laporan->id_peminjaman }}" disabled
                        class="w-full px-5 py-3 border-2 border-gray-200 rounded-[30px] bg-gray-50 text-gray-500 text-sm cursor-not-allowed"/>
                    <p class="text-xs text-gray-400 ml-3 mt-1">ID Peminjaman tidak bisa diubah.</p>
                </div>

                {{-- Jenis Laporan --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">Jenis Laporan <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="jenis_laporan"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition @error('jenis_laporan') border-red-400 @enderror">
                            <option value="dikembalikan"        {{ old('jenis_laporan', $laporan->jenis_laporan) === 'dikembalikan'        ? 'selected' : '' }}>Dikembalikan</option>
                            <option value="telat mengembalikan" {{ old('jenis_laporan', $laporan->jenis_laporan) === 'telat mengembalikan' ? 'selected' : '' }}>Telat Mengembalikan</option>
                            <option value="hilang"              {{ old('jenis_laporan', $laporan->jenis_laporan) === 'hilang'              ? 'selected' : '' }}>Hilang</option>
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
                            <option value="baik"            {{ old('kondisi_barang', $laporan->kondisi_barang) === 'baik'            ? 'selected' : '' }}>Baik</option>
                            <option value="masih di pinjam" {{ old('kondisi_barang', $laporan->kondisi_barang) === 'masih di pinjam' ? 'selected' : '' }}>Masih Di Pinjam</option>
                            <option value="rusak"           {{ old('kondisi_barang', $laporan->kondisi_barang) === 'rusak'           ? 'selected' : '' }}>Rusak</option>
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
                        <input type="datetime-local" name="tanggal_dipinjam"
                            value="{{ old('tanggal_dipinjam', $laporan->tanggal_dipinjam?->format('Y-m-d\TH:i')) }}"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"/>
                    </div>
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Tgl. Dikembalikan:</label>
                        <input type="datetime-local" name="tanggal_dikembalikan"
                            value="{{ old('tanggal_dikembalikan', $laporan->tanggal_dikembalikan?->format('Y-m-d\TH:i')) }}"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"/>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Foto --}}
            <div class="flex flex-col gap-5">

                {{-- Foto saat ini --}}
                @if($laporan->foto_bukti)
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">Foto Bukti Saat Ini:</label>
                    <div class="rounded-[20px] overflow-hidden border-2 border-gray-200 h-44">
                        <img src="{{ asset('storage/' . $laporan->foto_bukti) }}" alt="Foto Bukti" class="w-full h-full object-cover"/>
                    </div>
                </div>
                @endif

                {{-- Upload foto baru --}}
                <div class="flex flex-col flex-1">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-gray-800 font-medium text-sm">
                            {{ $laporan->foto_bukti ? 'Ganti Foto Bukti:' : 'Upload Foto Bukti:' }}
                        </label>
                        <button type="button" id="removeImage"
                            class="hidden px-4 py-1 bg-red-500 text-white text-xs font-medium rounded-[30px] hover:bg-red-600 transition">
                            Hapus
                        </button>
                    </div>
                    <div id="uploadArea"
                        class="border-2 border-dashed border-gray-300 rounded-[30px] bg-white hover:bg-gray-50 transition cursor-pointer h-32 flex items-center justify-center overflow-hidden">
                        <input type="file" name="foto_bukti" id="photoInput" accept="image/*" class="hidden"/>
                        <div id="uploadPlaceholder" class="text-center px-6">
                            <p class="text-sm font-medium text-gray-600">Klik untuk ganti foto</p>
                            <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP maks. 2MB</p>
                        </div>
                        <div id="imagePreview" class="hidden w-full h-full">
                            <img id="previewImg" src="" alt="Preview" class="w-full h-full object-cover rounded-[28px]"/>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1 ml-3">Kosongkan jika tidak ingin mengubah foto.</p>
                    @error('foto_bukti')<p class="text-red-500 text-xs mt-1 ml-3">{{ $message }}</p>@enderror
                </div>

                {{-- Tombol --}}
                <div class="flex gap-3 mt-auto">
                    <a href="{{ route('reports.index') }}"
                       class="flex-1 text-center border-2 border-gray-300 text-gray-700 px-5 py-3 rounded-[30px] font-semibold text-sm hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex-1 bg-costume-primary text-white px-5 py-3 rounded-[30px] font-semibold text-sm hover:bg-blue-700 transition shadow-sm">
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

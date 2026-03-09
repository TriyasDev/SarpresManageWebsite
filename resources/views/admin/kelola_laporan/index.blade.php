@extends('layouts.admin')
@section('title', 'Laporan - KlikAset')
@section('content')

{{-- Flash Message --}}
@if(session('success'))
    <div id="flashSuccess"
         class="mb-4 px-5 py-3 bg-green-100 text-green-700 border border-green-200 rounded-[30px] text-sm font-medium flex items-center justify-between">
        <span>{{ session('success') }}</span>
        <button onclick="document.getElementById('flashSuccess').remove()" class="ml-4 text-green-500 hover:text-green-700">✕</button>
    </div>
@endif

@if($errors->any())
    <div class="mb-4 px-5 py-3 bg-red-100 text-red-700 border border-red-200 rounded-[30px] text-sm">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- ============================================================ --}}
{{-- SECTION 1: Form Input Laporan --}}
{{-- ============================================================ --}}
<form action="{{ route('admin.kelola_laporan.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-6 lg:p-10 mb-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

            {{-- Kolom Kiri: Form Input --}}
            <div class="space-y-5">

                {{-- ID Peminjaman --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">
                        Masukan ID Peminjaman:
                    </label>
                    <input
                        type="text"
                        name="id_peminjaman"
                        value="{{ old('id_peminjaman') }}"
                        placeholder="Masukkan ID peminjaman"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('id_peminjaman') border-red-400 @enderror"
                    />
                    @error('id_peminjaman')
                        <p class="text-red-500 text-xs mt-1 ml-3">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jenis Laporan --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">
                        Jenis Laporan:
                    </label>
                    <div class="relative">
                        <select
                            name="jenis_laporan"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition @error('jenis_laporan') border-red-400 @enderror"
                        >
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
                    @error('jenis_laporan')
                        <p class="text-red-500 text-xs mt-1 ml-3">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kondisi Barang --}}
                <div>
                    <label class="block text-gray-800 font-medium mb-2 text-sm">
                        Kondisi Barang:
                    </label>
                    <div class="relative">
                        <select
                            name="kondisi_barang"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition @error('kondisi_barang') border-red-400 @enderror"
                        >
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="baik"           {{ old('kondisi_barang') === 'baik'            ? 'selected' : '' }}>Baik</option>
                            <option value="masih di pinjam"{{ old('kondisi_barang') === 'masih di pinjam' ? 'selected' : '' }}>Masih Di Pinjam</option>
                            <option value="rusak"          {{ old('kondisi_barang') === 'rusak'           ? 'selected' : '' }}>Rusak</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </div>
                    </div>
                    @error('kondisi_barang')
                        <p class="text-red-500 text-xs mt-1 ml-3">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Dipinjam --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Tgl. Dipinjam:</label>
                        <input
                            type="datetime-local"
                            name="tanggal_dipinjam"
                            value="{{ old('tanggal_dipinjam') }}"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"
                        />
                    </div>
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Tgl. Dikembalikan:</label>
                        <input
                            type="datetime-local"
                            name="tanggal_dikembalikan"
                            value="{{ old('tanggal_dikembalikan') }}"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"
                        />
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Upload Foto & Tombol Simpan --}}
            <div class="flex flex-col">
                {{-- Area Upload Foto --}}
                <div class="flex flex-col mb-7">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-gray-800 font-medium text-sm">Tambahkan Foto Bukti</label>
                        <button
                            type="button"
                            id="removeImage"
                            class="hidden px-4 py-1 bg-red-500 text-white text-xs font-medium rounded-[30px] hover:bg-red-600 transition"
                        >
                            Hapus Foto
                        </button>
                    </div>
                    <div
                        id="uploadArea"
                        class="border-2 border-dashed border-gray-300 rounded-[30px] bg-white hover:bg-gray-50 transition cursor-pointer h-48 flex items-center justify-center overflow-hidden"
                    >
                        <input type="file" name="foto_bukti" id="photoInput" accept="image/*" class="hidden" />
                        <div id="uploadPlaceholder" class="w-full text-center px-8">
                            <x-icon-gallery-add class="w-16 h-16 mx-auto text-gray-300"/>
                            <p class="text-lg font-bold text-gray-700 mb-1">Tambahkan Foto</p>
                            <p class="text-sm text-gray-400">Klik atau Drag Foto ke sini</p>
                        </div>
                        <div id="imagePreview" class="hidden w-full h-full">
                            <img id="previewImg" src="" alt="Preview" class="w-full h-full object-cover rounded-[28px]" />
                        </div>
                    </div>
                    @error('foto_bukti')
                        <p class="text-red-500 text-xs mt-1 ml-3">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Simpan --}}
                <button
                    type="submit"
                    class="w-full bg-costume-primary text-white px-5 py-3 rounded-[30px] font-semibold text-sm hover:bg-blue-700 active:bg-blue-800 transition shadow-md hover:shadow-lg"
                >
                    Simpan Laporan
                </button>
            </div>

        </div>
    </div>
</form>

{{-- ============================================================ --}}
{{-- SECTION 2: Filter & Pencarian --}}
{{-- ============================================================ --}}
<form method="GET" action="{{ route('admin.kelola_laporan') }}" id="filterForm">
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-5 mb-6">
        <div class="flex flex-col lg:flex-row gap-4">

            {{-- Pencarian --}}
            <div class="flex-1 relative">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari peminjam / barang ..."
                    class="w-full px-5 py-3 pr-12 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition"
                    id="searchInput"
                />
                <x-icon-magnifer class="w-5 h-5 absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"/>
            </div>

            {{-- Filter Jenis Laporan --}}
            <div class="lg:w-52">
                <div class="relative">
                    <select
                        name="jenis_laporan"
                        onchange="document.getElementById('filterForm').submit()"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition"
                    >
                        <option value="">Semua Jenis</option>
                        <option value="dikembalikan"        {{ request('jenis_laporan') === 'dikembalikan'        ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="telat mengembalikan" {{ request('jenis_laporan') === 'telat mengembalikan' ? 'selected' : '' }}>Telat Mengembalikan</option>
                        <option value="hilang"              {{ request('jenis_laporan') === 'hilang'              ? 'selected' : '' }}>Hilang</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Filter Kondisi --}}
            <div class="lg:w-48">
                <div class="relative">
                    <select
                        name="kondisi_barang"
                        onchange="document.getElementById('filterForm').submit()"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition"
                    >
                        <option value="">Semua Kondisi</option>
                        <option value="baik"            {{ request('kondisi_barang') === 'baik'            ? 'selected' : '' }}>Baik</option>
                        <option value="masih di pinjam" {{ request('kondisi_barang') === 'masih di pinjam' ? 'selected' : '' }}>Masih Di Pinjam</option>
                        <option value="rusak"           {{ request('kondisi_barang') === 'rusak'           ? 'selected' : '' }}>Rusak</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="lg:w-auto flex gap-3">
                {{-- Filter button --}}
                <button type="submit"
                    class="px-5 py-3 border-2 border-gray-300 rounded-[30px] bg-white text-sm font-medium hover:bg-gray-50 transition flex items-center gap-2"
                >
                    <x-icon-filter class="w-4 h-4"/>
                    Filter
                </button>

                {{-- Download PDF --}}
                <a href="{{ route('admin.kelola_laporan.export_pdf', request()->query()) }}"
                    class="px-5 py-3 border-2 border-blue-300 rounded-[30px] bg-blue-50 text-blue-700 text-sm font-medium hover:bg-blue-100 transition flex items-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    PDF
                </a>

                {{-- Download Excel --}}
                <a href="{{ route('admin.kelola_laporan.export_excel', request()->query()) }}"
                    class="px-5 py-3 border-2 border-green-300 rounded-[30px] bg-green-50 text-green-700 text-sm font-medium hover:bg-green-100 transition flex items-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Excel
                </a>

                {{-- Trash --}}
                <a href="{{ route('admin.kelola_laporan.trash') }}"
                    class="px-5 py-3 border-2 border-red-200 rounded-[30px] bg-red-50 text-red-600 text-sm font-medium hover:bg-red-100 transition flex items-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Trash
                </a>
            </div>
        </div>
    </div>
</form>

{{-- ============================================================ --}}
{{-- SECTION 3: Tabel Data Laporan --}}
{{-- ============================================================ --}}
<div class="bg-white rounded-[30px] shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/80">
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Nama Peminjam</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Barang</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Tgl Pinjam</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Tgl Kembali</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Jenis Laporan</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Kondisi</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Foto</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporans as $laporan)
                <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">

                    {{-- Nama Peminjam --}}
                    <td class="p-4">
                        <p class="font-medium text-center text-sm">
                            {{ $laporan->peminjam?->user?->nama ?? '-' }}
                        </p>
                        <p class="text-xs text-gray-500 text-center">
                            {{ $laporan->peminjam?->user?->email ?? '-' }}
                        </p>
                    </td>

                    {{-- Nama Aset --}}
                    <td class="p-4">
                        <p class="font-medium text-center text-sm">
                            {{ $laporan->peminjam?->aset?->nama_aset ?? '-' }}
                        </p>
                        <p class="text-xs text-gray-500 text-center">
                            {{ $laporan->peminjam?->aset?->kode_aset ?? '-' }}
                        </p>
                    </td>

                    {{-- Tgl Dipinjam --}}
                    <td class="p-4">
                        <p class="font-semibold text-center text-sm">
                            {{ $laporan->tanggal_dipinjam?->format('d/m/Y') ?? '-' }}
                        </p>
                        <p class="text-xs text-gray-500 text-center">
                            {{ $laporan->tanggal_dipinjam?->format('H:i') ?? '' }}
                        </p>
                    </td>

                    {{-- Tgl Dikembalikan --}}
                    <td class="p-4">
                        <p class="font-semibold text-center text-sm">
                            {{ $laporan->tanggal_dikembalikan?->format('d/m/Y') ?? '-' }}
                        </p>
                        <p class="text-xs text-gray-500 text-center">
                            {{ $laporan->tanggal_dikembalikan?->format('H:i') ?? '' }}
                        </p>
                    </td>

                    {{-- Jenis Laporan (badge) --}}
                    <td class="p-4">
                        <div class="flex justify-center">
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-[30px] border shadow-sm {{ $laporan->badge_jenis }}">
                                {{ $laporan->label_jenis }}
                            </span>
                        </div>
                    </td>

                    {{-- Kondisi Barang (badge) --}}
                    <td class="p-4">
                        <div class="flex justify-center">
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-[30px] border shadow-sm {{ $laporan->badge_kondisi }}">
                                {{ $laporan->label_kondisi }}
                            </span>
                        </div>
                    </td>

                    {{-- Foto Bukti --}}
                    <td class="p-4">
                        <div class="flex justify-center">
                            @if($laporan->foto_bukti)
                                <button type="button"
                                    onclick="openFotoModal('{{ asset('storage/' . $laporan->foto_bukti) }}')"
                                    class="w-10 h-10 rounded-[10px] overflow-hidden border-2 border-gray-200 hover:border-blue-400 transition"
                                >
                                    <img src="{{ asset('storage/' . $laporan->foto_bukti) }}" alt="Foto" class="w-full h-full object-cover" />
                                </button>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </div>
                    </td>

                    {{-- Aksi --}}
                    <td class="p-4">
                        <div class="flex justify-center items-center gap-2">
                            {{-- Edit --}}
                            <a href="{{ route('admin.kelola_laporan.edit', $laporan->id_laporan) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 transition"
                               title="Edit"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            {{-- Delete --}}
                            <form action="{{ route('admin.kelola_laporan.destroy', $laporan->id_laporan) }}" method="POST"
                                  onsubmit="return confirm('Pindahkan laporan ini ke trash?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 flex items-center justify-center rounded-full bg-red-50 text-red-600 hover:bg-red-100 transition"
                                    title="Hapus"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="p-10 text-center text-gray-400 text-sm">
                        Belum ada data laporan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex flex-col sm:flex-row items-center justify-between p-4 bg-white gap-4">
        <p class="text-xs lg:text-sm text-gray-600">
            Menampilkan {{ $laporans->firstItem() ?? 0 }}–{{ $laporans->lastItem() ?? 0 }} dari {{ $laporans->total() }} laporan
        </p>
        <div class="flex items-center gap-2 flex-wrap justify-center">
            {{ $laporans->links() }}
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- Modal Preview Foto --}}
{{-- ============================================================ --}}
<div id="fotoModal"
     class="fixed inset-0 z-50 hidden bg-black/60 flex items-center justify-center p-4"
     onclick="closeFotoModal()"
>
    <div class="relative max-w-2xl w-full" onclick="event.stopPropagation()">
        <button onclick="closeFotoModal()"
            class="absolute -top-4 -right-4 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-lg text-gray-600 hover:text-red-500 transition z-10">
            ✕
        </button>
        <img id="fotoModalImg" src="" alt="Foto Bukti" class="w-full rounded-[20px] shadow-2xl" />
    </div>
</div>

@endsection

@push('scripts')
<script>
// =============================================
// UPLOAD FOTO — Drag & Drop + Click
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
// LIVE SEARCH — Auto submit saat ketik
// =============================================
let searchTimer;
document.getElementById('searchInput')?.addEventListener('input', () => {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => {
        document.getElementById('filterForm').submit();
    }, 500);
});

// =============================================
// MODAL FOTO
// =============================================
function openFotoModal(src) {
    document.getElementById('fotoModalImg').src = src;
    document.getElementById('fotoModal').classList.remove('hidden');
    document.getElementById('fotoModal').classList.add('flex');
}
function closeFotoModal() {
    document.getElementById('fotoModal').classList.add('hidden');
    document.getElementById('fotoModal').classList.remove('flex');
    document.getElementById('fotoModalImg').src = '';
}
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeFotoModal();
});
</script>
@endpush

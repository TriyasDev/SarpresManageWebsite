@extends('layouts.admin')
@section('title', 'Tambah Laporan - KlikAset')
@section('content')

{{-- Breadcrumb --}}
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('reports.index') }}" class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali
    </a>
    <span class="text-gray-300">/</span>
    <span class="text-sm font-semibold text-gray-700">Tambah Laporan</span>
</div>

{{-- Error Alert --}}
@if($errors->any())
    <div class="mb-6 px-5 py-3 bg-red-100 text-red-700 border border-red-200 rounded-full text-sm">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8">

        <h2 class="text-xl lg:text-2xl font-bold text-gray-800 mb-6">Data Laporan Baru</h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10">

            {{-- KOLOM KIRI --}}
            <div class="space-y-6">

                {{-- Pilih Peminjaman (Custom Dropdown dengan Search) --}}
                <div>
                    <label class="block text-gray-800 font-semibold mb-2 text-sm">Pilih Peminjaman <span class="text-red-500">*</span></label>
                    <div class="relative" id="loanDropdownContainer">
                        <input type="text" id="loanSearchInput" placeholder="Cari Nama Peminjam / Nama Barang"
                               class="w-full px-5 py-3 border-2 border-gray-300 rounded-full outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"
                               autocomplete="off">
                        <input type="hidden" name="id_peminjaman" id="id_peminjaman_hidden">
                        <div id="loanDropdown" class="absolute z-20 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg max-h-60 overflow-y-auto hidden"></div>
                    </div>
                    @error('id_peminjaman')<p class="text-red-500 text-xs mt-1 ml-3">{{ $message }}</p>@enderror
                </div>

                {{-- Jenis Laporan --}}
                <div>
                    <label class="block text-gray-800 font-semibold mb-2 text-sm">Jenis Laporan <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="jenis_laporan"
                                class="w-full px-5 py-3 border-2 border-gray-300 rounded-full outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition @error('jenis_laporan') border-red-400 @enderror">
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
                    <label class="block text-gray-800 font-semibold mb-2 text-sm">Kondisi Barang <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="kondisi_barang"
                                class="w-full px-5 py-3 border-2 border-gray-300 rounded-full outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition @error('kondisi_barang') border-red-400 @enderror">
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="baik"            {{ old('kondisi_barang') === 'baik'            ? 'selected' : '' }}>Baik</option>
                            <option value="masih di pinjam" {{ old('kondisi_barang') === 'masih di pinjam' ? 'selected' : '' }}>Masih Dipinjam</option>
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
                        <label class="block text-gray-800 font-semibold mb-2 text-sm">Tgl. Dipinjam</label>
                        <input type="datetime-local" name="tanggal_dipinjam" id="tanggal_dipinjam" readonly
                               class="w-full px-5 py-3 border-2 border-gray-200 rounded-full bg-gray-100 text-gray-600 cursor-not-allowed text-sm">
                        <p class="text-xs text-gray-400 mt-1 ml-3">Otomatis dari data peminjaman</p>
                    </div>
                    <div>
                        <label class="block text-gray-800 font-semibold mb-2 text-sm">Tgl. Dikembalikan <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="tanggal_dikembalikan" id="tanggal_dikembalikan"
                               class="w-full px-5 py-3 border-2 border-gray-300 rounded-full outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('tanggal_dikembalikan') border-red-400 @enderror"
                               value="{{ old('tanggal_dikembalikan') }}">
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: Foto Bukti & Tombol --}}
            <div class="flex flex-col">
                <div class="flex flex-col mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <label class="text-gray-800 font-semibold text-sm">Foto Bukti</label>
                        <button type="button" id="removeImage"
                                class="hidden px-4 py-1.5 bg-red-500 text-white text-xs font-medium rounded-full hover:bg-red-600 transition shadow-sm">
                            Hapus Foto
                        </button>
                    </div>
                    <div id="uploadArea"
                         class="border-2 border-dashed border-gray-300 rounded-2xl bg-gray-50 hover:bg-gray-100 transition cursor-pointer h-52 flex items-center justify-center overflow-hidden">
                        <input type="file" name="foto_bukti" id="photoInput" accept="image/*" class="hidden"/>
                        <div id="uploadPlaceholder" class="w-full text-center px-6">
                            <svg class="w-14 h-14 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-base font-semibold text-gray-700 mb-1">Tambahkan Foto Bukti</p>
                            <p class="text-sm text-gray-400">Klik atau drag foto ke sini</p>
                        </div>
                        <div id="imagePreview" class="hidden w-full h-full">
                            <img id="previewImg" src="" alt="Preview" class="w-full h-full object-cover rounded-2xl"/>
                        </div>
                    </div>
                    @error('foto_bukti')<p class="text-red-500 text-xs mt-2 ml-3">{{ $message }}</p>@enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex gap-3 mt-auto pt-4">
                    <a href="{{ route('reports.index') }}"
                       class="flex-1 text-center border-2 border-gray-300 text-gray-700 px-5 py-3 rounded-full font-semibold text-sm hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="flex-1 bg-costume-primary text-white px-5 py-3 rounded-full font-semibold text-sm hover:bg-blue-700 active:bg-blue-800 transition shadow-md">
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
    // Data dari controller
    const loansData = @json($activeLoans);

    // DOM elements
    const searchInput = document.getElementById('loanSearchInput');
    const hiddenId = document.getElementById('id_peminjaman_hidden');
    const dropdown = document.getElementById('loanDropdown');
    let filteredLoans = [...loansData];
    let isOpen = false;
    let selectedDisplayText = ''; // untuk menyimpan teks yang dipilih

    function renderDropdown() {
        if (!isOpen) {
            dropdown.classList.add('hidden');
            return;
        }
        dropdown.classList.remove('hidden');
        if (filteredLoans.length === 0) {
            dropdown.innerHTML = '<div class="p-4 text-center text-gray-400 text-sm">Tidak ada peminjaman ditemukan</div>';
            return;
        }
        dropdown.innerHTML = '';
        filteredLoans.forEach(loan => {
            const div = document.createElement('div');
            div.className = 'px-4 py-3 hover:bg-blue-50 cursor-pointer border-b border-gray-100 last:border-0 flex justify-between items-start gap-2';
            if (hiddenId.value == loan.id) div.classList.add('bg-blue-100');
            div.innerHTML = `
                <div class="flex-1">
                    <div class="font-semibold text-gray-800 text-sm">#${loan.id} – ${loan.user}</div>
                    <div class="text-xs text-gray-500 mt-0.5">${loan.barang}  •  Tanggal kembali: ${loan.tenggat}</div>
                </div>
                <div class="text-xs text-blue-600 whitespace-nowrap">Pilih</div>
            `;
            div.addEventListener('click', () => selectLoan(loan));
            dropdown.appendChild(div);
        });
    }

    function selectLoan(loan) {
        hiddenId.value = loan.id;
        const displayText = `#${loan.id} – ${loan.user} – ${loan.barang}`;
        searchInput.value = displayText;
        selectedDisplayText = displayText;
        isOpen = false;
        renderDropdown();
        // Set tanggal dipinjam
        const tglPinjam = document.getElementById('tanggal_dipinjam');
        tglPinjam.value = loan.tanggal_pinjam || '';
    }

    function filterLoans() {
        const keyword = searchInput.value.trim().toLowerCase();
        // Jika keyword sama dengan teks yang sudah dipilih, tampilkan semua data (agar dropdown tidak kosong)
        if (keyword === selectedDisplayText.toLowerCase()) {
            filteredLoans = [...loansData];
        } else if (keyword === '') {
            filteredLoans = [...loansData];
        } else {
            filteredLoans = loansData.filter(loan =>
                loan.id.toString().includes(keyword) ||
                loan.user.toLowerCase().includes(keyword) ||
                loan.barang.toLowerCase().includes(keyword)
            );
        }
        renderDropdown();
    }

    searchInput.addEventListener('input', () => {
        // Jika user mulai mengetik, reset selectedDisplayText agar filter normal
        if (searchInput.value !== selectedDisplayText) {
            selectedDisplayText = '';
        }
        filterLoans();
        isOpen = true;
        renderDropdown();
    });

    searchInput.addEventListener('click', () => {
        isOpen = true;
        filterLoans();
    });

    document.addEventListener('click', (e) => {
        if (!document.getElementById('loanDropdownContainer').contains(e.target)) {
            isOpen = false;
            renderDropdown();
        }
    });

    searchInput.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            isOpen = false;
            renderDropdown();
        } else if (e.key === 'Enter' && filteredLoans.length > 0) {
            e.preventDefault();
            selectLoan(filteredLoans[0]);
        }
    });

    // Old value support
    @if(old('id_peminjaman'))
        const oldLoan = loansData.find(l => l.id == {{ old('id_peminjaman') }});
        if (oldLoan) selectLoan(oldLoan);
    @endif

    // Set default tanggal dikembalikan = sekarang
    const tglKembali = document.getElementById('tanggal_dikembalikan');
    if (!tglKembali.value) {
        const now = new Date();
        const pad = (n) => String(n).padStart(2, '0');
        tglKembali.value = `${now.getFullYear()}-${pad(now.getMonth()+1)}-${pad(now.getDate())}T${pad(now.getHours())}:${pad(now.getMinutes())}`;
    }

    // Upload foto
    const uploadArea = document.getElementById('uploadArea');
    const photoInput = document.getElementById('photoInput');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const removeImageBtn = document.getElementById('removeImage');

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
        previewImg.src = '';
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

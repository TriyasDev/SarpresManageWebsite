@extends('layouts.admin')
@section('title', 'Kelola Aset - KlikAset')

@section('content')

<div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-6 lg:p-10 mb-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

        {{-- Kolom Kiri : Input --}}
        <div class="space-y-5">

            {{-- Nama Merek --}}
            <div>
                <label class="block text-gray-800 font-medium mb-2 text-sm">
                    Masukan Nama Merek:
                </label>
                <input
                    type="text"
                    id="namaMerek"
                    placeholder="Masukkan nama merek"
                    class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"
                />
            </div>

            {{-- Kategori Barang --}}
            <div>
                <label class="block text-gray-800 font-medium mb-2 text-sm">
                    Kategori Barang:
                </label>
                <div class="relative">
                    <select
                        id="kategori"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition"
                    >
                        <option value="">Pilih Kategori</option>
                        <option value="Elektronik">Elektronik</option>
                        <option value="Furniture">Furniture</option>
                        <option value="Alat Tulis">Alat Tulis</option>
                        <option value="Kendaraan">Kendaraan</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Deskripsi Barang --}}
            <div>
                <label class="block text-gray-800 font-medium mb-2 text-sm">
                    Deskripsi Barang:
                </label>
                <input
                    type="text"
                    id="deskripsi"
                    placeholder="Masukkan deskripsi"
                    class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"
                />
            </div>

            {{-- Kondisi Barang --}}
            <div>
                <label class="block text-gray-800 font-medium mb-2 text-sm">
                    Kondisi Barang:
                </label>
                <input
                    type="text"
                    id="kondisi"
                    placeholder="Masukkan kondisi"
                    class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"
                />
            </div>

        </div>
        {{-- END Kolom Kiri --}}

        {{-- Kolom Kanan : Upload Foto + Simpan --}}
        <div class="flex flex-col">

            {{-- Area Upload --}}
            <div class="flex flex-col mb-7">

                {{-- Label row : "Tambahkan Foto" kiri | "Hapus Foto" kanan (muncul saat ada gambar) --}}
                <div class="flex items-center justify-between mb-2">
                    <label class="text-gray-800 font-medium text-sm">Tambahkan Foto</label>
                    <button
                        type="button"
                        id="removeImage"
                        class="hidden px-4 py-1 bg-red-500 text-white text-xs font-medium rounded-[30px] hover:bg-red-600 transition"
                    >
                        Hapus Foto
                    </button>
                </div>

                {{-- Drop Zone --}}
                <div
                    id="uploadArea"
                    class="border-2 border-dashed border-gray-300 rounded-[30px] bg-white hover:bg-gray-50 transition cursor-pointer h-[260px] flex items-center justify-center overflow-hidden"
                >
                    <input type="file" id="photoInput" accept="image/*" class="hidden" />

                    {{-- Placeholder --}}
                    <div id="uploadPlaceholder" class="w-full text-center px-8">
                        <x-icon-gallery-add class="w-16 h-16 mx-auto text-gray-300"/>
                        <p class="text-lg font-bold text-gray-700 mb-1">Tambahkan Foto</p>
                        <p class="text-sm text-gray-400">Klik atau Drag Foto ke sini</p>
                    </div>

                    {{-- Preview (fill penuh, tidak rounded) --}}
                    <div id="imagePreview" class="hidden w-full h-full">
                        <img
                            id="previewImg"
                            src=""
                            alt="Preview"
                            class="w-full h-full object-cover"
                        />
                    </div>

                </div>
            </div>

            {{-- Tombol Simpan --}}
            <button
                type="button"
                id="simpanBtn"
                class="w-full bg-costume-primary text-white px-5 py-3 rounded-[30px] font-semibold text-sm hover:bg-blue-700 active:bg-blue-800 transition shadow-sm hover:shadow-lg"
            >
                Simpan
            </button>

        </div>
        {{-- END Kolom Kanan --}}

    </div>
</div>

<div class="bg-white rounded-[30px] border border-gray-100 shadow-sm p-5 mb-6">
    <div class="flex flex-col lg:flex-row gap-4">

        {{-- Search Input --}}
        <div class="flex-1 relative">
            <input
                type="text"
                id="searchInput"
                placeholder="Cari Nama Merek Barang :"
                class="w-full px-5 py-3 pr-12 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"
            />
            <x-icon-magnifer class="w-5 h-5 absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"/>
        </div>

        {{-- Filter Kategori --}}
        <div class="lg:w-64">
            <div class="relative">
                <select
                    id="filterKategori"
                    class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition"
                >
                    <option value="">Kategori :</option>
                    <option value="Elektronik">Prasaran</option>
                    <option value="Furniture">Media Pendidikan</option>
                    <option value="Alat Tulis">Perlengkapan Kelas</option>
                    <option value="Kendaraan">Fasilitas Penunjang</option>
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
{{-- SECTION 3 : CARDS GRID                                --}}
{{-- ===================================================== --}}
<div id="cardsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
    {{-- Cards diisi oleh JavaScript --}}
</div>
{{-- END SECTION 3 --}}


{{-- ===================================================== --}}
{{-- MODAL EDIT ASET                                        --}}
{{-- ===================================================== --}}
<div id="editModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-[30px] shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-8">

            {{-- Modal Header --}}
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Edit Aset</h2>
                <button id="closeModal" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="space-y-4">

                <div>
                    <label class="block text-gray-700 font-medium mb-2 text-sm">Nama Merek:</label>
                    <input type="text" id="editNamaMerek"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition" />
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2 text-sm">Kategori:</label>
                    <div class="relative">
                        <select id="editKategori"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white text-sm transition">
                            <option value="Elektronik">Elektronik</option>
                            <option value="Furniture">Furniture</option>
                            <option value="Alat Tulis">Alat Tulis</option>
                            <option value="Kendaraan">Kendaraan</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2 text-sm">Deskripsi:</label>
                    <input type="text" id="editDeskripsi"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition" />
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2 text-sm">Kondisi:</label>
                    <input type="text" id="editKondisi"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition" />
                </div>

                {{-- Modal Actions --}}
                <div class="flex gap-3 pt-2">
                    <button id="saveEdit"
                        class="flex-1 bg-costume-primary text-white px-5 py-3 rounded-[30px] font-semibold text-sm hover:bg-blue-700 transition">
                        Simpan
                    </button>
                    <button id="cancelEdit"
                        class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-[30px] font-semibold text-sm hover:bg-gray-300 transition">
                        Batal
                    </button>
                </div>

            </div>

        </div>
    </div>
</div>
{{-- END MODAL --}}

@endsection

@push('scripts')
<script>
    // =============================================
    // UPLOAD FOTO
    // =============================================
    const uploadArea        = document.getElementById('uploadArea');
    const photoInput        = document.getElementById('photoInput');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const imagePreview      = document.getElementById('imagePreview');
    const previewImg        = document.getElementById('previewImg');
    const removeImageBtn    = document.getElementById('removeImage');

    // Klik area → buka file dialog
    uploadArea.addEventListener('click', () => photoInput.click());

    // Pilih file → tampilkan preview + munculkan tombol Hapus di label row
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

    // Hapus foto → reset ke placeholder + sembunyikan tombol Hapus
    removeImageBtn.addEventListener('click', () => {
        previewImg.src   = '';
        photoInput.value = '';
        imagePreview.classList.add('hidden');
        uploadPlaceholder.classList.remove('hidden');
        removeImageBtn.classList.add('hidden');
    });

    // Drag & Drop
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
    // SIMPAN — DATA SEMENTARA (STATIC)
    // =============================================
    let asetList  = [];
    let editIndex = null;

    document.getElementById('simpanBtn').addEventListener('click', () => {
        const nama      = document.getElementById('namaMerek').value.trim();
        const kategori  = document.getElementById('kategori').value;
        const deskripsi = document.getElementById('deskripsi').value.trim();
        const kondisi   = document.getElementById('kondisi').value.trim();
        const imgSrc    = previewImg.src || '';

        if (!nama) { alert('Nama Merek wajib diisi!'); return; }

        asetList.push({ nama, kategori, deskripsi, kondisi, img: imgSrc });

        document.getElementById('namaMerek').value = '';
        document.getElementById('kategori').value  = '';
        document.getElementById('deskripsi').value = '';
        document.getElementById('kondisi').value   = '';
        removeImageBtn.click();

        renderCards(asetList);
    });

    // =============================================
    // RENDER CARDS
    // =============================================
    function renderCards(data) {
        const container = document.getElementById('cardsContainer');
        if (data.length === 0) {
            container.innerHTML = `
                <div class="col-span-full text-center py-16 text-gray-400">
                    <x-icon-box class="w-14 h-14 mx-auto mb-3 text-gray-200"/>
                    <p class="text-base font-medium">Belum ada aset</p>
                </div>`;
            return;
        }
        container.innerHTML = data.map((item, i) => `
            <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200 flex flex-col">
                <div class="h-44 bg-gray-100 flex items-center justify-center overflow-hidden rounded-t-[30px]">
                    ${item.img
                        ? `<img src="${item.img}" alt="${item.nama}" class="w-full h-full object-cover"/>`
                        : `<svg class="w-14 h-14 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                           </svg>`
                    }
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <h3 class="font-bold text-gray-900 text-sm mb-1 truncate">${item.nama}</h3>
                    <span class="inline-block text-xs bg-blue-100 text-blue-700 font-semibold px-3 py-0.5 rounded-[30px] mb-2 w-fit">${item.kategori || 'Tanpa Kategori'}</span>
                    <p class="text-xs text-gray-500 truncate">${item.deskripsi || '-'}</p>
                    <p class="text-xs text-gray-400 mt-1">Kondisi: ${item.kondisi || '-'}</p>
                    <div class="flex gap-2 mt-4">
                        <button onclick="openEdit(${i})"
                            class="flex-1 py-2 text-xs font-semibold bg-costume-primary text-white rounded-[30px] hover:bg-blue-700 transition">
                            Edit
                        </button>
                        <button onclick="hapusAset(${i})"
                            class="flex-1 py-2 text-xs font-semibold bg-red-100 text-red-600 rounded-[30px] hover:bg-red-200 transition">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    // =============================================
    // SEARCH & FILTER
    // =============================================
    function filterCards() {
        const keyword  = document.getElementById('searchInput').value.toLowerCase();
        const kategori = document.getElementById('filterKategori').value;
        const filtered = asetList.filter(item =>
            item.nama.toLowerCase().includes(keyword) &&
            (kategori === '' || item.kategori === kategori)
        );
        renderCards(filtered);
    }

    document.getElementById('searchInput').addEventListener('input', filterCards);
    document.getElementById('filterKategori').addEventListener('change', filterCards);

    // =============================================
    // MODAL EDIT
    // =============================================
    function openEdit(index) {
        editIndex = index;
        const item = asetList[index];
        document.getElementById('editNamaMerek').value = item.nama;
        document.getElementById('editKategori').value  = item.kategori;
        document.getElementById('editDeskripsi').value = item.deskripsi;
        document.getElementById('editKondisi').value   = item.kondisi;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function hapusAset(index) {
        if (!confirm('Hapus aset ini?')) return;
        asetList.splice(index, 1);
        renderCards(asetList);
    }

    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
        editIndex = null;
    }

    document.getElementById('closeModal').addEventListener('click', closeModal);
    document.getElementById('cancelEdit').addEventListener('click', closeModal);

    document.getElementById('saveEdit').addEventListener('click', () => {
        if (editIndex === null) return;
        asetList[editIndex].nama      = document.getElementById('editNamaMerek').value.trim();
        asetList[editIndex].kategori  = document.getElementById('editKategori').value;
        asetList[editIndex].deskripsi = document.getElementById('editDeskripsi').value.trim();
        asetList[editIndex].kondisi   = document.getElementById('editKondisi').value.trim();
        renderCards(asetList);
        closeModal();
    });

    document.getElementById('editModal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('editModal')) closeModal();
    });

    // Init
    renderCards(asetList);
</script>
@endpush

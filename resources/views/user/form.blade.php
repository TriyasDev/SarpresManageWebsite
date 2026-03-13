<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>KlikAset - Pilih Barang</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif'],
                        jakarta: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    boxShadow: {
                        'card': '0 4px 16px rgba(0,0,0,0.08), 0 2px 6px rgba(0,0,0,0.04)',
                        'card-hover': '0 20px 50px rgba(37,99,235,0.13), 0 8px 20px rgba(0,0,0,0.07)',
                        'btn': '0 6px 20px rgba(37,99,235,0.35)',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .card {
            animation: cardIn 0.4s ease both;
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .toast {
            animation: toastIn 0.3s cubic-bezier(.4, 0, .2, 1) forwards;
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateY(14px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .toast.out {
            animation: toastOut 0.25s ease forwards;
        }

        @keyframes toastOut {
            to {
                opacity: 0;
                transform: translateY(8px) scale(0.92);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(28px) scale(0.96);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-content {
            animation: slideUp 0.28s cubic-bezier(.4, 0, .2, 1) both;
        }

        .filter-btn.active {
            background: #0f172a;
            border-color: #0f172a;
            color: white;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.22);
            transform: translateY(-1px);
        }

        .page-btn.active {
            background: #2563eb;
            border-color: #2563eb;
            color: white;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .form-input {
            width: 100%;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 16px;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            transition: all 0.2s;
            background: #f8fafc;
            color: #1e293b;
        }

        .form-input:focus {
            border-color: #2563eb;
            background: white;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .pinjam-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transform: translateX(-100%);
            transition: transform 0.4s;
        }

        .pinjam-btn:hover::before {
            transform: translateX(100%);
        }

        .product-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .card:hover .product-img {
            transform: scale(1.06);
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen font-jakarta">

    <!-- ===== STICKY HEADER ===== -->
    <div class="bg-white/95 backdrop-blur-lg sticky top-0 z-40 border-b border-slate-200 shadow-sm">
        <div class="max-w-screen-xl mx-auto px-5 py-3.5">

            <!-- Search -->
            <div class="relative mb-3">
                <input type="text" id="searchInput"
                    class="w-full border-2 border-slate-200 rounded-full py-2.5 pl-5 pr-12 text-sm outline-none bg-slate-50 transition-all duration-200 focus:border-blue-600 focus:bg-white focus:shadow-[0_0_0_4px_rgba(37,99,235,0.1)] placeholder-slate-400"
                    placeholder="Cari barang... (nama atau kategori)">
                <button id="searchClear" style="display:none;align-items:center;justify-content:center;"
                    class="absolute right-11 top-1/2 -translate-y-1/2 w-5 h-5 bg-slate-300 hover:bg-slate-500 border-none rounded-full text-white text-xs font-bold transition-colors cursor-pointer">✕</button>
                <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <!-- Filter -->
            <div class="flex flex-wrap gap-2 mb-2.5" id="filterRow">
                <button
                    class="filter-btn active px-4 py-1.5 border-2 border-slate-300 rounded-full text-xs font-semibold cursor-pointer bg-white text-slate-700 transition-all duration-200 hover:border-slate-600"
                    data-cat="semua">Semua <span
                        class="bg-slate-100 text-slate-500 rounded-full px-1.5 text-[11px] ml-1">9</span></button>
                <button
                    class="filter-btn px-4 py-1.5 border-2 border-slate-300 rounded-full text-xs font-semibold cursor-pointer bg-white text-slate-700 transition-all duration-200 hover:border-slate-600"
                    data-cat="prasarana">Prasarana <span
                        class="bg-slate-100 text-slate-500 rounded-full px-1.5 text-[11px] ml-1">2</span></button>
                <button
                    class="filter-btn px-4 py-1.5 border-2 border-slate-300 rounded-full text-xs font-semibold cursor-pointer bg-white text-slate-700 transition-all duration-200 hover:border-slate-600"
                    data-cat="elektronik">Elektronik <span
                        class="bg-slate-100 text-slate-500 rounded-full px-1.5 text-[11px] ml-1">3</span></button>
                <button
                    class="filter-btn px-4 py-1.5 border-2 border-slate-300 rounded-full text-xs font-semibold cursor-pointer bg-white text-slate-700 transition-all duration-200 hover:border-slate-600"
                    data-cat="multimedia">Multimedia <span
                        class="bg-slate-100 text-slate-500 rounded-full px-1.5 text-[11px] ml-1">2</span></button>
                <button
                    class="filter-btn px-4 py-1.5 border-2 border-slate-300 rounded-full text-xs font-semibold cursor-pointer bg-white text-slate-700 transition-all duration-200 hover:border-slate-600"
                    data-cat="perlengkapan">Perlengkapan Kelas <span
                        class="bg-slate-100 text-slate-500 rounded-full px-1.5 text-[11px] ml-1">1</span></button>
                <button
                    class="filter-btn px-4 py-1.5 border-2 border-slate-300 rounded-full text-xs font-semibold cursor-pointer bg-white text-slate-700 transition-all duration-200 hover:border-slate-600"
                    data-cat="fasilitas">Fasilitas Penunjang <span
                        class="bg-slate-100 text-slate-500 rounded-full px-1.5 text-[11px] ml-1">1</span></button>
            </div>

            <!-- Sort -->
            <div class="flex items-center justify-between flex-wrap gap-2">
                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-600 font-medium">Urutkan:</span>
                    <select id="sortSelect"
                        class="border-2 border-slate-200 rounded-xl px-3 py-1.5 text-xs font-semibold outline-none bg-white text-slate-800 cursor-pointer focus:border-blue-600">
                        <option value="popular">Terpopuler</option>
                        <option value="rating">Rating Tertinggi</option>
                        <option value="nameaz">Nama A-Z</option>
                        <option value="avail">Ketersediaan</option>
                    </select>
                </div>
                <span class="text-xs text-slate-500">Menampilkan <strong id="shownCount"
                        class="text-slate-800">9</strong> barang</span>
            </div>
        </div>
    </div>

    <!-- ===== PRODUCT GRID ===== -->
    <main class="max-w-screen-xl mx-auto px-5 py-6">
        <div class="grid grid-cols-[repeat(auto-fill,minmax(270px,1fr))] gap-5" id="productGrid">
            <div id="emptyState" class="col-span-full text-center py-16 hidden">
                <div class="text-5xl mb-3">🔍</div>
                <h3 class="font-outfit text-xl font-bold text-slate-700 mb-1">Barang tidak ditemukan</h3>
                <p class="text-slate-400 text-sm">Coba kata kunci atau filter lain</p>
            </div>
        </div>
        <!-- Pagination -->
        <div class="flex flex-wrap items-center justify-between mt-8 gap-3">
            <p class="text-xs text-slate-500" id="pageInfo">Halaman <strong>1</strong> dari <strong>1</strong></p>
            <div class="flex gap-1.5 items-center flex-wrap" id="pagination"></div>
        </div>
    </main>

    <!-- ===== MODAL PEMINJAMAN ===== -->
    <div id="modalOverlay"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[500] flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-250">
        <div class="modal-content bg-white rounded-3xl w-full max-w-[480px] shadow-2xl max-h-[92vh] overflow-y-auto">

            <!-- STEP 1: Detail Barang -->
            <div id="stepDetail">
                <div class="p-7 pb-0">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="font-outfit text-xl font-extrabold text-slate-900" id="modalTitle">Detail Barang</h2>
                        <button id="modalClose"
                            class="bg-slate-100 hover:bg-slate-200 border-none rounded-full w-8 h-8 cursor-pointer text-base text-slate-600 flex items-center justify-center transition-colors">✕</button>
                    </div>
                    <div class="rounded-2xl overflow-hidden mb-4 h-44 relative">
                        <img id="modalProductImg" src="" alt="" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    </div>
                    <div class="flex flex-col gap-0 mb-5" id="modalInfo"></div>
                </div>
                <div class="flex gap-2.5 px-7 pb-7">
                    <button id="modalCancel"
                        class="flex-1 py-2.5 rounded-xl border-2 border-slate-200 bg-white font-jakarta text-sm font-bold cursor-pointer transition-all text-slate-700 hover:border-slate-400 hover:bg-slate-50">Batal</button>
                    <button id="modalNext"
                        class="flex-[2] py-2.5 rounded-xl border-none bg-blue-600 hover:bg-blue-700 text-white font-jakarta text-sm font-bold cursor-pointer transition-all hover:shadow-btn">Isi
                        Form Peminjaman →</button>
                </div>
            </div>

            <!-- STEP 2: Form Peminjaman -->
            <div id="stepForm" class="hidden">
                <div class="p-7">
                    <div class="flex items-center gap-3 mb-5">
                        <button id="backToDetail"
                            class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 cursor-pointer transition-colors text-slate-600 font-bold border-none">←</button>
                        <div>
                            <h2 class="font-outfit text-lg font-extrabold text-slate-900">Form Peminjaman</h2>
                            <p class="text-xs text-slate-500" id="formSubtitle"></p>
                        </div>
                    </div>

                    <!-- Ringkasan Barang -->
                    <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl mb-5 border border-slate-200">
                        <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0 bg-slate-100">
                            <img id="formItemImg" src="" alt="" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="font-semibold text-sm text-slate-800" id="formItemName"></p>
                            <p class="text-xs text-slate-500" id="formItemMeta"></p>
                        </div>
                    </div>

                    <!-- Fields -->
                    <div class="flex flex-col gap-3.5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="fNama" class="form-input" placeholder="Nama lengkap Anda">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Kelas <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="fKelas" class="form-input" placeholder="Contoh: XII IPA 1">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">NIPD <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="fNipd" class="form-input" placeholder="NIPD Anda">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">No. HP / WhatsApp <span
                                    class="text-red-500">*</span></label>
                            <input type="tel" id="fHp" class="form-input" placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Tgl Pinjam <span
                                        class="text-red-500">*</span></label>
                                <input type="date" id="fTglPinjam" class="form-input">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Tgl Kembali <span
                                        class="text-red-500">*</span></label>
                                <input type="date" id="fTglKembali" class="form-input">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Keperluan</label>
                            <textarea id="fKeperluan" class="form-input resize-none" rows="2"
                                placeholder="Keperluan peminjaman..."></textarea>
                        </div>
                    </div>

                    <div class="flex gap-2.5 mt-5">
                        <button id="formCancel"
                            class="flex-1 py-2.5 rounded-xl border-2 border-slate-200 bg-white font-jakarta text-sm font-bold cursor-pointer transition-all text-slate-700 hover:border-slate-400">Batal</button>
                        <button id="formSubmit"
                            class="flex-[2] py-2.5 rounded-xl border-none bg-blue-600 hover:bg-blue-700 text-white font-jakarta text-sm font-bold cursor-pointer transition-all hover:shadow-btn flex items-center justify-center gap-2">
                            ✓ Kirim Pengajuan
                        </button>
                    </div>
                </div>
            </div>

            <!-- STEP 3: Sukses -->
            <div id="stepSuccess" class="hidden p-10 text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center text-5xl mx-auto mb-5">
                    🎉</div>
                <h2 class="font-outfit text-2xl font-extrabold text-slate-900 mb-2">Pengajuan Terkirim!</h2>
                <p class="text-slate-500 text-sm mb-2" id="successMsg"></p>
                <p class="text-slate-400 text-xs mb-7">Pengajuan Anda sedang menunggu persetujuan admin. Harap menunggu
                    konfirmasi lebih lanjut.</p>
                <button id="successClose"
                    class="w-full py-2.5 rounded-xl border-none bg-blue-600 hover:bg-blue-700 text-white font-jakarta text-sm font-bold cursor-pointer transition-all">Selesai</button>
            </div>

        </div>
    </div>

    <!-- Toast -->
    <div class="fixed bottom-5 right-5 z-[999] flex flex-col gap-2 pointer-events-none" id="toastContainer"></div>

    <!-- Back to Top -->
    <button id="backToTop"
        class="fixed bottom-5 right-5 w-10 h-10 bg-slate-800 hover:bg-slate-900 text-white border-none rounded-full cursor-pointer flex items-center justify-center shadow-md z-[199] opacity-0 translate-y-2 pointer-events-none transition-all duration-300">↑</button>

    <script>
        /* ===== DATA ===== */
        const PRODUCTS = [
            { id: 1, name: 'Monitor Dell 24"', cat: 'elektronik', desc: 'Monitor Full HD untuk presentasi dan editing.', img: 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=600&q=80', avail: 15, maxDay: 7, rating: 4.8, cond: 'Sangat Baik', pop: 95, newest: 7 },
            { id: 2, name: 'Laptop Asus ROG', cat: 'elektronik', desc: 'Laptop performa tinggi untuk rendering dan coding.', img: 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=600&q=80', avail: 8, maxDay: 5, rating: 4.9, cond: 'Sangat Baik', pop: 99, newest: 2 },
            { id: 3, name: 'Proyektor Epson', cat: 'multimedia', desc: 'Proyektor HD dengan gambar jernih untuk presentasi.', img: 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?w=600&q=80', avail: 5, maxDay: 3, rating: 4.7, cond: 'Sangat Baik', pop: 88, newest: 5 },
            { id: 4, name: 'Kamera DSLR Canon', cat: 'multimedia', desc: 'Kamera profesional untuk dokumentasi dan fotografi.', img: 'https://images.unsplash.com/photo-1617469767053-d3b523a0b982?w=600&q=80', avail: 3, maxDay: 4, rating: 4.9, cond: 'Baik', pop: 90, newest: 1 },
            { id: 5, name: 'Meja Kerja Lipat', cat: 'prasarana', desc: 'Meja lipat ringan cocok untuk kegiatan luar ruang.', img: 'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?w=600&q=80', avail: 20, maxDay: 14, rating: 4.5, cond: 'Baik', pop: 70, newest: 9 },
            { id: 6, name: 'Kursi Ergonomis', cat: 'prasarana', desc: 'Kursi nyaman dengan sandaran tulang belakang.', img: 'https://images.unsplash.com/photo-1589384267710-7a170981ca78?w=600&q=80', avail: 12, maxDay: 10, rating: 4.6, cond: 'Sangat Baik', pop: 75, newest: 6 },
            { id: 7, name: 'Papan Tulis Portabel', cat: 'perlengkapan', desc: 'Papan tulis magnetik yang mudah dibawa kemana saja.', img: 'https://images.unsplash.com/photo-1596495578065-6e0763fa1178?w=600&q=80', avail: 7, maxDay: 7, rating: 4.4, cond: 'Baik', pop: 60, newest: 8 },
            { id: 8, name: 'Speaker Bluetooth JBL', cat: 'elektronik', desc: 'Speaker portabel dengan suara jernih dan bass kuat.', img: 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=600&q=80', avail: 6, maxDay: 3, rating: 4.7, cond: 'Sangat Baik', pop: 82, newest: 3 },
            { id: 9, name: 'Panel Surya Portable', cat: 'fasilitas', desc: 'Panel surya untuk pengisian daya saat kegiatan outdoor.', img: 'https://images.unsplash.com/photo-1509391366360-2e959784a276?w=600&q=80', avail: 4, maxDay: 5, rating: 4.6, cond: 'Baik', pop: 65, newest: 4 },
        ];

        const catLabel = { elektronik: 'Elektronik', multimedia: 'Multimedia', prasarana: 'Prasarana', perlengkapan: 'Perlengkapan Kelas', fasilitas: 'Fasilitas Penunjang' };
        const catBadge = { elektronik: 'bg-blue-100 text-blue-700', multimedia: 'bg-pink-100 text-pink-700', prasarana: 'bg-green-100 text-green-700', perlengkapan: 'bg-amber-100 text-amber-700', fasilitas: 'bg-purple-100 text-purple-700' };

        const ITEMS_PER_PAGE = 6;
        let currentPage = 1, activeFilter = 'semua', currentSearch = '', currentSort = 'popular', selectedProd = null;

        /* ===== HELPERS ===== */
        const getAvailDot = n => n >= 10 ? 'bg-green-500' : n >= 5 ? 'bg-orange-500' : 'bg-red-500';
        const getAvailTxt = n => n >= 5 ? `${n} Tersedia` : `${n} Tersisa!`;
        const fmtDate = d => new Date(d).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });

        function filtered() {
            let list = [...PRODUCTS];
            if (activeFilter !== 'semua') list = list.filter(p => p.cat === activeFilter);
            if (currentSearch.trim()) {
                const q = currentSearch.toLowerCase();
                list = list.filter(p => p.name.toLowerCase().includes(q) || p.cat.toLowerCase().includes(q) || p.desc.toLowerCase().includes(q));
            }
            if (currentSort === 'rating') list.sort((a, b) => b.rating - a.rating);
            else if (currentSort === 'nameaz') list.sort((a, b) => a.name.localeCompare(b.name));
            else if (currentSort === 'avail') list.sort((a, b) => b.avail - a.avail);
            else list.sort((a, b) => b.pop - a.pop);
            return list;
        }

        /* ===== CARD ===== */
        function createCard(p, delay) {
            const dot = getAvailDot(p.avail);
            const lbl = catLabel[p.cat] || p.cat;
            const badge = catBadge[p.cat] || 'bg-slate-100 text-slate-700';
            return `
<div class="card bg-white rounded-2xl shadow-card overflow-hidden transition-all duration-300 cursor-pointer hover:-translate-y-1.5 hover:shadow-card-hover"
     data-id="${p.id}" style="animation-delay:${delay}ms">
    <div class="overflow-hidden relative h-44">
        <img src="${p.img}" alt="${p.name}" class="product-img">
        <div class="absolute inset-0 bg-gradient-to-t from-black/25 to-transparent"></div>
        <div class="absolute top-2.5 left-2.5 right-2.5 flex justify-between">
            <div class="bg-white/95 backdrop-blur-sm rounded-full px-2.5 py-1 flex items-center gap-1.5 text-xs font-bold shadow-sm">
                <div class="w-2 h-2 rounded-full ${dot}"></div><span>${getAvailTxt(p.avail)}</span>
            </div>
            <div class="bg-white/95 backdrop-blur-sm rounded-full px-2 py-1 flex items-center gap-1 text-xs font-bold shadow-sm">
                <span class="text-amber-400">★</span><span>${p.rating}</span>
            </div>
        </div>
    </div>
    <div class="p-4">
        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider mb-2 ${badge}">${lbl}</span>
        <h3 class="font-outfit text-base font-bold text-slate-900 mb-1">${p.name}</h3>
        <p class="text-xs text-slate-500 mb-3 leading-relaxed">${p.desc}</p>
        <div class="flex flex-col gap-1 mb-3.5 text-xs text-slate-600">
            <div class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Kondisi: ${p.cond}
            </div>
            <div class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                Maksimal ${p.maxDay} hari
            </div>
        </div>
        <button class="pinjam-btn w-full bg-blue-600 hover:bg-blue-700 text-white border-none rounded-xl py-2.5 font-jakarta text-sm font-bold cursor-pointer flex items-center justify-center gap-2 transition-all hover:-translate-y-px hover:shadow-btn relative overflow-hidden"
                data-id="${p.id}" onclick="handlePinjam(event,${p.id})">
            Pinjam Sekarang
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </button>
    </div>
</div>`;
        }

        /* ===== RENDER ===== */
        function render() {
            const list = filtered();
            const pages = Math.max(1, Math.ceil(list.length / ITEMS_PER_PAGE));
            if (currentPage > pages) currentPage = 1;
            const slice = list.slice((currentPage - 1) * ITEMS_PER_PAGE, currentPage * ITEMS_PER_PAGE);

            const grid = document.getElementById('productGrid');
            const empty = document.getElementById('emptyState');
            grid.querySelectorAll('.card').forEach(c => c.remove());

            if (!slice.length) { empty.style.display = 'block'; }
            else { empty.style.display = 'none'; slice.forEach((p, i) => grid.insertAdjacentHTML('beforeend', createCard(p, i * 55))); }

            document.getElementById('shownCount').textContent = slice.length;
            document.getElementById('pageInfo').innerHTML = `Halaman <strong>${currentPage}</strong> dari <strong>${pages}</strong>`;
            renderPagination(currentPage, pages);
        }

        function renderPagination(cur, total) {
            const pg = document.getElementById('pagination');
            pg.innerHTML = '';
            const mk = (lbl, disabled, cb, active = false) => {
                const b = document.createElement('button');
                b.className = `page-btn w-9 h-9 rounded-full border-2 border-slate-200 bg-white text-xs font-bold cursor-pointer flex items-center justify-center transition-all text-slate-700 hover:border-blue-600 hover:text-blue-600 disabled:opacity-30 disabled:cursor-not-allowed ${active ? 'active' : ''}`;
                b.innerHTML = lbl; b.disabled = disabled; if (cb) b.onclick = cb; return b;
            };
            pg.appendChild(mk('←', cur === 1, () => { currentPage--; render(); scrollTo({ top: 0, behavior: 'smooth' }); }));
            let pages = [];
            if (total <= 5) for (let i = 1; i <= total; i++) pages.push(i);
            else { pages.push(1); if (cur > 3) pages.push('...'); for (let i = Math.max(2, cur - 1); i <= Math.min(total - 1, cur + 1); i++) pages.push(i); if (cur < total - 2) pages.push('...'); pages.push(total); }
            pages.forEach(p => {
                if (p === '...') { const s = document.createElement('span'); s.className = 'text-slate-400 font-bold px-0.5'; s.textContent = '···'; pg.appendChild(s); }
                else pg.appendChild(mk(p, false, () => { currentPage = p; render(); scrollTo({ top: 0, behavior: 'smooth' }); }, p === cur));
            });
            pg.appendChild(mk('→', cur === total, () => { currentPage++; render(); scrollTo({ top: 0, behavior: 'smooth' }); }));
        }

        /* ===== EVENTS: SEARCH / FILTER / SORT ===== */
        let st;
        document.getElementById('searchInput').addEventListener('input', function () {
            currentSearch = this.value;
            document.getElementById('searchClear').style.display = this.value ? 'flex' : 'none';
            clearTimeout(st); st = setTimeout(() => { currentPage = 1; render(); }, 200);
        });
        document.getElementById('searchClear').addEventListener('click', function () {
            document.getElementById('searchInput').value = ''; currentSearch = ''; this.style.display = 'none';
            currentPage = 1; render(); document.getElementById('searchInput').focus();
        });
        document.getElementById('filterRow').addEventListener('click', function (e) {
            const btn = e.target.closest('.filter-btn'); if (!btn) return;
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active'); activeFilter = btn.dataset.cat; currentPage = 1; render();
        });
        document.getElementById('sortSelect').addEventListener('change', function () {
            currentSort = this.value; currentPage = 1; render();
        });

        /* ===== MODAL ===== */
        function handlePinjam(e, id) {
            e.stopPropagation();
            const p = PRODUCTS.find(x => x.id === id); if (!p) return;
            selectedProd = p; openDetail(p);
        }

        function openDetail(p) {
            const lbl = catLabel[p.cat] || p.cat;
            document.getElementById('modalTitle').textContent = p.name;
            document.getElementById('modalProductImg').src = p.img;
            document.getElementById('modalProductImg').alt = p.name;
            document.getElementById('modalInfo').innerHTML = `
        <div class="flex justify-between text-sm py-2 border-b border-slate-100"><span class="text-slate-500">Kategori</span><span class="font-semibold text-slate-800">${lbl}</span></div>
        <div class="flex justify-between text-sm py-2 border-b border-slate-100"><span class="text-slate-500">Ketersediaan</span><span class="font-semibold" style="color:${p.avail >= 5 ? '#16a34a' : '#dc2626'}">${p.avail} unit</span></div>
        <div class="flex justify-between text-sm py-2 border-b border-slate-100"><span class="text-slate-500">Kondisi</span><span class="font-semibold text-slate-800">${p.cond}</span></div>
        <div class="flex justify-between text-sm py-2 border-b border-slate-100"><span class="text-slate-500">Rating</span><span class="font-semibold text-slate-800">★ ${p.rating}</span></div>
        <div class="flex justify-between text-sm py-2"><span class="text-slate-500">Maks. Peminjaman</span><span class="font-semibold text-slate-800">${p.maxDay} hari</span></div>`;
            showStep('detail'); openOverlay();
        }

        function showStep(s) {
            ['Detail', 'Form', 'Success'].forEach(n => document.getElementById('step' + n).classList.toggle('hidden', n.toLowerCase() !== s));
        }
        function openOverlay() { const o = document.getElementById('modalOverlay'); o.style.opacity = '1'; o.style.pointerEvents = 'all'; document.body.style.overflow = 'hidden'; }
        function closeOverlay() { const o = document.getElementById('modalOverlay'); o.style.opacity = '0'; o.style.pointerEvents = 'none'; document.body.style.overflow = ''; selectedProd = null; setTimeout(() => showStep('detail'), 280); }

        document.getElementById('modalClose').onclick = closeOverlay;
        document.getElementById('modalCancel').onclick = closeOverlay;
        document.getElementById('formCancel').onclick = closeOverlay;
        document.getElementById('successClose').onclick = closeOverlay;
        document.getElementById('modalOverlay').addEventListener('click', function (e) { if (e.target === this) closeOverlay(); });

        document.getElementById('modalNext').onclick = function () {
            if (!selectedProd) return;
            const p = selectedProd;
            document.getElementById('formSubtitle').textContent = p.name;
            document.getElementById('formItemImg').src = p.img;
            document.getElementById('formItemName').textContent = p.name;
            document.getElementById('formItemMeta').textContent = `Maks. ${p.maxDay} hari · ${p.avail} unit tersedia`;
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('fTglPinjam').min = today;
            document.getElementById('fTglKembali').min = today;
            showStep('form');
        };
        document.getElementById('backToDetail').onclick = () => showStep('detail');

        document.getElementById('fTglPinjam').addEventListener('change', function () {
            document.getElementById('fTglKembali').min = this.value;
            if (document.getElementById('fTglKembali').value < this.value) document.getElementById('fTglKembali').value = '';
            if (selectedProd && this.value) {
                const mx = new Date(this.value); mx.setDate(mx.getDate() + selectedProd.maxDay);
                document.getElementById('fTglKembali').max = mx.toISOString().split('T')[0];
            }
        });

        document.getElementById('formSubmit').onclick = function () {
            const nama = document.getElementById('fNama').value.trim();
            const kelas = document.getElementById('fKelas').value.trim();
            const nipd = document.getElementById('fNipd').value.trim();
            const hp = document.getElementById('fHp').value.trim();
            const tglP = document.getElementById('fTglPinjam').value;
            const tglK = document.getElementById('fTglKembali').value;
            const kep = document.getElementById('fKeperluan').value.trim();

            if (!nama || !kelas || !nipd || !hp || !tglP || !tglK) { showToast('⚠️ Lengkapi semua field yang wajib diisi!'); return; }
            if (tglK < tglP) { showToast('⚠️ Tanggal kembali tidak boleh sebelum tanggal pinjam!'); return; }

            // =====================================================
            // KIRIM DATA KE ADMIN — simpan di localStorage
            // =====================================================
            const submission = {
                id: Date.now(),
                nama, kelas, nipd, hp,
                keperluan: kep || '-',
                tglPinjam: tglP,
                tglKembali: tglK,
                barang: selectedProd.name,
                barangImg: selectedProd.img,
                status: 'pending',
                createdAt: new Date().toISOString(),
            };
            const existing = JSON.parse(localStorage.getItem('klikaset_submissions') || '[]');
            existing.unshift(submission);
            localStorage.setItem('klikaset_submissions', JSON.stringify(existing));
            // =====================================================

            document.getElementById('successMsg').textContent =
                `${selectedProd.name} oleh ${nama} · ${fmtDate(tglP)} s/d ${fmtDate(tglK)}`;

            ['fNama', 'fKelas', 'fNipd', 'fHp', 'fTglPinjam', 'fTglKembali', 'fKeperluan'].forEach(id => {
                const el = document.getElementById(id); if (el) el.value = '';
            });
            showStep('success');
        };

        /* ===== CARD CLICK (open detail) ===== */
        document.getElementById('productGrid').addEventListener('click', function (e) {
            const card = e.target.closest('.card');
            if (!card || e.target.closest('.pinjam-btn')) return;
            const p = PRODUCTS.find(x => x.id === parseInt(card.dataset.id));
            if (p) { selectedProd = p; openDetail(p); }
        });

        /* ===== TOAST ===== */
        function showToast(msg, dur = 2800) {
            const wrap = document.getElementById('toastContainer');
            const t = document.createElement('div');
            t.className = 'toast bg-slate-900 text-white px-4 py-2.5 rounded-2xl text-sm font-semibold shadow-lg flex items-center gap-2 pointer-events-auto';
            t.textContent = msg; wrap.appendChild(t);
            setTimeout(() => { t.classList.add('out'); setTimeout(() => t.remove(), 280); }, dur);
        }

        /* ===== BACK TO TOP ===== */
        const btt = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            btt.style.opacity = window.pageYOffset > 280 ? '1' : '0';
            btt.style.transform = window.pageYOffset > 280 ? 'translateY(0)' : 'translateY(8px)';
            btt.style.pointerEvents = window.pageYOffset > 280 ? 'all' : 'none';
        });
        btt.addEventListener('click', () => scrollTo({ top: 0, behavior: 'smooth' }));

        render();
    </script>
</body>

</html>

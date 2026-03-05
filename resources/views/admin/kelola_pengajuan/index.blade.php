@extends('layouts.admin')

@section('title', 'Kelola Pengajuan - KlikAset')

@section('content')

    {{-- ===== SECTION 1: Statistik + Search ===== --}}
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

            {{-- Disetujui --}}
            <div class="bg-white rounded-[20px] border-2 border-gray-100 p-4 lg:p-5 flex items-center gap-4 shadow-sm">
                <div class="w-12 h-12 lg:w-14 lg:h-14 bg-blue-100 rounded-[16px] flex items-center justify-center shrink-0">
                    <x-icon-checklist-minimalistic class="w-7 h-7 lg:w-8 lg:h-8 text-blue-500" />
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium leading-tight">Total Disetujui<br>Bulan ini</p>
                    <p class="text-3xl lg:text-4xl font-bold text-gray-900 mt-0.5" id="statApproved">0</p>
                </div>
            </div>

            {{-- Ditolak --}}
            <div class="bg-white rounded-[20px] border-2 border-gray-100 p-4 lg:p-5 flex items-center gap-4 shadow-sm">
                <div class="w-12 h-12 lg:w-14 lg:h-14 bg-red-100 rounded-[16px] flex items-center justify-center shrink-0">
                    <x-icon-forbidden-circle class="w-7 h-7 lg:w-8 lg:h-8 text-red-500" />
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium leading-tight">Total Ditolak<br>Bulan ini</p>
                    <p class="text-3xl lg:text-4xl font-bold text-gray-900 mt-0.5" id="statRejected">0</p>
                </div>
            </div>

            {{-- Menunggu --}}
            <div class="bg-white rounded-[20px] border-2 border-gray-100 p-4 lg:p-5 flex items-center gap-4 shadow-sm">
                <div
                    class="w-12 h-12 lg:w-14 lg:h-14 bg-yellow-100 rounded-[16px] flex items-center justify-center shrink-0">
                    <x-icon-hourglass class="w-7 h-7 lg:w-8 lg:h-8 text-yellow-400" />
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium leading-tight">Menunggu<br>Persetujuan</p>
                    <p class="text-3xl lg:text-4xl font-bold text-gray-900 mt-0.5" id="statPending">0</p>
                </div>
            </div>

        </div>

        {{-- Search --}}
        <div class="relative">
            <input type="text" id="adminSearch" placeholder="Cari nama peminjam atau barang..."
                class="w-full bg-white border-2 border-gray-200 rounded-[30px] px-5 py-3 pr-12 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 text-sm transition" />
            <x-icon-magnifer class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" />
        </div>

    </div>

    {{-- ===== SECTION 2: Tabel Pengajuan ===== --}}
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full min-w-[750px]">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/80">
                        <th class="p-4 text-left font-semibold text-xs lg:text-sm text-gray-600">Nama Peminjam</th>
                        <th class="p-4 text-left font-semibold text-xs lg:text-sm text-gray-600">Barang</th>
                        <th class="p-4 text-left font-semibold text-xs lg:text-sm text-gray-600">Keperluan</th>
                        <th class="p-4 text-left font-semibold text-xs lg:text-sm text-gray-600">Tgl Pinjam</th>
                        <th class="p-4 text-left font-semibold text-xs lg:text-sm text-gray-600">Tgl Kembali</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-600">Status</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody id="adminTableBody">
                    {{-- Rows diisi oleh JavaScript --}}
                    <tr id="emptyRow">
                        <td colspan="7" class="py-16 text-center">
                            <p class="text-4xl mb-3">📭</p>
                            <p class="font-semibold text-gray-500 text-sm">Belum ada pengajuan masuk</p>
                            <p class="text-xs text-gray-400 mt-1">Pengajuan dari halaman Pilih Barang akan muncul di sini
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Footer Tabel --}}
        <div
            class="flex flex-col sm:flex-row items-center justify-between p-4 lg:p-5 bg-gray-50/50 border-t border-gray-100 gap-3">
            <p class="text-xs lg:text-sm text-gray-500" id="tableInfo">
                Menampilkan <strong class="text-gray-800">0</strong> pengajuan
            </p>
            <div class="flex items-center gap-2 flex-wrap justify-center" id="adminPagination"></div>
        </div>

    </div>

@endsection


@push('scripts')
    <script>
        /* ============================================================
           KlikAset — Admin Kelola Pengajuan
           Membaca data dari localStorage key: 'klikaset_submissions'
           yang ditulis oleh halaman user (pilih-barang)
           ============================================================ */

        const ADMIN_PER_PAGE = 10;
        let adminPage = 1;
        let adminSearch = '';
        let allData = [];   // semua submission dari localStorage

        /* ---- Format tanggal ---- */
        function fmtDate(d) {
            return new Date(d).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
        }

        /* ---- Baca & simpan ke localStorage ---- */
        function loadData() {
            allData = JSON.parse(localStorage.getItem('klikaset_submissions') || '[]');
        }
        function saveData() {
            localStorage.setItem('klikaset_submissions', JSON.stringify(allData));
        }

        /* ---- Update stat cards ---- */
        function updateStats() {
            document.getElementById('statApproved').textContent = allData.filter(s => s.status === 'approved').length;
            document.getElementById('statRejected').textContent = allData.filter(s => s.status === 'rejected').length;
            document.getElementById('statPending').textContent = allData.filter(s => s.status === 'pending').length;
        }

        /* ---- Render tabel ---- */
        function renderTable() {
            loadData();
            updateStats();

            let list = [...allData];

            /* filter search */
            if (adminSearch.trim()) {
                const q = adminSearch.toLowerCase();
                list = list.filter(s =>
                    s.nama.toLowerCase().includes(q) ||
                    s.barang.toLowerCase().includes(q) ||
                    (s.kelas && s.kelas.toLowerCase().includes(q))
                );
            }

            const total = list.length;
            const pages = Math.max(1, Math.ceil(total / ADMIN_PER_PAGE));
            if (adminPage > pages) adminPage = 1;

            const slice = list.slice((adminPage - 1) * ADMIN_PER_PAGE, adminPage * ADMIN_PER_PAGE);

            const tbody = document.getElementById('adminTableBody');
            tbody.innerHTML = '';

            /* info bawah tabel */
            const start = total === 0 ? 0 : (adminPage - 1) * ADMIN_PER_PAGE + 1;
            const end = Math.min(adminPage * ADMIN_PER_PAGE, total);
            document.getElementById('tableInfo').innerHTML =
                total === 0
                    ? 'Menampilkan <strong class="text-gray-800">0</strong> pengajuan'
                    : `Menampilkan <strong class="text-gray-800">${start}–${end}</strong> dari <strong class="text-gray-800">${total}</strong> pengajuan`;

            /* empty state */
            if (slice.length === 0) {
                tbody.innerHTML = `
                <tr id="emptyRow">
                    <td colspan="7" class="py-16 text-center">
                        <p class="text-4xl mb-3">📭</p>
                        <p class="font-semibold text-gray-500 text-sm">Belum ada pengajuan masuk</p>
                        <p class="text-xs text-gray-400 mt-1">Pengajuan dari halaman Pilih Barang akan muncul di sini</p>
                    </td>
                </tr>`;
                renderPagination(1, 1);
                return;
            }

            /* baris data */
            slice.forEach(s => {
                const statusBadge = {
                    pending: `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-50 text-yellow-700 border border-yellow-200">⏳ Menunggu</span>`,
                    approved: `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">✅ Disetujui</span>`,
                    rejected: `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">❌ Ditolak</span>`,
                }[s.status] || '';

                const aksi = s.status === 'pending'
                    ? `<div class="flex gap-1.5 justify-center">
                        <button onclick="updateStatus(${s.id},'approved')"
                            class="px-4 py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-[30px] border border-green-200 hover:bg-green-200 transition cursor-pointer">
                            Terima
                        </button>
                        <button onclick="updateStatus(${s.id},'rejected')"
                            class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 hover:bg-red-200 transition cursor-pointer">
                            Tolak
                        </button>
                   </div>`
                    : `<p class="text-xs text-gray-400 text-center italic">Sudah diproses</p>`;

                const tr = document.createElement('tr');
                tr.className = 'border-b border-gray-100 hover:bg-gray-50/50 transition';
                tr.innerHTML = `
                <td class="p-4">
                    <p class="font-medium text-sm text-gray-800">${s.nama}</p>
                    <p class="text-xs text-gray-400">${s.kelas ?? ''} · ${s.nipd ?? ''}</p>
                    <p class="text-xs text-gray-400">${s.hp ?? ''}</p>
                </td>
                <td class="p-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-10 h-10 rounded-xl overflow-hidden flex-shrink-0 bg-gray-100">
                            <img src="${s.barangImg ?? ''}" alt="${s.barang}" class="w-full h-full object-cover"
                                 onerror="this.style.display='none'">
                        </div>
                        <p class="font-medium text-sm text-gray-800">${s.barang}</p>
                    </div>
                </td>
                <td class="p-4 text-xs text-gray-600 max-w-[140px]">
                    <span class="line-clamp-2">${s.keperluan ?? '-'}</span>
                </td>
                <td class="p-4">
                    <p class="font-semibold text-sm text-gray-800">${fmtDate(s.tglPinjam)}</p>
                </td>
                <td class="p-4">
                    <p class="font-semibold text-sm text-gray-800">${fmtDate(s.tglKembali)}</p>
                </td>
                <td class="p-4 text-center">${statusBadge}</td>
                <td class="p-4">${aksi}</td>`;
                tbody.appendChild(tr);
            });

            renderPagination(adminPage, pages);
        }

        /* ---- Pagination ---- */
        function renderPagination(cur, total) {
            const pg = document.getElementById('adminPagination');
            pg.innerHTML = '';

            if (total <= 1) return;

            const mk = (lbl, disabled, cb, active = false) => {
                const b = document.createElement('button');
                b.className = `h-8 lg:h-10 px-3 rounded-[30px] border-2 text-xs lg:text-sm font-medium transition flex items-center justify-center
                ${active
                        ? 'border-blue-600 bg-blue-600 text-white shadow-sm'
                        : 'border-gray-100 bg-white text-gray-700 hover:bg-gray-100'}
                ${disabled ? 'opacity-40 cursor-not-allowed' : 'cursor-pointer'}`;
                b.innerHTML = lbl; b.disabled = disabled;
                if (cb && !disabled) b.onclick = cb;
                return b;
            };

            pg.appendChild(mk('&laquo; Sebelumnya', cur === 1, () => { adminPage--; renderTable(); }));

            let pages = [];
            if (total <= 5) for (let i = 1; i <= total; i++) pages.push(i);
            else { pages.push(1); if (cur > 3) pages.push('...'); for (let i = Math.max(2, cur - 1); i <= Math.min(total - 1, cur + 1); i++) pages.push(i); if (cur < total - 2) pages.push('...'); pages.push(total); }

            pages.forEach(p => {
                if (p === '...') {
                    const s = document.createElement('span');
                    s.className = 'text-gray-400 font-bold px-1'; s.textContent = '···'; pg.appendChild(s);
                } else {
                    pg.appendChild(mk(p, false, () => { adminPage = p; renderTable(); }, p === cur));
                }
            });

            pg.appendChild(mk('Selanjutnya &raquo;', cur === total, () => { adminPage++; renderTable(); }));
        }

        /* ---- Terima / Tolak ---- */
        function updateStatus(id, status) {
            loadData();
            const sub = allData.find(s => s.id === id);
            if (!sub) return;
            sub.status = status;
            saveData();
            renderTable();
        }

        /* ---- Search ---- */
        document.getElementById('adminSearch').addEventListener('input', function () {
            adminSearch = this.value;
            adminPage = 1;
            renderTable();
        });

        /* ---- Auto-refresh setiap 5 detik (opsional, cocok saat dev) ---- */
        setInterval(renderTable, 5000);

        /* ---- Init ---- */
        renderTable();
    </script>
@endpush
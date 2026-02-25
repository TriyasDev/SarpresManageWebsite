<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KlikAset - Pilih Barang</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --blue: #2563eb;
            --blue-dark: #1d4ed8;
            --blue-light: #eff6ff;
            --green: #16a34a;
            --orange: #ea580c;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.08), 0 1px 2px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.10), 0 2px 6px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.12), 0 4px 12px rgba(0, 0, 0, 0.07);
            --shadow-xl: 0 20px 60px rgba(37, 99, 235, 0.15), 0 8px 24px rgba(0, 0, 0, 0.08);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
            min-height: 100vh;
        }

        /* ---- STICKY HEADER ---- */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
        }

        .header-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 16px 24px;
        }

        /* ---- SEARCH ---- */
        .search-wrap {
            position: relative;
            margin-bottom: 14px;
        }

        .search-input {
            width: 100%;
            border: 2px solid var(--gray-200);
            border-radius: 50px;
            padding: 12px 52px 12px 22px;
            font-size: 15px;
            font-family: inherit;
            outline: none;
            background: var(--gray-50);
            color: var(--gray-800);
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }

        .search-input:focus {
            border-color: var(--blue);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .search-input::placeholder {
            color: var(--gray-400);
        }

        .search-icon {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            width: 22px;
            height: 22px;
            color: var(--gray-400);
            pointer-events: none;
            transition: color 0.2s;
        }

        .search-input:focus~.search-icon {
            color: var(--blue);
        }

        .search-clear {
            display: none;
            position: absolute;
            right: 46px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            background: var(--gray-300);
            border: none;
            border-radius: 50%;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: white;
            font-weight: 700;
            transition: background 0.15s;
            line-height: 1;
            padding: 0;
        }

        .search-clear:hover {
            background: var(--gray-500);
        }

        /* ---- FILTER BUTTONS ---- */
        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 12px;
        }

        .filter-btn {
            padding: 7px 18px;
            border: 2px solid var(--gray-300);
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            background: white;
            color: var(--gray-700);
            transition: all 0.18s cubic-bezier(.4, 0, .2, 1);
            position: relative;
            overflow: hidden;
        }

        .filter-btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--gray-900);
            border-radius: inherit;
            transform: scale(0);
            opacity: 0;
            transition: transform 0.25s, opacity 0.25s;
        }

        .filter-btn:hover {
            border-color: var(--gray-600);
            transform: translateY(-1px);
        }

        .filter-btn.active {
            background: var(--gray-900);
            border-color: var(--gray-900);
            color: white;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);
            transform: translateY(-1px);
        }

        .filter-btn .count-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            padding: 0 6px;
            font-size: 11px;
            margin-left: 4px;
            vertical-align: middle;
        }

        .filter-btn:not(.active) .count-badge {
            background: var(--gray-100);
            color: var(--gray-500);
        }

        /* ---- SORT & COUNT ROW ---- */
        .sort-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .sort-label {
            font-size: 14px;
            color: var(--gray-600);
            font-weight: 500;
        }

        .sort-select {
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            padding: 7px 14px;
            font-size: 13px;
            font-family: inherit;
            font-weight: 600;
            outline: none;
            background: white;
            color: var(--gray-800);
            cursor: pointer;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .sort-select:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .item-count {
            font-size: 13px;
            color: var(--gray-500);
        }

        .item-count strong {
            color: var(--gray-800);
        }

        /* ---- GRID ---- */
        main {
            max-width: 1280px;
            margin: 0 auto;
            padding: 28px 24px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 22px;
        }

        /* ---- CARD ---- */
        .card {
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            overflow: hidden;
            transition: transform 0.28s cubic-bezier(.4, 0, .2, 1), box-shadow 0.28s;
            cursor: pointer;
            position: relative;
            animation: cardIn 0.4s ease both;
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(22px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .card:hover {
            transform: translateY(-6px) scale(1.01);
            box-shadow: var(--shadow-xl);
        }

        .card.hidden {
            display: none;
        }

        .card-image {
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            font-size: 36px;
        }

        .card-image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 40%, rgba(0, 0, 0, 0.12) 100%);
        }

        .card-badges {
            position: absolute;
            top: 12px;
            left: 12px;
            right: 12px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .badge-avail {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            border-radius: 50px;
            padding: 5px 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            box-shadow: var(--shadow-sm);
        }

        .badge-avail .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .badge-avail .dot.green {
            background: var(--green);
        }

        .badge-avail .dot.orange {
            background: var(--orange);
        }

        .badge-avail .dot.red {
            background: #dc2626;
        }

        .badge-rating {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            border-radius: 50px;
            padding: 5px 10px;
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            font-weight: 700;
            box-shadow: var(--shadow-sm);
        }

        .star {
            color: #f59e0b;
            font-size: 14px;
        }

        .card-body {
            padding: 18px 20px 20px;
        }

        .cat-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 10px;
        }

        .cat-badge.elektronik {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .cat-badge.multimedia {
            background: #fce7f3;
            color: #be185d;
        }

        .cat-badge.prasarana {
            background: #dcfce7;
            color: #15803d;
        }

        .cat-badge.perlengkapan {
            background: #fef3c7;
            color: #b45309;
        }

        .cat-badge.fasilitas {
            background: #f3e8ff;
            color: #7e22ce;
        }

        .card-title {
            font-family: 'Outfit', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 6px;
        }

        .card-desc {
            font-size: 13px;
            color: var(--gray-500);
            margin-bottom: 14px;
            line-height: 1.55;
        }

        .card-meta {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-bottom: 16px;
        }

        .card-meta-row {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 13px;
            color: var(--gray-700);
        }

        .meta-icon {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .pinjam-btn {
            width: 100%;
            background: var(--blue);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.18s, transform 0.15s, box-shadow 0.18s;
            position: relative;
            overflow: hidden;
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

        .pinjam-btn:hover {
            background: var(--blue-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
        }

        .pinjam-btn:active {
            transform: translateY(0);
            box-shadow: none;
        }

        .pinjam-btn .btn-icon {
            width: 18px;
            height: 18px;
            transition: transform 0.2s;
        }

        .pinjam-btn:hover .btn-icon {
            transform: translateX(4px);
        }

        .pinjam-btn.added {
            background: var(--green);
            box-shadow: 0 6px 20px rgba(22, 163, 74, 0.3);
        }

        /* ---- EMPTY STATE ---- */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            display: none;
        }

        .empty-state .empty-icon {
            font-size: 56px;
            margin-bottom: 12px;
        }

        .empty-state h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--gray-700);
            margin-bottom: 6px;
        }

        .empty-state p {
            color: var(--gray-400);
            font-size: 14px;
        }

        /* ---- PAGINATION ---- */
        .pagination-wrap {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            margin-top: 40px;
            gap: 12px;
        }

        .page-info {
            font-size: 13px;
            color: var(--gray-500);
        }

        .page-info strong {
            color: var(--gray-800);
        }

        .pagination {
            display: flex;
            gap: 6px;
            align-items: center;
            flex-wrap: wrap;
        }

        .page-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid var(--gray-200);
            background: white;
            font-size: 14px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.18s;
            color: var(--gray-700);
        }

        .page-btn:hover:not(:disabled):not(.active) {
            border-color: var(--blue);
            color: var(--blue);
            transform: scale(1.08);
        }

        .page-btn.active {
            background: var(--blue);
            border-color: var(--blue);
            color: white;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .page-btn:disabled {
            opacity: 0.35;
            cursor: not-allowed;
        }

        .page-dots {
            color: var(--gray-400);
            font-weight: 700;
            padding: 0 4px;
            font-size: 16px;
        }

        /* ---- TOAST ---- */
        .toast-container {
            position: fixed;
            bottom: 80px;
            right: 24px;
            z-index: 999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }

        .toast {
            background: var(--gray-900);
            color: white;
            padding: 12px 20px;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 600;
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: center;
            gap: 10px;
            animation: toastIn 0.3s cubic-bezier(.4, 0, .2, 1) forwards;
            pointer-events: all;
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateY(16px) scale(0.95);
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
                transform: translateY(10px) scale(0.9);
            }
        }

        /* ---- CART BUBBLE ---- */
        .cart-bubble {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 56px;
            height: 56px;
            background: var(--blue);
            color: white;
            border-radius: 50%;
            box-shadow: var(--shadow-xl);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            z-index: 200;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .cart-bubble:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 30px rgba(37, 99, 235, 0.4);
        }

        .cart-bubble .cart-count {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 22px;
            height: 22px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            font-size: 11px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
            transition: transform 0.2s;
            display: none;
        }

        .cart-bubble .cart-count.show {
            display: flex;
            animation: bounceIn 0.3s ease;
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0);
            }

            60% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        /* ---- MODAL ---- */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(6px);
            z-index: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s;
        }

        .modal-overlay.open {
            opacity: 1;
            pointer-events: all;
        }

        .modal {
            background: white;
            border-radius: 24px;
            padding: 32px;
            max-width: 460px;
            width: 100%;
            box-shadow: var(--shadow-xl);
            transform: scale(0.94) translateY(20px);
            transition: transform 0.28s cubic-bezier(.4, 0, .2, 1);
        }

        .modal-overlay.open .modal {
            transform: scale(1) translateY(0);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .modal-title {
            font-family: 'Outfit', sans-serif;
            font-size: 22px;
            font-weight: 800;
            color: var(--gray-900);
        }

        .modal-close {
            background: var(--gray-100);
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            cursor: pointer;
            font-size: 18px;
            color: var(--gray-600);
            transition: background 0.15s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            background: var(--gray-200);
        }

        .modal-img {
            height: 120px;
            border-radius: 16px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
        }

        .modal-info {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
        }

        .modal-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }

        .modal-row span:first-child {
            color: var(--gray-500);
        }

        .modal-row span:last-child {
            font-weight: 600;
            color: var(--gray-800);
        }

        .modal-actions {
            display: flex;
            gap: 10px;
        }

        .btn-secondary {
            flex: 1;
            padding: 12px;
            border-radius: 12px;
            border: 2px solid var(--gray-200);
            background: white;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.18s;
            color: var(--gray-700);
        }

        .btn-secondary:hover {
            border-color: var(--gray-400);
            background: var(--gray-50);
        }

        .btn-primary {
            flex: 2;
            padding: 12px;
            border-radius: 12px;
            border: none;
            background: var(--blue);
            color: white;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.18s;
        }

        .btn-primary:hover {
            background: var(--blue-dark);
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
        }

        /* ---- BACK TO TOP ---- */
        .back-to-top {
            position: fixed;
            bottom: 90px;
            right: 24px;
            width: 44px;
            height: 44px;
            background: var(--gray-800);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-md);
            z-index: 199;
            opacity: 0;
            transform: translateY(10px);
            pointer-events: none;
            transition: opacity 0.25s, transform 0.25s, background 0.18s;
            font-size: 18px;
        }

        .back-to-top.show {
            opacity: 1;
            transform: translateY(0);
            pointer-events: all;
        }

        .back-to-top:hover {
            background: var(--gray-900);
        }

        /* ---- SKELETON ---- */
        @keyframes shimmer {
            0% {
                background-position: -400px 0;
            }

            100% {
                background-position: 400px 0;
            }
        }

        .skeleton {
            background: linear-gradient(90deg, var(--gray-200) 25%, var(--gray-100) 50%, var(--gray-200) 75%);
            background-size: 800px 100%;
            animation: shimmer 1.4s infinite linear;
            border-radius: 8px;
        }

        /* ---- RESPONSIVE ---- */
        @media (max-width: 600px) {
            .header-inner {
                padding: 12px 16px;
            }

            main {
                padding: 18px 14px;
            }

            .product-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .pagination-wrap {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <div class="header-inner">
            <!-- Search -->
            <div class="search-wrap">
                <input type="text" id="searchInput" class="search-input"
                    placeholder="Cari barang... (nama atau kategori)">
                <button class="search-clear" id="searchClear" title="Hapus">✕</button>
                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <!-- Filter -->
            <div class="filter-row" id="filterRow">
                <button class="filter-btn active" data-cat="semua">Semua <span class="count-badge"
                        id="cntSemua">9</span></button>
                <button class="filter-btn" data-cat="prasarana">Prasarana <span class="count-badge"
                        id="cntPrasarana">2</span></button>
                <button class="filter-btn" data-cat="elektronik">Elektronik <span class="count-badge"
                        id="cntElektronik">3</span></button>
                <button class="filter-btn" data-cat="multimedia">Multimedia <span class="count-badge"
                        id="cntMultimedia">2</span></button>
                <button class="filter-btn" data-cat="perlengkapan">Perlengkapan Kelas <span class="count-badge"
                        id="cntPerlengkapan">1</span></button>
                <button class="filter-btn" data-cat="fasilitas">Fasilitas Penunjang <span class="count-badge"
                        id="cntFasilitas">1</span></button>
            </div>

            <!-- Sort -->
            <div class="sort-row">
                <div style="display:flex;align-items:center;gap:10px;">
                    <span class="sort-label">Urutkan:</span>
                    <select class="sort-select" id="sortSelect">
                        <option value="popular">Terpopuler</option>
                        <option value="rating">Rating Tertinggi</option>
                        <option value="newest">Terbaru</option>
                        <option value="nameaz">Nama A-Z</option>
                        <option value="avail">Ketersediaan</option>
                    </select>
                </div>
                <div class="item-count" id="itemCount">Menampilkan <strong id="shownCount">9</strong> dari
                    <strong>9</strong> barang</div>
            </div>
        </div>
    </div>

    <!-- MAIN -->
    <main>
        <div class="product-grid" id="productGrid">
            <!-- Cards rendered by JS -->
            <div class="empty-state" id="emptyState">
                <div class="empty-icon">🔍</div>
                <h3>Barang tidak ditemukan</h3>
                <p>Coba kata kunci lain atau ubah filter kategori</p>
            </div>
        </div>

        <!-- PAGINATION -->
        <div class="pagination-wrap" id="paginationWrap">
            <p class="page-info" id="pageInfo">Halaman <strong>1</strong> dari <strong>1</strong></p>
            <div class="pagination" id="pagination"></div>
        </div>
    </main>

    <!-- TOAST -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- CART BUBBLE -->
    <button class="cart-bubble" id="cartBubble" title="Keranjang Peminjaman">
        🛒
        <span class="cart-count" id="cartCount">0</span>
    </button>

    <!-- BACK TO TOP -->
    <button class="back-to-top" id="backToTop" title="Kembali ke atas">↑</button>

    <!-- MODAL -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <div class="modal-header">
                <span class="modal-title" id="modalTitle">Detail Barang</span>
                <button class="modal-close" id="modalClose">✕</button>
            </div>
            <div class="modal-img" id="modalImg"></div>
            <div class="modal-info" id="modalInfo"></div>
            <div class="modal-actions">
                <button class="btn-secondary" id="modalCancel">Batal</button>
                <button class="btn-primary" id="modalConfirm">✓ Tambah ke Peminjaman</button>
            </div>
        </div>
    </div>

    <script>
        /* ===== DATA ===== */
        const PRODUCTS = [
            { id: 1, name: "Monitor Dell 24\"", cat: "elektronik", desc: "Monitor Full HD untuk presentasi dan editing.", avail: 15, maxDay: 7, rating: 4.8, cond: "Sangat Baik", emoji: "", bg: "#dbeafe", pop: 95, newest: 7 },
            { id: 2, name: "Laptop Asus ROG", cat: "elektronik", desc: "Laptop performa tinggi untuk rendering dan coding.", avail: 8, maxDay: 5, rating: 4.9, cond: "Sangat Baik", emoji: "", bg: "#ede9fe", pop: 99, newest: 2 },
            { id: 3, name: "Proyektor Epson", cat: "multimedia", desc: "Proyektor HD dengan gambar jernih untuk presentasi.", avail: 5, maxDay: 3, rating: 4.7, cond: "Sangat Baik", emoji: "", bg: "#fce7f3", pop: 88, newest: 5 },
            { id: 4, name: "Kamera DSLR Canon", cat: "multimedia", desc: "Kamera profesional untuk dokumentasi dan fotografi.", avail: 3, maxDay: 4, rating: 4.9, cond: "Baik", emoji: "", bg: "#fef3c7", pop: 90, newest: 1 },
            { id: 5, name: "Meja Kerja Lipat", cat: "prasarana", desc: "Meja lipat ringan cocok untuk kegiatan luar ruang.", avail: 20, maxDay: 14, rating: 4.5, cond: "Baik", emoji: "", bg: "#dcfce7", pop: 70, newest: 9 },
            { id: 6, name: "Kursi Ergonomis", cat: "prasarana", desc: "Kursi nyaman dengan sandaran tulang belakang.", avail: 12, maxDay: 10, rating: 4.6, cond: "Sangat Baik", emoji: "", bg: "#f0fdf4", pop: 75, newest: 6 },
            { id: 7, name: "Papan Tulis Portabel", cat: "perlengkapan", desc: "Papan tulis magnetik yang mudah dibawa kemana saja.", avail: 7, maxDay: 7, rating: 4.4, cond: "Baik", emoji: "", bg: "#fff7ed", pop: 60, newest: 8 },
            { id: 8, name: "Speaker Bluetooth JBL", cat: "elektronik", desc: "Speaker portabel dengan suara jernih dan bass kuat.", avail: 6, maxDay: 3, rating: 4.7, cond: "Sangat Baik", emoji: "", bg: "#ffe4e6", pop: 82, newest: 3 },
            { id: 9, name: "Panel Surya Portable", cat: "fasilitas", desc: "Panel surya untuk pengisian daya saat kegiatan outdoor.", avail: 4, maxDay: 5, rating: 4.6, cond: "Baik", emoji: "", bg: "#fefce8", pop: 65, newest: 4 },
        ];

        const ITEMS_PER_PAGE = 6;
        let currentPage = 1;
        let activeFilter = "semua";
        let currentSearch = "";
        let currentSort = "popular";
        let cart = [];
        let selectedProduct = null;

        /* ===== HELPERS ===== */
        function getAvailDot(n) {
            if (n >= 10) return 'green';
            if (n >= 5) return 'orange';
            return 'red';
        }
        function getAvailText(n) {
            if (n >= 10) return `${n} Tersedia`;
            if (n >= 5) return `${n} Tersedia`;
            return `${n} Tersisa!`;
        }
        function filtered() {
            let list = [...PRODUCTS];
            if (activeFilter !== 'semua') list = list.filter(p => p.cat === activeFilter);
            if (currentSearch.trim()) {
                const q = currentSearch.toLowerCase();
                list = list.filter(p => p.name.toLowerCase().includes(q) || p.cat.toLowerCase().includes(q) || p.desc.toLowerCase().includes(q));
            }
            // sort
            if (currentSort === 'rating') list.sort((a, b) => b.rating - a.rating);
            else if (currentSort === 'newest') list.sort((a, b) => a.newest - b.newest);
            else if (currentSort === 'nameaz') list.sort((a, b) => a.name.localeCompare(b.name));
            else if (currentSort === 'avail') list.sort((a, b) => b.avail - a.avail);
            else list.sort((a, b) => b.pop - a.pop);
            return list;
        }

        function createCard(p, delay) {
            const inCart = cart.includes(p.id);
            const dotClass = getAvailDot(p.avail);
            const catLabel = { elektronik: 'Elektronik', multimedia: 'Multimedia', prasarana: 'Prasarana', perlengkapan: 'Perlengkapan Kelas', fasilitas: 'Fasilitas Penunjang' }[p.cat] || p.cat;
            return `
    <div class="card" data-id="${p.id}" style="animation-delay:${delay}ms">
        <div class="card-image" style="background:${p.bg}">
            <span style="font-size:52px">${p.emoji}</span>
            <div class="card-image-overlay"></div>
            <div class="card-badges">
                <div class="badge-avail">
                    <div class="dot ${dotClass}"></div>
                    <span>${getAvailText(p.avail)}</span>
                </div>
                <div class="badge-rating">
                    <span class="star">★</span>
                    <span>${p.rating}</span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <span class="cat-badge ${p.cat}">${catLabel}</span>
            <h3 class="card-title">${p.name}</h3>
            <p class="card-desc">${p.desc}</p>
            <div class="card-meta">
                <div class="card-meta-row">
                    <svg class="meta-icon" fill="currentColor" style="color:#16a34a" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>Kondisi: ${p.cond}</span>
                </div>
                <div class="card-meta-row">
                    <svg class="meta-icon" fill="currentColor" style="color:#2563eb" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                    <span>Maksimal: ${p.maxDay} hari</span>
                </div>
            </div>
            <button class="pinjam-btn ${inCart ? 'added' : ''}" data-id="${p.id}" onclick="handlePinjam(event,${p.id})">
                ${inCart ? '✓ Ditambahkan' : 'Pinjam Sekarang'}
                ${!inCart ? `<svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>` : ''}
            </button>
        </div>
    </div>`;
        }

        /* ===== RENDER ===== */
        function render() {
            const list = filtered();
            const total = list.length;
            const totalPages = Math.max(1, Math.ceil(total / ITEMS_PER_PAGE));
            if (currentPage > totalPages) currentPage = 1;
            const start = (currentPage - 1) * ITEMS_PER_PAGE;
            const page = list.slice(start, start + ITEMS_PER_PAGE);

            const grid = document.getElementById('productGrid');
            const empty = document.getElementById('emptyState');

            // Remove old cards (keep empty state)
            grid.querySelectorAll('.card').forEach(c => c.remove());

            if (page.length === 0) {
                empty.style.display = 'block';
            } else {
                empty.style.display = 'none';
                page.forEach((p, i) => {
                    grid.insertAdjacentHTML('beforeend', createCard(p, i * 60));
                });
            }

            document.getElementById('shownCount').textContent = page.length;
            document.getElementById('pageInfo').innerHTML = `Halaman <strong>${currentPage}</strong> dari <strong>${totalPages}</strong>`;

            renderPagination(currentPage, totalPages);
        }

        function renderPagination(cur, total) {
            const pg = document.getElementById('pagination');
            pg.innerHTML = '';

            const prev = document.createElement('button');
            prev.className = 'page-btn';
            prev.innerHTML = '&#8592;';
            prev.disabled = cur === 1;
            prev.onclick = () => { if (cur > 1) { currentPage--; render(); window.scrollTo({ top: 0, behavior: 'smooth' }); } };
            pg.appendChild(prev);

            let pages = [];
            if (total <= 5) { for (let i = 1; i <= total; i++) pages.push(i); }
            else {
                pages.push(1);
                if (cur > 3) pages.push('...');
                for (let i = Math.max(2, cur - 1); i <= Math.min(total - 1, cur + 1); i++) pages.push(i);
                if (cur < total - 2) pages.push('...');
                pages.push(total);
            }

            pages.forEach(p => {
                if (p === '...') {
                    const d = document.createElement('span');
                    d.className = 'page-dots';
                    d.textContent = '···';
                    pg.appendChild(d);
                } else {
                    const btn = document.createElement('button');
                    btn.className = 'page-btn' + (p === cur ? ' active' : '');
                    btn.textContent = p;
                    btn.onclick = () => { currentPage = p; render(); window.scrollTo({ top: 0, behavior: 'smooth' }); };
                    pg.appendChild(btn);
                }
            });

            const next = document.createElement('button');
            next.className = 'page-btn';
            next.innerHTML = '&#8594;';
            next.disabled = cur === total;
            next.onclick = () => { if (cur < total) { currentPage++; render(); window.scrollTo({ top: 0, behavior: 'smooth' }); } };
            pg.appendChild(next);
        }

        /* ===== SEARCH ===== */
        let searchTimeout;
        document.getElementById('searchInput').addEventListener('input', function () {
            currentSearch = this.value;
            document.getElementById('searchClear').style.display = this.value ? 'flex' : 'none';
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => { currentPage = 1; render(); }, 220);
        });
        document.getElementById('searchClear').addEventListener('click', function () {
            document.getElementById('searchInput').value = '';
            currentSearch = '';
            this.style.display = 'none';
            currentPage = 1;
            render();
            document.getElementById('searchInput').focus();
        });

        /* ===== FILTER ===== */
        document.getElementById('filterRow').addEventListener('click', function (e) {
            const btn = e.target.closest('.filter-btn');
            if (!btn) return;
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            activeFilter = btn.dataset.cat;
            currentPage = 1;
            render();
        });

        /* ===== SORT ===== */
        document.getElementById('sortSelect').addEventListener('change', function () {
            currentSort = this.value;
            currentPage = 1;
            render();
        });

        /* ===== PINJAM / MODAL ===== */
        function handlePinjam(e, id) {
            e.stopPropagation();
            const p = PRODUCTS.find(x => x.id === id);
            if (!p) return;
            selectedProduct = p;
            openModal(p);
        }

        function openModal(p) {
            const catLabel = { elektronik: 'Elektronik', multimedia: 'Multimedia', prasarana: 'Prasarana', perlengkapan: 'Perlengkapan Kelas', fasilitas: 'Fasilitas Penunjang' }[p.cat] || p.cat;
            document.getElementById('modalTitle').textContent = p.name;
            document.getElementById('modalImg').style.background = p.bg;
            document.getElementById('modalImg').innerHTML = `<span style="font-size:52px">${p.emoji}</span>`;
            document.getElementById('modalInfo').innerHTML = `
        <div class="modal-row"><span>Kategori</span><span>${catLabel}</span></div>
        <div class="modal-row"><span>Ketersediaan</span><span style="color:${p.avail >= 5 ? '#16a34a' : '#dc2626'}">${p.avail} unit</span></div>
        <div class="modal-row"><span>Kondisi</span><span>${p.cond}</span></div>
        <div class="modal-row"><span>Rating</span><span>★ ${p.rating}</span></div>
        <div class="modal-row"><span>Maks. Peminjaman</span><span>${p.maxDay} hari</span></div>
    `;
            document.getElementById('modalOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('modalOverlay').classList.remove('open');
            document.body.style.overflow = '';
            selectedProduct = null;
        }

        document.getElementById('modalClose').onclick = closeModal;
        document.getElementById('modalCancel').onclick = closeModal;
        document.getElementById('modalOverlay').addEventListener('click', function (e) {
            if (e.target === this) closeModal();
        });

        document.getElementById('modalConfirm').onclick = function () {
            if (!selectedProduct) return;
            addToCart(selectedProduct);
            closeModal();
        };

        function addToCart(p) {
            if (!cart.includes(p.id)) {
                cart.push(p.id);
                showToast(`✓ ${p.name} ditambahkan ke peminjaman!`);
                updateCartBubble();
                render();
            } else {
                showToast(`ℹ️ ${p.name} sudah ada di keranjang`);
            }
        }

        /* ===== CART BUBBLE ===== */
        function updateCartBubble() {
            const cnt = document.getElementById('cartCount');
            cnt.textContent = cart.length;
            if (cart.length > 0) cnt.classList.add('show');
            else cnt.classList.remove('show');
        }

        document.getElementById('cartBubble').addEventListener('click', function () {
            if (cart.length === 0) {
                showToast('🛒 Keranjang masih kosong!');
                return;
            }
            const names = cart.map(id => PRODUCTS.find(p => p.id === id)?.name).filter(Boolean).join(', ');
            showToast(`🛒 ${cart.length} barang: ${names}`, 4000);
        });

        /* ===== TOAST ===== */
        function showToast(msg, dur = 2800) {
            const wrap = document.getElementById('toastContainer');
            const t = document.createElement('div');
            t.className = 'toast';
            t.textContent = msg;
            wrap.appendChild(t);
            setTimeout(() => {
                t.classList.add('out');
                setTimeout(() => t.remove(), 280);
            }, dur);
        }

        /* ===== BACK TO TOP ===== */
        const btt = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            btt.classList.toggle('show', window.pageYOffset > 300);
        });
        btt.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

        /* ===== CARD CLICK (DETAIL) ===== */
        document.getElementById('productGrid').addEventListener('click', function (e) {
            const card = e.target.closest('.card');
            if (!card || e.target.closest('.pinjam-btn')) return;
            const id = parseInt(card.dataset.id);
            const p = PRODUCTS.find(x => x.id === id);
            if (p) { selectedProduct = p; openModal(p); }
        });

        /* ===== INIT ===== */
        render();
    </script>
</body>

</html>
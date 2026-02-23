<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Toko Mas Sumatra - Official Store')</title>

    {{-- CSS & Fonts global --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font utama: Playfair Display (judul/logo), Lato (teks) --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        {{-- =========================================================
           STYLE DASAR APLIKASI
           ========================================================= --}}
        body { font-family: 'Lato', sans-serif; background-color: #f8f9fa; }
        h1, h2, h3, .navbar-brand { font-family: 'Playfair Display', serif; }

        .text-gold { color: #c5a059; }
        .bg-black { background-color: #1a1a1a !important; }
        .btn-gold { background-color: #c5a059; color: white; border: none; }
        .btn-gold:hover { background-color: #b08d4b; color: white; }

        {{-- =========================================================
           NAVBAR (HEADER) GLOBAL
           ========================================================= --}}
        .navbar {
            padding: 1rem 0.75rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-nav .nav-link {
            font-size: 0.9rem;
            font-weight: 400;
            letter-spacing: 0.02em;
            color: rgba(255, 255, 255, 0.8);
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: #ffffff;
        }

        .lang-switch a {
            font-size: 0.8rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #ffffff;
        }
        .lang-switch a.active {
            color: #c5a059;
        }

        .nav-icons {
            gap: 3rem;
        }
        .nav-icons a {
            color: rgba(255,255,255,0.75);
        }
        .nav-icons a:hover {
            color: #c5a059;
        }

        /* === WRAPPER NAVBAR FULL-WIDTH === */
        .navbar-full {
            width: 100%;
            padding-left: 2rem;
            padding-right: 2rem;
        }

        /* === Layout utama navbar: 3 kolom sama besar (kiri, tengah, kanan) === */
        .navbar-main-inner {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;  /* tiga kolom lebar sama */
            align-items: center;
            width: 100%;
            column-gap: 2rem;
        }

        /* Kiri: bahasa + menu, rata kiri */
        .navbar-main-left {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }

        /* Tengah: logo benar‑benar di tengah kolom tengah */
        .navbar-main-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Kanan: ikon rata kanan */
        .navbar-main-right {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        /* Di layar kecil, stack ke bawah */
        @media (max-width: 991.98px) {
            .navbar-full {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .navbar-main-inner {
                display: flex;
                flex-direction: column;
                align-items: stretch;
            }
            .navbar-main-left,
            .navbar-main-center,
            .navbar-main-right {
                align-items: center;
                justify-content: center;
            }
            .navbar-main-left { order: 2; }
            .navbar-main-center {
                order: 1;
                margin-bottom: 0.5rem;
            }
            .navbar-main-right { order: 3; }
        }

        {{-- =========================================================
           HERO, TICKER, DAN KARTU PRODUK
           ========================================================= --}}
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                        url('https://images.unsplash.com/photo-1573408301185-9146fe634ad0?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .price-ticker {
            background-color: #c5a059;
            color: white;
            padding: 10px 0;
            font-weight: bold;
        }

        .product-card {
            border: none;
            transition: transform 0.3s;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .product-img {
            height: 250px;
            object-fit: cover;
            width: 100%;
            background-color: #eee;
        }
        .price-tag {
            color: #c5a059;
            font-size: 1.2rem;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
        }

        {{-- =========================================================
           BANNER KOLEKSI
           ========================================================= --}}
        .collection-banner {
            background: #f6f6f6;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .collection-banner:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.12);
        }

        .collection-banner-box {
            width: 100%;
            height: 500px;
            background-color: #e9ecef;
            background-size: cover;
            background-position: center;
        }

        .collection-banner-body {
            padding: 16px 18px 20px;
            text-align: center;
        }

        .collection-banner-title {
            font-size: 2rem;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .collection-banner-link {
            font-size: 0.85rem;
            color: #7b1b4a;
            text-decoration: none;
        }
        .collection-banner-link:hover {
            text-decoration: underline;
        }

        {{-- =========================================================
           SLIDER KOLEKSI
           ========================================================= --}}
        .collection-slider-container {
            padding-left: 5rem;
            padding-right: 5rem;
        }

        @media (max-width: 768px) {
            .collection-slider-container {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }

        .collection-slider-wrapper {
            position: relative;
        }

        .collection-slider {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            gap: 0;
            padding-bottom: 8px;
        }

        .collection-slider::-webkit-scrollbar {
            display: none;
        }
        .collection-slider {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .collection-slider-item {
            flex: 0 0 calc(100% / 3);
            max-width: calc(100% / 3);
        }

        .collection-slider-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background-color: rgba(255,255,255,0.9);
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }

        /* dst... (style lain tetap) */

        @stack('styles')
            cursor: pointer;
        .collection-slider-arrow:hover {
            background-color: #f3e3bf;
        }
        .collection-slider-arrow-left {
            left: 2rem;
        }
        .collection-slider-arrow-right {
            right: 2rem;
        }

        {{-- =========================================================
           GRID FULL-WIDTH UNTUK TOP PRODUCTS & PRODUK TERBARU
           ========================================================= --}}
        .featured-products-container,
        .latest-products-container {
            padding-left: 10rem;
            padding-right: 10rem;
        }

        @media (max-width: 992px) {
            .featured-products-container,
            .latest-products-container {
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }

        .ratio-card .product-img {
            aspect-ratio: 5 / 4;
            height: auto;
        }

        .ratio-card-small .product-img {
            aspect-ratio: 8 / 4;
            height: auto;
        }

        @media (min-width: 1200px) {
            .col-xl-2-4 {
                flex: 0 0 20%;
                max-width: 20%;
            }
        }

        {{-- =========================================================
           STYLING "PRODUK TERBARU" – GAYA GALERI
           ========================================================= --}}
        .latest-gallery-container {
            padding-left: 10rem;
            padding-right: 10rem;
        }

        @media (max-width: 1200px) {
            .latest-gallery-container {
                padding-left: 4rem;
                padding-right: 4rem;
            }
        }

        @media (max-width: 768px) {
            .latest-gallery-container {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }

        .latest-gallery-card {
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.04);
            padding: 10px 10px 12px;
        }

        .latest-gallery-image-wrap {
            width: 100%;
            background-color: #f3f4f6;
            border-radius: 14px;
            overflow: hidden;
            height: 260px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .latest-gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .latest-gallery-info {
            padding: 8px 4px 0;
        }

        .latest-gallery-name {
            font-size: 0.95rem;
            font-weight: 600;
            color: #222;
            margin-bottom: 2px;
        }

        .latest-gallery-meta {
            font-size: 0.8rem;
            margin-bottom: 4px;
        }

        .latest-gallery-price {
            font-size: 0.95rem;
            font-weight: 700;
            color: #c5a059;
        }

        /* === Katalog: card produk di halaman /katalog === */
        .catalog-card {
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.04);
            padding: 10px 10px 12px;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .catalog-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        /* Thumbnail 1:1 */
        .catalog-thumb-wrap {
            width: 100%;
            background-color: #f3f4f6;
            border-radius: 14px;
            overflow: hidden;
            aspect-ratio: 1 / 1;   /* RASIO KOTAK 1:1 */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .catalog-thumb-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .catalog-card-body {
            padding: 8px 4px 0;
        }

        .catalog-name {
            font-size: 0.95rem;
            font-weight: 600;
            color: #222;
            margin-bottom: 2px;
        }

        .catalog-price {
            font-size: 0.95rem;
            font-weight: 700;
            color: #c5a059;
        }

        .catalog-location {
            font-size: 0.8rem;
        }

        /* === Sidebar Filter Katalog ===*/
        
        .catalog-filter-card {
            background: #ffffff;
            border-radius: 10px;                 /* sesuaikan kalau mau lebih tajam */
            border: 1px solid #eaeaea;
            padding: 18px 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        }
        .catalog-filter-card h6 {
            font-size: 0.95rem;
            letter-spacing: 0.03em;
            margin-bottom: 12px;
        }

        /* ---------------------------
        Pola baru: hidden input + label (catalog-filter-input + catalog-filter-label)
        --------------------------- */
        .catalog-filter-option {
            margin-bottom: 8px;
            position: relative;
        }

        /* sembunyikan input tapi tetap fokusable */
        .catalog-filter-input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        /* label sebagai pill (visual) */
        .catalog-filter-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 999px;                 /* pill shape */
            border: 1px solid transparent;
            font-size: 0.90rem;
            color: #374151;
            cursor: pointer;
            transition: background-color .12s ease, border-color .12s ease;
        }

        /* kotak kecil di kiri (visual only) */
        .catalog-filter-label::before {
            content: "";
            width: 14px;
            height: 14px;
            border-radius: 4px;                   /* small rounded square */
            border: 1px solid #d1d5db;
            background-color: #ffffff;
            box-sizing: border-box;
            display: inline-block;
        }

        /* hover effect pada label (subtle) */
        .catalog-filter-label:hover {
            background-color: #fbfbfb;
            border-color: #eee;
        }

        /* IMPORTANT: jangan ubah keseluruhan label saat checked.
        HANYA ubah kotak (::before) untuk menampilkan centang. */
        .catalog-filter-input:checked + .catalog-filter-label::before {
            border-color: #111827;
            background-color: #111827;
            background-image: url("data:image/svg+xml,%3Csvg width='10' height='8' viewBox='0 0 10 8' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 4L3.5 6.5L9 1' stroke='%23ffffff' stroke-width='1.4' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center;
        }

        /* label text tetap stabil saat checked */
        .catalog-filter-input:checked + .catalog-filter-label {
            border-color: transparent;
            background-color: transparent !important;
            color: inherit;
            font-weight: 400;
        }

        /* fokus hanya pada kotak kecil */
        .catalog-filter-input:focus + .catalog-filter-label::before {
            box-shadow: 0 0 0 3px rgba(17,24,39,0.06);
        }

        /* ---------------------------
        Pola lama (form-check) — tetap dukung jika masih ada sisa markup lama
        (.catalog-filter-check .form-check-input + .form-check-label)
        --------------------------- */
        .catalog-filter-check {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 4px;
            border-radius: 4px;
        }

        /* tampilkan kotak kecil, override default Bootstrap */
        .catalog-filter-check .form-check-input {
            width: 16px;
            height: 16px;
            margin-top: 0;
            border-radius: 3px;       /* kotak kecil */
            border: 1px solid #d1d5db;
            box-shadow: none;
            background-color: #ffffff;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            position: relative;
        }

        /* hover pada kotak kecil */
        .catalog-filter-check .form-check-input:hover {
            border-color: #9ca3af;
        }

        /* centang hitam pada kotak lama */
        .catalog-filter-check .form-check-input:checked {
            border-color: #111827;
            background-color: #111827;
        }
        .catalog-filter-check .form-check-input:checked::after {
            content: "✓";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -56%);
            font-size: 0.8rem;
            color: #ffffff;
        }

        /* pastikan label lama tidak berubah gaya saat checked */
        .catalog-filter-check .form-check-input:checked + .form-check-label {
            background-color: transparent;
            border-color: transparent;
            color: inherit;
            font-weight: 400;
        }

        /* fokus lembut untuk pola lama */
        .catalog-filter-check .form-check-input:focus {
            outline: none;
            box-shadow: 0 0 0 1px rgba(17,24,39,0.08);
        }

        /* sedikit spacing untuk link 'Hapus filter' */
        .catalog-filter-card .btn-link {
            margin-left: 0;
            margin-top: 6px;
            display: inline-block;
        }

        /* === Pagination Katalog === */
        .catalog-pagination-nav {
            display: flex;
            flex-direction: column;   /* angka di atas, teks di bawah */
            align-items: center;
            justify-content: center;
            gap: 4px;
            font-size: 0.85rem;
            color: #6b7280;
        }

        .catalog-pagination {
            --bs-pagination-padding-x: 0;   /* kita atur manual via width/height */
            --bs-pagination-padding-y: 0;
            --bs-pagination-border-radius: 999px;
            --bs-pagination-bg: #ffffff;
            --bs-pagination-border-color: #e5e7eb;
            --bs-pagination-color: #4b5563;
            --bs-pagination-hover-bg: #f3f4f6;
            --bs-pagination-hover-border-color: #e5e7eb;
            --bs-pagination-hover-color: #111827;
            --bs-pagination-active-bg: #c5a059;
            --bs-pagination-active-border-color: #c5a059;
            --bs-pagination-active-color: #ffffff;
            --bs-pagination-disabled-bg: #f9fafb;
            --bs-pagination-disabled-color: #9ca3af;
            --bs-pagination-disabled-border-color: #e5e7eb;
        }

        /* Jarak antar angka: padding horizontal 3 (Bootstrap) */
        .catalog-pagination .page-item {
            margin: 0.4rem; /* ~ padding-x: 3px kanan-kiri */
        }

        .catalog-pagination .page-link {
            width: 32px;
            height: 32px;
            border-radius: 50%;      /* angka jadi lingkaran penuh */
            border-width: 1px;
            font-size: 0.8rem;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Panah kiri-kanan: tanpa border luar, hanya ikon */
        .catalog-pagination .page-item:first-child .page-link,
        .catalog-pagination .page-item:last-child .page-link {
            border: none;
            background: transparent;
        }

        .catalog-pagination .page-item:first-child .page-link:hover,
        .catalog-pagination .page-item:last-child .page-link:hover {
            background: #f3f4f6;
        }

        .catalog-pagination-info {
            font-size: 0.8rem;
            color: #9ca3af;
        }

        {{-- =========================================================
           SLOT STYLES PER HALAMAN
           ========================================================= --}}
        @yield('styles')
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-black sticky-top">
        <div class="navbar-full">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <div class="navbar-main-inner">
                    {{-- KIRI --}}
                    <div class="navbar-main-left">
                        <div class="lang-switch d-flex align-items-center mb-1">
                            @php
                                $currentLocale = app()->getLocale() ?? 'id';
                            @endphp
                            <a href="#" class="text-decoration-none me-1 {{ $currentLocale === 'id' ? 'active' : '' }}">ID</a>
                            <span class="text-light-50">|</span>
                            <a href="#" class="text-decoration-none ms-1 {{ $currentLocale === 'en' ? 'active' : '' }}">EN</a>
                        </div>

                        <ul class="navbar-nav gap-lg-2">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('about.store') ? 'active' : '' }}"
                                   href="{{ route('about.store') }}">Tentang Kami</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('store.locations') ? 'active' : '' }}"
                                   href="{{ route('store.locations') }}">Lokasi & Kontak</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('catalog.index') }}">Produk Kami</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Artikel</a>
                            </li>
                        </ul>
                    </div>

                    {{-- TENGAH --}}
                    <div class="navbar-main-center">
                        <a class="navbar-brand text-gold fs-3 mb-0" href="{{ route('home') }}">
                            Toko Mas Sumatra
                        </a>
                    </div>

                    {{-- KANAN --}}
                    <div class="navbar-main-right">
                        <div class="d-flex align-items-center nav-icons">
                            <a href="#"><i class="bi bi-search fs-6"></i></a>
                            <a href="#"><i class="bi bi-heart fs-6"></i></a>
                            <a href="#"><i class="bi bi-bag fs-6"></i></a>

                            <div class="d-flex align-items-center">
                                @if(Auth::check())
                                    <a href="{{ Auth::user()->role == 'admin' ? url('/admin/dashboard') : route('customer.dashboard') }}"
                                       class="d-flex align-items-center text-decoration-none"
                                       style="color: rgba(255,255,255,0.8);">
                                        <i class="bi bi-person fs-5 me-1"></i>
                                        <span class="d-none d-md-inline small">Dashboard</span>
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                       class="d-flex align-items-center text-decoration-none"
                                       style="color: rgba(255,255,255,0.8);">
                                        <i class="bi bi-person fs-5 me-1"></i>
                                        <span class="d-none d-md-inline small">Login / Register</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Mobile: bahasa di bawah --}}
                <div class="d-lg-none mt-3">
                    <div class="lang-switch d-flex align-items-center">
                        <span class="text-light-50 small me-2">Bahasa:</span>
                        <a href="#" class="text-decoration-none me-1 small {{ $currentLocale === 'id' ? 'active' : '' }}">ID</a>
                        <span class="text-light-50 small">|</span>
                        <a href="#" class="text-decoration-none ms-1 small {{ $currentLocale === 'en' ? 'active' : '' }}">EN</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- KONTEN UTAMA --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-dark text-light pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row gy-4">
                {{-- Kolom 1 --}}
                <div class="col-md-3">
                    <h6 class="text-uppercase small fw-bold mb-3">Tentang Toko Mas Sumatra</h6>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-1"><a href="{{ route('about.store') }}" class="text-decoration-none text-light-50">Profil Singkat</a></li>
                        <li class="mb-1"><a href="{{ route('home') }}#katalog" class="text-decoration-none text-light-50">Katalog Perhiasan</a></li>
                        <li class="mb-1"><a href="{{ route('store.locations') }}" class="text-decoration-none text-light-50">Lokasi & Kontak</a></li>
                        <li class="mb-1"><a href="{{ route('about.store') }}#custom" class="text-decoration-none text-light-50">Layanan Custom</a></li>
                    </ul>
                </div>

                {{-- Kolom 2 --}}
                <div class="col-md-3">
                    <h6 class="text-uppercase small fw-bold mb-3">Informasi</h6>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-1"><a href="#" class="text-decoration-none text-light-50">Syarat & Ketentuan</a></li>
                        <li class="mb-1"><a href="#" class="text-decoration-none text-light-50">Kebijakan Privasi</a></li>
                        <li class="mb-1"><a href="#" class="text-decoration-none text-light-50">Pertanyaan yang Sering Diajukan</a></li>
                    </ul>
                </div>

                {{-- Kolom 3 --}}
                <div class="col-md-3">
                    <h6 class="text-uppercase small fw-bold mb-3">Ikuti Kami</h6>
                    <p class="small text-light-50 mb-2">
                        Dapatkan informasi promo dan koleksi terbaru Toko Mas Sumatra.
                    </p>
                    <div class="d-flex gap-2 mb-3">
                        <a href="#" class="btn btn-outline-light btn-sm rounded-pill px-3">
                            <i class="bi bi-instagram me-1"></i> Instagram
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-pill px-3">
                            <i class="bi bi-facebook me-1"></i> Facebook
                        </a>
                    </div>
                    <p class="small text-light-50 mb-1">Ingin pengalaman yang lebih personal?</p>
                    <p class="small text-light-50 mb-0">
                        Segera hadir aplikasi Toko Mas Sumatra untuk kemudahan berbelanja emas dari rumah.
                    </p>
                </div>

                {{-- Kolom 4 --}}
                <div class="col-md-3">
                    <h6 class="text-uppercase small fw-bold mb-3">Kontak & Legal</h6>
                    <p class="small mb-1">
                        <strong>Toko Mas Sumatra</strong><br>
                        <span class="text-light-50">[Alamat singkat toko Anda]</span>
                    </p>
                    <p class="small mb-1">
                        <span class="text-light-50">Email:</span><br>
                        <a href="mailto:info@tokomassumatra.com" class="text-decoration-none text-light-50">
                            info@tokomassumatra.com
                        </a>
                    </p>
                    <p class="small mb-1">
                        <span class="text-light-50">WhatsApp:</span><br>
                        <a href="https://wa.me/6282164836268" target="_blank" class="text-decoration-none text-light-50 fw-semibold">
                            +62 821-6483-6268
                        </a>
                    </p>
                    <p class="small text-light-50 mb-0">
                        Terdaftar dan diawasi oleh otoritas terkait sesuai ketentuan perdagangan emas yang berlaku.
                    </p>
                </div>
            </div>

            <hr class="border-secondary border-opacity-50 my-4">

            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="small text-light-50 mb-1">Juga tersedia di:</p>
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <span class="small text-light-50">Tokopedia</span>
                        <span class="small text-light-50">Shopee</span>
                        <span class="small text-light-50">Blibli</span>
                    </div>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <p class="small text-light-50 mb-0">
                        &copy; {{ date('Y') }} Toko Mas Sumatra. Seluruh hak cipta dilindungi.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    {{-- JS global --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Slider sederhana untuk "Koleksi Berdasarkan Tema" --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const slider = document.getElementById('collectionSlider');
            const prevBtn = document.getElementById('collectionPrev');
            const nextBtn = document.getElementById('collectionNext');

            if (slider && prevBtn && nextBtn) {
                const scrollAmount = slider.clientWidth;

                prevBtn.addEventListener('click', function () {
                    slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                });

                nextBtn.addEventListener('click', function () {
                    slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                });
            }
        });
    </script>

    @stack('scripts')
    @yield('scripts')
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            padding: 1rem 0.75rem;                 /* tinggi navbar */
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Link menu navbar (kiri) */
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

        /* Switch bahasa (ID | EN) */
        .lang-switch a {
            font-size: 0.8rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #ffffff;        /* default putih */
        }
        .lang-switch a.active {
            color: #c5a059;        /* emas ketika terpilih */
        }

        /* Ikon di sisi kanan navbar */
        .nav-icons {
            gap: 3rem;             /* jarak antar ikon kanan */
        }
        .nav-icons a {
            color: rgba(255,255,255,0.75);
        }
        .nav-icons a:hover {
            color: #c5a059;        /* emas saat hover */
        }

        {{-- =========================================================
           HERO, TICKER, DAN KARTU PRODUK
           ========================================================= --}}
        /* Background hero di homepage */
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                        url('https://images.unsplash.com/photo-1573408301185-9146fe634ad0?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        /* Baris informasi harga emas (atas homepage) */
        .price-ticker {
            background-color: #c5a059;
            color: white;
            padding: 10px 0;
            font-weight: bold;
        }

        /* Kartu produk di katalog */
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
           BANNER KOLEKSI (KOTAK BESAR KOSONG)
           ========================================================= --}}
        /* Kontainer banner koleksi */
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

        /* Area kotak gambar (kosong dulu, nanti bisa diisi background-image)
           UBAH height DI SINI jika ingin banner lebih tinggi/rendah */
        .collection-banner-box {
            width: 100%;
            height: 500px;
            background-color: #e9ecef;
            background-size: cover;
            background-position: center;
        }

        /* Bagian teks di bawah kotak gambar */
        .collection-banner-body {
            padding: 16px 18px 20px;
            text-align: center;
        }

        /* Judul koleksi – UBAH font-size DI SINI kalau mau diubah lagi */
        .collection-banner-title {
            font-size: 2rem;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .collection-banner-link {
            font-size: 0.85rem;
            color: #7b1b4a;           /* bisa diganti dengan warna brand lain */
            text-decoration: none;
        }
        .collection-banner-link:hover {
            text-decoration: underline;
        }

        {{-- =========================================================
           SLIDER KOLEKSI (Koleksi Berdasarkan Tema)
           ========================================================= --}}
        .collection-slider-wrapper {
            position: relative;
        }

        /* Container horizontal scroll */
        .collection-slider {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            gap: 1rem;
            padding-bottom: 8px;
        }

        /* Sembunyikan scrollbar visual */
        .collection-slider::-webkit-scrollbar {
            display: none;
        }
        .collection-slider {
            -ms-overflow-style: none;  /* IE */
            scrollbar-width: none;     /* Firefox */
        }

        /* Item: 3 kartu per view di desktop, proporsional saat zoom */
        /* Setiap item SELALU 1/3 lebar container di segala ukuran layar */
        .collection-slider-item {
            flex: 0 0 calc(100% / 3);
            max-width: calc(100% / 3);
        }

        /* Tombol panah */
        .collection-slider-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background-color: rgba(255,255,255,0.9);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 2;
        }
        .collection-slider-arrow:hover {
            background-color: #f3e3bf;
        }
        .collection-slider-arrow-left {
            left: -18px;
        }
        .collection-slider-arrow-right {
            right: -18px;
        }

        {{-- =========================================================
           SLOT TAMBAHAN STYLE PER HALAMAN (opsional)
           ========================================================= --}}
        @yield('styles')
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-black sticky-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <div class="row w-100 align-items-center">
                    {{-- Kiri: Bahasa + Menu --}}
                    <div class="col-lg-4 mb-2 mb-lg-0">
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
                                <a class="nav-link" href="{{ route('home') }}#katalog">Koleksi Kami</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Artikel</a>
                            </li>
                        </ul>
                    </div>

                    {{-- Tengah: Logo --}}
                    <div class="col-lg-4 d-flex justify-content-center mb-2 mb-lg-0">
                        <a class="navbar-brand text-gold fs-3" href="{{ route('home') }}">
                            Toko Mas Sumatra
                        </a>
                    </div>

                    {{-- Kanan: Ikon --}}
                    <div class="col-lg-4 d-flex justify-content-center justify-content-lg-end">
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
                const scrollAmount = slider.clientWidth; // geser 3 kartu sekaligus

                prevBtn.addEventListener('click', function () {
                    slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                });

                nextBtn.addEventListener('click', function () {
                    slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                });
            }
        });
    </script>

    {{-- SLOT TAMBAHAN SCRIPT PER HALAMAN (opsional) --}}
    @yield('scripts')
</body>
</html>
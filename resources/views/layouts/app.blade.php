<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Mas Sumatra - Official Store')</title>

    {{-- CSS & Fonts global --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        body { font-family: 'Lato', sans-serif; background-color: #f8f9fa; }
        h1, h2, h3, .navbar-brand { font-family: 'Playfair Display', serif; }

        .text-gold { color: #c5a059; }
        .bg-black { background-color: #1a1a1a !important; }
        .btn-gold { background-color: #c5a059; color: white; border: none; }
        .btn-gold:hover { background-color: #b08d4b; color: white; }

        /* Navbar */
        .navbar {
            padding: 1rem 0.5rem;        /* sedikit lebih tinggi */
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-nav .nav-link {
            font-size: 0.9rem;           /* lebih kecil, minimalis */
            text-transform: none;
        }

        /* Language switch */
        .lang-switch a {
            font-size: 0.8rem;
            letter-spacing: 0.03em;
        }

        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                url('https://images.unsplash.com/photo-1573408301185-9146fe634ad0?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .price-ticker { background-color: #c5a059; color: white; padding: 10px 0; font-weight: bold; }

        .product-card {
            border: none;
            transition: transform 0.3s;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden;
        }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .product-img {
            height: 250px;
            object-fit: cover;
            width: 100%;
            background-color: #eee;
        }
        .price-tag { color: #c5a059; font-size: 1.2rem; font-weight: 700; font-family: 'Playfair Display', serif; }

        @yield('styles')
    </style>
</head>
<body>

    {{-- Navbar dengan 3 area: kiri (menu), tengah (logo), kanan (ikon + auth) --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-black sticky-top">
        <div class="container">
            {{-- Language switch di pojok kiri atas --}}
            <div class="lang-switch d-none d-lg-flex align-items-center me-3">
                {{-- TODO: ganti href ke route perubahan bahasa jika sudah ada --}}
                <a href="#" class="text-light-50 text-decoration-none me-1">ID</a>
                <span class="text-light-50">|</span>
                <a href="#" class="text-light-50 text-decoration-none ms-1">EN</a>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <div class="row w-100 align-items-center">
                    {{-- Kiri: menu teks --}}
                    <div class="col-lg-4 d-flex justify-content-center justify-content-lg-start mb-2 mb-lg-0">
                        <ul class="navbar-nav gap-lg-2">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('about.store') ? 'active' : '' }}" href="{{ route('about.store') }}">
                                    Tentang Kami
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('store.locations') ? 'active' : '' }}" href="{{ route('store.locations') }}">
                                    Lokasi & Kontak
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}#katalog">
                                    Koleksi Kami
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Artikel
                                </a>
                            </li>
                        </ul>
                    </div>

                    {{-- Tengah: logo --}}
                    <div class="col-lg-4 d-flex justify-content-center mb-2 mb-lg-0">
                        <a class="navbar-brand text-gold fs-3" href="{{ route('home') }}">
                            Toko Mas Sumatra
                        </a>
                    </div>

                    {{-- Kanan: ikon + auth --}}
                    <div class="col-lg-4 d-flex justify-content-center justify-content-lg-end">
                        <div class="d-flex align-items-center gap-3">
                            {{-- Ikon minimalis (sementara non-aktif / placeholder) --}}
                            <a href="#" class="text-light-50">
                                <i class="bi bi-heart fs-5"></i>
                            </a>
                            <a href="#" class="text-light-50">
                                <i class="bi bi-bag fs-5"></i>
                            </a>
                            <a href="#" class="text-light-50">
                                <i class="bi bi-bell fs-5"></i>
                            </a>

                            {{-- Tombol Login/Register atau Dashboard --}}
                            @yield('navbar_right')
                        </div>
                    </div>
                </div>

                {{-- Language switch ditampilkan di mobile dalam collapsible --}}
                <div class="d-lg-none mt-3">
                    <div class="lang-switch d-flex align-items-center">
                        <span class="text-light-50 small me-2">Bahasa:</span>
                        <a href="#" class="text-light-50 text-decoration-none me-1 small">ID</a>
                        <span class="text-light-50 small">|</span>
                        <a href="#" class="text-light-50 text-decoration-none ms-1 small">EN</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    {{-- Konten utama --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer (tetap seperti sebelumnya dengan sedikit penyesuaian route) --}}
    <footer class="bg-dark text-light pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row gy-4">
                {{-- Kolom 1: Tentang Toko --}}
                <div class="col-md-3">
                    <h6 class="text-uppercase small fw-bold mb-3">Tentang Toko Mas Sumatra</h6>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-1">
                            <a href="{{ route('about.store') }}" class="text-decoration-none text-light-50">
                                Profil Singkat
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('home') }}#katalog" class="text-decoration-none text-light-50">
                                Katalog Perhiasan
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('store.locations') }}" class="text-decoration-none text-light-50">
                                Lokasi & Kontak
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('about.store') }}#custom" class="text-decoration-none text-light-50">
                                Layanan Custom
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Kolom 2: Informasi --}}
                <div class="col-md-3">
                    <h6 class="text-uppercase small fw-bold mb-3">Informasi</h6>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-1">
                            <a href="#" class="text-decoration-none text-light-50">
                                Syarat & Ketentuan
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="#" class="text-decoration-none text-light-50">
                                Kebijakan Privasi
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="#" class="text-decoration-none text-light-50">
                                Pertanyaan yang Sering Diajukan
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Kolom 3: Ikuti Kami --}}
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

                {{-- Kolom 4: Kontak & Legal --}}
                <div class="col-md-3">
                    <h6 class="text-uppercase small fw-bold mb-3">Kontak & Legal</h6>
                    <p class="small mb-1">
                        <strong>Toko Mas Sumatra</strong><br>
                        <span class="text-light-50">
                            [Alamat singkat toko Anda]
                        </span>
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

    @yield('scripts')
</body>
</html>
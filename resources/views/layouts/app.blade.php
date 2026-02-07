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
        /* --- CUSTOM CSS FOR LUXURY LOOK --- */
        body { font-family: 'Lato', sans-serif; background-color: #f8f9fa; }
        h1, h2, h3, .navbar-brand { font-family: 'Playfair Display', serif; }
        
        /* Warna Identitas */
        .text-gold { color: #c5a059; }
        .bg-black { background-color: #1a1a1a !important; }
        .btn-gold { background-color: #c5a059; color: white; border: none; }
        .btn-gold:hover { background-color: #b08d4b; color: white; }

        /* Navbar */
        .navbar { padding: 1rem 0; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }

        /* Hero Section (bisa dipakai di home) */
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                url('https://images.unsplash.com/photo-1573408301185-9146fe634ad0?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        /* Price Ticker */
        .price-ticker { background-color: #c5a059; color: white; padding: 10px 0; font-weight: bold; }

        /* Product Card */
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

    {{-- Navbar global sederhana, bisa dikembangkan nanti --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-black sticky-top">
        <div class="container">
            <a class="navbar-brand text-gold fs-3" href="{{ route('home') }}">Toko Mas Sumatra</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link @yield('nav_home_active')" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#katalog">Koleksi</a>
                    </li>
                    {{-- Nanti kita bisa pindahkan logic Auth ke sini kalau mau --}}
                    @yield('navbar_right')
                </ul>
            </div>
        </div>
    </nav>

    {{-- Konten utama halaman --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer global --}}
    <footer class="bg-dark text-light pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row gy-4">
                {{-- Kolom 1: Tentang Toko --}}
                <div class="col-md-3">
                    <h6 class="text-uppercase small fw-bold mb-3">Tentang Toko Mas Sumatra</h6>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-1">
                            <a href="{{ url('#tentang-toko') }}" class="text-decoration-none text-light-50">
                                Profil Singkat
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ url('#katalog') }}" class="text-decoration-none text-light-50">
                                Katalog Perhiasan
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ url('#lokasi-kontak') }}" class="text-decoration-none text-light-50">
                                Lokasi & Kontak
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="#" class="text-decoration-none text-light-50">
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

                {{-- Kolom 3: Ikuti Kami / “Feel the Experience” --}}
                <div class="col-md-3">
                    <h6 class="text-uppercase small fw-bold mb-3">Ikuti Kami</h6>
                    <p class="small text-light-50 mb-2">
                        Dapatkan informasi promo dan koleksi terbaru Toko Mas Sumatra.
                    </p>
                    <div class="d-flex gap-2 mb-3">
                        {{-- GANTI # DENGAN LINK SOSIAL MEDIA ASLI --}}
                        <a href="#" class="btn btn-outline-light btn-sm rounded-pill px-3">
                            <i class="bi bi-instagram me-1"></i> Instagram
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-pill px-3">
                            <i class="bi bi-facebook me-1"></i> Facebook
                        </a>
                    </div>
                    {{-- Jika suatu saat punya aplikasi mobile, bisa ganti jadi badge Play Store / App Store --}}
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
                        {{-- GANTI DENGAN ALAMAT SINGKAT --}}
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
                        <a href="https://wa.me/6281234567890" target="_blank" class="text-decoration-none text-light-50 fw-semibold">
                            +62 812-3456-7890
                        </a>
                    </p>
                    <p class="small text-light-50 mb-0">
                        Terdaftar dan diawasi oleh otoritas terkait sesuai ketentuan perdagangan emas yang berlaku.
                    </p>
                </div>
            </div>

            <hr class="border-secondary border-opacity-50 my-4">

            {{-- Baris bawah: marketplace / hak cipta --}}
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="small text-light-50 mb-1">Juga tersedia di:</p>
                    {{-- Jika belum ada, bisa dibiarkan placeholder --}}
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <span class="small text-light-50">Tokopedia</span>
                        <span class="small text-light-50">Shopee</span>
                        <span class="small text-light-50">Blibli</span>
                        {{-- Nanti bisa diganti logo SVG/PNG --}}
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
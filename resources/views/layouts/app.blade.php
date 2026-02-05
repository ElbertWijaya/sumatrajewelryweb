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
    <footer class="bg-black text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} Toko Mas Sumatra. All Rights Reserved.</p>
            <small class="text-muted">Jl. Jendral Sudirman No. 123, Medan, Sumatra Utara</small>
        </div>
    </footer>

    {{-- JS global --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>
</html>
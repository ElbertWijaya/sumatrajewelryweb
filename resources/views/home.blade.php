<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Mas Sumatra - Official Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"> <style>
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
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1573408301185-9146fe634ad0?auto=format&fit=crop&w=1920&q=80');
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
    </style>
</head>
<body>

    <div class="price-ticker text-center">
        <div class="container">
            Update Harga Emas Murni (24K) Hari Ini: 
            <span class="fs-5 ms-2">Rp {{ number_format($goldPrice24k->sell_price_per_gram ?? 0, 0, ',', '.') }} / gram</span>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-black sticky-top">
        <div class="container">
            <a class="navbar-brand text-gold fs-3" href="{{ route('home') }}">Toko Mas Sumatra</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="{{ route('home') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#katalog">Koleksi</a></li>
                    
                    @if(Auth::check())
                        <li class="nav-item ms-3">
                            <a href="{{ Auth::user()->role == 'admin' ? url('/admin/dashboard') : route('customer.dashboard') }}" class="btn btn-gold btn-sm text-white fw-bold">
                                <i class="bi bi-person-circle"></i> Dashboard {{ Auth::user()->role == 'admin' ? 'Admin' : 'Saya' }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item ms-3">
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm fw-bold">
                                Masuk / Daftar
                            </a>
                        </li>
                    @endif
                    </ul>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <div class="container">
            <h1 class="display-4 mb-3">Keindahan Abadi Khas Sumatra</h1>
            <p class="lead mb-4">Temukan koleksi perhiasan emas berkualitas tinggi dengan desain eksklusif.</p>
            <a href="#katalog" class="btn btn-gold btn-lg px-5">Lihat Koleksi Terbaru</a>
        </div>
    </div>

    <div class="container py-5" id="katalog">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Produk Terbaru</h2>
            <div style="width: 60px; height: 3px; background: #c5a059; margin: 10px auto;"></div>
        </div>

        <div class="row">
            @forelse($products as $product)
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="product-card h-100">
                    @if($product->image_url)
                        <img src="{{ asset('uploads/' . $product->image_url) }}" class="product-img" alt="{{ $product->name }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center product-img text-muted">
                            <small>No Image</small>
                        </div>
                    @endif

                    <div class="card-body text-center">
                        <h5 class="card-title text-dark">{{ $product->name }}</h5>
                        <p class="text-muted small mb-1">{{ $product->karat_type }} | {{ $product->weight }} gr</p>
                        
                        @php
                            $hargaDasar = ($product->karat_type == '24K') ? $goldPrice24k->sell_price_per_gram : ($goldPrice24k->sell_price_per_gram * 0.8);
                            $estimasiHarga = ($product->weight * $hargaDasar) + $product->labor_cost + $product->stone_price;
                        @endphp
                        
                        <div class="price-tag mb-3">
                            Rp {{ number_format($estimasiHarga, 0, ',', '.') }}
                        </div>
                        
                        <a href="{{ route('product.detail', $product->id) }}" class="btn btn-dark w-100">Detail Produk</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada produk yang siap dijual.</p>
            </div>
            @endforelse
        </div>
    </div>

    <footer class="bg-black text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} Toko Mas Sumatra. All Rights Reserved.</p>
            <small class="text-muted">Jl. Jendral Sudirman No. 123, Medan, Sumatra Utara</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
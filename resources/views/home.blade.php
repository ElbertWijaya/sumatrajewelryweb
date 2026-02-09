@extends('layouts.app')

@section('title', 'Toko Mas Sumatra - Official Store')
@section('nav_home_active', 'active')

@section('navbar_right')
@endsection

@section('content')
    {{-- Price Ticker --}}
    <div class="price-ticker text-center">
        <div class="container">
            Update Harga Emas Murni (24K) Hari Ini:
            <span class="fs-5 ms-2">
                Rp {{ number_format($goldPrice24k->sell_price_per_gram ?? 0, 0, ',', '.') }} / gram
            </span>
        </div>
    </div>

    {{-- Hero Section --}}
    <div class="hero-section">
        <div class="container">
            <h1 class="display-4 mb-3">Keindahan Abadi Khas Sumatra</h1>
            <p class="lead mb-4">
                Temukan koleksi perhiasan emas berkualitas tinggi dengan desain eksklusif,
                harga transparan, dan layanan yang bersahabat.
            </p>
            <a href="#katalog" class="btn btn-gold btn-lg px-5">Lihat Koleksi Terbaru</a>
        </div>
    </div>

    {{-- KOLEKSI BERDASARKAN TEMA (HEADER CONTAINER, SLIDER FULL-WIDTH DENGAN PADDING) --}}
    <div class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold">Koleksi Berdasarkan Tema</h2>
                <div style="width: 80px; height: 3px; background: #c5a059; margin: 10px auto;"></div>
                <p class="text-muted mb-0">
                    Temukan koleksi perhiasan emas pilihan kami untuk setiap momen istimewa.
                </p>
            </div>
        </div>

        <div class="container-fluid px-0">
            <div class="collection-slider-container">
                <div class="collection-slider-wrapper">
                    <button type="button"
                            class="collection-slider-arrow collection-slider-arrow-left d-none d-md-flex"
                            id="collectionPrev">
                        <i class="bi bi-chevron-left"></i>
                    </button>

                    <button type="button"
                            class="collection-slider-arrow collection-slider-arrow-right d-none d-md-flex"
                            id="collectionNext">
                        <i class="bi bi-chevron-right"></i>
                    </button>

                    <div class="collection-slider" id="collectionSlider">
                        {{-- 1. Hadiah Pernikahan --}}
                        <div class="collection-slider-item">
                            <div class="collection-banner h-100">
                                <div class="collection-banner-box" style="background-image: none;"></div>
                                <div class="collection-banner-body">
                                    <div class="collection-banner-title text-dark">
                                        HADIAH PERNIKAHAN
                                    </div>
                                    <a href="#katalog" class="collection-banner-link">
                                        Lihat Koleksi <i class="bi bi-arrow-right-short"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- 2. Koleksi Pria --}}
                        <div class="collection-slider-item">
                            <div class="collection-banner h-100">
                                <div class="collection-banner-box" style="background-image: none;"></div>
                                <div class="collection-banner-body">
                                    <div class="collection-banner-title text-dark">
                                        KOLEKSI PRIA
                                    </div>
                                    <a href="#katalog" class="collection-banner-link">
                                        Lihat Koleksi <i class="bi bi-arrow-right-short"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- 3. Cincin Kawin & Tunangan --}}
                        <div class="collection-slider-item">
                            <div class="collection-banner h-100">
                                <div class="collection-banner-box" style="background-image: none;"></div>
                                <div class="collection-banner-body">
                                    <div class="collection-banner-title text-dark">
                                        CINCIN KAWIN &amp; TUNANGAN
                                    </div>
                                    <a href="#katalog" class="collection-banner-link">
                                        Lihat Koleksi <i class="bi bi-arrow-right-short"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- 4. Koleksi Zodiak --}}
                        <div class="collection-slider-item">
                            <div class="collection-banner h-100">
                                <div class="collection-banner-box" style="background-image: none;"></div>
                                <div class="collection-banner-body">
                                    <div class="collection-banner-title text-dark">
                                        KOLEKSI ZODIAK
                                    </div>
                                    <a href="#katalog" class="collection-banner-link">
                                        Lihat Koleksi <i class="bi bi-arrow-right-short"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- 5. Perhiasan Eksotik --}}
                        <div class="collection-slider-item">
                            <div class="collection-banner h-100">
                                <div class="collection-banner-box" style="background-image: none;"></div>
                                <div class="collection-banner-body">
                                    <div class="collection-banner-title text-dark">
                                        PERHIASAN EKSOTIK
                                    </div>
                                    <a href="#katalog" class="collection-banner-link">
                                        Lihat Koleksi <i class="bi bi-arrow-right-short"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- 6. Koleksi Sehari-hari --}}
                        <div class="collection-slider-item">
                            <div class="collection-banner h-100">
                                <div class="collection-banner-box" style="background-image: none;"></div>
                                <div class="collection-banner-body">
                                    <div class="collection-banner-title text-dark">
                                        KOLEKSI SEHARI-HARI
                                    </div>
                                    <a href="#katalog" class="collection-banner-link">
                                        Lihat Koleksi <i class="bi bi-arrow-right-short"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> {{-- /collection-slider --}}
                </div>
            </div>
        </div>
    </div>

    {{-- TOP PRODUCTS / KOLEKSI UNGGULAN (FULL-WIDTH, PADDING 8REM) --}}
    @if($products->count() > 0)
        @php
            $topProducts = $products->take(3);
        @endphp

        {{-- Header tetap di container biasa --}}
        <div class="container py-5">
            <div class="text-center mb-4">
                <h2 class="fw-bold">Pilihan Koleksi Unggulan</h2>
                <div style="width: 80px; height: 3px; background: #c5a059; margin: 10px auto;"></div>
                <p class="text-muted mb-0">
                    Beberapa rekomendasi perhiasan emas pilihan kami untuk melengkapi momen spesial Anda.
                </p>
            </div>
        </div>

        {{-- Grid produk unggulan full-width --}}
        <div class="container-fluid px-0">
            <div class="featured-products-container">
                <div class="row g-4">
                    @foreach($topProducts as $product)
                        @php
                            $hargaDasar = ($product->karat_type == '24K')
                                ? $goldPrice24k->sell_price_per_gram
                                : ($goldPrice24k->sell_price_per_gram * 0.8);
                            $estimasiHarga = ($product->weight * $hargaDasar)
                                + $product->labor_cost
                                + $product->stone_price;
                        @endphp

                        <div class="col-lg-4 col-md-6">
                            <div class="product-card h-100 ratio-card">
                                @if($product->image_url)
                                    <img src="{{ asset('uploads/' . $product->image_url) }}"
                                         class="product-img"
                                         alt="{{ $product->name }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center product-img text-muted">
                                        <small>Tidak ada gambar</small>
                                    </div>
                                @endif

                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title text-dark">{{ $product->name }}</h5>
                                    <p class="text-muted small mb-2">
                                        {{ $product->karat_type }} &middot; {{ $product->weight }} gr
                                    </p>
                                    <div class="mb-2">
                                        <span class="text-gold fw-bold">
                                            Rp {{ number_format($estimasiHarga, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <p class="small text-muted flex-grow-1">
                                        Perhiasan emas dengan detail yang elegan, cocok sebagai hadiah
                                        maupun koleksi pribadi Anda.
                                    </p>
                                    <a href="{{ route('product.detail', $product->id) }}" class="btn btn-dark w-100 mt-2">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- KATALOG PRODUK UTAMA (FULL-WIDTH, PADDING 8REM) --}}
    <div class="py-5" id="katalog">
        {{-- Header --}}
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Produk Terbaru</h2>
                <div style="width: 60px; height: 3px; background: #c5a059; margin: 10px auto;"></div>
            </div>
        </div>

        {{-- Grid produk --}}
        <div class="container-fluid px-0">
            <div class="latest-products-container">
                @php
                    // Ambil maksimal 10 produk secara acak dari koleksi $products
                    $latestProducts = $products->shuffle()->take(10);
                @endphp

                <div class="row g-4">
                    @forelse($latestProducts as $product)
                        @php
                            $hargaDasar = ($product->karat_type == '24K')
                                ? $goldPrice24k->sell_price_per_gram
                                : ($goldPrice24k->sell_price_per_gram * 0.8);
                            $estimasiHarga = ($product->weight * $hargaDasar)
                                + $product->labor_cost
                                + $product->stone_price;
                        @endphp

                        {{-- 5 kolom per baris di desktop: 12 / 5 = 2.4 → pakai kelas custom --}}
                        <div class="col-6 col-md-4 col-lg-3 col-xl-2-4">
                            <div class="product-card h-100 ratio-card-small">
                                @if($product->image_url)
                                    <img src="{{ asset('uploads/' . $product->image_url) }}" class="product-img" alt="{{ $product->name }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center product-img text-muted">
                                        <small>No Image</small>
                                    </div>
                                @endif

                                <div class="card-body text-center">
                                    <h5 class="card-title text-dark">{{ $product->name }}</h5>
                                    <p class="text-muted small mb-1">
                                        {{ $product->karat_type }} | {{ $product->weight }} gr
                                    </p>
                                    <div class="price-tag mb-3">
                                        Rp {{ number_format($estimasiHarga, 0, ',', '.') }}
                                    </div>
                                    <a href="{{ route('product.detail', $product->id) }}" class="btn btn-dark w-100">
                                        Detail Produk
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">Belum ada produk yang siap dijual.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Tombol tampilkan lebih banyak --}}
                <div class="text-center mt-4">
                    <a href="#" class="btn btn-outline-dark px-5 py-2">
                        Tampilkan Lebih Banyak
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION ARTIKEL / EDUKASI STATIS --}}
    <div class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold">Edukasi & Artikel</h2>
                <div style="width: 80px; height: 3px; background: #c5a059; margin: 10px auto;"></div>
                <p class="text-muted mb-0">
                    Pelajari lebih banyak seputar emas dan perhiasan sebelum Anda berbelanja.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="border rounded-3 bg-white h-100 p-4 shadow-sm">
                        <h5 class="fw-semibold mb-2">Tips Memilih Perhiasan Emas yang Tepat</h5>
                        <p class="small text-muted mb-3">
                            Beberapa hal penting yang perlu diperhatikan saat memilih perhiasan emas,
                            mulai dari kadar, berat, hingga kecocokan dengan aktivitas sehari-hari Anda.
                        </p>
                        <a href="{{ route('about.store') }}" class="small fw-semibold text-decoration-none">
                            Baca selengkapnya <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="border rounded-3 bg-white h-100 p-4 shadow-sm">
                        <h5 class="fw-semibold mb-2">Perbedaan Emas 24K dan Emas Perhiasan</h5>
                        <p class="small text-muted mb-3">
                            Emas murni 24K dan emas perhiasan memiliki karakteristik yang berbeda.
                            Kenali kelebihan masing-masing sebelum Anda memutuskan untuk membeli.
                        </p>
                        <span class="badge bg-light text-gold border border-warning-subtle small">
                            Edukasi Investasi
                        </span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="border rounded-3 bg-white h-100 p-4 shadow-sm">
                        <h5 class="fw-semibold mb-2">Merawat Perhiasan Agar Tetap Berkilau</h5>
                        <p class="small text-muted mb-3">
                            Dengan perawatan yang tepat, perhiasan emas Anda akan tetap berkilau dan nyaman digunakan
                            dalam jangka waktu yang lama.
                        </p>
                        <span class="badge bg-light text-gold border border-warning-subtle small mb-2">
                            Tips Perawatan
                        </span>
                        <p class="small text-muted mb-0 mt-2">
                            Artikel lengkap akan segera hadir di halaman blog Toko Mas Sumatra.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
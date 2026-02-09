@extends('layouts.app')

@section('title', 'Toko Mas Sumatra - Official Store')
@section('nav_home_active', 'active')

{{-- Tidak dipakai lagi (user icon dihandle di layout) --}}
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

    {{-- KOLEKSI BERDASARKAN TEMA (SLIDER 3 ITEM) --}}
    <div class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold">Koleksi Berdasarkan Tema</h2>
                <div style="width: 80px; height: 3px; background: #c5a059; margin: 10px auto;"></div>
                <p class="text-muted mb-0">
                    Temukan koleksi perhiasan emas pilihan kami untuk setiap momen istimewa.
                </p>
            </div>

            <div class="collection-slider-wrapper">
                {{-- Panah kiri (disembunyikan di layar kecil) --}}
                <button type="button"
                        class="collection-slider-arrow collection-slider-arrow-left d-none d-md-flex"
                        id="collectionPrev">
                    <i class="bi bi-chevron-left"></i>
                </button>

                {{-- Panah kanan --}}
                <button type="button"
                        class="collection-slider-arrow collection-slider-arrow-right d-none d-md-flex"
                        id="collectionNext">
                    <i class="bi bi-chevron-right"></i>
                </button>

                {{-- Area yang bisa digeser horizontal --}}
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

    {{-- TOP PRODUCTS / KOLEKSI UNGGULAN --}}
    @if($products->count() > 0)
        @php
            $topProducts = $products->take(3);
        @endphp
        <div class="container py-5">
            <div class="text-center mb-4">
                <h2 class="fw-bold">Pilihan Koleksi Unggulan</h2>
                <div style="width: 80px; height: 3px; background: #c5a059; margin: 10px auto;"></div>
                <p class="text-muted mb-0">
                    Beberapa rekomendasi perhiasan emas pilihan kami untuk melengkapi momen spesial Anda.
                </p>
            </div>

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

                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm overflow-hidden">
                            @if($product->image_url)
                                <img src="{{ asset('uploads/' . $product->image_url) }}"
                                     class="card-img-top"
                                     style="height: 260px; object-fit: cover;"
                                     alt="{{ $product->name }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light"
                                     style="height: 260px;">
                                    <small class="text-muted">Tidak ada gambar</small>
                                </div>
                            @endif

                            <div class="card-body d-flex flex-column">
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
    @endif

    {{-- KATALOG PRODUK UTAMA --}}
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
                            <p class="text-muted small mb-1">
                                {{ $product->karat_type }} | {{ $product->weight }} gr
                            </p>

                            @php
                                $hargaDasar = ($product->karat_type == '24K')
                                    ? $goldPrice24k->sell_price_per_gram
                                    : ($goldPrice24k->sell_price_per_gram * 0.8);
                                $estimasiHarga = ($product->weight * $hargaDasar)
                                    + $product->labor_cost
                                    + $product->stone_price;
                            @endphp

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
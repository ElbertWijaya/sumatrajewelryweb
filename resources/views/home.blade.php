@extends('layouts.app')

@section('title', 'Toko Mas Sumatra - Official Store')
@section('nav_home_active', 'active')

{{-- Tambahan konten di sisi kanan navbar (Auth) --}}
@section('navbar_right')
    @if(Auth::check())
        <a href="{{ Auth::user()->role == 'admin' ? url('/admin/dashboard') : route('customer.dashboard') }}" class="btn btn-gold btn-sm text-white fw-bold">
            <i class="bi bi-person-circle"></i> Dashboard {{ Auth::user()->role == 'admin' ? 'Admin' : 'Saya' }}
        </a>
    @else
        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm fw-bold">
            Masuk / Daftar
        </a>
    @endif
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

    {{-- Katalog Produk --}}
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
@endsection
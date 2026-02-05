@extends('layouts.app')

@section('title', $product->name . ' - Toko Mas Sumatra')
@section('nav_home_active', '') {{-- di halaman detail, menu Beranda tidak perlu "active" --}}
{{-- Jika ingin tombol Dashboard/Login sama seperti home, bisa reuse section navbar_right --}}
@section('navbar_right')
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
@endsection

@section('content')
    <div class="container py-4">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="#katalog">Koleksi</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row mt-4">
            {{-- Gambar produk --}}
            <div class="col-md-5 mb-4">
                <div class="card border-0 shadow-sm">
                    @if($product->image_url)
                        <img src="{{ asset('uploads/' . $product->image_url) }}" class="card-img-top" alt="{{ $product->name }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center text-muted" style="height: 320px; background-color: #eee;">
                            <span>No Image</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Detail produk --}}
            <div class="col-md-7">
                <h1 class="h3 mb-2">{{ $product->name }}</h1>
                <p class="text-muted mb-2">{{ $product->karat_type }} • {{ $product->weight }} gr • SKU: {{ $product->sku }}</p>

                @php
                    $goldPrice24k = $goldPrice24k ?? \App\Models\GoldPrice::where('karat_type', '24K')->first();
                    $hargaDasar = ($product->karat_type == '24K')
                        ? ($goldPrice24k->sell_price_per_gram ?? 0)
                        : (($goldPrice24k->sell_price_per_gram ?? 0) * 0.8);
                    $estimasiHarga = ($product->weight * $hargaDasar)
                        + $product->labor_cost
                        + $product->stone_price;
                @endphp

                <div class="mb-3">
                    <span class="d-block text-muted small">Perkiraan Harga</span>
                    <span class="price-tag d-block">
                        Rp {{ number_format($estimasiHarga, 0, ',', '.') }}
                    </span>
                    <small class="text-muted d-block">
                        Harga dapat berubah mengikuti update harga emas harian.
                    </small>
                </div>

                <div class="mb-3">
                    <p class="text-muted">
                        {{ $product->description ?? 'Perhiasan emas berkualitas tinggi dengan desain eksklusif khas Toko Mas Sumatra. Cocok untuk investasi maupun aksesoris fashion.' }}
                    </p>
                </div>

                <div class="d-grid gap-2 mb-3">
                    <a href="{{ route('checkout.show', $product->id) }}" class="btn btn-gold btn-lg text-uppercase fw-bold shadow">
                        Beli Sekarang
                    </a>
                    <a href="https://wa.me/628123456789?text=Halo admin, saya mau tanya tentang produk {{ $product->name }} ({{ $product->sku }})"
                       target="_blank" class="btn btn-outline-success">
                        Chat WhatsApp
                    </a>
                </div>
                
                <div class="mt-2 text-center text-md-start">
                    <small class="text-muted">
                        <i class="bi bi-shield-lock"></i> Jaminan Emas Asli & Buyback Guarantee
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection
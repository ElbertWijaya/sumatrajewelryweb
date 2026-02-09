@extends('layouts.app')

@section('title', 'Katalog Perhiasan - Toko Mas Sumatra')

@section('content')
    <div class="py-5 bg-light">
        <div class="container">
            {{-- Header --}}
            <div class="text-center mb-4">
                <h2 class="fw-bold">Katalog Perhiasan</h2>
                <div style="width: 80px; height: 3px; background: #c5a059; margin: 10px auto;"></div>
                <p class="text-muted mb-0">
                    Lihat koleksi lengkap perhiasan emas yang tersedia di Toko Mas Sumatra.
                </p>
            </div>

            {{-- Bar pencarian & info jumlah (search belum aktif, hanya UI dulu) --}}
            <div class="row mb-4 align-items-center">
                <div class="col-md-6 mb-2 mb-md-0">
                    <form action="{{ route('catalog.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   placeholder="Cari cincin, gelang, kalung..."
                                   value="{{ request('search') }}">
                            <button class="btn btn-dark" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-md-end small text-muted">
                    Menampilkan {{ $products->total() }} produk
                </div>
            </div>

            {{-- Layout dua kolom (filter kiri, produk kanan) --}}
            <div class="row">
                {{-- Sidebar filter (sementara placeholder, nanti kita isi bertahap) --}}
                <div class="col-lg-3 mb-4">
                    <div class="border rounded-3 bg-white p-3 shadow-sm">
                        <h6 class="fw-bold mb-3">Filter</h6>

                        <p class="small text-muted mb-1">Kategori (coming soon)</p>
                        <p class="small text-muted mb-1">Kadar / Karat (coming soon)</p>
                        <p class="small text-muted mb-0">Rentang harga & berat (coming soon)</p>
                    </div>
                </div>

                {{-- Daftar produk --}}
                <div class="col-lg-9">
                    @if($products->count() === 0)
                        <div class="text-center py-5">
                            <p class="text-muted mb-0">Belum ada produk yang bisa ditampilkan.</p>
                        </div>
                    @else
                        <div class="row g-3">
                            @foreach($products as $product)
                                @php
                                    $hargaDasar = ($product->karat_type == '24K')
                                        ? ($goldPrice24k->sell_price_per_gram ?? 0)
                                        : (($goldPrice24k->sell_price_per_gram ?? 0) * 0.8);

                                    $estimasiHarga = ($product->weight * $hargaDasar)
                                        + $product->labor_cost
                                        + $product->stone_price;
                                @endphp

                                {{-- 5 per baris di xl, 4 di lg, 3 di md, 2 di sm (pakai class custom col-xl-2-4 yang sudah ada) --}}
                                <div class="col-6 col-md-4 col-lg-3 col-xl-2-4">
                                    <div class="latest-gallery-card h-100 d-flex flex-column">
                                        <div class="latest-gallery-image-wrap">
                                            @if($product->image_url)
                                                <img src="{{ asset('uploads/' . $product->image_url) }}"
                                                     alt="{{ $product->name }}"
                                                     class="latest-gallery-image">
                                            @else
                                                <span class="text-muted small">No Image</span>
                                            @endif
                                        </div>

                                        <div class="latest-gallery-info">
                                            <div class="latest-gallery-name text-truncate">
                                                {{ $product->name }}
                                            </div>
                                            <div class="latest-gallery-meta small text-muted">
                                                {{ $product->karat_type }} &middot; {{ $product->weight }} gr
                                            </div>
                                            <div class="latest-gallery-price">
                                                Rp {{ number_format($estimasiHarga, 0, ',', '.') }}
                                            </div>
                                        </div>

                                        <div class="mt-auto pt-2">
                                            <a href="{{ route('product.detail', $product->id) }}"
                                               class="btn btn-outline-dark btn-sm w-100">
                                                Detail Produk
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-4">
                            {{ $products->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
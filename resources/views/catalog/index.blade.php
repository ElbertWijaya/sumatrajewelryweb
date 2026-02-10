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

            {{-- Bar pencarian (di tengah) & info jumlah --}}
            <div class="row mb-4 align-items-center justify-content-center">
                <div class="col-md-8 col-lg-6 mb-2 mb-md-0">
                    <form action="{{ route('catalog.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   placeholder="Cari cincin, gelang, kalung..."
                                   value="{{ $search }}">
                            <button class="btn btn-dark" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
                <div class="col-12 text-center small text-muted mt-2">
                    Menampilkan {{ $products->total() }} produk
                </div>
            </div>

            {{-- Layout dua kolom (filter kiri, produk kanan) --}}
            <div class="row">
                {{-- Sidebar filter --}}
                <div class="col-lg-3 mb-4">
                    <div class="border rounded-3 bg-white p-3 shadow-sm">
                        <h6 class="fw-bold mb-3">Filter</h6>

                        {{-- Filter Kategori --}}
                        <div class="mb-3">
                            <div class="small text-muted mb-1">Kategori</div>
                            @foreach($categories as $cat)
                                <div class="form-check small">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="category_filter"
                                           id="cat_{{ $cat->id }}"
                                           value="{{ $cat->id }}"
                                           onclick="applyFilter('category', '{{ $cat->id }}')"
                                           {{ (string)$categoryId === (string)$cat->id ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cat_{{ $cat->id }}">
                                        {{ $cat->name }}
                                    </label>
                                </div>
                            @endforeach

                            {{-- Tombol reset kategori --}}
                            @if($categoryId)
                                <button type="button"
                                        class="btn btn-link btn-sm p-0 mt-1"
                                        onclick="applyFilter('category', '')">
                                    <small>Hapus filter kategori</small>
                                </button>
                            @endif
                        </div>

                        <hr>

                        {{-- Filter Karat --}}
                        <div class="mb-3">
                            <div class="small text-muted mb-1">Kadar / Karat</div>
                            @foreach($karats as $k)
                                <div class="form-check small">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="karat_filter"
                                           id="karat_{{ $k }}"
                                           value="{{ $k }}"
                                           onclick="applyFilter('karat', '{{ $k }}')"
                                           {{ $karat === $k ? 'checked' : '' }}>
                                    <label class="form-check-label" for="karat_{{ $k }}">
                                        {{ $k }}
                                    </label>
                                </div>
                            @endforeach

                            @if($karat)
                                <button type="button"
                                        class="btn btn-link btn-sm p-0 mt-1"
                                        onclick="applyFilter('karat', '')">
                                    <small>Hapus filter karat</small>
                                </button>
                            @endif
                        </div>

                        {{-- Nanti bisa tambah filter lain di bawah ini (harga, berat, stok, dll.) --}}
                    </div>
                </div>

                {{-- Daftar produk --}}
                <div class="col-lg-9">
                    {{-- Baris sort --}}
                    <div class="d-flex justify-content-end align-items-center mb-3 small">
                        <span class="me-2 text-muted">Urutkan:</span>
                        <select class="form-select form-select-sm w-auto"
                                onchange="applyFilter('sort', this.value)">
                            <option value="latest" {{ $sort === 'latest' || !$sort ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                        </select>
                    </div>

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

                                    // Sementara: rating & lokasi dummy sampai ada di DB
                                    $rating      = 4.8;
                                    $ratingCount = 32;
                                    $stok        = $product->stock_status === 'ready'
                                        ? 'Tersedia'
                                        : strtoupper($product->stock_status);
                                    $lokasiCabang = 'Cabang Utama';
                                @endphp

                                {{-- 5 per baris di xl, 4 di lg, 3 di md, 2 di sm --}}
                                <div class="col-6 col-md-4 col-lg-3 col-xl-2-4">
                                    <a href="{{ route('product.detail', $product->id) }}"
                                       class="text-decoration-none text-dark d-block h-100">
                                        <div class="catalog-card h-100 d-flex flex-column">
                                            {{-- Thumbnail 1:1 --}}
                                            <div class="catalog-thumb-wrap">
                                                @if($product->image_url)
                                                    <img src="{{ asset('uploads/' . $product->image_url) }}"
                                                         alt="{{ $product->name }}"
                                                         class="catalog-thumb-img">
                                                @else
                                                    <span class="text-muted small">No Image</span>
                                                @endif
                                            </div>

                                            {{-- Info produk --}}
                                            <div class="catalog-card-body">
                                                {{-- Nama produk --}}
                                                <div class="catalog-name text-truncate">
                                                    {{ $product->name }}
                                                </div>

                                                {{-- Harga --}}
                                                <div class="catalog-price">
                                                    Rp {{ number_format($estimasiHarga, 0, ',', '.') }}
                                                </div>

                                                {{-- Rating + stok --}}
                                                <div class="d-flex justify-content-between align-items-center small mt-1">
                                                    <div class="text-muted">
                                                        ★ {{ number_format($rating, 1) }}
                                                        <span class="text-muted">({{ $ratingCount }})</span>
                                                    </div>
                                                    <div class="text-muted">
                                                        Stok: {{ $stok }}
                                                    </div>
                                                </div>

                                                {{-- Lokasi cabang --}}
                                                <div class="catalog-location small text-muted mt-1">
                                                    {{ $lokasiCabang }}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-4">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function applyFilter(key, value) {
        const url = new URL(window.location.href);

        if (value) {
            url.searchParams.set(key, value);
        } else {
            url.searchParams.delete(key);
        }

        // setiap ganti filter/sort, kembali ke halaman 1
        url.searchParams.delete('page');

        window.location.href = url.toString();
    }
</script>
@endsection
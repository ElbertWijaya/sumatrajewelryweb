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

            {{-- Bar pencarian (di tengah) --}}
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
            </div>

            {{-- Layout dua kolom (filter kiri, produk kanan) --}}
            <div class="row">
                {{-- Sidebar filter --}}
                <div class="col-lg-3 mb-4">
                    <div class="catalog-filter-card">
                        <h6 class="fw-bold mb-3">Filter</h6>

                        {{-- Note: controller mengirimkan arrays: categoryArr, karatArr, branchArr, colorArr, collectionArr --}}
                        @php
                            $categorySelected = $categoryArr ?? [];
                            $karatSelected = $karatArr ?? [];
                            $branchSelected = $branchArr ?? [];
                            $colorSelected = $colorArr ?? [];
                            $collectionSelected = $collectionArr ?? [];
                        @endphp

                        {{-- Filter Kategori --}}
                        <div class="mb-3">
                            <div class="small text-muted mb-1">Kategori</div>
                            @foreach($categories as $cat)
                                <div class="catalog-filter-option">
                                    <input
                                        class="catalog-filter-input"
                                        type="checkbox"
                                        name="category"
                                        id="cat_{{ $cat->id }}"
                                        value="{{ $cat->id }}"
                                        onclick="applyFilter('category', '{{ $cat->id }}')"
                                        {{ in_array((string)$cat->id, array_map('strval', $categorySelected)) ? 'checked' : '' }}>
                                    <label class="catalog-filter-label" for="cat_{{ $cat->id }}">
                                        {{ $cat->name }}
                                    </label>
                                </div>
                            @endforeach

                            @if(!empty($categorySelected))
                                <button type="button"
                                        class="btn btn-link btn-sm p-0 mt-1"
                                        onclick="clearFilterKey('category')">
                                    <small>Hapus filter kategori</small>
                                </button>
                            @endif
                        </div>

                        <hr>

                        {{-- Filter Karat --}}
                        <div class="mb-3">
                            <div class="small text-muted mb-1">Kadar / Karat</div>
                            @foreach($karats as $k)
                                <div class="catalog-filter-option">
                                    <input
                                        class="catalog-filter-input"
                                        type="checkbox"
                                        name="karat"
                                        id="karat_{{ $k }}"
                                        value="{{ $k }}"
                                        onclick="applyFilter('karat', '{{ $k }}')"
                                        {{ in_array((string)$k, array_map('strval', $karatSelected)) ? 'checked' : '' }}>
                                    <label class="catalog-filter-label" for="karat_{{ $k }}">
                                        {{ $k }}
                                    </label>
                                </div>
                            @endforeach

                            @if(!empty($karatSelected))
                                <button type="button"
                                        class="btn btn-link btn-sm p-0 mt-1"
                                        onclick="clearFilterKey('karat')">
                                    <small>Hapus filter karat</small>
                                </button>
                            @endif
                        </div>

                        <hr>

                        {{-- Filter Lokasi Cabang --}}
                        <div class="mb-3">
                            <div class="small text-muted mb-1">Lokasi Cabang</div>
                            @foreach($branchLocations as $loc)
                                <div class="catalog-filter-option">
                                    <input
                                        class="catalog-filter-input"
                                        type="checkbox"
                                        name="branch_location"
                                        id="branch_{{ \Illuminate\Support\Str::slug($loc) }}"
                                        value="{{ $loc }}"
                                        onclick="applyFilter('branch_location', '{{ $loc }}')"
                                        {{ in_array((string)$loc, array_map('strval', $branchSelected)) ? 'checked' : '' }}>
                                    <label class="catalog-filter-label" for="branch_{{ \Illuminate\Support\Str::slug($loc) }}">
                                        {{ $loc }}
                                    </label>
                                </div>
                            @endforeach

                            @if(!empty($branchSelected))
                                <button type="button"
                                        class="btn btn-link btn-sm p-0 mt-1"
                                        onclick="clearFilterKey('branch_location')">
                                    <small>Hapus filter lokasi</small>
                                </button>
                            @endif
                        </div>

                        <hr>

                        {{-- Filter Warna Emas --}}
                        <div class="mb-3">
                            <div class="small text-muted mb-1">Warna Emas</div>
                            @foreach($goldColors as $color)
                                <div class="catalog-filter-option">
                                    <input
                                        class="catalog-filter-input"
                                        type="checkbox"
                                        name="gold_color"
                                        id="gold_{{ \Illuminate\Support\Str::slug($color) }}"
                                        value="{{ $color }}"
                                        onclick="applyFilter('gold_color', '{{ $color }}')"
                                        {{ in_array((string)$color, array_map('strval', $colorSelected)) ? 'checked' : '' }}>
                                    <label class="catalog-filter-label" for="gold_{{ \Illuminate\Support\Str::slug($color) }}">
                                        {{ $color }}
                                    </label>
                                </div>
                            @endforeach

                            @if(!empty($colorSelected))
                                <button type="button"
                                        class="btn btn-link btn-sm p-0 mt-1"
                                        onclick="clearFilterKey('gold_color')">
                                    <small>Hapus filter warna</small>
                                </button>
                            @endif
                        </div>

                        <hr>

                        {{-- Filter Collection --}}
                        <div class="mb-3">
                            <div class="small text-muted mb-1">Collection</div>
                            @foreach($collections as $col)
                                <div class="catalog-filter-option">
                                    <input
                                        class="catalog-filter-input"
                                        type="checkbox"
                                        name="collection"
                                        id="collection_{{ $loop->index }}"
                                        value="{{ $col }}"
                                        onclick="applyFilter('collection', '{{ $col }}')"
                                        {{ in_array((string)$col, array_map('strval', $collectionSelected)) ? 'checked' : '' }}>
                                    <label class="catalog-filter-label" for="collection_{{ $loop->index }}">
                                        {{ $col }}
                                    </label>
                                </div>
                            @endforeach

                            @if(!empty($collectionSelected))
                                <button type="button"
                                        class="btn btn-link btn-sm p-0 mt-1"
                                        onclick="clearFilterKey('collection')">
                                    <small>Hapus filter collection</small>
                                </button>
                            @endif
                        </div>

                        <hr>

                        {{-- Filter Stok Ready --}}
                        <div class="mb-3">
                            <div class="small text-muted mb-1">Stok</div>
                            <div class="catalog-filter-option">
                                <input
                                    class="catalog-filter-input"
                                    type="checkbox"
                                    name="only_ready"
                                    id="only_ready"
                                    {{ $onlyReady ? 'checked' : '' }}
                                    onclick="applyFilter('only_ready', this.checked ? '1' : '')">
                                <label class="catalog-filter-label" for="only_ready">
                                    Hanya tampilkan stok ready
                                </label>
                            </div>
                        </div>

                        <hr>

                        {{-- Filter Berat --}}
                        <div class="mb-3">
                            <div class="small text-muted mb-1">Berat (gram)</div>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number"
                                           step="0.01"
                                           min="0"
                                           class="form-control form-control-sm"
                                           placeholder="Min"
                                           value="{{ $minWeight }}"
                                           onchange="applyFilter('min_weight', this.value)">
                                </div>
                                <div class="col-6">
                                    <input type="number"
                                           step="0.01"
                                           min="0"
                                           class="form-control form-control-sm"
                                           placeholder="Max"
                                           value="{{ $maxWeight }}"
                                           onchange="applyFilter('max_weight', this.value)">
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Filter Harga --}}
                        <div class="mb-2">
                            <div class="small text-muted mb-1">Harga (Rp)</div>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number"
                                           min="0"
                                           class="form-control form-control-sm"
                                           placeholder="Min"
                                           value="{{ $minPrice }}"
                                           onchange="applyFilter('min_price', this.value)">
                                </div>
                                <div class="col-6">
                                    <input type="number"
                                           min="0"
                                           class="form-control form-control-sm"
                                           placeholder="Max"
                                           value="{{ $maxPrice }}"
                                           onchange="applyFilter('max_price', this.value)">
                                </div>
                            </div>
                        </div>

                        {{-- Tombol reset rentang --}}
                        @if($minWeight || $maxWeight || $minPrice || $maxPrice || !$onlyReady || !empty($branchSelected) || !empty($colorSelected) || !empty($collectionSelected) || !empty($categorySelected) || !empty($karatSelected))
                            <button type="button"
                                    class="btn btn-link btn-sm p-0 mt-1"
                                    onclick="resetRangeFilters()">
                                <small>Reset filter stok, berat, harga, lokasi, warna & collection</small>
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Daftar produk --}}
                <div class="col-lg-9" id="product-grid">
                    {{-- Baris sort --}}
                    <div class="d-flex justify-content-end align-items-center mb-3 small">
                        <span class="me-2 text-muted">Urutkan:</span>
                        <select class="form-select form-select-sm w-auto"
                                onchange="applyFilter('sort', this.value)">
                            <option value="latest" {{ $sort === 'latest' || !$sort ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Terlama</option>
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

                                    // Rating masih dummy
                                    $rating      = 4.8;
                                    $ratingCount = 32;

                                    $stok = $product->stock_status === 'ready'
                                        ? 'Tersedia'
                                        : strtoupper($product->stock_status);

                                    $lokasiCabang = $product->branch_location ?: 'Cabang';
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

                                                {{-- (Opsional) Warna Emas --}}
                                                @if($product->gold_color)
                                                    <div class="small text-muted">
                                                        {{ $product->gold_color }}
                                                    </div>
                                                @endif

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
                        <div class="mt-4 d-flex justify-content-center">
                            {{ $products->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // keys that support multiple selection (we will use bracket notation key[])
        const MULTI_KEYS = ['category', 'karat', 'branch_location', 'gold_color', 'collection'];

        function isMultiKey(key) {
            return MULTI_KEYS.includes(key);
        }

        function paramNameFor(key) {
            return isMultiKey(key) ? key + '[]' : key;
        }

        function applyFilter(key, value) {
            const url = new URL(window.location.href);
            const pname = paramNameFor(key);

            if (value === '' || value === null) {
                // explicit clear of this filter key
                url.searchParams.delete(pname);
            } else if (isMultiKey(key)) {
                // get all existing values for pname
                const current = url.searchParams.getAll(pname);

                if (current.includes(value)) {
                    // remove that value
                    const remaining = current.filter(v => v !== value);
                    url.searchParams.delete(pname);
                    remaining.forEach(v => url.searchParams.append(pname, v));
                } else {
                    // append new value (as repeated pname)
                    url.searchParams.append(pname, value);
                }
            } else {
                // single-value key
                const current = url.searchParams.get(pname);
                if (current === value) {
                    url.searchParams.delete(pname);
                } else {
                    url.searchParams.set(pname, value);
                }
            }

            // setiap ganti filter/sort, kembali ke halaman 1
            url.searchParams.delete('page');

            // scroll langsung ke area produk setelah reload
            url.hash = 'product-grid';

            window.location.href = url.toString();
        }

        function clearFilterKey(key) {
            const url = new URL(window.location.href);
            const pname = paramNameFor(key);
            url.searchParams.delete(pname);
            url.searchParams.delete('page');
            url.hash = 'product-grid';
            window.location.href = url.toString();
        }

        function resetRangeFilters() {
            const url = new URL(window.location.href);
            url.searchParams.delete('min_weight');
            url.searchParams.delete('max_weight');
            url.searchParams.delete('min_price');
            url.searchParams.delete('max_price');
            // kembalikan filter stok ready ke default: true
            url.searchParams.set('only_ready', '1');
            // juga hapus lokasi, warna, collection, kategori, karat (multi keys)
            ['branch_location', 'gold_color', 'collection', 'category', 'karat'].forEach(k => {
                url.searchParams.delete(paramNameFor(k));
            });
            url.searchParams.delete('page');
            url.hash = 'product-grid';
            window.location.href = url.toString();
        }
    </script>
@endsection
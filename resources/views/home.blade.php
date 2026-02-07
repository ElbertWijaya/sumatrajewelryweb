@extends('layouts.app')

@section('title', 'Toko Mas Sumatra - Official Store')
@section('nav_home_active', 'active')

{{-- Tambahan konten di sisi kanan navbar (Auth) --}}
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

    {{-- Tentang Toko --}}
    <div class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-md-6">
                    <h2 class="fw-bold mb-3">Tentang Toko Mas Sumatra</h2>
                    <div style="width: 60px; height: 3px; background: #c5a059; margin-bottom: 16px;"></div>
                    <p class="text-muted mb-3">
                        Toko Mas Sumatra hadir sebagai mitra terpercaya Anda dalam memilih perhiasan emas, 
                        baik untuk kebutuhan sehari-hari, hadiah spesial, maupun investasi jangka panjang.
                    </p>
                    <p class="text-muted mb-3">
                        Kami berkomitmen menyediakan emas berkualitas dengan harga yang jelas dan wajar, 
                        ditunjang layanan konsultasi ramah serta proses transaksi yang aman dan nyaman.
                    </p>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Emas bersertifikat dengan kadar terukur.
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Melayani pembelian ready stock maupun pesanan custom.
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Layanan buyback dan penyesuaian desain tertentu.
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <div class="border rounded-3 p-4 bg-white shadow-sm h-100">
                        <h5 class="fw-semibold mb-3">
                            Mengapa berbelanja di Toko Mas Sumatra?
                        </h5>
                        <div class="d-flex mb-3">
                            <div class="me-3">
                                <span class="rounded-circle bg-warning bg-opacity-25 d-inline-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                                    <i class="bi bi-shield-check text-warning fs-4"></i>
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-1">Transparansi Harga</h6>
                                <p class="mb-0 small text-muted">
                                    Harga emas selalu disesuaikan dengan harga pasar terkini dan ditampilkan secara terbuka.
                                </p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="me-3">
                                <span class="rounded-circle bg-warning bg-opacity-25 d-inline-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                                    <i class="bi bi-gem text-warning fs-4"></i>
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-1">Desain Eksklusif & Custom</h6>
                                <p class="mb-0 small text-muted">
                                    Pilihan desain siap pakai dan layanan pembuatan perhiasan custom sesuai keinginan Anda.
                                </p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="me-3">
                                <span class="rounded-circle bg-warning bg-opacity-25 d-inline-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                                    <i class="bi bi-people text-warning fs-4"></i>
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-1">Layanan Ramah & Profesional</h6>
                                <p class="mb-0 small text-muted">
                                    Tim kami siap membantu Anda memilih perhiasan yang tepat sesuai kebutuhan dan anggaran.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Lokasi & Kontak --}}
    <div class="py-5">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold">Lokasi & Kontak</h2>
                <div style="width: 60px; height: 3px; background: #c5a059; margin: 10px auto;"></div>
                <p class="text-muted mb-0">
                    Silakan berkunjung langsung ke toko kami atau hubungi untuk konsultasi dan pemesanan.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="border rounded-3 p-4 h-100 bg-light">
                        <h5 class="mb-3">
                            <i class="bi bi-geo-alt-fill text-warning me-2"></i>
                            Alamat Toko
                        </h5>
                        {{-- GANTI TEKS BERIKUT DENGAN ALAMAT TOKO ANDA --}}
                        <p class="mb-1 fw-semibold">
                            Toko Mas Sumatra
                        </p>
                        <p class="mb-3 text-muted">
                            [Tuliskan alamat lengkap toko di sini, misalnya:  
                            Jl. Contoh No. 123, Pasar Emas Sumatra, Kota/Kabupaten, Provinsi.]
                        </p>
                        <p class="mb-1">
                            <strong>Jam Operasional:</strong><br>
                            <span class="text-muted">
                                Senin – Sabtu: 09.00 – 17.00 WIB<br>
                                Minggu / Hari Libur: menyesuaikan.
                            </span>
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="border rounded-3 p-4 h-100 bg-light">
                        <h5 class="mb-3">
                            <i class="bi bi-telephone-fill text-warning me-2"></i>
                            Kontak & Pemesanan
                        </h5>
                        {{-- GANTI NOMOR & LINK BERIKUT DENGAN DATA NYATA --}}
                        <p class="mb-2">
                            <strong>Telepon / WhatsApp:</strong><br>
                            <a href="https://wa.me/6281234567890" target="_blank" class="text-decoration-none">
                                +62 812-3456-7890
                            </a>
                        </p>
                        <p class="mb-3">
                            <strong>Email:</strong><br>
                            <a href="mailto:info@tokomassumatra.com" class="text-decoration-none">
                                info@tokomassumatra.com
                            </a>
                        </p>
                        <p class="mb-3 small text-muted">
                            Untuk pemesanan custom, Anda dapat menghubungi kami terlebih dahulu 
                            melalui WhatsApp untuk konsultasi desain, estimasi harga, dan waktu pengerjaan.
                        </p>
                        {{-- OPSIONAL: tombol CTA --}}
                        <div class="d-flex flex-wrap gap-2">
                            <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-success btn-sm">
                                <i class="bi bi-whatsapp me-1"></i> Chat via WhatsApp
                            </a>
                            <a href="#katalog" class="btn btn-outline-dark btn-sm">
                                Lihat Koleksi di Website
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- OPSIONAL: embed maps nantinya bisa ditambahkan di sini --}}
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
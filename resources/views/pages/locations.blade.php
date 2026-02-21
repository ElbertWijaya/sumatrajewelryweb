@extends('layouts.app')

@section('title', 'Lokasi & Kontak - Toko Mas Sumatra')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center mb-4">
        <div class="col-lg-8 text-center">
            <h1 class="fw-bold mb-2">Lokasi & Kontak</h1>
            <div style="width: 80px; height: 3px; background: #c5a059; margin: 10px auto 20px;"></div>
            <p class="text-muted">
                Toko Mas Sumatra hadir di dua lokasi untuk memudahkan Anda berkunjung dan berkonsultasi langsung 
                mengenai kebutuhan perhiasan emas Anda.
            </p>
        </div>
    </div>

    <div class="row gy-4 mb-4">
        {{-- Cabang Asia --}}
        <div class="col-md-6">
            <div class="border rounded-3 p-4 h-100 bg-light">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h4 class="fw-semibold mb-1">Toko Mas Sumatra - Asia</h4>
                        <p class="small text-muted mb-0">Cabang Asia • Toko Pusat</p>
                    </div>
                    <span class="badge bg-dark text-uppercase small">Offline Store</span>
                </div>

                <div class="row g-3 align-items-start">
                    <div class="col-12 col-lg-6">
                        <p class="mb-2 small">
                            <strong><i class="bi bi-geo-alt me-1"></i>Alamat</strong><br>
                            <span class="text-muted">
                                Jl. Asia No.170 B, Sei Rengas II, Kec. Medan Area,<br>
                                Kota Medan, Sumatera Utara 20211
                            </span>
                        </p>

                        <p class="mb-2 small">
                            <strong><i class="bi bi-clock me-1"></i>Jam Operasional</strong><br>
                            <span class="text-muted">
                                Buka setiap hari 09.00 &ndash; 16.30 WIB<br>
                                (Tutup pada hari Minggu)
                            </span>
                        </p>

                        <p class="mb-0 small">
                            <strong><i class="bi bi-whatsapp me-1"></i>Telepon / WhatsApp</strong><br>
                            <a href="https://wa.me/6282164836268" target="_blank" class="text-decoration-none fw-semibold">
                                0821-6483-6268
                            </a>
                        </p>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm">
                            <iframe
                                src="https://www.google.com/maps?q=Jl.+Asia+No.170+B,+Sei+Rengas+II,+Medan+Area,+Medan+20211&output=embed"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cabang Sun Plaza --}}
        <div class="col-md-6">
            <div class="border rounded-3 p-4 h-100 bg-white">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h4 class="fw-semibold mb-1">Sumatra Jewellery - Sun Plaza</h4>
                        <p class="small text-muted mb-0">Cabang Sun Plaza • Mall</p>
                    </div>
                    <span class="badge bg-secondary text-uppercase small">Mall Store</span>
                </div>

                <div class="row g-3 align-items-start">
                    <div class="col-12 col-lg-6">
                        <p class="mb-2 small">
                            <strong><i class="bi bi-geo-alt me-1"></i>Alamat</strong><br>
                            <span class="text-muted">
                                Mall Jl. KH. Zainul Arifin No.7, Madras Hulu, Kec. Medan Polonia,<br>
                                Kota Medan, Sumatera Utara 20152
                            </span>
                        </p>

                        <p class="mb-2 small">
                            <strong><i class="bi bi-clock me-1"></i>Jam Operasional</strong><br>
                            <span class="text-muted">
                                Buka setiap hari 11.00 &ndash; 21.00 WIB
                            </span>
                        </p>

                        <p class="mb-0 small">
                            <strong><i class="bi bi-telephone me-1"></i>Telepon</strong><br>
                            <a href="tel:+62614501879" class="text-decoration-none fw-semibold">
                                (061) 4501879
                            </a>
                        </p>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm">
                            <iframe
                                src="https://www.google.com/maps?q=Sun+Plaza+Medan,+Jl.+KH.+Zainul+Arifin+No.7,+Medan+20152&output=embed"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kontak umum / online --}}
    <div class="row justify-content-center mt-4">
        <div class="col-lg-8">
            <div class="border rounded-3 p-4 bg-white shadow-sm">
                <h5 class="fw-semibold mb-3">Kontak Umum & Layanan Online</h5>
                <p class="small text-muted mb-3">
                    Untuk pertanyaan seputar ketersediaan produk, layanan custom, maupun pemesanan jarak jauh,
                    tim kami siap membantu Anda melalui kanal berikut:
                </p>
                <div class="row g-3 small text-muted">
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="me-2 text-gold"><i class="bi bi-envelope-open fs-5"></i></div>
                            <div>
                                <div class="fw-semibold mb-1">Email Resmi</div>
                                <a href="mailto:info@tokomassumatra.com" class="text-decoration-none">
                                    info@tokomassumatra.com
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="me-2 text-success"><i class="bi bi-whatsapp fs-5"></i></div>
                            <div>
                                <div class="fw-semibold mb-1">WhatsApp Pusat Layanan</div>
                                <a href="https://wa.me/6282164836268" target="_blank" class="text-decoration-none fw-semibold">
                                    0821-6483-6268 (Cabang Asia)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
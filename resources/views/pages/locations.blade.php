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
        {{-- Dua kartu cabang sejajar --}}
        <div class="col-md-6">
            <button type="button"
                    class="store-location-card w-100 text-start border rounded-3 p-3 bg-white shadow-sm active"
                    data-store-map="https://www.google.com/maps?q=Jl.+Asia+No.170+B,+Sei+Rengas+II,+Medan+Area,+Medan+20211&output=embed">
                <div class="d-flex align-items-start mb-2">
                    <i class="bi bi-geo-alt text-gold me-2 mt-1"></i>
                    <div>
                        <div class="fw-semibold">Toko Mas Sumatra - Asia</div>
                        <div class="small text-muted">Jl. Asia No.170 B, Sei Rengas II, Medan Area, Kota Medan 20211</div>
                    </div>
                </div>
                <div class="small text-muted mb-1">
                    <i class="bi bi-clock me-1"></i>
                    09.00 &ndash; 16.30 WIB (tutup Minggu)
                </div>
                <div class="small">
                    <i class="bi bi-whatsapp text-success me-1"></i>
                    <span class="fw-semibold">0821-6483-6268</span>
                </div>
            </button>
        </div>

        <div class="col-md-6">
            <button type="button"
                    class="store-location-card w-100 text-start border rounded-3 p-3 bg-white shadow-sm"
                    data-store-map="https://www.google.com/maps?q=Sun+Plaza+Medan,+Jl.+KH.+Zainul+Arifin+No.7,+Medan+20152&output=embed">
                <div class="d-flex align-items-start mb-2">
                    <i class="bi bi-geo-alt text-gold me-2 mt-1"></i>
                    <div>
                        <div class="fw-semibold">Sumatra Jewellery - Sun Plaza</div>
                        <div class="small text-muted">Mall Jl. KH. Zainul Arifin No.7, Madras Hulu, Medan Polonia, Kota Medan 20152</div>
                    </div>
                </div>
                <div class="small text-muted mb-1">
                    <i class="bi bi-clock me-1"></i>
                    11.00 &ndash; 21.00 WIB
                </div>
                <div class="small">
                    <i class="bi bi-telephone text-muted me-1"></i>
                    <span class="fw-semibold">(061) 4501879</span>
                </div>
            </button>
        </div>
    </div>

    {{-- Peta di bawah dua kartu --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="border rounded-3 p-3 bg-light shadow-sm">
                <h6 class="fw-semibold mb-2">Peta Lokasi Toko</h6>
                <p class="small text-muted mb-3">Pilih salah satu cabang di atas untuk melihat posisinya pada peta.</p>

                <div class="ratio ratio-16x9 rounded overflow-hidden">
                    <iframe
                        id="storeMap"
                        src="https://www.google.com/maps?q=Jl.+Asia+No.170+B,+Sei+Rengas+II,+Medan+Area,+Medan+20211&output=embed"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
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
</div>
@push('styles')
    .store-location-card {
        cursor: pointer;
        transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
    }

    .store-location-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
    }

    .store-location-card.active {
        border-color: #c5a059;
        box-shadow: 0 8px 20px rgba(197, 160, 89, 0.25);
    }
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var items = document.querySelectorAll('.store-location-card');
        var iframe = document.getElementById('storeMap');

        if (!items.length || !iframe) return;

        items.forEach(function (item) {
            item.addEventListener('click', function () {
                var src = this.getAttribute('data-store-map');
                if (!src) return;

                iframe.setAttribute('src', src);

                items.forEach(function (el) { el.classList.remove('active'); });
                this.classList.add('active');
            });
        });
    });
</script>
@endpush
@endsection
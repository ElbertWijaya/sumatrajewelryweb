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
        {{-- Cabang 1 --}}
        <div class="col-md-6">
            <div class="border rounded-3 p-4 h-100 bg-light">
                <h4 class="fw-semibold mb-1">Cabang 1 - [Nama Lokasi]</h4>
                <p class="small text-muted mb-3">Toko Pusat</p>

                <p class="mb-2 small">
                    <strong>Alamat:</strong><br>
                    <span class="text-muted">
                        [Tuliskan alamat lengkap cabang 1 di sini.]
                    </span>
                </p>

                <p class="mb-2 small">
                    <strong>Jam Operasional:</strong><br>
                    <span class="text-muted">
                        Senin – Sabtu: 09.00 – 17.00 WIB<br>
                        Minggu / Hari Libur: menyesuaikan.
                    </span>
                </p>

                <p class="mb-2 small">
                    <strong>Telepon / WhatsApp:</strong><br>
                    <a href="https://wa.me/6281234567890" target="_blank" class="text-decoration-none">
                        +62 812-3456-7890
                    </a>
                </p>

                {{-- OPSIONAL: embed maps cabang 1 --}}
                {{-- <div class="mt-3">
                    <iframe src="URL_GOOGLE_MAPS_CABANG_1" ...></iframe>
                </div> --}}
            </div>
        </div>

        {{-- Cabang 2 --}}
        <div class="col-md-6">
            <div class="border rounded-3 p-4 h-100 bg-light">
                <h4 class="fw-semibold mb-1">Cabang 2 - [Nama Lokasi]</h4>
                <p class="small text-muted mb-3">Cabang</p>

                <p class="mb-2 small">
                    <strong>Alamat:</strong><br>
                    <span class="text-muted">
                        [Tuliskan alamat lengkap cabang 2 di sini.]
                    </span>
                </p>

                <p class="mb-2 small">
                    <strong>Jam Operasional:</strong><br>
                    <span class="text-muted">
                        Senin – Sabtu: 09.00 – 17.00 WIB<br>
                        Minggu / Hari Libur: menyesuaikan.
                    </span>
                </p>

                <p class="mb-2 small">
                    <strong>Telepon / WhatsApp:</strong><br>
                    <a href="https://wa.me/6289876543210" target="_blank" class="text-decoration-none">
                        +62 898-7654-3210
                    </a>
                </p>

                {{-- OPSIONAL: embed maps cabang 2 --}}
            </div>
        </div>
    </div>

    {{-- Kontak umum / online --}}
    <div class="row justify-content-center mt-4">
        <div class="col-lg-8">
            <div class="border rounded-3 p-4 bg-white shadow-sm">
                <h5 class="fw-semibold mb-2">Kontak Umum & Layanan Online</h5>
                <p class="small text-muted mb-2">
                    Jika Anda memiliki pertanyaan seputar ketersediaan produk, layanan custom, atau informasi lainnya, 
                    Anda dapat menghubungi kami melalui:
                </p>
                <ul class="small text-muted mb-0">
                    <li class="mb-1">
                        Email: 
                        <a href="mailto:info@tokomassumatra.com" class="text-decoration-none">
                            info@tokomassumatra.com
                        </a>
                    </li>
                    <li class="mb-1">
                        WhatsApp pusat layanan:
                        <a href="https://wa.me/6281234567890" target="_blank" class="text-decoration-none fw-semibold">
                            +62 812-3456-7890
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
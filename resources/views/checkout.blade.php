@extends('layouts.app')

@section('title', 'Checkout - Toko Mas Sumatra')
@section('nav_home_active', '') 

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
<div class="container py-5">
    <div class="row">
        {{-- Form checkout --}}
        <div class="col-md-7">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Informasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" required placeholder="Contoh: Nama customer...">
                            </div>
                            <div class="col">
                                <label class="form-label">Nomor WhatsApp</label>
                                <input type="text" name="phone_number" class="form-control" required placeholder="0812...">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                            <small class="text-muted">Nota digital akan dikirim ke sini.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="address" class="form-control" rows="3" required placeholder="Jalan, Nomor Rumah, Kecamatan, Kota..."></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Metode Pembayaran</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="transfer" value="transfer" checked>
                                <label class="form-check-label" for="transfer">
                                    Transfer Bank (Upload bukti pembayaran setelah ini)
                                </label>
                            </div>
                            {{-- Tambahkan opsi lain nanti bila perlu --}}
                        </div>

                        <button type="submit" class="btn btn-gold px-4">
                            Lanjutkan & Buat Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Ringkasan pesanan --}}
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Ringkasan Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        @if($product->image_url)
                            <img src="{{ asset('uploads/' . $product->image_url) }}" width="80" class="rounded me-3" alt="{{ $product->name }}">
                        @else
                            <div class="bg-secondary rounded me-3" style="width:80px; height:80px;"></div>
                        @endif
                        <div>
                            <h6 class="mb-0">{{ $product->name }}</h6>
                            <small class="text-muted">
                                {{ $product->karat_type }} | {{ $product->weight }} gr
                            </small>
                        </div>
                    </div>
                    <hr>
                    @php
                        $hargaDasar = ($product->karat_type == '24K')
                            ? $goldPrice24k->sell_price_per_gram
                            : ($goldPrice24k->sell_price_per_gram * 0.8);
                        $estimasiHarga = ($product->weight * $hargaDasar)
                            + $product->labor_cost
                            + $product->stone_price;
                    @endphp
                    <div class="d-flex justify-content-between mb-2">
                        <span>Harga Perkiraan</span>
                        <span>Rp {{ number_format($estimasiHarga, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Ongkir (Perkiraan)</span>
                        <span>Rp 0</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total Pembayaran</span>
                        <span>Rp {{ number_format($estimasiHarga, 0, ',', '.') }}</span>
                    </div>
                    <small class="text-muted d-block mt-2">
                        *Total final bisa berbeda sedikit saat admin melakukan konfirmasi.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
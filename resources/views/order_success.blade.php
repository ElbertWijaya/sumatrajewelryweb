@extends('layouts.app')

@section('title', 'Pesanan Berhasil - Toko Mas Sumatra')
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
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body text-center p-4">
                    @php
                        $isPaid   = $order->payment_status === 'paid';
                        $isShipped = $order->order_status === 'ready_to_ship';

                        // Tentukan emoji & judul utama
                        if ($isShipped) {
                            $statusEmoji = '🚚';  // atau ganti '🚢' kalau mau kapal
                            $statusTitle = 'Pesanan Sedang Dikirim';
                        } elseif ($isPaid) {
                            $statusEmoji = '✅';
                            $statusTitle = 'Pembayaran Berhasil Diterima';
                        } else {
                            $statusEmoji = '💰';
                            $statusTitle = 'Pesanan Berhasil Dibuat';
                        }
                    @endphp

                    {{-- Icon status dinamis --}}
                    <div class="mb-3">
                        <span class="rounded-circle d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10" style="width:70px; height:70px;">
                            <span style="font-size: 2.2rem;">{{ $statusEmoji }}</span>
                        </span>
                    </div>

                    <h3 class="mb-2">{{ $statusTitle }}</h3>

                    {{-- Pesan berbeda tipis paid vs unpaid vs shipped --}}
                    @if($isShipped)
                        <p class="text-muted mb-3">
                            Pesanan Anda sudah dikirim. Silakan pantau proses pengiriman melalui Dashboard Customer.
                        </p>
                    @elseif($isPaid)
                        <p class="text-muted mb-3">
                            Terima kasih, pembayaran Anda sudah kami terima dan pesanan sedang kami proses.
                        </p>
                    @else
                        <p class="text-muted mb-3">
                            Terima kasih, pesanan Anda sudah kami terima. Silakan selesaikan pembayaran sesuai instruksi di bawah ini.
                        </p>
                    @endif

                    {{-- Info ringkas pesanan --}}
                    <div class="text-start border rounded p-3 mb-3 bg-light">
                        <p class="mb-1">
                            <strong>No. Invoice:</strong> {{ $order->invoice_number ?? '-' }}
                        </p>
                        <p class="mb-1">
                            <strong>Nama Pemesan:</strong> {{ $order->user->name ?? '-' }}
                        </p>
                        <p class="mb-1">
                            <strong>Total Harga:</strong>
                            Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}
                        </p>
                        @if(!empty($order->tracking_number))
                            <p class="mb-1">
                                <strong>No. Resi:</strong> {{ $order->tracking_number }}
                            </p>
                        @endif
                        <p class="mb-0 text-muted">
                            <small>*Rincian lengkap dapat dilihat di Dashboard Customer.</small>
                        </p>
                    </div>

                    @if($isShipped)
                        {{-- Sudah dikirim: hanya info + tombol ke dashboard --}}
                        <div class="alert alert-info">
                            Pesanan Anda sedang dalam proses pengiriman. Terima kasih sudah berbelanja di Toko Mas Sumatra.
                        </div>

                        <a href="{{ route('customer.dashboard') }}" class="btn btn-primary mt-3">
                            Cek Status Pengiriman
                        </a>
                    @elseif($isPaid)
                        {{-- Sudah dibayar: info + tombol ke dashboard --}}
                        <div class="alert alert-success">
                            Pembayaran sudah terverifikasi. Pesanan Anda sedang diproses oleh admin.
                        </div>

                        <a href="{{ route('customer.dashboard') }}" class="btn btn-primary mt-3">
                            Cek Status di Dashboard
                        </a>
                    @else
                        {{-- Belum dibayar: instruksi transfer + upload bukti --}}
                        <div class="text-start">
                            <div class="bg-warning bg-opacity-10 p-3 rounded border border-warning mb-3">
                                <p class="mb-1 fw-bold">Silakan Transfer ke:</p>
                                <h5 class="mb-0">BCA 123-456-7890 (Toko Mas Sumatra)</h5>
                            </div>

                            <form action="{{ route('payment.upload', $order->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">
                                        @if($order->payment_proof)
                                            Foto Ulang / Ganti Bukti Pembayaran
                                        @else
                                            Upload Foto Bukti Pembayaran
                                        @endif
                                    </label>
                                    <input type="file" name="payment_proof" class="form-control" accept="image/*" required>
                                    <small class="text-muted">
                                        Format: JPG/PNG. Maks 10MB. Anda dapat mengirim ulang bukti jika foto sebelumnya kurang jelas.
                                    </small>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                                    Kirim Bukti Pembayaran
                                </button>
                            </form>

                            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary w-100 mt-3">
                                Nanti Saja, Kembali ke Dashboard
                            </a>
                        </div>
                    @endif

                    <hr class="my-4">

                    <a href="{{ route('home') }}" class="btn btn-link text-decoration-none">
                        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
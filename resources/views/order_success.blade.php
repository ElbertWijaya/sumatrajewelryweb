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
                    {{-- Icon sukses --}}
                    <div class="mb-3">
                        <span class="rounded-circle d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10" style="width:70px; height:70px;">
                            <i class="bi bi-check2-circle text-success" style="font-size: 2.2rem;"></i>
                        </span>
                    </div>

                    <h3 class="mb-2">Pesanan Berhasil Dibuat</h3>
                    <p class="text-muted mb-3">
                        Terima kasih, pesanan Anda sudah kami terima. Silakan ikuti instruksi di bawah ini untuk menyelesaikan pembayaran.
                    </p>

                    {{-- Info ringkas pesanan --}}
                    <div class="text-start border rounded p-3 mb-3 bg-light">
                        <p class="mb-1"><strong>Kode Pesanan:</strong> {{ $order->order_code ?? '-' }}</p>
                        <p class="mb-1"><strong>Nama Pemesan:</strong> {{ $order->name ?? $order->user->name ?? '-' }}</p>
                        <p class="mb-1"><strong>Total Pembayaran:</strong> 
                            Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}
                        </p>
                        <p class="mb-0 text-muted">
                            <small>*Detail lengkap dapat dilihat di Dashboard Customer.</small>
                        </p>
                    </div>

                    @if(isset($order->is_paid) && $order->is_paid)
                        {{-- Jika sudah dibayar --}}
                        <div class="alert alert-success">
                            Pembayaran Anda sudah kami konfirmasi. 
                            <br>Silakan pantau proses selanjutnya di dashboard.
                        </div>

                        <a href="{{ route('customer.dashboard') }}" class="btn btn-primary mt-3">
                            Cek Status di Dashboard
                        </a>
                    @else
                        {{-- Jika belum dibayar: instruksi transfer + upload bukti --}}
                        <div class="text-start">
                            <div class="bg-warning bg-opacity-10 p-3 rounded border border-warning mb-3">
                                <p class="mb-1 fw-bold">Silakan Transfer ke:</p>
                                <h5 class="mb-0">BCA 123-456-7890 (Toko Mas Sumatra)</h5>
                            </div>

                            <form action="{{ route('payment.upload', $order->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Upload Foto Bukti Transfer</label>
                                    <input type="file" name="payment_proof" class="form-control" accept="image/*" required>
                                    <small class="text-muted">Format: JPG/PNG. Maks 10MB.</small>
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
@extends('layouts.app')

@section('title', 'Verifikasi Nomor Telepon - Toko Mas Sumatra')

@section('content')
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body p-4 p-lg-5">
                        <h3 class="fw-bold mb-2 text-center">Verifikasi Nomor Telepon</h3>
                        <p class="text-muted small text-center mb-4">
                            Kami telah mengirim kode OTP ke nomor di bawah ini. Masukkan kode untuk melanjutkan.
                        </p>

                        @if ($errors->any())
                            <div class="alert alert-danger small">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register.phone.verify') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Nomor Telepon</label>
                                <input type="text" name="phone_number" class="form-control form-control-lg" value="{{ old('phone_number', $phone) }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Kode OTP</label>
                                <input type="text" name="otp" class="form-control form-control-lg @error('otp') is-invalid @enderror" placeholder="6 digit kode" required>
                                @error('otp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Nama Lengkap (opsional)</label>
                                <input type="text" name="name" class="form-control form-control-lg" value="{{ old('name') }}" placeholder="Nama Anda">
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-dark btn-lg">VERIFIKASI &amp; MASUK</button>
                            </div>

                            <div class="text-center small mt-3">
                                <a href="{{ route('login') }}">Kembali ke halaman masuk</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

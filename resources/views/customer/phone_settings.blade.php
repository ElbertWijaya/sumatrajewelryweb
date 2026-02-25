@extends('layouts.app')

@section('title', 'Pengaturan Nomor Telepon - Toko Mas Sumatra')

@section('content')
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body p-4 p-lg-5">
                        <h3 class="fw-bold mb-2">Pengaturan Nomor Telepon</h3>
                        <p class="text-muted small mb-4">
                            Nomor telepon yang terverifikasi akan digunakan untuk keamanan akun dan akses cepat via OTP.
                        </p>

                        @if (session('status'))
                            <div class="alert alert-success small">{{ session('status') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger small">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-4">
                            <h6 class="fw-semibold mb-1">Status Saat Ini</h6>
                            <p class="small mb-1">
                                <span class="fw-semibold">Nomor:</span>
                                @if($user->phone_number)
                                    {{ $user->phone_number }}
                                @else
                                    <span class="text-muted">Belum diatur</span>
                                @endif
                            </p>
                            <p class="small mb-0">
                                <span class="fw-semibold">Verifikasi:</span>
                                @if($user->phone_verified_at)
                                    <span class="badge bg-success">Terverifikasi</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum terverifikasi</span>
                                @endif
                            </p>
                        </div>

                        <hr>

                        @if(empty($otpStep) || empty($phoneForOtp))
                            {{-- Langkah 1: input nomor telepon --}}
                            <form method="POST" action="{{ route('account.phone.sendOtp') }}" class="mb-4">
                                @csrf
                                <h6 class="fw-semibold mb-2">1. Masukkan Nomor Telepon</h6>
                                <p class="small text-muted">Masukkan nomor telepon yang ingin Anda hubungkan ke akun ini. Kami akan mengirim kode OTP untuk verifikasi.</p>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Nomor Telepon</label>
                                    <input type="tel" name="phone_number" class="form-control form-control-lg @error('phone_number') is-invalid @enderror"
                                           value="{{ old('phone_number', $user->phone_number) }}" placeholder="Contoh: 0882015043857" required>
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-dark btn-lg">KIRIM KODE OTP</button>
                                </div>
                            </form>
                        @else
                            {{-- Langkah 2: input OTP --}}
                            <form method="POST" action="{{ route('account.phone.verify') }}" class="mb-4">
                                @csrf
                                <h6 class="fw-semibold mb-2">2. Masukkan Kode OTP</h6>
                                <p class="small text-muted">Masukkan kode OTP yang Anda terima untuk nomor <strong>{{ $phoneForOtp }}</strong>.</p>

                                <input type="hidden" name="phone_number" value="{{ $phoneForOtp }}">

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Kode OTP</label>
                                    <input type="text" name="otp" class="form-control form-control-lg @error('otp') is-invalid @enderror" placeholder="6 digit kode" required>
                                    @error('otp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-gold btn-lg text-dark">VERIFIKASI NOMOR</button>
                                </div>
                            </form>

                            <div class="d-flex justify-content-between small">
                                <form method="POST" action="{{ route('account.phone.sendOtp') }}">
                                    @csrf
                                    <input type="hidden" name="phone_number" value="{{ $phoneForOtp }}">
                                    <button type="submit" class="btn btn-link p-0">Kirim ulang kode</button>
                                </form>

                                <a href="{{ route('account.phone', ['reset' => 1]) }}" class="text-decoration-none">Ubah nomor telepon</a>
                            </div>
                        @endif

                        <div class="text-center small mt-3">
                            <a href="{{ route('customer.dashboard') }}">&larr; Kembali ke Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

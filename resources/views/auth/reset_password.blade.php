@extends('layouts.app')

@section('title', 'Atur Ulang Password - Toko Mas Sumatra')

@section('content')
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body p-4 p-lg-5">
                        <h3 class="fw-bold mb-2 text-center">Atur Ulang Password</h3>
                        <p class="text-muted small text-center mb-4">
                            Masukkan password baru untuk akun Anda.
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

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Alamat Email</label>
                                <input type="email" name="email" value="{{ old('email', $email) }}" required
                                       class="form-control form-control-lg @error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Password Baru</label>
                                <input type="password" name="password" required
                                       class="form-control form-control-lg @error('password') is-invalid @enderror">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" required
                                       class="form-control form-control-lg">
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-dark btn-lg">SIMPAN PASSWORD BARU</button>
                            </div>
                        </form>

                        <div class="text-center small mt-3">
                            <a href="{{ route('login') }}">Kembali ke halaman masuk</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Lupa Password - Toko Mas Sumatra')

@section('content')
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body p-4 p-lg-5">
                        <h3 class="fw-bold mb-2 text-center">Lupa Password</h3>
                        <p class="text-muted small text-center mb-4">
                            Masukkan email yang terdaftar. Kami akan mengirimkan link untuk mengatur ulang password Anda.
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

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Alamat Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                                       placeholder="nama@email.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-dark btn-lg">KIRIM LINK RESET PASSWORD</button>
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

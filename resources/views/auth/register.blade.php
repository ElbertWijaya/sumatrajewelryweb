@extends('layouts.app')

@section('title', 'Daftar - Toko Mas Sumatra')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h4 class="mb-3">Buat Akun</h4>

                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-dark">Daftar Sekarang</button>
                        </div>
                    </form>

                    <hr class="my-3">

                    <p class="small text-center text-muted mb-0">
                        Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
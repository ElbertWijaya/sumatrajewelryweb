<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Masuk - Toko Mas Sumatra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f4f4f4; font-family: 'Lato', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .text-gold { color: #c5a059; }
        .btn-gold { background-color: #c5a059; color: white; border: none; }
        .btn-gold:hover { background-color: #b08d4b; color: white; }
        .card-login { border: none; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .divider-text { display: flex; align-items: center; text-align: center; color: #999; }
        .divider-text::before, .divider-text::after { content: ''; flex: 1; border-bottom: 1px solid #ddd; }
        .divider-text:not(:empty)::before { margin-right: .5em; }
        .divider-text:not(:empty)::after { margin-left: .5em; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5">
            <div class="text-center mb-4">
                <h2 class="font-serif fw-bold">Toko Mas Sumatra</h2>
                <p class="text-muted">Portal Akses Layanan Digital</p>
            </div>

            <div class="card card-login bg-white">
                <div class="card-body p-5">
                    
                    <h4 class="mb-4 text-center fw-bold">Masuk ke Akun</h4>

                    <form action="{{ route('login.process') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small text-uppercase fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-lg bg-light" placeholder="nama@email.com" required value="{{ old('email') }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted small text-uppercase fw-bold">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg bg-light" placeholder="********" required>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 py-3 fw-bold fs-5 shadow-sm">
                            MASUK SEKARANG
                        </button>
                    </form>

                    <div class="divider-text my-4">atau akses sebagai</div>

                    <div class="row g-2">
                        <div class="col-6">
                            <button class="btn btn-outline-secondary w-100 btn-sm" disabled>
                                <i class="bi bi-person"></i> Pelanggan
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-warning w-100 btn-sm text-dark" disabled>
                                <i class="bi bi-shield-lock"></i> Staff Admin
                            </button>
                        </div>
                    </div>
                    <p class="text-center mt-3 small text-muted">
                        *Sistem akan otomatis mendeteksi tipe akun Anda (Staff/Pelanggan) setelah login.
                    </p>

                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="text-decoration-none text-muted">&larr; Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
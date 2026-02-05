<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Toko Mas Sumatra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Lato', sans-serif; background-color: #f8f9fa; }
        h1, h2, h3 { font-family: 'Playfair Display', serif; }
        .text-gold { color: #c5a059; }
        .btn-gold { background-color: #c5a059; color: white; border: none; padding: 12px 30px; }
        .btn-gold:hover { background-color: #b08d4b; color: white; }
        .breadcrumb a { text-decoration: none; color: #6c757d; }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand text-gold" href="{{ route('home') }}">Toko Mas Sumatra</a>
            <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm">Kembali ke Katalog</a>
        </div>
    </nav>

    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="#">Koleksi</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row mt-4">
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    @if($product->image_url)
                        <img src="{{ asset('uploads/' . $product->image_url) }}" class="img-fluid rounded" style="width: 100%; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                            <span class="text-muted">Foto Belum Tersedia</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <h1 class="mb-2">{{ $product->name }}</h1>
                <p class="text-muted">SKU: {{ $product->sku }}</p>
                
                <hr>

                @php
                    $hargaDasar = ($product->karat_type == '24K') ? $goldPrice24k->sell_price_per_gram : ($goldPrice24k->sell_price_per_gram * 0.8);
                    $totalHarga = ($product->weight * $hargaDasar) + $product->labor_cost + $product->stone_price;
                @endphp

                <h2 class="text-gold mb-4">Rp {{ number_format($totalHarga, 0, ',', '.') }}</h2>

                <table class="table table-borderless mb-4">
                    <tr>
                        <th class="ps-0" width="150">Kadar Emas</th>
                        <td>: <span class="badge bg-dark">{{ $product->karat_type }}</span></td>
                    </tr>
                    <tr>
                        <th class="ps-0">Berat Bersih</th>
                        <td>: {{ $product->weight }} gram</td>
                    </tr>
                    <tr>
                        <th class="ps-0">Kondisi Stok</th>
                        <td>: <span class="text-success fw-bold">Tersedia (Ready Stock)</span></td>
                    </tr>
                </table>

                <div class="mb-5">
                    <h5>Deskripsi Produk</h5>
                    <p class="text-muted">
                        {{ $product->description ?? 'Perhiasan emas berkualitas tinggi dengan desain eksklusif khas Toko Mas Sumatra. Cocok untuk investasi maupun aksesoris fashion.' }}
                    </p>
                </div>

                <div class="d-grid gap-2">
                    <button href="{{ route('checkout.show', $product->id) }}"
                    class="btn btn-gold btn-lg text-uppercase fw-bold shadow">
                        Beli Sekarang
                    </button>
                    
                    <a href="https://wa.me/628123456789?text=Halo admin, saya mau tanya tentang produk {{ $product->name }} ({{ $product->sku }})" target="_blank" class="btn btn-outline-success">
                        Chat WhatsApp
                    </a>
                </div>
                
                <div class="mt-3 text-center">
                    <small class="text-muted"><i class="bi bi-shield-lock"></i> Jaminan Emas Asli & Buyback Guarantee</small>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-light text-center py-4 mt-5">
        <small class="text-muted">&copy; 2026 Toko Mas Sumatra</small>
    </footer>

</body>
</html>
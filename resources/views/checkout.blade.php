<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Toko Mas Sumatra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row">
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
                                <input type="text" name="name" class="form-control" required placeholder="Contoh: Elbert Wijaya">
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

                        <button type="submit" class="btn btn-warning w-100 fw-bold py-3 mt-2">
                            BUAT PESANAN SEKARANG
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Ringkasan Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        @if($product->image_url)
                            <img src="{{ asset('uploads/' . $product->image_url) }}" width="80" class="rounded me-3">
                        @else
                            <div class="bg-secondary rounded me-3" style="width:80px; height:80px;"></div>
                        @endif
                        <div>
                            <h6 class="mb-0">{{ $product->name }}</h6>
                            <small class="text-muted">{{ $product->karat_type }} | {{ $product->weight }} gr</small>
                        </div>
                    </div>
                    <hr>
                    @php
                        $hargaDasar = ($product->karat_type == '24K') ? $goldPrice24k->sell_price_per_gram : ($goldPrice24k->sell_price_per_gram * 0.8);
                        $totalHarga = ($product->weight * $hargaDasar) + $product->labor_cost + $product->stone_price;
                    @endphp
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Harga Barang</span>
                        <span class="fw-bold">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                    </div>
                    <div class="alert alert-info small mt-3">
                        <i class="bi bi-info-circle"></i> Biaya ongkos kirim akan diinformasikan admin via WhatsApp setelah pesanan dibuat.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
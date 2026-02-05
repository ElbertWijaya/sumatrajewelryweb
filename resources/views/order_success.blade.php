<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pesanan - Toko Mas Sumatra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="card-body p-4 text-center">
    
    <h4 class="mb-3">Pesanan Berhasil Dibuat!</h4>
    <h2 class="text-primary fw-bold">{{ $order->invoice_number }}</h2>
    <p class="text-muted">Total Tagihan: <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></p>
    
    <hr>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger text-start">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if($order->payment_method == 'cash')
        <div class="alert alert-info">
            <h5><i class="bi bi-shop"></i> Bayar di Toko</h5>
            <p class="mb-0">Silakan datang ke Toko Mas Sumatra dan tunjukkan Nomor Invoice ini ke kasir untuk melakukan pembayaran dan pengambilan barang.</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-outline-dark mt-3">Kembali ke Beranda</a>

    @elseif($order->payment_proof)
        <div class="alert alert-success">
            <h5><i class="bi bi-check-circle"></i> Bukti Pembayaran Diterima</h5>
            <p class="mb-0">Terima kasih! Admin kami sedang memverifikasi pembayaran Anda. Status akan berubah menjadi LUNAS segera.</p>
        </div>
        <a href="{{ route('customer.dashboard') }}" class="btn btn-primary mt-3">Cek Status di Dashboard</a>

    @else
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
        </div>
    @endif

</div>

</body>
</html>
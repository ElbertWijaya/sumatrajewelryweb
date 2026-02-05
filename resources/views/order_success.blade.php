<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - Toko Mas Sumatra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5 text-center">
    <div class="card shadow mx-auto" style="max-width: 600px;">
        <div class="card-body p-5">
            <div class="mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="green" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
            </div>
            
            <h2 class="mb-3">Terima Kasih!</h2>
            <p class="text-muted">Pesanan Anda berhasil dibuat dengan nomor invoice:</p>
            <h4 class="text-primary fw-bold">{{ $order->invoice_number }}</h4>
            
            <hr class="my-4">
            
            <p class="mb-2">Silakan transfer total pembayaran sebesar:</p>
            <h1 class="display-6 fw-bold text-danger">Rp {{ number_format($order->total_price, 0, ',', '.') }}</h1>
            
            <div class="bg-light p-3 border rounded mt-3 text-start">
                <p class="mb-1 fw-bold">Rekening BCA:</p>
                <div class="d-flex justify-content-between">
                    <span>123-456-7890</span>
                    <span class="text-uppercase">a.n Toko Mas Sumatra</span>
                </div>
            </div>

            <div class="mt-4">
                <p class="small text-muted">Admin kami akan segera menghubungi WhatsApp Anda untuk konfirmasi ongkir.</p>
                <a href="{{ route('home') }}" class="btn btn-outline-dark mt-2">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
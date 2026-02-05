<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #{{ $order->invoice_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white d-flex justify-content-between">
                    <span>Invoice: <strong>{{ $order->invoice_number }}</strong></span>
                    <span>Status: {{ strtoupper($order->payment_status) }}</span>
                </div>
                <div class="card-body">
                    <h5 class="mb-3">Informasi Pembeli</h5>
                    <table class="table table-borderless table-sm">
                        <tr><td width="150">Nama</td><td>: {{ $order->user->name }}</td></tr>
                        <tr><td>Email</td><td>: {{ $order->user->email }}</td></tr>
                        <tr><td>No HP / WA</td><td>: {{ $order->user->phone_number }}</td></tr>
                        <tr><td>Alamat Kirim</td><td>: {{ $order->user->address ?? 'Alamat belum diisi lengkap' }}</td></tr>
                    </table>

                    <hr>

                    <h5 class="mb-3">Barang yang Dibeli</h5>
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Harga Saat Deal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->product->name }}</strong><br>
                                    <small>{{ $item->product->karat_type }} | {{ $item->product->weight }} gr</small>
                                </td>
                                <td>Rp {{ number_format($item->price_at_moment, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-end">TOTAL TAGIHAN</th>
                                <th class="text-primary fs-5">Rp {{ number_format($order->total_price, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>

<div class="mb-4 p-3 bg-light border rounded">
                        <h6 class="fw-bold">Metode Pembayaran: <span class="text-uppercase text-primary">{{ $order->payment_method }}</span></h6>
                        
                        @if($order->payment_method == 'transfer')
                            @if($order->payment_proof)
                                <div class="mt-2">
                                    <p class="mb-1">Bukti Transfer:</p>
                                    <img src="{{ asset('uploads/proofs/' . $order->payment_proof) }}" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                                    <div class="mt-2">
                                        <a href="{{ asset('uploads/proofs/' . $order->payment_proof) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Lihat Full Size</a>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning mt-2 mb-0">
                                    <i class="bi bi-exclamation-triangle"></i> Pembeli belum mengupload bukti transfer.
                                </div>
                            @endif
                        @else
                            <div class="alert alert-info mt-2 mb-0">
                                <i class="bi bi-info-circle"></i> Pembayaran Cash (Bayar di Toko). Pastikan uang diterima fisik.
                            </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ url('/admin/dashboard') }}" class="btn btn-secondary">Kembali</a>

                        @if($order->payment_status == 'unpaid')
                            <form action="{{ route('admin.order.confirm', $order->id) }}" method="POST" onsubmit="return confirm('Yakin pembayaran VALID? Stok akan berubah jadi SOLD.');">
                                @csrf
                                <button type="submit" class="btn btn-success fw-bold">
                                    ✅ Verifikasi Pembayaran (LUNAS)
                                </button>
                            </form>
                        @else
                            <button class="btn btn-secondary" disabled>Pesanan Selesai</button>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
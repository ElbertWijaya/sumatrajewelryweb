<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Saya - Toko Mas Sumatra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-black mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Toko Mas Sumatra</a>
            <div class="d-flex">
                <span class="text-white me-3 align-self-center">Halo, {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <h3 class="mb-4">Riwayat Pesanan Saya</h3>

        <div class="card shadow-sm">
            <div class="card-body">
                @if($myOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Barang</th>
                                    <th>Total Harga</th>
                                    <th>Status Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($myOrders as $order)
                                <tr>
                                    <td class="fw-bold">{{ $order->invoice_number }}</td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                    <td>
                                        @foreach($order->items as $item)
                                            <div>{{ $item->product->name }} ({{ $item->product->weight }}gr)</div>
                                        @endforeach
                                    </td>
                                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        @if($order->payment_status == 'paid')
                                            <span class="badge bg-success">LUNAS</span>
                                        @else
                                            <span class="badge bg-danger">BELUM LUNAS</span>
                                            @if($order->payment_proof)
                                                <br><small class="text-success">(Menunggu Verifikasi)</small>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->payment_status == 'unpaid' && $order->payment_method == 'transfer')
                                            <a href="{{ route('order.success', $order->id) }}" class="btn btn-primary btn-sm">
                                                @if($order->payment_proof)
                                                    Lihat / Ganti Bukti
                                                @else
                                                    Upload Bukti Bayar
                                                @endif
                                            </a>
                                        @elseif($order->payment_method == 'cash')
                                            <span class="badge bg-secondary">Bayar di Toko</span>
                                        @else
                                            <button class="btn btn-outline-secondary btn-sm" disabled>Selesai</button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <p class="text-muted">Anda belum memiliki pesanan.</p>
                        <a href="{{ route('home') }}" class="btn btn-warning">Mulai Belanja</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

</body>
</html>
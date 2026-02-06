<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Saya - Toko Mas Sumatra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
                                    <th>Status Pesanan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($myOrders as $order)
                                    @php
                                        $paymentStatus = $order->payment_status;   // unpaid, paid, verified, failed
                                        $orderStatus   = $order->order_status;     // pending, processing, production, ready_to_ship, completed, cancelled

                                        // Ringkasan barang: ambil item pertama
                                        $firstItem = $order->items->first();

                                        // Mapping badge & teks status
                                        $badgeClass = 'bg-secondary';
                                        $badgeText  = 'UNKNOWN';
                                        $statusText = '';

                                        if ($paymentStatus === 'unpaid') {
                                            $badgeClass = 'bg-danger';
                                            $badgeText  = 'BELUM LUNAS';
                                            if ($order->payment_proof) {
                                                $statusText = 'Menunggu verifikasi pembayaran';
                                            } else {
                                                $statusText = 'Menunggu pembayaran';
                                            }
                                        } elseif ($paymentStatus === 'paid') {
                                            $badgeClass = 'bg-success';
                                            if ($orderStatus === 'processing') {
                                                $badgeText  = 'DIPROSES';
                                                $statusText = 'Sedang dikemas';
                                            } elseif ($orderStatus === 'production') {
                                                $badgeText  = 'DIPROSES';
                                                $statusText = 'Sedang diproduksi';
                                            } elseif ($orderStatus === 'ready_to_ship') {
                                                $badgeText  = 'DIKIRIM';
                                                $statusText = 'Sedang dikirim ke alamat Anda';
                                            } elseif ($orderStatus === 'completed') {
                                                $badgeText  = 'SELESAI';
                                                $statusText = 'Pesanan telah diterima';
                                            } else {
                                                $badgeText  = 'DIPROSES';
                                                $statusText = 'Sedang diproses';
                                            }
                                        } elseif ($paymentStatus === 'failed') {
                                            $badgeClass = 'bg-danger';
                                            $badgeText  = 'GAGAL';
                                            $statusText = 'Pembayaran gagal / dibatalkan';
                                        } else {
                                            // 'verified' atau status lain jika digunakan
                                            $badgeClass = 'bg-success';
                                            $badgeText  = strtoupper($paymentStatus);
                                            $statusText = 'Status pesanan: ' . $orderStatus;
                                        }

                                        // Flags untuk aksi
                                        $canUploadProof = ($paymentStatus === 'unpaid' && $order->payment_method === 'transfer');
                                        $canViewDetail  = in_array($orderStatus, ['pending', 'processing', 'production', 'ready_to_ship']);
                                        $isCompleted    = ($orderStatus === 'completed');
                                        $isCancelled    = ($orderStatus === 'cancelled');
                                    @endphp

                                    <tr>
                                        <td class="fw-bold">
                                            <a href="{{ route('order.success', $order->id) }}" class="text-decoration-none">
                                                {{ $order->invoice_number }}
                                            </a>
                                        </td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>
                                            @if($firstItem)
                                                {{ $firstItem->product->name }} ({{ $firstItem->product->weight }}gr)
                                                @if($order->items->count() > 1)
                                                    <div class="small text-muted">
                                                        + {{ $order->items->count() - 1 }} item lainnya
                                                    </div>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        
                                        <td>
                                            <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span><br>
                                            <small class="text-muted">
                                                {{ $statusText }}
                                                @if($orderStatus === 'ready_to_ship' && $order->tracking_number)
                                                    <br>
                                                    <span class="fw-semibold text-dark">
                                                        <i class="bi bi-truck"></i> Resi: {{ $order->tracking_number }}
                                                    </span>
                                                @endif
                                            </small>
                                        </td>

                                        <td>
                                            @if($canUploadProof)
                                                <a href="{{ route('order.success', $order->id) }}" class="btn btn-primary btn-sm mb-1">
                                                    @if($order->payment_proof)
                                                        Foto Ulang Bukti Pembayaran
                                                    @else
                                                        Upload Bukti Pembayaran
                                                    @endif
                                                </a>
                                            @elseif($canViewDetail)
                                                {{-- Bisa lihat detail/tracking --}}
                                                <a href="{{ route('order.success', $order->id) }}" class="btn btn-outline-primary btn-sm mb-1">
                                                    @if($orderStatus === 'ready_to_ship')
                                                        Lihat Tracking
                                                    @else
                                                        Lihat Detail
                                                    @endif
                                                </a>
                                            @endif

                                            @if($order->payment_method == 'cash' && $paymentStatus === 'unpaid')
                                                <span class="badge bg-secondary">Bayar di Toko</span>
                                            @elseif($isCompleted)
                                                <button class="btn btn-secondary btn-sm" disabled>Pesanan Selesai</button>
                                            @elseif($isCancelled)
                                                <button class="btn btn-outline-secondary btn-sm" disabled>Pesanan Dibatalkan</button>
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
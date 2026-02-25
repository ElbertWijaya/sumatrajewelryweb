@extends('layouts.app')

@section('title', 'Dashboard Saya')

@section('content')
    @php
        $user = Auth::user();

        $totalOrders     = $myOrders->count();
        $unpaidOrders    = $myOrders->where('payment_status', 'unpaid')->count();
        $activeOrders    = $myOrders->filter(function ($order) {
            return in_array($order->order_status, ['pending', 'processing', 'production', 'ready_to_ship']);
        });
        $activeOrdersCount = $activeOrders->count();
        $completedOrders = $myOrders->where('order_status', 'completed')->count();
    @endphp

    <div class="py-5" style="background-color: #f5f5f7;">
        <div class="container">
            <div class="row g-4">
                {{-- Sidebar kiri: menu dashboard (shared) --}}
                <div class="col-lg-3 col-xl-2">
                    @include('customer.partials.sidebar', ['active' => 'dashboard', 'totalOrders' => $totalOrders])
                </div>

                {{-- Kolom tengah: hero + status + pesanan aktif + riwayat --}}
                <div class="col-lg-6 col-xl-7">
                    {{-- Hero section --}}
                    <div class="card border-0 mb-3" style="background: linear-gradient(135deg, #4338ca, #6366f1); color: #ffffff;">
                        <div class="card-body p-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                            <div class="mb-3 mb-md-0">
                                <div class="small text-uppercase fw-semibold mb-2" style="letter-spacing: 0.08em; opacity: 0.85;">Dashboard Pelanggan</div>
                                <h4 class="fw-semibold mb-2">Selamat datang kembali, {{ $user->name }}.</h4>
                                <p class="mb-0 small" style="max-width: 360px; opacity: 0.9;">
                                    Pantau status pesanan emas Anda, kelola informasi akun, dan temukan rekomendasi perhiasan terbaik.
                                </p>
                            </div>
                            <div class="text-md-end">
                                <div class="small mb-2">Pesanan aktif</div>
                                <div class="fs-3 fw-bold">{{ $activeOrdersCount }}</div>
                                <a href="{{ route('catalog.index') }}" class="btn btn-light btn-sm mt-2 d-inline-flex align-items-center">
                                    <i class="bi bi-bag me-2"></i> Lanjut Belanja
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Status chips --}}
                    <div class="row g-2 mb-3">
                        <div class="col-6 col-md-3">
                            <div class="card border-0 shadow-sm small h-100">
                                <div class="card-body py-2 px-3">
                                    <div class="text-muted mb-1">Belum Bayar</div>
                                    <div class="fw-semibold">{{ $unpaidOrders }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="card border-0 shadow-sm small h-100">
                                <div class="card-body py-2 px-3">
                                    <div class="text-muted mb-1">Sedang Proses</div>
                                    <div class="fw-semibold">{{ $activeOrdersCount }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="card border-0 shadow-sm small h-100">
                                <div class="card-body py-2 px-3">
                                    <div class="text-muted mb-1">Selesai</div>
                                    <div class="fw-semibold">{{ $completedOrders }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="card border-0 shadow-sm small h-100">
                                <div class="card-body py-2 px-3">
                                    <div class="text-muted mb-1">Total Pesanan</div>
                                    <div class="fw-semibold">{{ $totalOrders }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Pesanan aktif --}}
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Pesanan Aktif</h6>
                                <small class="text-muted">Pesanan yang masih dalam proses.</small>
                            </div>

                            @if($activeOrdersCount > 0)
                                @foreach($activeOrders as $order)
                                    @php
                                        $firstItem = $order->items->first();
                                    @endphp
                                    <div class="d-flex align-items-center py-2 border-bottom small">
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold">
                                                <a href="{{ route('order.success', $order->id) }}" class="text-decoration-none">
                                                    {{ $order->invoice_number }}
                                                </a>
                                            </div>
                                            <div class="text-muted">
                                                @if($firstItem)
                                                    {{ $firstItem->product->name }}
                                                @else
                                                    Pesanan tanpa item
                                                @endif
                                                • {{ $order->created_at->format('d M Y') }}
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-semibold mb-1">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                            <span class="badge bg-primary-subtle text-primary text-capitalize">{{ str_replace('_', ' ', $order->order_status) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-3 small text-muted">
                                    Belum ada pesanan aktif. Yuk mulai belanja perhiasan impian Anda.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Riwayat pesanan (tabel penuh) --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="mb-0">Riwayat Pesanan</h6>
                                    <div class="small text-muted">Detail lengkap semua pesanan Anda.</div>
                                </div>
                                <a href="{{ route('catalog.index') }}" class="btn btn-outline-dark btn-sm d-none d-md-inline-flex align-items-center">
                                    <i class="bi bi-shop me-1"></i> Lihat Katalog
                                </a>
                            </div>

                            @if($myOrders->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>No. Invoice</th>
                                                <th>Tanggal</th>
                                                <th>Barang</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($myOrders as $order)
                                                @php
                                                    $paymentStatus = $order->payment_status;   // unpaid, paid, failed, ...
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
                                                            $statusText = 'Menunggu verifikasi pembayaran.';
                                                        } else {
                                                            $statusText = 'Menunggu pembayaran.';
                                                        }

                                                    } elseif ($paymentStatus === 'paid') {
                                                        $badgeClass = 'bg-success';

                                                        if ($orderStatus === 'processing') {
                                                            $badgeText  = 'SEDANG DIPROSES';
                                                            $statusText = 'Pesanan sedang diproses oleh toko.';
                                                        } elseif ($orderStatus === 'production') {
                                                            $badgeText  = 'DALAM PRODUKSI';
                                                            $statusText = 'Pesanan sedang diproduksi.';
                                                        } elseif ($orderStatus === 'ready_to_ship') {
                                                            $badgeText  = 'DIKIRIM';
                                                            $statusText = 'Pesanan sedang dikirim ke alamat Anda.';
                                                        } elseif ($orderStatus === 'completed') {
                                                            $badgeText  = 'SELESAI';
                                                            $statusText = 'Pesanan telah diterima.';
                                                        } elseif ($orderStatus === 'cancelled') {
                                                            $badgeClass = 'bg-secondary';
                                                            $badgeText  = 'DIBATALKAN';
                                                            $statusText = 'Pesanan dibatalkan.';
                                                        } else {
                                                            // fallback jika ada status lain
                                                            $badgeText  = 'DIPROSES';
                                                            $statusText = 'Pesanan sedang diproses.';
                                                        }

                                                    } elseif ($paymentStatus === 'failed') {
                                                        $badgeClass = 'bg-danger';
                                                        $badgeText  = 'GAGAL';
                                                        $statusText = 'Pembayaran gagal atau dibatalkan.';

                                                    } else {
                                                        // 'verified' atau status lain jika suatu saat digunakan
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
                                                    <td class="fw-semibold">
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
                                <div class="text-center py-4">
                                    <p class="text-muted mb-2">Anda belum memiliki pesanan.</p>
                                    <a href="{{ route('catalog.index') }}" class="btn btn-dark">
                                        <i class="bi bi-shop me-1"></i> Mulai Belanja
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- (Kolom kanan dihilangkan sesuai permintaan, info akun akan dipindah ke halaman Settings terpisah) --}}
            </div>
        </div>
    </div>
@endsection
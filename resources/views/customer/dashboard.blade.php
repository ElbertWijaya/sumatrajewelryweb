@extends('layouts.app')

@section('title', 'Dashboard Saya')

@section('styles')
    <style>
        .customer-hero {
            background-color: #ffffff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 14px 40px rgba(15, 23, 42, 0.08);
        }

        .customer-hero-label {
            font-size: 0.75rem;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: #9ca3af;
        }

        .customer-hero-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #111827;
        }

        .customer-hero-sub {
            font-size: 0.9rem;
            color: #4b5563;
        }

        .customer-hero-stats {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.75rem;
        }

        .customer-hero-stat {
            padding: 0.6rem 0.85rem;
            border-radius: 12px;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
        }

        .customer-hero-stat-label {
            font-size: 0.75rem;
            color: #6b7280;
            margin-bottom: 0.1rem;
        }

        .customer-hero-stat-value {
            font-size: 1.05rem;
            font-weight: 600;
            color: #111827;
        }

        .customer-section-card {
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
            background-color: #ffffff;
        }

        .customer-section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.6rem;
        }

        .customer-section-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #111827;
        }

        .customer-section-sub {
            font-size: 0.8rem;
            color: #6b7280;
        }

        .customer-order-row {
            padding-top: 0.6rem;
            padding-bottom: 0.6rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .customer-order-row:last-child {
            border-bottom: none;
        }

        .customer-history-table thead {
            background-color: #f9fafb;
        }

        .customer-history-table thead th {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #6b7280;
            border-bottom-color: #e5e7eb;
        }

        .customer-history-table tbody td {
            font-size: 0.85rem;
            vertical-align: middle;
        }

        .customer-history-table tbody tr:hover {
            background-color: #f9fafb;
        }

        @media (min-width: 992px) {
            .customer-hero-title {
                font-size: 1.6rem;
            }
        }
    </style>
@endsection

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
                <div class="col-lg-3 col-xl-3">
                    @include('customer.partials.sidebar', ['active' => 'dashboard', 'totalOrders' => $totalOrders])
                </div>

                {{-- Kolom tengah: hero + pesanan aktif + riwayat --}}
                <div class="col-lg-9 col-xl-9">
                    {{-- Hero section (brand color, tanpa ungu) --}}
                    <div class="card customer-hero mb-3">
                        <div class="card-body p-4">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-6">
                                    <div class="customer-hero-label mb-1">Dashboard Pelanggan</div>
                                    <h4 class="customer-hero-title mb-2">Selamat datang kembali, {{ $user->name }}.</h4>
                                    <p class="customer-hero-sub mb-3" style="max-width: 400px;">
                                        Pantau status pesanan emas Anda, kelola informasi akun, dan temukan rekomendasi perhiasan terbaik.
                                    </p>
                                    <a href="{{ route('catalog.index') }}" class="btn btn-gold btn-sm d-inline-flex align-items-center">
                                        <i class="bi bi-bag me-2"></i> Lanjut Belanja
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <div class="customer-hero-stats">
                                        <div class="customer-hero-stat">
                                            <div class="customer-hero-stat-label">Belum Bayar</div>
                                            <div class="customer-hero-stat-value">{{ $unpaidOrders }}</div>
                                        </div>
                                        <div class="customer-hero-stat">
                                            <div class="customer-hero-stat-label">Sedang Proses</div>
                                            <div class="customer-hero-stat-value">{{ $activeOrdersCount }}</div>
                                        </div>
                                        <div class="customer-hero-stat">
                                            <div class="customer-hero-stat-label">Selesai</div>
                                            <div class="customer-hero-stat-value">{{ $completedOrders }}</div>
                                        </div>
                                        <div class="customer-hero-stat">
                                            <div class="customer-hero-stat-label">Total Pesanan</div>
                                            <div class="customer-hero-stat-value">{{ $totalOrders }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Pesanan aktif --}}
                    <div class="card customer-section-card mb-3">
                        <div class="card-body">
                            <div class="customer-section-header">
                                <div class="customer-section-title">Pesanan Aktif</div>
                                <div class="customer-section-sub">Pesanan yang masih dalam proses.</div>
                            </div>

                            @if($activeOrdersCount > 0)
                                @foreach($activeOrders as $order)
                                    @php
                                        $firstItem = $order->items->first();
                                    @endphp
                                    <div class="d-flex align-items-center customer-order-row small">
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
                                            <span class="badge bg-dark text-white text-capitalize">{{ str_replace('_', ' ', $order->order_status) }}</span>
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
                    <div class="card customer-section-card">
                        <div class="card-body">
                            <div class="customer-section-header mb-2">
                                <div>
                                    <div class="customer-section-title">Riwayat Pesanan</div>
                                    <div class="customer-section-sub">Detail lengkap semua pesanan Anda.</div>
                                </div>
                                <a href="{{ route('catalog.index') }}" class="btn btn-outline-dark btn-sm d-none d-md-inline-flex align-items-center">
                                    <i class="bi bi-shop me-1"></i> Lihat Katalog
                                </a>
                            </div>

                            @if($myOrders->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0 customer-history-table">
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
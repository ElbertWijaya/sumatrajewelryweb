@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('styles')
    <style>
        .customer-orders-tabs {
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 1rem;
        }

        .customer-orders-tabs .nav-link {
            border: none;
            border-bottom: 2px solid transparent;
            border-radius: 0;
            padding: 0.6rem 0.9rem;
            font-size: 0.9rem;
            color: #4b5563;
        }

        .customer-orders-tabs .nav-link.active {
            color: #111827;
            border-color: #111827;
            font-weight: 600;
        }

        .customer-orders-tabs .badge {
            font-size: 0.7rem;
            border-radius: 999px;
            background-color: #f3f4f6;
            color: #6b7280;
        }

        .customer-order-card {
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
            background-color: #ffffff;
        }

        .customer-order-header {
            font-size: 0.8rem;
            color: #4b5563;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 0.45rem;
            margin-bottom: 0.45rem;
        }

        .customer-order-store {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            font-weight: 600;
            color: #111827;
        }

        .customer-order-store i {
            color: #f59e0b;
        }

        .customer-order-meta {
            font-size: 0.78rem;
            color: #9ca3af;
        }

        .customer-order-status-badge {
            font-size: 0.75rem;
            border-radius: 999px;
        }

        .customer-order-body {
            font-size: 0.87rem;
        }

        .customer-order-product-thumb {
            width: 72px;
            height: 72px;
            border-radius: 12px;
            overflow: hidden;
            background-color: #f3f4f6;
            flex-shrink: 0;
        }

        .customer-order-product-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .customer-order-product-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: #111827;
        }

        .customer-order-product-meta {
            font-size: 0.8rem;
            color: #6b7280;
        }

        .customer-order-footer {
            border-top: 1px solid #f1f5f9;
            margin-top: 0.6rem;
            padding-top: 0.6rem;
            font-size: 0.85rem;
        }

        .customer-orders-search .form-control {
            font-size: 0.9rem;
            padding: 0.55rem 0.9rem;
        }
        .customer-orders-search .input-group-text {
            background-color: #ffffff;
            padding: 0.55rem 0.75rem;
        }
    </style>
@endsection

@section('content')
    <div class="py-5" style="background-color: #f5f5f7;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-xl-3">
                    @include('customer.partials.sidebar', ['active' => 'orders', 'totalOrders' => $totalOrders])
                </div>

                <div class="col-lg-9 col-xl-9">
                    <div class="mb-3">
                        <h5 class="mb-1">Pesanan Saya</h5>
                        <p class="small text-muted mb-0">Pantau semua pesanan Anda berdasarkan status.</p>
                    </div>

                    {{-- Tabs status pesanan --}}
                    @php
                        $status = $statusFilter;
                    @endphp
                    <ul class="nav customer-orders-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'all' ? 'active' : '' }}" href="{{ route('customer.orders', ['status' => 'all']) }}">
                                Semua
                                <span class="badge ms-1">{{ $counts['all'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'unpaid' ? 'active' : '' }}" href="{{ route('customer.orders', ['status' => 'unpaid']) }}">
                                Belum Bayar
                                <span class="badge ms-1">{{ $counts['unpaid'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'processing' ? 'active' : '' }}" href="{{ route('customer.orders', ['status' => 'processing']) }}">
                                Diproses
                                <span class="badge ms-1">{{ $counts['processing'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'shipping' ? 'active' : '' }}" href="{{ route('customer.orders', ['status' => 'shipping']) }}">
                                Dikirim
                                <span class="badge ms-1">{{ $counts['shipping'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'completed' ? 'active' : '' }}" href="{{ route('customer.orders', ['status' => 'completed']) }}">
                                Selesai
                                <span class="badge ms-1">{{ $counts['completed'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'cancelled' ? 'active' : '' }}" href="{{ route('customer.orders', ['status' => 'cancelled']) }}">
                                Dibatalkan
                                <span class="badge ms-1">{{ $counts['cancelled'] }}</span>
                            </a>
                        </li>
                    </ul>

                    {{-- Search bar khusus pesanan --}}
                    <div class="customer-orders-search mb-3">
                        @php
                            $currentSearch = $searchQuery ?? request('q');
                        @endphp

                        <form method="GET" action="{{ route('customer.orders') }}" class="d-flex flex-wrap align-items-center gap-2">
                            <div class="flex-grow-1">
                                <div class="input-group w-100">
                                    <span class="input-group-text border-end-0">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text"
                                           name="q"
                                           class="form-control border-start-0"
                                           placeholder="Cari berdasarkan No. Invoice, Nama Produk, atau Metode Pembayaran"
                                           value="{{ $currentSearch }}">
                                    <input type="hidden" name="status" value="{{ $status }}">
                                </div>
                            </div>

                            @if(!empty($currentSearch))
                                <div class="ms-auto">
                                    <a href="{{ route('customer.orders', ['status' => $status]) }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                                </div>
                            @endif
                        </form>
                    </div>

                    {{-- Daftar pesanan --}}
                    @if($orders->count() > 0)
                        <div class="d-flex flex-column gap-3">
                            @foreach($orders as $order)
                                @php
                                    $paymentStatus = $order->payment_status;   // unpaid, paid, failed, ...
                                    $orderStatus   = $order->order_status;     // pending, processing, production, ready_to_ship, completed, cancelled

                                    $firstItem = $order->items->first();
                                    $branchLocation = $firstItem && $firstItem->product && $firstItem->product->branch_location
                                        ? $firstItem->product->branch_location
                                        : null;

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
                                            $badgeText  = 'DIPROSES';
                                            $statusText = 'Pesanan sedang diproses.';
                                        }

                                    } elseif ($paymentStatus === 'failed') {
                                        $badgeClass = 'bg-danger';
                                        $badgeText  = 'GAGAL';
                                        $statusText = 'Pembayaran gagal atau dibatalkan.';

                                    } else {
                                        $badgeClass = 'bg-success';
                                        $badgeText  = strtoupper($paymentStatus);
                                        $statusText = 'Status pesanan: ' . $orderStatus;
                                    }

                                    $canUploadProof = ($paymentStatus === 'unpaid' && $order->payment_method === 'transfer');
                                    $canViewDetail  = in_array($orderStatus, ['pending', 'processing', 'production', 'ready_to_ship']);
                                    $isCompleted    = ($orderStatus === 'completed');
                                    $isCancelled    = ($orderStatus === 'cancelled');
                                @endphp

                                <div class="customer-order-card p-3">
                                    {{-- Header toko + invoice & tanggal + status --}}
                                    <div class="d-flex justify-content-between align-items-center customer-order-header">
                                        <div>
                                            <div class="customer-order-store">
                                                <i class="bi bi-shop"></i>
                                                <span>
                                                    Toko Mas Sumatra
                                                    @if($branchLocation)
                                                        - {{ $branchLocation }}
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="customer-order-meta mt-1">
                                                #{{ $order->invoice_number }}
                                                <span class="mx-1">•</span>
                                                {{ $order->created_at->format('d M Y') }}
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <a href="{{ route('order.success', $order->id) }}"
                                               class="badge customer-order-status-badge {{ $badgeClass }} text-decoration-none">
                                                {{ $badgeText }}
                                            </a>
                                        </div>
                                    </div>

                                    {{-- Body: thumbnail + info produk + ringkasan status + total --}}
                                    <div class="customer-order-body d-flex align-items-start gap-3 pt-2">
                                        <div class="customer-order-product-thumb">
                                            @if($firstItem && $firstItem->product && $firstItem->product->image_url)
                                                <img src="{{ asset('uploads/' . $firstItem->product->image_url) }}" alt="{{ $firstItem->product->name }}">
                                            @else
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted small">
                                                    No Image
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex-grow-1">
                                            @if($firstItem && $firstItem->product)
                                                <div class="customer-order-product-name mb-1">
                                                    {{ $firstItem->product->name }}
                                                </div>
                                                <div class="customer-order-product-meta">
                                                    {{ $firstItem->product->karat_type ?? '' }}
                                                    @if(!empty($firstItem->product->karat_type))
                                                        <span class="mx-1">•</span>
                                                    @endif
                                                    {{ $firstItem->product->weight }} gr
                                                </div>
                                                @if($order->items->count() > 1)
                                                    <div class="small text-muted mt-1">
                                                        + {{ $order->items->count() - 1 }} produk lainnya
                                                    </div>
                                                @endif
                                            @else
                                                <span class="text-muted">Detail produk tidak tersedia.</span>
                                            @endif

                                            <div class="small text-muted mt-2">
                                                {{ $statusText }}
                                            </div>

                                            @if($orderStatus === 'ready_to_ship' && $order->tracking_number)
                                                <div class="small mt-1">
                                                    <span class="fw-semibold text-dark">
                                                        <i class="bi bi-truck"></i> Resi: {{ $order->tracking_number }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="text-end">
                                            <div class="small text-muted">Total Pesanan</div>
                                            <div class="fw-semibold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                        </div>
                                    </div>

                                    {{-- Footer: metode pembayaran + aksi --}}
                                    <div class="customer-order-footer d-flex flex-wrap justify-content-between align-items-center gap-2">
                                        <div class="small text-muted">
                                            Metode: {{ strtoupper($order->payment_method) }}
                                        </div>
                                        <div>
                                            @if($canUploadProof)
                                                <a href="{{ route('order.success', $order->id) }}" class="btn btn-dark btn-sm mb-1">
                                                    @if($order->payment_proof)
                                                        Foto Ulang Bukti Pembayaran
                                                    @else
                                                        Upload Bukti Pembayaran
                                                    @endif
                                                </a>
                                            @elseif($canViewDetail)
                                                <a href="{{ route('order.success', $order->id) }}" class="btn btn-outline-dark btn-sm mb-1">
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
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <p class="text-muted mb-2">Belum ada pesanan pada kategori ini.</p>
                            <a href="{{ route('catalog.index') }}" class="btn btn-dark">
                                <i class="bi bi-shop me-1"></i> Mulai Belanja
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

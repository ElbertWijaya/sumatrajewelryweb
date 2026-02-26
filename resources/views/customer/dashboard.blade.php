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

                {{-- Kolom tengah: hero ringkasan saja, detail pesanan dipindah ke "Pesanan Saya" --}}
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

                    {{-- Section ringkasan singkat (detail pesanan dipindah ke halaman Pesanan Saya) --}}
                    <div class="card customer-section-card mt-3">
                        <div class="card-body">
                            <div class="customer-section-header mb-1">
                                <div class="customer-section-title">Ringkasan Pesanan</div>
                            </div>
                            <div class="customer-section-sub mb-3">
                                Detail lengkap dan riwayat pesanan kini tersedia di menu <strong>Pesanan Saya</strong> pada sidebar.
                            </div>
                            <a href="{{ route('customer.orders') }}" class="btn btn-outline-dark btn-sm">
                                Lihat Pesanan Saya
                            </a>
                        </div>
                    </div>
                </div>

                {{-- (Kolom kanan dihilangkan sesuai permintaan, info akun akan dipindah ke halaman Settings terpisah) --}}
            </div>
        </div>
    </div>
@endsection
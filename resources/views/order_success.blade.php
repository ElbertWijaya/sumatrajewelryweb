@extends('layouts.app')

@section('title', 'Pesanan Berhasil - Toko Mas Sumatra')
@section('nav_home_active', '')

@section('navbar_right')
    @if(Auth::check())
        <li class="nav-item ms-3">
            <a href="{{ Auth::user()->role == 'admin' ? url('/admin/dashboard') : route('customer.dashboard') }}" class="btn btn-gold btn-sm text-white fw-bold">
                <i class="bi bi-person-circle"></i> Dashboard {{ Auth::user()->role == 'admin' ? 'Admin' : 'Saya' }}
            </a>
        </li>
    @else
        <li class="nav-item ms-3">
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm fw-bold">
                Masuk / Daftar
            </a>
        </li>
    @endif
@endsection

@section('styles')
    <style>
        .order-detail-wrapper {
            background-color: #f5f5f7;
        }

        .order-detail-card {
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
        }

        .order-detail-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .order-detail-title {
            font-size: 1rem;
            font-weight: 600;
            color: #111827;
        }

        .order-detail-meta {
            font-size: 0.8rem;
            color: #6b7280;
        }

        .order-detail-badge {
            font-size: 0.75rem;
            border-radius: 999px;
        }

        .order-summary-box {
            background-color: #f9fafb;
            border-radius: 12px;
            padding: 0.9rem 1rem;
            margin-bottom: 1.25rem;
            font-size: 0.85rem;
        }

        .order-summary-label {
            color: #6b7280;
        }

        .order-summary-value {
            font-weight: 600;
            color: #111827;
        }

        .order-timeline {
            list-style: none;
            padding-left: 0;
            margin-bottom: 1.5rem;
        }

        .order-timeline-step {
            position: relative;
            padding-left: 1.6rem;
            margin-bottom: 0.75rem;
            font-size: 0.85rem;
        }

        .order-timeline-step:last-child {
            margin-bottom: 0;
        }

        .order-timeline-dot {
            position: absolute;
            left: 0;
            top: 0.1rem;
            width: 0.7rem;
            height: 0.7rem;
            border-radius: 999px;
            border: 2px solid #d1d5db;
            background-color: #f9fafb;
        }

        .order-timeline-step::before {
            content: '';
            position: absolute;
            left: 0.34rem;
            top: 0.7rem;
            width: 2px;
            height: calc(100% - 0.7rem);
            background-color: #e5e7eb;
        }

        .order-timeline-step:last-child::before {
            display: none;
        }

        .order-timeline-step.done .order-timeline-dot,
        .order-timeline-step.active .order-timeline-dot {
            border-color: #111827;
            background-color: #111827;
        }

        .order-timeline-step.done {
            color: #4b5563;
        }

        .order-timeline-step.active {
            color: #111827;
            font-weight: 600;
        }

        .order-timeline-desc {
            display: block;
            font-size: 0.78rem;
            color: #9ca3af;
        }

        .order-payment-box {
            background-color: #fffbeb;
            border-radius: 12px;
            border: 1px solid #facc15;
            padding: 0.9rem 1rem;
            font-size: 0.85rem;
        }
    </style>
@endsection

@section('content')
<div class="order-detail-wrapper py-5">
    <div class="container">
    {{-- Alert flash message (upload bukti, dll) --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card order-detail-card">
                <div class="card-body p-4">
                    @php
                        $paymentStatus = $order->payment_status;   // unpaid, paid, failed, ...
                        $orderStatus   = $order->order_status;     // pending, processing, production, ready_to_ship, completed, cancelled
                        $hasProof      = !empty($order->payment_proof);

                        $isPaid        = $paymentStatus === 'paid';
                        $isShipped     = $orderStatus === 'ready_to_ship';
                        $isCompleted   = $orderStatus === 'completed';
                        $isCancelled   = $orderStatus === 'cancelled' || $paymentStatus === 'failed';

                        $badgeClass = 'bg-secondary';
                        $badgeText  = 'UNKNOWN';
                        $statusText = '';

                        if ($paymentStatus === 'unpaid') {
                            $badgeClass = 'bg-danger';
                            $badgeText  = 'BELUM LUNAS';

                            if ($hasProof) {
                                $statusText = 'Bukti pembayaran sudah diterima dan sedang diverifikasi oleh toko.';
                            } else {
                                $statusText = 'Pesanan Anda sudah tercatat, silakan selesaikan pembayaran.';
                            }

                        } elseif ($paymentStatus === 'paid') {
                            $badgeClass = 'bg-success';

                            if ($orderStatus === 'processing') {
                                $badgeText  = 'SEDANG DIPROSES';
                                $statusText = 'Pembayaran telah diterima. Pesanan sedang diproses oleh toko.';
                            } elseif ($orderStatus === 'production') {
                                $badgeText  = 'DALAM PRODUKSI';
                                $statusText = 'Pesanan sedang diproduksi di workshop.';
                            } elseif ($orderStatus === 'ready_to_ship') {
                                $badgeText  = 'DIKIRIM';
                                $statusText = 'Pesanan telah diserahkan ke kurir dan sedang dikirim.';
                            } elseif ($orderStatus === 'completed') {
                                $badgeText  = 'SELESAI';
                                $statusText = 'Pesanan telah diterima. Terima kasih telah berbelanja di Toko Mas Sumatra.';
                            } elseif ($orderStatus === 'cancelled') {
                                $badgeClass = 'bg-secondary';
                                $badgeText  = 'DIBATALKAN';
                                $statusText = 'Pesanan ini telah dibatalkan.';
                            } else {
                                $badgeText  = 'DIPROSES';
                                $statusText = 'Pembayaran telah diterima. Pesanan sedang diproses.';
                            }

                        } elseif ($paymentStatus === 'failed') {
                            $badgeClass = 'bg-danger';
                            $badgeText  = 'GAGAL';
                            $statusText = 'Pembayaran gagal atau dibatalkan. Silakan lakukan pemesanan ulang jika diperlukan.';

                        } else {
                            $badgeClass = 'bg-success';
                            $badgeText  = strtoupper($paymentStatus);
                            $statusText = 'Status pesanan: ' . $orderStatus;
                        }

                        // Tahap timeline (0 = dibatalkan/gagal)
                        $currentStage = 1;

                        if ($isCancelled) {
                            $currentStage = 0;
                        } elseif ($paymentStatus === 'unpaid' && ! $hasProof) {
                            $currentStage = 1; // pesanan dibuat, menunggu pembayaran
                        } elseif ($paymentStatus === 'unpaid' && $hasProof) {
                            $currentStage = 2; // menunggu verifikasi pembayaran
                        } elseif ($paymentStatus === 'paid' && in_array($orderStatus, ['pending', 'processing', 'production'])) {
                            $currentStage = 3; // pesanan diproses
                        } elseif ($paymentStatus === 'paid' && $orderStatus === 'ready_to_ship') {
                            $currentStage = 4; // dikirim
                        } elseif ($orderStatus === 'completed') {
                            $currentStage = 5; // selesai
                        }

                        $steps = [
                            1 => ['label' => 'Pesanan Dibuat', 'desc' => 'Detail pesanan telah kami terima di sistem.'],
                            2 => ['label' => 'Menunggu Verifikasi Pembayaran', 'desc' => 'Tim kami sedang memeriksa bukti pembayaran Anda.'],
                            3 => ['label' => 'Pesanan Diproses', 'desc' => 'Perhiasan sedang disiapkan atau diproduksi oleh toko.'],
                            4 => ['label' => 'Sedang Dikirim', 'desc' => 'Pesanan telah diserahkan ke kurir dan sedang menuju alamat Anda.'],
                            5 => ['label' => 'Pesanan Selesai', 'desc' => 'Pesanan telah diterima oleh Anda. Terima kasih!'],
                        ];

                        $firstItem = $order->items->first();
                        $branchLocation = $firstItem && $firstItem->product && $firstItem->product->branch_location
                            ? $firstItem->product->branch_location
                            : null;

                        $canUploadProof = ($paymentStatus === 'unpaid' && $order->payment_method === 'transfer');
                    @endphp

                    {{-- Header ringkasan pesanan --}}
                    <div class="order-detail-header">
                        <div>
                            <div class="order-detail-title">Detail Pesanan</div>
                            <div class="order-detail-meta mt-1">
                                @if($branchLocation)
                                    Toko Mas Sumatra - {{ $branchLocation }}
                                    <span class="mx-1">•</span>
                                @else
                                    Toko Mas Sumatra
                                    <span class="mx-1">•</span>
                                @endif
                                No. Invoice {{ $order->invoice_number ?? '-' }}
                                <span class="mx-1">•</span>
                                {{ $order->created_at->format('d M Y') }}
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge order-detail-badge {{ $badgeClass }}">{{ $badgeText }}</span>
                        </div>
                    </div>

                    {{-- Ringkasan utama --}}
                    <div class="order-summary-box">
                        <div class="row g-2 align-items-center">
                            <div class="col-sm-6">
                                <div class="order-summary-label">Nama Pemesan</div>
                                <div class="order-summary-value">{{ $order->user->name ?? '-' }}</div>
                            </div>
                            <div class="col-sm-3">
                                <div class="order-summary-label">Metode</div>
                                <div class="order-summary-value text-uppercase">{{ $order->payment_method ?? '-' }}</div>
                            </div>
                            <div class="col-sm-3 text-sm-end">
                                <div class="order-summary-label">Total Pesanan</div>
                                <div class="order-summary-value">Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</div>
                            </div>
                        </div>

                        @if(!empty($order->tracking_number))
                            <div class="mt-2">
                                <span class="order-summary-label">No. Resi</span>
                                <span class="order-summary-value ms-1">{{ $order->tracking_number }}</span>
                            </div>
                        @endif

                        <div class="mt-2" style="font-size: 0.8rem; color: #6b7280;">
                            {{ $statusText }}
                        </div>
                    </div>

                    {{-- Timeline status --}}
                    @if(! $isCancelled)
                        <ul class="order-timeline">
                            @foreach($steps as $index => $step)
                                @php
                                    $stepClasses = '';
                                    if ($currentStage > $index) {
                                        $stepClasses = 'done';
                                    } elseif ($currentStage === $index) {
                                        $stepClasses = 'active';
                                    }
                                @endphp
                                <li class="order-timeline-step {{ $stepClasses }}">
                                    <span class="order-timeline-dot"></span>
                                    {{ $step['label'] }}
                                    @if(!empty($step['desc']))
                                        <span class="order-timeline-desc">{{ $step['desc'] }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="alert alert-secondary mb-3">
                            Pesanan ini berstatus <strong>DIBATALKAN</strong> atau pembayaran <strong>GAGAL</strong>.
                            @if($statusText)
                                <div class="small mt-1 text-muted">{{ $statusText }}</div>
                            @endif
                        </div>
                    @endif

                    {{-- Bagian tindakan / instruksi sesuai status --}}
                    @if($isShipped)
                        <div class="mt-3">
                            <h6 class="mb-2"><i class="bi bi-truck"></i> Status Pengiriman</h6>
                            <p class="small text-muted mb-2">
                                Pesanan Anda telah diserahkan ke kurir dan sedang dalam perjalanan. Gunakan nomor resi di atas
                                untuk melacak posisi paket melalui situs atau aplikasi ekspedisi.
                            </p>
                        </div>
                    @elseif($isCompleted)
                        <div class="alert alert-success mt-2 mb-3">
                            Pesanan telah selesai dan diterima. Terima kasih telah berbelanja di Toko Mas Sumatra.
                        </div>
                    @elseif($isPaid)
                        <div class="alert alert-success mt-2 mb-3">
                            Pembayaran Anda sudah kami terima. Pesanan sedang kami proses.
                        </div>
                    @elseif($paymentStatus === 'unpaid')
                        {{-- Belum dibayar: instruksi transfer + upload bukti (jika transfer) --}}
                        <div class="mt-3">
                            @if($order->payment_method === 'transfer')
                                <div class="order-payment-box mb-3">
                                    <div class="fw-semibold mb-1">Silakan Transfer ke Rekening Berikut:</div>
                                    <div>BCA 123-456-7890 a.n. <strong>Toko Mas Sumatra</strong></div>
                                    <div class="small text-muted mt-1">Mohon transfer sesuai total pesanan di atas.</div>
                                </div>

                                @if($canUploadProof)
                                    <form action="{{ route('payment.upload', $order->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">
                                                @if($hasProof)
                                                    Foto Ulang / Ganti Bukti Pembayaran
                                                @else
                                                    Upload Foto Bukti Pembayaran
                                                @endif
                                            </label>
                                            <input type="file" name="payment_proof" class="form-control" accept="image/*" required>
                                            <small class="text-muted">
                                                Format: JPG/PNG. Maks 10MB. Anda dapat mengirim ulang bukti apabila foto sebelumnya
                                                kurang jelas atau kurang tepat.
                                            </small>
                                        </div>
                                        <button type="submit" class="btn btn-dark w-100 py-2 fw-semibold">
                                            Kirim Bukti Pembayaran
                                        </button>
                                    </form>
                                @endif
                            @else
                                <div class="alert alert-warning mt-2 mb-3">
                                    Metode pembayaran Anda adalah <strong>BAYAR DI TOKO</strong>. Silakan datang ke cabang terkait
                                    untuk menyelesaikan pembayaran dan pengambilan perhiasan.
                                </div>
                            @endif

                            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary w-100 mt-3">
                                Kembali ke Dashboard
                            </a>
                        </div>
                    @endif

                    <hr class="my-4">

                    <a href="{{ route('home') }}" class="btn btn-link text-decoration-none">
                        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
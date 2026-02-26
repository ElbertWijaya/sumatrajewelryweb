@php
    $user = Auth::user();
    $active = $active ?? 'dashboard';
@endphp

<div class="card border-0 shadow-sm h-100">
    <div class="card-body d-flex flex-column">
        <div class="d-flex align-items-center mb-4">
            <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                <i class="bi bi-person"></i>
            </div>
            <div class="ms-3">
                <div class="small text-muted">Dashboard</div>
                <div class="fw-semibold text-truncate" style="max-width: 140px;">
                    {{ $user->name }}
                </div>
            </div>
        </div>

        <div class="small text-uppercase text-muted mb-2">Overview</div>
        <ul class="nav nav-pills flex-column mb-3 dashboard-sidebar-nav">
            <li class="nav-item mb-1">
                <a class="nav-link d-flex align-items-center justify-content-between {{ $active === 'dashboard' ? 'active' : '' }}" href="{{ route('customer.dashboard') }}">
                    <span><i class="bi bi-grid me-2"></i>Dashboard</span>
                </a>
            </li>
            <li class="nav-item mb-1">
                <a class="nav-link d-flex align-items-center justify-content-between {{ $active === 'orders' ? 'active' : '' }}" href="{{ route('customer.orders') }}">
                    <span><i class="bi bi-bag-check me-2"></i>Pesanan Saya</span>
                    @if(isset($totalOrders) && $totalOrders > 0)
                        <span class="badge bg-dark-subtle text-dark">{{ $totalOrders }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item mb-1">
                <a class="nav-link d-flex align-items-center justify-content-between {{ $active === 'favorites' ? 'active' : '' }}" href="{{ route('customer.favorites') }}">
                    <span><i class="bi bi-heart me-2"></i>Favorit</span>
                    <span class="badge bg-light text-muted">Segera</span>
                </a>
            </li>
            <li class="nav-item mb-1">
                <a class="nav-link d-flex align-items-center justify-content-between {{ $active === 'settings' ? 'active' : '' }}" href="{{ route('account.settings') }}">
                    <span><i class="bi bi-gear me-2"></i>Settings</span>
                    <span class="badge bg-light text-muted">Profil</span>
                </a>
            </li>
        </ul>

        <div class="small text-uppercase text-muted mb-2 mt-3">Lainnya</div>
        <ul class="nav nav-pills flex-column mb-4">
            <li class="nav-item mb-1">
                <a class="nav-link d-flex align-items-center" href="{{ route('home') }}">
                    <i class="bi bi-shop me-2"></i> Kembali ke Beranda
                </a>
            </li>
        </ul>

        <form action="{{ route('logout') }}" method="POST" class="mt-auto">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                <i class="bi bi-box-arrow-right me-1"></i> Keluar
            </button>
        </form>
    </div>
    </div>

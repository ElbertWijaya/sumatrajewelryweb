@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
    @php
        $user = Auth::user();
    @endphp

    <div class="py-5" style="background-color: #f5f5f7;">
        <div class="container-xxl">
            <div class="row g-4">
                <div class="col-lg-3 col-xl-3">
                    @include('customer.partials.sidebar', ['active' => 'settings'])
                </div>

                <div class="col-lg-9 col-xl-9">
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body p-4">
                            <h5 class="mb-1">Informasi Akun</h5>
                            <p class="text-muted small mb-4">Lihat dan kelola data pribadi yang terhubung dengan akun Toko Mas Sumatra.</p>

                            <div class="row g-3">
                                <div class="col-12 col-lg-6">
                                    <label class="form-label small text-muted mb-1">Nama Lengkap</label>
                                    <input type="text" class="form-control form-control-sm" value="{{ $user->name }}" readonly>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label small text-muted mb-1">Email</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                                        <span class="input-group-text">
                                            @if($user->email_verified_at)
                                                <span class="badge bg-success-subtle text-success border-0">Verified</span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning border-0">Unverified</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label class="form-label small text-muted mb-1">Nomor Telepon</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" value="{{ $user->phone_number ?? 'Belum diatur' }}" readonly>
                                        <span class="input-group-text">
                                            @if($user->phone_verified_at)
                                                <span class="badge bg-success-subtle text-success border-0">Verified</span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning border-0">Unverified</span>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="form-text small">
                                        Ubah atau verifikasi nomor telepon Anda di menu "Nomor Telepon".
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label class="form-label small text-muted mb-1">Tanggal Lahir</label>
                                    <input type="text" class="form-control form-control-sm" value="-" readonly>
                                    <div class="form-text small text-muted">Field ini bisa kita aktifkan nanti jika dibutuhkan.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h6 class="mb-2">Keamanan Akun</h6>
                            <p class="small text-muted mb-3">Beberapa tindakan keamanan umum untuk menjaga akun Anda tetap aman.</p>

                            <div class="d-flex flex-column flex-md-row gap-2">
                                <a href="{{ route('password.request') }}" class="btn btn-outline-dark btn-sm">
                                    <i class="bi bi-shield-lock me-1"></i> Ubah Kata Sandi
                                </a>
                                <a href="{{ route('account.phone') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-phone me-1"></i> Kelola Nomor Telepon
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

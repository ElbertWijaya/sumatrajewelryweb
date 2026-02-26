@extends('layouts.app')

@section('title', 'Favorit Saya')

@section('content')
    <div class="py-5" style="background-color: #f5f5f7;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-xl-3">
                    @include('customer.partials.sidebar', ['active' => 'favorites'])
                </div>

                <div class="col-lg-9 col-xl-9">
                    <div class="mb-3">
                        <h5 class="mb-1">Produk Favorit</h5>
                        <p class="small text-muted mb-0">Di sini nantinya Anda dapat menyimpan dan mengelola daftar perhiasan yang Anda sukai.</p>
                    </div>

                    <div class="text-center py-5">
                        <p class="text-muted mb-2">Fitur favorit / wishlist belum diaktifkan.</p>
                        <p class="text-muted mb-0">Saat fitur ini siap, Anda dapat menandai produk di katalog dan melihatnya kembali di halaman ini.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

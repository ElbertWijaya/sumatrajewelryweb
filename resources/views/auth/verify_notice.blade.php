@extends('layouts.app')

@section('title', 'Verifikasi Email - Toko Mas Sumatra')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4 shadow-sm">
                <h4>Verifikasi Email</h4>

                <p class="mb-3">
                    Terima kasih telah mendaftar. Kami telah mengirimkan email verifikasi ke alamat yang Anda gunakan.
                    Silakan klik tautan verifikasi yang ada di email tersebut sebelum melakukan pemesanan.
                </p>

                @if (session('status') === 'verification-link-sent')
                    <div class="alert alert-success">
                        Tautan verifikasi baru telah dikirim ke email Anda.
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-dark">Kirim Ulang Email Verifikasi</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
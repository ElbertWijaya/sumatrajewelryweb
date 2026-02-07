@extends('layouts.app')

@section('title', 'Tentang Toko Mas Sumatra')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center mb-4">
        <div class="col-lg-8 text-center">
            <h1 class="fw-bold mb-2">Tentang Toko Mas Sumatra</h1>
            <div style="width: 80px; height: 3px; background: #c5a059; margin: 10px auto 20px;"></div>
            <p class="text-muted">
                Toko Mas Sumatra berdiri sebagai wujud kecintaan kami terhadap keindahan perhiasan emas 
                dan nilai kebersamaan yang menyertainya. Setiap perhiasan yang kami hadirkan dirancang 
                untuk menjadi bagian dari momen penting dalam hidup Anda.
            </p>
        </div>
    </div>

    {{-- Sejarah singkat --}}
    <div class="row justify-content-center mb-5">
        <div class="col-lg-9">
            <h4 class="fw-semibold mb-3">Sejarah Singkat</h4>
            <p class="text-muted">
                Berawal dari sebuah toko kecil di Sumatra, Toko Mas Sumatra tumbuh dengan mengedepankan 
                kejujuran, ketelitian, dan pelayanan yang hangat. Sejak awal berdiri, kami berkomitmen 
                untuk hanya menyediakan emas dengan kadar terukur dan harga yang transparan.
            </p>
            <p class="text-muted">
                Seiring waktu, kepercayaan pelanggan menjadi fondasi utama perkembangan kami. 
                Dari melayani pembelian perhiasan klasik hingga pesanan cincin kawin dan desain custom, 
                kami terus berupaya menjaga standar kualitas yang konsisten.
            </p>
        </div>
    </div>

    {{-- Visi & Misi --}}
    <div class="row gy-4 mb-5">
        <div class="col-md-6">
            <div class="border rounded-3 p-4 h-100 bg-light">
                <h4 class="fw-semibold mb-3">Visi</h4>
                <p class="text-muted mb-0">
                    Menjadi toko perhiasan emas yang dipercaya keluarga Indonesia sebagai 
                    sahabat dalam setiap momen berharga, dari generasi ke generasi.
                </p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="border rounded-3 p-4 h-100 bg-light">
                <h4 class="fw-semibold mb-3">Misi</h4>
                <ul class="text-muted mb-0">
                    <li class="mb-1">Menyediakan perhiasan emas berkualitas dengan kadar yang terjamin.</li>
                    <li class="mb-1">Memberikan informasi harga emas yang transparan dan mudah dipahami.</li>
                    <li class="mb-1">Menghadirkan desain yang elegan, baik ready stock maupun custom.</li>
                    <li class="mb-1">Membangun hubungan jangka panjang dengan pelanggan melalui layanan yang ramah dan profesional.</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Narasi / Filosofi Toko --}}
    <div class="row justify-content-center mb-5">
        <div class="col-lg-9">
            <h4 class="fw-semibold mb-3">Filosofi Kami</h4>
            <p class="text-muted">
                Bagi kami, perhiasan emas bukan sekadar benda berharga; ia menyimpan cerita, doa, dan harapan. 
                Setiap detail — dari pemilihan bahan, proses pengerjaan, hingga penyerahan kepada pelanggan — 
                kami upayakan dengan sepenuh hati agar memberikan pengalaman yang berkesan.
            </p>
            <p class="text-muted">
                Kami percaya bahwa kepercayaan dibangun dari hal-hal kecil: kejelasan informasi, kejujuran timbangan, 
                dan kesediaan untuk mendengarkan kebutuhan Anda. Karena itu, setiap kunjungan ke Toko Mas Sumatra 
                kami harapkan terasa seperti berkunjung ke sahabat lama yang dapat Anda andalkan.
            </p>
        </div>
    </div>

    {{-- Layanan utama & Custom --}}
    <div class="row gy-4 mb-4" id="custom">
        <div class="col-md-4">
            <div class="border rounded-3 p-4 h-100 text-center">
                <i class="bi bi-gem fs-1 text-warning mb-3"></i>
                <h5 class="fw-semibold mb-2">Perhiasan Ready Stock</h5>
                <p class="small text-muted mb-0">
                    Koleksi cincin, gelang, kalung, dan anting yang siap dipilih sebagai hadiah 
                    maupun pelengkap penampilan sehari-hari Anda.
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border rounded-3 p-4 h-100 text-center">
                <i class="bi bi-brush fs-1 text-warning mb-3"></i>
                <h5 class="fw-semibold mb-2">Layanan Custom</h5>
                <p class="small text-muted mb-0">
                    Wujudkan desain impian Anda, mulai dari cincin kawin hingga perhiasan spesial, 
                    dengan konsultasi langsung bersama tim kami.
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border rounded-3 p-4 h-100 text-center">
                <i class="bi bi-arrow-repeat fs-1 text-warning mb-3"></i>
                <h5 class="fw-semibold mb-2">Buyback & Penyesuaian</h5>
                <p class="small text-muted mb-0">
                    Kami menyediakan layanan buyback tertentu serta penyesuaian perhiasan 
                    agar tetap nyaman dan sesuai dengan kebutuhan Anda.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
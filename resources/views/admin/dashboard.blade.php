<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Toko Mas Sumatra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Toko Mas Sumatra - Internal System</a>
        </div>
    </nav>

    <div class="container">
        
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
        @endif

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card text-white bg-warning mb-3 shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Harga Emas Murni (24K)</span>
                        <button type="button" class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#updatePriceModal">Update Harga</button>
                    </div>
                    <div class="card-body">
                        <h2 class="card-title">Rp {{ number_format($goldPrice24k->sell_price_per_gram ?? 0, 0, ',', '.') }} / gram</h2>
                        <p class="card-text">Buyback: Rp {{ number_format($goldPrice24k->buyback_price_per_gram ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-success mb-3 shadow">
                    <div class="card-header">Total Stok Produk</div>
                    <div class="card-body">
                        <h2 class="card-title">{{ $products->count() }} Pcs</h2>
                        <p class="card-text">Siap dijual di etalase.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <span>Pesanan Masuk (Incoming Orders)</span>
                <span class="badge bg-warning text-dark">{{ $orders->where('payment_status', 'unpaid')->count() }} Belum Dibayar</span>
            </div>
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Invoice</th>
                            <th>Pembeli</th>
                            <th>Total Harga</th>
                            <th>Status Bayar</th>
                            <th>Status Order</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="fw-bold text-primary">{{ $order->invoice_number }}</td>
                            <td>
                                {{ $order->user->name ?? 'Guest' }}<br>
                                <small class="text-muted">{{ $order->user->phone_number ?? '-' }}</small>
                            </td>
                            <td class="fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td>
                                @if($order->payment_status == 'paid')
                                    <span class="badge bg-success">LUNAS</span>
                                @else
                                    <span class="badge bg-danger">BELUM BAYAR</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $order->order_status }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada pesanan masuk hari ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span>Daftar Inventaris Perhiasan</span>
                <button class="btn btn-light btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    + Tambah Produk Baru
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Foto</th>
                            <th>SKU</th>
                            <th>Nama Produk</th>
                            <th>Karat</th>
                            <th>Berat</th>
                            <th>Harga Estimasi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td class="text-center">
                                @if($product->image_url)
                                    <img src="{{ asset('uploads/' . $product->image_url) }}" width="50" height="50" style="object-fit: cover; border-radius: 5px;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->karat_type }}</td>
                            <td>{{ $product->weight }} gr</td>
                            <td>
                                @php
                                    $hargaDasar = ($product->karat_type == '24K')
                                        ? ($goldPrice24k->sell_price_per_gram ?? 0)
                                        : (($goldPrice24k->sell_price_per_gram ?? 0) * 0.8);
                                    $total = ($product->weight * $hargaDasar) + $product->labor_cost + $product->stone_price;
                                @endphp
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($product->stock_status == 'ready')
                                    <span class="badge bg-success">READY</span>
                                @elseif($product->stock_status == 'booked')
                                    <span class="badge bg-warning text-dark">BOOKED</span>
                                @elseif($product->stock_status == 'sold')
                                    <span class="badge bg-danger">SOLD</span>
                                @else
                                    <span class="badge bg-secondary">{{ $product->stock_status }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Update Harga Emas --}}
    <div class="modal fade" id="updatePriceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('/admin/gold-price/update') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Update Harga Emas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Harga Jual / gram (24K)</label>
                            <input type="number" name="sell_price" class="form-control" value="{{ $goldPrice24k->sell_price_per_gram }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Harga Buyback / gram</label>
                            <input type="number" name="buyback_price" class="form-control" value="{{ $goldPrice24k->buyback_price_per_gram }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Produk --}}
    <div class="modal fade" id="addProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg"> 
            <div class="modal-content">
                <form action="{{ url('/admin/product/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Input Produk Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>SKU / Barcode *</label>
                                <input type="text" name="sku" class="form-control" placeholder="Contoh: CN-005" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Nama Produk *</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Kadar *</label>
                                <select name="karat_type" class="form-select">
                                    <option value="17K">17K (Emas Tua)</option>
                                    <option value="24K">24K (Murni)</option>
                                    <option value="8K">8K (Emas Muda)</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Berat (Gram) *</label>
                                <input type="number" step="0.001" name="weight" class="form-control" placeholder="0.000" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Ongkos Bikin (Rp)</label>
                                <input type="number" name="labor_cost" class="form-control" value="0">
                            </div>
                        </div>

                        {{-- Lokasi Cabang & Warna Emas --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Lokasi Cabang</label>
                                <select name="branch_location" class="form-select">
                                    <option value="Asia">Asia</option>
                                    <option value="Sun Plaza">Sun Plaza</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Warna Emas</label>
                                <select name="gold_color" class="form-select">
                                    <option value="">Pilih warna</option>
                                    <option value="Kuning">Kuning</option>
                                    <option value="Putih">Putih</option>
                                    <option value="Rose Gold">Rose Gold</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Upload Foto Produk</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG. Maks 2MB.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
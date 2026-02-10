<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;      // Panggil Model Produk
use App\Models\GoldPrice;    // Panggil Model Harga Emas
use App\Models\Order;        // Panggil Model Order

class AdminController extends Controller
{
    public function index()
    {
        // 1. Ambil data harga emas pertama
        $goldPrice24k = GoldPrice::where('karat_type', '24K')->first();
        
        // 2. Ambil semua produk yang ada di database
        $products = Product::all();

        // 3. Ambil data pesanan
        $orders = Order::with('user')->latest()->get();

        // 4. Kirim data ke view
        return view('admin.dashboard', compact('goldPrice24k', 'products', 'orders'));
    }

    public function updatePrice(Request $request)
    {
        // 1. Cari data harga 24K di database
        $goldPrice = GoldPrice::where('karat_type', '24K')->first();

        // 2. Update angkanya dengan input dari form
        $goldPrice->sell_price_per_gram    = $request->sell_price;
        $goldPrice->buyback_price_per_gram = $request->buyback_price;
        
        // 3. Simpan ke database
        $goldPrice->save();

        // 4. Kembali ke halaman dashboard dengan pesan sukses
        return redirect('/admin/dashboard')->with('success', 'Harga emas berhasil diperbarui!');
    }    

    public function storeProduct(Request $request)
    {
        // 1. Validasi (Cek kelengkapan data)
        $request->validate([
            'sku'             => 'required|unique:products,sku', // SKU tidak boleh kembar
            'name'            => 'required',
            'weight'          => 'required|numeric',
            'karat_type'      => 'required',
            'branch_location' => 'nullable|string', // Asia / Sun Plaza
            'gold_color'      => 'nullable|string', // Kuning / Putih / Rose Gold
            'labor_cost'      => 'nullable|numeric',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi foto
        ]);

        // 2. Proses Upload Foto (Jika ada)
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Beri nama unik: waktu_saat_ini + nama_asli
            $imageName = time() . '_' . $image->getClientOriginalName();
            // Pindahkan ke folder public/uploads
            $image->move(public_path('uploads'), $imageName);
        }

        // 3. Simpan ke Database
        Product::create([
            'sku'             => $request->sku,
            'name'            => $request->name,
            'category_id'     => 1, // Sementara kategori default 1 (Cincin)
            'weight'          => $request->weight,
            'karat_type'      => $request->karat_type,
            'stone_price'     => 0, // belum ada input di form
            'labor_cost'      => $request->labor_cost ?? 0,
            'image_url'       => $imageName,
            'stock_status'    => 'ready',
            'branch_location' => $request->branch_location ?: 'Asia',
            'gold_color'      => $request->gold_color ?: null,
        ]);

        // 4. Kembali ke dashboard
        return redirect()->back()->with('success', 'Produk baru berhasil ditambahkan!');
    }

    // 1. Tampilkan Detail Order
    public function showOrder($id)
    {
        // Ambil order beserta item produknya
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // 2. Proses Konfirmasi Pembayaran
    public function confirmPayment($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        // A. Ubah Status Pesanan
        $order->update([
            'payment_status' => 'paid',
            'order_status'   => 'processing', // Sedang diproses
        ]);

        // B. Ubah Status Barang jadi SOLD
        foreach ($order->items as $item) {
            $item->product->update(['stock_status' => 'sold']);
        }

        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi! Pesanan sedang diproses oleh toko.');
    }

    // 3. Input Nomor Resi dan ubah status pesanan
    public function inputResi(Request $request, $id)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:50'
        ]);

        $order = Order::findOrFail($id);

        $order->update([
            'tracking_number' => $request->tracking_number,
            'order_status'    => 'ready_to_ship'
        ]);

        return redirect()->back()->with('success', 'Nomor Resi berhasil diinput. Status pesanan berubah menjadi DIKIRIM.');
    }
}
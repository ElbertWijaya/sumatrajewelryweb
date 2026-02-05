<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;      // Panggil Model Produk
use App\Models\GoldPrice;    // Panggil Model Harga Emas

class AdminController extends Controller
{
    public function index()
    {
        // 1. Ambil data harga emas pertama
        $goldPrice24k = GoldPrice::where('karat_type', '24K')->first();
        
        // 2. Ambil semua produk yang ada di database
        $products = Product::all();

        // 3. Kirim data tersebut ke View (halaman HTML)
        return view('admin.dashboard', compact('goldPrice24k', 'products'));
    }

    public function updatePrice(Request $request)
    {
        // 1. Cari data harga 24K di database
        $goldPrice = GoldPrice::where('karat_type', '24K')->first();

        // 2. Update angkanya dengan input dari form
        $goldPrice->sell_price_per_gram = $request->sell_price;
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
            'sku' => 'required|unique:products,sku', // SKU tidak boleh kembar
            'name' => 'required',
            'weight' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi foto
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
            'sku' => $request->sku,
            'name' => $request->name,
            'category_id' => 1, // Sementara kita set kategori ID 1 (Cincin) dulu
            'weight' => $request->weight,
            'karat_type' => $request->karat_type,
            'labor_cost' => $request->labor_cost ?? 0, // Jika kosong anggap 0
            'image_url' => $imageName, // Simpan nama filenya saja
            'stock_status' => 'ready'
        ]);

        // 4. Kembali ke dashboard
        return redirect()->back()->with('success', 'Produk baru berhasil ditambahkan!');
    }
}


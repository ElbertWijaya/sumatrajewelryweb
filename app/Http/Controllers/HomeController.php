<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\GoldPrice;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil Harga Emas Hari Ini (24K)
        $goldPrice24k = GoldPrice::where('karat_type', '24K')->first();

        // 2. Ambil Produk yang statusnya 'ready' saja (Jangan tampilkan barang terjual)
        $products = Product::where('stock_status', 'ready')->latest()->get();

        // 3. Kirim ke tampilan halaman depan
        return view('home', compact('goldPrice24k', 'products'));
    }

    public function show($id)
    {
        // 1. Cari produk berdasarkan ID, jika tidak ketemu tampilkan error 404
        $product = Product::findOrFail($id);
        
        // 2. Ambil harga emas hari ini (untuk hitung ulang harga detail)
        $goldPrice24k = GoldPrice::where('karat_type', '24K')->first();

        // 3. Tampilkan view detail
        return view('product_detail', compact('product', 'goldPrice24k'));
    }
}
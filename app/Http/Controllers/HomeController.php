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
}
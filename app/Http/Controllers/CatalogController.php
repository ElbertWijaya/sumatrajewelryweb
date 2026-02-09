<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\GoldPrice;

class CatalogController extends Controller
{
    // Halaman katalog penuh (versi dasar tanpa filter pintar dulu)
    public function index(Request $request)
    {
        // Ambil produk ready saja
        $products = Product::where('stock_status', 'ready')
            ->latest()
            ->paginate(20);

        // Kategori untuk nantinya dipakai di sidebar filter (V2)
        $categories = Category::orderBy('name')->get();

        // Harga emas 24K untuk estimasi harga (sama seperti di home)
        $goldPrice24k = GoldPrice::where('karat_type', '24K')->first();

        return view('catalog.index', compact('products', 'categories', 'goldPrice24k'));
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\GoldPrice;

class CatalogController extends Controller
{
    // Halaman katalog penuh
public function index(Request $request)
{
    // Ambil parameter filter dari query string
    $search      = $request->input('search');
    $categoryId  = $request->input('category');      // id kategori
    $karat       = $request->input('karat');         // contoh: 17K, 24K
    $sort        = $request->input('sort');          // latest, price_asc, price_desc

    // Filter tambahan
    $onlyReady      = $request->boolean('only_ready', true); // default: true
    $minWeight      = $request->input('min_weight');         // gram
    $maxWeight      = $request->input('max_weight');
    $minPrice       = $request->input('min_price');          // Rupiah
    $maxPrice       = $request->input('max_price');
    $branchLocation = $request->input('branch_location');    // Asia / Sun Plaza
    $collection     = $request->input('collection');    // nama koleksi
    $goldColor      = $request->input('gold_color');         // Kuning / Putih / Rose Gold

    // Query dasar
    $query = Product::query();

    // 0. Filter stok ready (default)
    if ($onlyReady) {
        $query->where('stock_status', 'ready');
    }

    // 1. Filter: search nama
    if ($search) {
        $query->where('name', 'like', '%' . $search . '%');
    }

    // 2. Filter: kategori
    if ($categoryId) {
        $query->where('category_id', $categoryId);
    }

    // 3. Filter: karat
    if ($karat) {
        $query->where('karat_type', $karat);
    }

    // 4. Filter: lokasi cabang
    if ($branchLocation) {
        $query->where('branch_location', $branchLocation);
    }

    // 5. Filter: warna emas
    if ($goldColor) {
        $query->where('gold_color', $goldColor);
    }

    // 6. Filter: koleksi
    if ($collection) {
    $query->where('collection', $collection);
}

    // Ambil harga emas 24K untuk estimasi
    $goldPrice24k = GoldPrice::where('karat_type', '24K')->first();
    $basePrice24  = $goldPrice24k->sell_price_per_gram ?? 0;

    // Ekspresi kasar estimasi harga untuk keperluan whereRaw / orderByRaw
    $priceExpr = "(weight * " . ($basePrice24 > 0 ? $basePrice24 : 1) . ") + labor_cost + stone_price";

    // 6. Filter: rentang berat
    if ($minWeight !== null && $minWeight !== '') {
        $query->where('weight', '>=', (float) $minWeight);
    }
    if ($maxWeight !== null && $maxWeight !== '') {
        $query->where('weight', '<=', (float) $maxWeight);
    }

    // 7. Filter: rentang harga estimasi
    if ($basePrice24 > 0) {
        if ($minPrice !== null && $minPrice !== '') {
            $query->whereRaw("$priceExpr >= ?", [(float) $minPrice]);
        }
        if ($maxPrice !== null && $maxPrice !== '') {
            $query->whereRaw("$priceExpr <= ?", [(float) $maxPrice]);
        }
    }

    // 8. Sort
    switch ($sort) {
        case 'price_asc':
            if ($basePrice24 > 0) {
                $query->orderByRaw("$priceExpr ASC");
            } else {
                $query->orderBy('labor_cost');
            }
            break;
        case 'price_desc':
            if ($basePrice24 > 0) {
                $query->orderByRaw("$priceExpr DESC");
            } else {
                $query->orderByDesc('labor_cost');
            }
            break;
        case 'oldest':
            $query->oldest(); // orderBy('created_at', 'asc')
            break;
        case 'latest':
        default:
            $query->latest();
            break;
    }

    // Paginate
    $products = $query->paginate(20)->withQueryString();

    // Data pendukung filter
    $categories = Category::orderBy('name')->get();

    // Daftar karat unik dari produk
    $karats = Product::select('karat_type')
        ->distinct()
        ->orderBy('karat_type')
        ->pluck('karat_type');

    // Daftar lokasi unik (kalau nanti cabang nambah, otomatis ikut)
    $branchLocations = Product::select('branch_location')
        ->distinct()
        ->orderBy('branch_location')
        ->pluck('branch_location');

    // Daftar warna emas unik
    $goldColors = Product::select('gold_color')
        ->whereNotNull('gold_color')
        ->distinct()
        ->orderBy('gold_color')
        ->pluck('gold_color');
    
    // Daftar koleksi unik
    $collections = Product::select('collection')
        ->whereNotNull('collection')
        ->distinct()
        ->orderBy('collection')
        ->pluck('collection');        

    return view('catalog.index', compact(
        'products',
        'categories',
        'goldPrice24k',
        'search',
        'categoryId',
        'karat',
        'sort',
        'karats',
        'onlyReady',
        'minWeight',
        'maxWeight',
        'minPrice',
        'maxPrice',
        'branchLocation',
        'goldColor',
        'collection',
        'collections',
        'branchLocations',
        'goldColors'
        ));
    }
}
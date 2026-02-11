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

        // Untuk filter multi-select kita menerima array atau single value.
        $category    = $request->input('category', []);      // id kategori (array atau single)
        $karat       = $request->input('karat', []);         // contoh: 17K, 24K (array or single)
        $sort        = $request->input('sort');              // latest, price_asc, price_desc
        $onlyReady   = $request->boolean('only_ready', true); // default: true
        $minWeight   = $request->input('min_weight');         // gram
        $maxWeight   = $request->input('max_weight');
        $minPrice    = $request->input('min_price');          // Rupiah
        $maxPrice    = $request->input('max_price');
        $branchLocation = $request->input('branch_location', []); // array or single
        $collection  = $request->input('collection', []);    // array or single
        $goldColor   = $request->input('gold_color', []);    // array or single

        // Normalize: if value is string with comma-separated values, explode it.
        $normalize = function ($val) {
            if ($val === null || $val === '') return [];
            if (is_array($val)) return array_values($val);
            // if comma separated like "a,b"
            if (is_string($val) && strpos($val, ',') !== false) {
                return array_filter(array_map('trim', explode(',', $val)));
            }
            return [$val];
        };

        $categoryArr     = $normalize($category);
        $karatArr        = $normalize($karat);
        $branchArr       = $normalize($branchLocation);
        $collectionArr   = $normalize($collection);
        $colorArr        = $normalize($goldColor);

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

        // 2. Filter: kategori (multiple)
        if (!empty($categoryArr)) {
            $query->whereIn('category_id', $categoryArr);
        }

        // 3. Filter: karat (multiple)
        if (!empty($karatArr)) {
            $query->whereIn('karat_type', $karatArr);
        }

        // 4. Filter: lokasi cabang (multiple)
        if (!empty($branchArr)) {
            $query->whereIn('branch_location', $branchArr);
        }

        // 5. Filter: warna emas (multiple)
        if (!empty($colorArr)) {
            $query->whereIn('gold_color', $colorArr);
        }

        // 6. Filter: koleksi (multiple)
        if (!empty($collectionArr)) {
            $query->whereIn('collection', $collectionArr);
        }

        // Ambil harga emas 24K untuk estimasi
        $goldPrice24k = GoldPrice::where('karat_type', '24K')->first();
        $basePrice24  = $goldPrice24k->sell_price_per_gram ?? 0;

        // Ekspresi kasar estimasi harga untuk keperluan whereRaw / orderByRaw
        $priceExpr = "(weight * " . ($basePrice24 > 0 ? $basePrice24 : 1) . ") + labor_cost + stone_price";

        // 7. Filter: rentang berat
        if ($minWeight !== null && $minWeight !== '') {
            $query->where('weight', '>=', (float) $minWeight);
        }
        if ($maxWeight !== null && $maxWeight !== '') {
            $query->where('weight', '<=', (float) $maxWeight);
        }

        // 8. Filter: rentang harga estimasi
        if ($basePrice24 > 0) {
            if ($minPrice !== null && $minPrice !== '') {
                $query->whereRaw("$priceExpr >= ?", [(float) $minPrice]);
            }
            if ($maxPrice !== null && $maxPrice !== '') {
                $query->whereRaw("$priceExpr <= ?", [(float) $maxPrice]);
            }
        }

        // 9. Sort
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
        
        // Kirim juga array yang sudah dinormalisasi agar view bisa cek checked dengan mudah
        return view('catalog.index', compact(
            'products',
            'categories',
            'goldPrice24k',
            'search',
            'categoryArr',    // array of selected category ids
            'karatArr',
            'sort',
            'karats',
            'onlyReady',
            'minWeight',
            'maxWeight',
            'minPrice',
            'maxPrice',
            'branchArr',
            'goldColors',
            'colorArr',
            'collectionArr',
            'collections',
            'branchLocations'
        ));
    }
}
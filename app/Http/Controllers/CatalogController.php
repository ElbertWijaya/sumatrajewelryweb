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
        // Ambil parameter filter dari query string / request
        $search      = $request->input('search');

        // Terima kemungkinan array (karat[]), atau single value, atau comma-separated string
        $category     = $request->input('category', []);      // id kategori (array or single)
        $karat        = $request->input('karat', []);         // contoh: 17K, 24K
        $sort         = $request->input('sort');              // latest, price_asc, price_desc
        $onlyReady    = $request->boolean('only_ready', true); // default: true
        $minWeight    = $request->input('min_weight');         // gram
        $maxWeight    = $request->input('max_weight');
        $minPrice     = $request->input('min_price');          // Rupiah
        $maxPrice     = $request->input('max_price');
        $branch       = $request->input('branch_location', []); // array or single
        $collection   = $request->input('collection', []);    // array or single
        $goldColor    = $request->input('gold_color', []);    // array or single

        // normalizer: turn single / comma-separated into array of strings
        $normalize = function ($val) {
            if ($val === null || $val === '') return [];
            if (is_array($val)) return array_values($val);
            if (is_string($val) && strpos($val, ',') !== false) {
                return array_values(array_filter(array_map('trim', explode(',', $val))));
            }
            return [$val];
        };

        $categoryArr   = $normalize($category);
        $karatArr      = $normalize($karat);
        $branchArr     = $normalize($branch);
        $collectionArr = $normalize($collection);
        $colorArr      = $normalize($goldColor);

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

        // Filter berat
        if ($minWeight !== null && $minWeight !== '') {
            $query->where('weight', '>=', (float) $minWeight);
        }
        if ($maxWeight !== null && $maxWeight !== '') {
            $query->where('weight', '<=', (float) $maxWeight);
        }

        // Filter harga estimasi
        if ($basePrice24 > 0) {
            if ($minPrice !== null && $minPrice !== '') {
                $query->whereRaw("$priceExpr >= ?", [(float) $minPrice]);
            }
            if ($maxPrice !== null && $maxPrice !== '') {
                $query->whereRaw("$priceExpr <= ?", [(float) $maxPrice]);
            }
        }

        // Sort
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
                $query->oldest();
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

        $karats = Product::select('karat_type')
            ->distinct()
            ->orderBy('karat_type')
            ->pluck('karat_type');

        $branchLocations = Product::select('branch_location')
            ->distinct()
            ->orderBy('branch_location')
            ->pluck('branch_location');

        $goldColors = Product::select('gold_color')
            ->whereNotNull('gold_color')
            ->distinct()
            ->orderBy('gold_color')
            ->pluck('gold_color');

        $collections = Product::select('collection')
            ->whereNotNull('collection')
            ->distinct()
            ->orderBy('collection')
            ->pluck('collection');

        // Kirim arrays yang sudah dinormalisasi agar view bisa cek checked dengan mudah
        return view('catalog.index', compact(
            'products',
            'categories',
            'goldPrice24k',
            'search',
            'categoryArr',
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
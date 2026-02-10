public function index(Request $request)
{
    // Ambil parameter filter dari query string
    $search      = $request->input('search');
    $categoryId  = $request->input('category');     // id kategori
    $karat       = $request->input('karat');        // contoh: 17K, 24K
    $sort        = $request->input('sort');         // latest, price_asc, price_desc

    // Filter tambahan V2
    $onlyReady   = $request->boolean('only_ready', true); // default: true
    $minWeight   = $request->input('min_weight');         // gram
    $maxWeight   = $request->input('max_weight');
    $minPrice    = $request->input('min_price');          // Rupiah
    $maxPrice    = $request->input('max_price');

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

    // Untuk filter harga kita butuh harga dasar 24K
    $goldPrice24k = GoldPrice::where('karat_type', '24K')->first();
    $basePrice24  = $goldPrice24k->sell_price_per_gram ?? 0;

    // Rumus estimasi harga sama seperti di view,
    // tapi kita pakai dalam bentuk ekspresi SQL kasar
    // NOTE: ini pendekatan kira-kira, tapi konsisten.
    $priceExpr = "(weight * " . ($basePrice24 > 0 ? $basePrice24 : 1) . ") + labor_cost + stone_price";

    // 4. Filter: rentang berat
    if ($minWeight !== null && $minWeight !== '') {
        $query->where('weight', '>=', (float) $minWeight);
    }
    if ($maxWeight !== null && $maxWeight !== '') {
        $query->where('weight', '<=', (float) $maxWeight);
    }

    // 5. Filter: rentang harga estimasi (pakai whereRaw)
    if ($minPrice !== null && $minPrice !== '' && $basePrice24 > 0) {
        $query->whereRaw("$priceExpr >= ?", [(float) $minPrice]);
    }
    if ($maxPrice !== null && $maxPrice !== '' && $basePrice24 > 0) {
        $query->whereRaw("$priceExpr <= ?", [(float) $maxPrice]);
    }

    // 6. Sort
    switch ($sort) {
        case 'price_asc':
            if ($basePrice24 > 0) {
                $query->orderByRaw("$priceExpr ASC");
            } else {
                $query->orderBy('labor_cost'); // fallback sederhana
            }
            break;
        case 'price_desc':
            if ($basePrice24 > 0) {
                $query->orderByRaw("$priceExpr DESC");
            } else {
                $query->orderByDesc('labor_cost'); // fallback
            }
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
        'maxPrice'
    ));
}
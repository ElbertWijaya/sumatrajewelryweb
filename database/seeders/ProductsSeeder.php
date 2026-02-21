<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan table products ada
        if (! Schema::hasTable('products')) {
            return;
        }

        $now = Carbon::now();

        // Ambil category id default (jika ada)
        $firstCategory = DB::table('categories')->first();
        $categoryId = $firstCategory ? $firstCategory->id : null;

        $exampleProducts = [
            [
                'sku' => $this->generateSku('CIN'),
                'name' => 'Cincin Emas Classic',
                'category_id' => $categoryId,
                'weight' => 3.5,
                'karat_type' => '17K',
                'stone_price' => 150000,
                'labor_cost' => 200000,
                'stock_status' => 'ready',
                'image_url' => null,
                'description' => 'Cincin elegan untuk acara spesial.',
                'branch_location' => 'Asia',
                'gold_color' => 'Kuning',
                'collection' => 'Perhiasan Sehari-hari',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'sku' => $this->generateSku('GEL'),
                'name' => 'Gelang Elegan',
                'category_id' => $categoryId,
                'weight' => 5.2,
                'karat_type' => '24K',
                'stone_price' => 0,
                'labor_cost' => 300000,
                'stock_status' => 'ready',
                'image_url' => null,
                'description' => 'Gelang minimalis cocok untuk sehari-hari.',
                'branch_location' => 'Sun Plaza',
                'gold_color' => 'Putih',
                'collection' => 'Koleksi Eksklusif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // insertOrIgnore agar idempotent (tidak error jika ada duplicate SKU)
        DB::table('products')->insertOrIgnore($exampleProducts);
    }

    private function generateSku(string $prefix = 'P'): string
    {
        // contoh: CIN-20260211-5F3A2C (prefix + tanggal + random)
        return strtoupper($prefix . '-' . date('Ymd') . '-' . Str::upper(Str::random(6)));
    }
}
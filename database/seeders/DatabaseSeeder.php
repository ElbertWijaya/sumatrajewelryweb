<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\GoldPrice;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Owner (idempotent)
        User::updateOrCreate(
            ['email' => 'owner@sumatra.com'],
            [
                'name' => 'Owner Sumatra',
                // gunakan cast hashed di model, tidak perlu Hash::make
                'password' => 'password123',
                'role' => 'owner',
                'phone_number' => '08123456789'
            ]
        );

        // 2. Buat Data Harga Emas Hari Ini
        GoldPrice::updateOrCreate(
            ['karat_type' => '24K'],
            [
                'sell_price_per_gram' => 1100000, // 1.1 Juta
                'buyback_price_per_gram' => 1000000,
            ]
        );
        
        GoldPrice::updateOrCreate(
            ['karat_type' => '17K'],
            [
                'sell_price_per_gram' => 850000, 
                'buyback_price_per_gram' => 750000,
            ]
        );

        // 3. Buat Kategori
        $kategoriCincin = Category::updateOrCreate(
            ['slug' => 'cincin-wanita'],
            [
                'name' => 'Cincin Wanita'
            ]
        );

        // 4. Buat Produk Contoh
        Product::updateOrCreate(
            ['sku' => 'CM-001'],
            [
                'name' => 'Cincin Emas Listring',
                'category_id' => $kategoriCincin->id,
                'weight' => 3.5, // 3.5 Gram
                'karat_type' => '17K',
                'stone_price' => 200000,
                'labor_cost' => 150000,
                'stock_status' => 'ready',
                'description' => 'Cincin elegan dengan ukiran halus khas Sumatra.'
            ]
            
        );

        // 5. Tambahkan 19 variasi produk lain (total 20 produk)
        for ($i = 2; $i <= 20; $i++) {
            Product::updateOrCreate(
                ['sku' => 'CM-' . str_pad($i, 3, '0', STR_PAD_LEFT)],
                [
                    'name' => 'Cincin Emas Varian ' . $i,
                    'category_id' => $kategoriCincin->id,
                    'weight' => 3 + ($i * 0.1), // sedikit variasi berat
                    'karat_type' => '17K',
                    'stone_price' => 150000 + ($i * 5000),
                    'labor_cost' => 120000 + ($i * 3000),
                    'stock_status' => 'ready',
                    'description' => 'Cincin emas varian ke-' . $i . ' dari koleksi Sumatra.'
                ]
            );
        }
    }
}
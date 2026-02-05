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
        // 1. Buat Akun Owner (Untuk Login nanti)
        User::create([
            'name' => 'Owner Sumatra',
            'email' => 'owner@sumatra.com',
            'password' => Hash::make('password123'), // Password aman
            'role' => 'owner',
            'phone_number' => '08123456789'
        ]);

        // 2. Buat Data Harga Emas Hari Ini
        GoldPrice::create([
            'karat_type' => '24K',
            'sell_price_per_gram' => 1100000, // 1.1 Juta
            'buyback_price_per_gram' => 1000000,
        ]);
        
        GoldPrice::create([
            'karat_type' => '17K',
            'sell_price_per_gram' => 850000, 
            'buyback_price_per_gram' => 750000,
        ]);

        // 3. Buat Kategori
        $kategoriCincin = Category::create([
            'name' => 'Cincin Wanita',
            'slug' => 'cincin-wanita'
        ]);

        // 4. Buat Produk Contoh
        Product::create([
            'sku' => 'CM-001',
            'name' => 'Cincin Emas Listring',
            'category_id' => $kategoriCincin->id,
            'weight' => 3.5, // 3.5 Gram
            'karat_type' => '17K',
            'stone_price' => 200000,
            'labor_cost' => 150000,
            'stock_status' => 'ready',
            'description' => 'Cincin elegan dengan ukiran halus khas Sumatra.'
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Cek apakah table products ada
        if (!\Schema::hasTable('products')) {
            return;
        }

        $exampleProducts = [
            [
                'name' => 'Cincin Emas Classic',
                'karat_type' => '17K',
                'weight' => 3.5,
                'labor_cost' => 200000,
                'stone_price' => 150000,
                'image_url' => null,
                'stock_status' => 'ready',
                'branch_location' => 'Jakarta',
                'gold_color' => 'Kuning',
                'collection' => 'Daily Collections',
                'category_id' => $this->firstCategoryId(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Gelang Elegan',
                'karat_type' => '24K',
                'weight' => 5.2,
                'labor_cost' => 300000,
                'stone_price' => 0,
                'image_url' => null,
                'stock_status' => 'ready',
                'branch_location' => 'Bandung',
                'gold_color' => 'Putih',
                'collection' => 'Pilihan Unggulan',
                'category_id' => $this->firstCategoryId(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('products')->insert($exampleProducts);
    }

    private function firstCategoryId()
    {
        if (\Schema::hasTable('categories')) {
            $c = DB::table('categories')->first();
            return $c ? $c->id : null;
        }
        return null;
    }
}
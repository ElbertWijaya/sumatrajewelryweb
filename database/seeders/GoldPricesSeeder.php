<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class GoldPricesSeeder extends Seeder
{
    public function run(): void
    {
        if (! Schema::hasTable('gold_prices')) {
            return;
        }

        $now = Carbon::now();

        $rows = [
            [
                'karat_type' => '24K',
                'sell_price_per_gram' => 1000000, // contoh angka, silakan sesuaikan
                'buyback_price_per_gram' => 950000,
                'updated_by' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'karat_type' => '17K',
                'sell_price_per_gram' => 700000,
                'buyback_price_per_gram' => 650000,
                'updated_by' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('gold_prices')->insertOrIgnore($rows);
    }
}

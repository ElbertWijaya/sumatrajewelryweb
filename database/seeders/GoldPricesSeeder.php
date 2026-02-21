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

        $karats = config('jewelry.karats', []);

        if (empty($karats)) {
            return;
        }

        $rows = [];

        // Angka hanya contoh; dibuat menurun dari 24K ke bawah
        $baseSell = 1000000;      // 24K
        $baseBuyback = 950000;    // 24K
        $step = 25000;            // selisih antar karat

        foreach ($karats as $index => $karat) {
            $rows[] = [
                'karat_type' => $karat,
                'sell_price_per_gram' => max(1, $baseSell - $index * $step),
                'buyback_price_per_gram' => max(1, $baseBuyback - $index * $step),
                'updated_by' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('gold_prices')->insertOrIgnore($rows);
    }
}

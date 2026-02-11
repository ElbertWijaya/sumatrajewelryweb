<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan table categories ada (mencegah error saat seeding di environment yg berbeda)
        if (! Schema::hasTable('categories')) {
            return;
        }

        $now = Carbon::now();
        $categories = [
            ['name' => 'Cincin', 'slug' => 'cincin', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Gelang', 'slug' => 'gelang', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kalung', 'slug' => 'kalung', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Anting', 'slug' => 'anting', 'created_at' => $now, 'updated_at' => $now],
        ];

        // Gunakan insertOrIgnore agar seeding idempotent (tidak error bila data sudah ada)
        DB::table('categories')->insertOrIgnore($categories);
    }
}
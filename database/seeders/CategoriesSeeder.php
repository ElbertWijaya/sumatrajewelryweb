<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $categories = [
            ['name' => 'Cincin', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Gelang', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kalung', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Anting', 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($categories as $c) {
            // jika table categories ada
            if (SchemaHasTable('categories')) {
                DB::table('categories')->insert($c);
            }
        }
    }
}

/*
 Helper: function SchemaHasTable digunakan di seeder untuk menghindari error
 jika struktur DB berbeda. Karena kita tidak bisa mengeksekusi helper di seeder
 langsung, pastikan table categories ada; jika tidak, hapus pengecekan SchemaHasTable
 dan sesuaikan seeder berdasarkan schema Anda.
 */
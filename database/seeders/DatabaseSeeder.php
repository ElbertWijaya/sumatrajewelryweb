<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan: categories -> products -> users
        $this->call([
            \Database\Seeders\CategoriesSeeder::class,
            \Database\Seeders\ProductsSeeder::class,
            \Database\Seeders\UsersTableSeeder::class,
        ]);
    }
}
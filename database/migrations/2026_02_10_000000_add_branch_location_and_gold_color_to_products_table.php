<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Tambah branch_location hanya jika belum ada
            if (! Schema::hasColumn('products', 'branch_location')) {
                $table->string('branch_location')
                      ->default('Asia')
                      ->after('description');
            }

            // Tambah gold_color hanya jika belum ada
            if (! Schema::hasColumn('products', 'gold_color')) {
                $table->string('gold_color')
                      ->nullable()
                      ->after('branch_location');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'gold_color')) {
                $table->dropColumn('gold_color');
            }
            if (Schema::hasColumn('products', 'branch_location')) {
                $table->dropColumn('branch_location');
            }
        });
    }
};
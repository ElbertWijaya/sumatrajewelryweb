<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Lokasi cabang: Asia / Sun Plaza
            $table->string('branch_location')
                  ->default('Asia')
                  ->after('description');

            // Warna emas: Kuning / Putih / Rose Gold
            $table->string('gold_color')
                  ->nullable()
                  ->after('branch_location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['branch_location', 'gold_color']);
        });
    }
};
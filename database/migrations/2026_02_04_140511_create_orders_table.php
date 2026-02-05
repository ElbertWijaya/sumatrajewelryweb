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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->decimal('total_price', 15, 2);
            $table->enum('payment_method', ['transfer', 'cash'])->default('transfer');
            $table->enum('payment_status', ['unpaid', 'paid', 'verified', 'failed'])->default('unpaid');
            $table->enum('order_status', ['pending', 'processing', 'production', 'ready_to_ship', 'completed', 'cancelled'])->default('pending');
            $table->string('payment_proof')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

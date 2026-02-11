<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Jika kolom email_verified_at belum ada (Laravel biasanya sudah punya),
            // jangan tambah di sini — periksa schema DB Anda dulu.
            $table->string('provider')->nullable()->after('password');
            $table->string('provider_id')->nullable()->after('provider')->index();
            $table->string('phone_number')->nullable()->after('provider_id')->unique()->index();
            $table->timestamp('phone_verified_at')->nullable()->after('phone_number');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'phone_verified_at')) {
                $table->dropColumn('phone_verified_at');
            }
            if (Schema::hasColumn('users', 'phone_number')) {
                $table->dropUnique(['phone_number']);
                $table->dropIndex(['phone_number']);
                $table->dropColumn('phone_number');
            }
            if (Schema::hasColumn('users', 'provider_id')) {
                $table->dropIndex(['provider_id']);
                $table->dropColumn('provider_id');
            }
            if (Schema::hasColumn('users', 'provider')) {
                $table->dropColumn('provider');
            }
        });
    }
};
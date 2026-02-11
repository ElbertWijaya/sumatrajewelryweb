<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom phone_verified_at jika belum ada
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'phone_verified_at')) {
                $table->timestamp('phone_verified_at')->nullable()->after('phone_number');
            }
        });

        // Pastikan index provider_id ada (cek dulu)
        if (! $this->indexExists('users', 'users_provider_id_index')) {
            DB::statement('ALTER TABLE `users` ADD INDEX `users_provider_id_index` (`provider_id`)');
        }

        // Coba buat unique index untuk phone_number hanya jika aman (tidak ada duplikat)
        if (! $this->indexExists('users', 'users_phone_number_unique')) {
            $dupes = DB::select("
                SELECT phone_number, COUNT(*) AS cnt
                FROM users
                WHERE phone_number IS NOT NULL AND phone_number != ''
                GROUP BY phone_number
                HAVING cnt > 1
            ");
            if (empty($dupes)) {
                DB::statement('ALTER TABLE `users` ADD UNIQUE `users_phone_number_unique` (`phone_number`)');
            } else {
                info('Terdeteksi duplikat phone_number; unique index users_phone_number_unique tidak dibuat. Bersihkan data jika ingin menambahkan constraint.');
            }
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'phone_verified_at')) {
                $table->dropColumn('phone_verified_at');
            }
        });

        if ($this->indexExists('users', 'users_provider_id_index')) {
            DB::statement('ALTER TABLE `users` DROP INDEX `users_provider_id_index`');
        }

        if ($this->indexExists('users', 'users_phone_number_unique')) {
            DB::statement('ALTER TABLE `users` DROP INDEX `users_phone_number_unique`');
        }
    }

    /**
     * Periksa eksistensi index menggunakan INFORMATION_SCHEMA (portable & bindable).
     */
    private function indexExists(string $table, string $indexName): bool
    {
        // Ambil nama database saat ini
        $database = DB::getDatabaseName();

        $result = DB::select(
            'SELECT INDEX_NAME FROM INFORMATION_SCHEMA.STATISTICS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND INDEX_NAME = ? LIMIT 1',
            [$database, $table, $indexName]
        );

        return ! empty($result);
    }
};
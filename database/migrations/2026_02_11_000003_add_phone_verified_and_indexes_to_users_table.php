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

        // Pastikan ada index untuk provider_id (jika belum ada, buat)
        if (! $this->indexExists('users', 'users_provider_id_index')) {
            DB::statement('ALTER TABLE `users` ADD INDEX `users_provider_id_index` (`provider_id`)');
        }

        // Periksa dan buat unique index untuk phone_number jika aman (tidak ada duplikat)
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
                // Log agar admin tahu; tidak menggagalkan migration
                info('Terdeteksi duplikat phone_number; unique index tidak dibuat. Periksa data duplikat dan bersihkan jika ingin menambahkan constraint.');
            }
        }
    }

    public function down(): void
    {
        // Hati-hati saat rollback; hanya hapus kolom/index kalau ada
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

    // Utility: cek index ada (MySQL)
    private function indexExists(string $table, string $indexName): bool
    {
        $db = DB::getPdo();
        $stmt = $db->prepare("SHOW INDEX FROM `{$table}` WHERE Key_name = :idx LIMIT 1");
        $stmt->execute(['idx' => $indexName]);
        return (bool) $stmt->fetch();
    }
};
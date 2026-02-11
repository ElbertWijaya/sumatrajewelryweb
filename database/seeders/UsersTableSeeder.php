<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus dulu jika ingin idempotent di environment test (opsional)
        // DB::table('users')->truncate();

        // Admin
        DB::table('users')->insert([
            'name' => 'Admin Toko',
            'email' => 'admin@example.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'), // ubah jika mau lebih aman
            'role' => 'admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Customer (email/password)
        DB::table('users')->insert([
            'name' => 'Customer Test',
            'email' => 'customer@example.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
            'role' => 'customer',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Phone-registered user (example, phone already verified for testing)
        DB::table('users')->insert([
            'name' => 'Phone User',
            'email' => 'phoneuser+test@example.com', // placeholder email
            'email_verified_at' => null, // not verified email yet
            'password' => Hash::make(Str::random(16)),
            'phone_number' => '+6281234567890',
            'phone_verified_at' => Carbon::now(),
            'role' => 'customer',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
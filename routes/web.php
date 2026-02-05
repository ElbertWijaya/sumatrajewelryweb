<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

// Halaman Depan (Homepage)
Route::get('/', [HomeController::class, 'index'])->name('home');

use App\Http\Controllers\AdminController;

// Rute untuk membuka Dashboard Admin
Route::get('/admin/dashboard', [AdminController::class, 'index']);

// Rute untuk memproses update harga (Method POST)
Route::post('/admin/gold-price/update', [AdminController::class, 'updatePrice']);

// Rute untuk menyimpan produk baru
Route::post('/admin/product/store', [AdminController::class, 'storeProduct']);

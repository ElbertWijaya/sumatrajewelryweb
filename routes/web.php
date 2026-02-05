<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

// Halaman Depan (Homepage)
Route::get('/', [HomeController::class, 'index'])->name('home');

use App\Http\Controllers\AdminController;

// Rute untuk membuka Dashboard Admin
Route::get('/admin/dashboard', [AdminController::class, 'index']);

// Admin Order Management
Route::get('/admin/order/{id}', [AdminController::class, 'showOrder'])->name('admin.order.show');
Route::post('/admin/order/{id}/confirm', [AdminController::class, 'confirmPayment'])->name('admin.order.confirm');

// Rute untuk memproses update harga (Method POST)
Route::post('/admin/gold-price/update', [AdminController::class, 'updatePrice']);

// Rute untuk menyimpan produk baru
Route::post('/admin/product/store', [AdminController::class, 'storeProduct']);

// Halaman Detail Produk
Route::get('/product/{id}', [HomeController::class, 'show'])->name('product.detail');

use App\Http\Controllers\OrderController;

// 1. Halaman Form Checkout (Beli Barang Ini)
Route::get('/checkout/{id}', [OrderController::class, 'showCheckout'])->name('checkout.show');

// 2. Proses Checkout (Tombol Submit)
Route::post('/checkout/process', [OrderController::class, 'processOrder'])->name('checkout.process');

// 3. Halaman Sukses / Instruksi Bayar
Route::get('/order/success/{id}', [OrderController::class, 'success'])->name('order.success');


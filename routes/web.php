<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LoginController; // <--- PENTING: Tambahkan ini

// --- HALAMAN DEPAN ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{id}', [HomeController::class, 'show'])->name('product.detail');

// --- SISTEM AUTENTIKASI (LOGIN & LOGOUT) ---
// 1. Halaman Portal Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// 2. Proses Login
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
// 3. Proses Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// --- GROUP CUSTOMER (Harus Login) ---
Route::middleware(['auth'])->group(function () {
    // Dashboard Customer
    Route::get('/my-dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');
});


// --- AREA ADMIN ---
Route::get('/admin/dashboard', [AdminController::class, 'index']);

// Admin Order Management
Route::get('/admin/order/{id}', [AdminController::class, 'showOrder'])->name('admin.order.show');
Route::post('/admin/order/{id}/confirm', [AdminController::class, 'confirmPayment'])->name('admin.order.confirm');

// Admin Produk & Harga
Route::post('/admin/gold-price/update', [AdminController::class, 'updatePrice']);
Route::post('/admin/product/store', [AdminController::class, 'storeProduct']);


// --- AREA TRANSAKSI / CHECKOUT ---
// 1. Halaman Form Checkout
Route::get('/checkout/{id}', [OrderController::class, 'showCheckout'])->name('checkout.show');
// 2. Proses Checkout
Route::post('/checkout/process', [OrderController::class, 'processOrder'])->name('checkout.process');
// 3. Halaman Sukses
Route::get('/order/success/{id}', [OrderController::class, 'success'])->name('order.success');
// 4. Upload Bukti Bayar
Route::post('/order/upload/{id}', [OrderController::class, 'uploadProof'])->name('payment.upload');
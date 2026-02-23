<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LoginController; // <--- PENTING: Tambahkan ini
use App\Http\Controllers\Auth\PasswordResetController;

// --- HALAMAN DEPAN ---
Route::get('/', [HomeController::class, 'index'])->name('home');
// Halaman statis informasi toko
Route::view('/tentang-toko', 'pages.about')->name('about.store');
// Halaman statis lokasi & kontak
Route::view('/lokasi-kontak', 'pages.locations')->name('store.locations');
// Halaman detail produk
Route::get('/product/{id}', [HomeController::class, 'show'])->name('product.detail');

// --- HALAMAN UTAMA PRODUK ---
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');

// --- SISTEM AUTENTIKASI (LOGIN & LOGOUT) ---
// 1. Halaman Portal Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// 2. Proses Login
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
// 3. Proses Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register routes
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register.show');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.post');

// Forgot / reset password
Route::get('/password/forgot', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.update');
// Email verification routes (using built-in controllers)
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
Route::get('/email/verify', function () {
    return view('auth.verify_notice');
})->middleware('auth')->name('verification.notice');
// Handle verification (signed URL)
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/my-dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');
// Resend verification
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');
// Protect checkout: require auth and verified
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/checkout/{id}', [App\Http\Controllers\OrderController::class, 'showCheckout'])->name('checkout.show');
    Route::post('/checkout/process', [App\Http\Controllers\OrderController::class, 'processOrder'])->name('checkout.process');
});

// Social login (Google, Facebook) — stub routes
Route::get('auth/{provider}', [App\Http\Controllers\Auth\SocialController::class, 'redirect'])->name('social.redirect');
Route::get('auth/{provider}/callback', [App\Http\Controllers\Auth\SocialController::class, 'callback'])->name('social.callback');

// Phone registration (stub) — endpoint yang dipanggil dari modal login
Route::post('register/phone/send-otp', [App\Http\Controllers\Auth\PhoneRegisterController::class, 'sendOtp'])
    ->name('register.phone.sendOtp');

Route::get('register/phone/verify', [App\Http\Controllers\Auth\PhoneRegisterController::class, 'showVerifyForm'])
    ->name('register.phone.verifyForm');
Route::post('register/phone/verify', [App\Http\Controllers\Auth\PhoneRegisterController::class, 'verifyAndRegister'])
    ->name('register.phone.verify');

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
Route::post('/admin/order/{id}/resi', [AdminController::class, 'inputResi'])->name('admin.order.resi');

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
Route::post('/orders/{id}/upload-proof', [OrderController::class, 'uploadProof'])->name('payment.upload');
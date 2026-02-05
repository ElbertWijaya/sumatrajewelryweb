<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class CustomerController extends Controller
{
    // Halaman Utama Dashboard Customer
    public function index()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Ambil pesanan milik user ini saja (diurutkan dari terbaru)
        $myOrders = Order::where('user_id', $user->id)
                         ->with('items.product') // Ambil data produknya juga
                         ->latest()
                         ->get();

        return view('customer.dashboard', compact('myOrders'));
    }
}
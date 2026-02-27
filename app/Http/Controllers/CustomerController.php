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

    // Halaman "Pesanan Saya" dengan daftar dan filter status
    public function orders(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();

        $statusFilter = $request->query('status', 'all');
        $searchQuery  = trim($request->query('q', ''));

        $allOrders = Order::where('user_id', $user->id)
            ->with('items.product')
            ->latest()
            ->get();

        $totalOrders   = $allOrders->count();
        $unpaidCount   = $allOrders->where('payment_status', 'unpaid')->count();
        $processingCount = $allOrders->whereIn('order_status', ['pending', 'processing', 'production'])->count();
        $shippingCount = $allOrders->where('order_status', 'ready_to_ship')->count();
        $completedCount = $allOrders->where('order_status', 'completed')->count();
        $cancelledCount = $allOrders->where('order_status', 'cancelled')->count();

        $orders = $allOrders->filter(function ($order) use ($statusFilter) {
            switch ($statusFilter) {
                case 'unpaid':
                    return $order->payment_status === 'unpaid';
                case 'processing':
                    return in_array($order->order_status, ['pending', 'processing', 'production']);
                case 'shipping':
                    return $order->order_status === 'ready_to_ship';
                case 'completed':
                    return $order->order_status === 'completed';
                case 'cancelled':
                    return $order->order_status === 'cancelled';
                case 'all':
                default:
                    return true;
            }
        });

        // Filter tambahan berdasarkan pencarian (invoice, nama produk, atau metode pembayaran)
        if ($searchQuery !== '') {
            $queryLower = mb_strtolower($searchQuery);

            $orders = $orders->filter(function ($order) use ($queryLower) {
                $invoiceNumber = (string) ($order->invoice_number ?? '');

                $firstItem    = $order->items->first();
                $productName  = $firstItem && $firstItem->product ? (string) $firstItem->product->name : '';

                $paymentMethod = (string) ($order->payment_method ?? '');

                return mb_stripos($invoiceNumber, $queryLower) !== false
                    || mb_stripos($productName, $queryLower) !== false
                    || mb_stripos($paymentMethod, $queryLower) !== false;
            });
        }


        $counts = [
            'all'        => $totalOrders,
            'unpaid'     => $unpaidCount,
            'processing' => $processingCount,
            'shipping'   => $shippingCount,
            'completed'  => $completedCount,
            'cancelled'  => $cancelledCount,
        ];

        return view('customer.orders', [
            'orders'        => $orders,
            'statusFilter'  => $statusFilter,
            'counts'        => $counts,
            'totalOrders'   => $totalOrders,
            'searchQuery'   => $searchQuery,
        ]);
    }

    // Halaman placeholder untuk Favorit / Wishlist
    public function favorites()
    {
        $user = Auth::user();

        return view('customer.favorites', [
            'user' => $user,
        ]);
    }
}
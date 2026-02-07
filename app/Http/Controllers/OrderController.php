<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\GoldPrice;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // 1. Tampilkan Halaman Form Checkout
    public function showCheckout($id)
    {
        $product = Product::findOrFail($id);
        
        // Cek stok dulu, kalau sudah laku jangan boleh dibeli
        if ($product->stock_status !== 'ready') {
            return redirect()->back()->with('error', 'Maaf, produk ini baru saja terjual!');
        }

        // Ambil harga emas untuk kalkulasi final
        $goldPrice24k = GoldPrice::where('karat_type', '24K')->first();
        
        return view('checkout', compact('product', 'goldPrice24k'));
    }

    // 2. Proses Simpan Pesanan (Jantung Sistem)
    public function processOrder(Request $request)
    {
        // Validasi Input
        $request->validate([
            'name'         => 'required',
            'email'        => 'required|email',
            'phone_number' => 'required',
            'address'      => 'required',
            'product_id'   => 'required'
        ]);

        // A. Cek / Buat User Baru (Auto-Register)
        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'name'         => $request->name,
                'phone_number' => $request->phone_number,
                'address'      => $request->address,
                'password'     => Hash::make('12345678'),
                'role'         => 'customer'
            ]
        );

        // B. Hitung Harga Final (Backend Validation)
        $product      = Product::findOrFail($request->product_id);
        $goldPrice24k = GoldPrice::where('karat_type', '24K')->first();

        $hargaDasar = ($product->karat_type == '24K')
            ? $goldPrice24k->sell_price_per_gram
            : ($goldPrice24k->sell_price_per_gram * 0.8);

        $totalHarga = ($product->weight * $hargaDasar)
            + $product->labor_cost
            + $product->stone_price;

        // C. Buat Nomor Invoice Unik (INV-TANGGAL-RANDOM)
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        // D. Simpan ke Tabel Orders
        $order = Order::create([
            'invoice_number' => $invoiceNumber,
            'user_id'        => $user->id,
            'total_price'    => $totalHarga,
            'payment_status' => 'unpaid', // Belum bayar
            'order_status'   => 'pending',  // Menunggu transfer
            'payment_method' => $request->payment_method
        ]);

        // E. Simpan Detail Barang (Order Items)
        OrderItem::create([
            'order_id'        => $order->id,
            'product_id'      => $product->id,
            'price_at_moment' => $totalHarga,
        ]);

        // F. Update Stok Produk jadi BOOKED
        $product->update(['stock_status' => 'booked']);

        // G. Login user (jika belum login)
        if (!Auth::check()) {
            Auth::login($user);
        }

        // H. Arahkan ke Halaman Pembayaran / Success
        return redirect()->route('order.success', $order->id);
    }

    // 3. Tampilkan Halaman Sukses & Instruksi Transfer
    public function success($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('order_success', compact('order'));
    }

    // 4. Upload / Foto Ulang Bukti Pembayaran
    public function uploadProof(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Hanya izinkan upload jika masih UNPAID
        if ($order->payment_status !== 'unpaid') {
            return redirect()
                ->route('order.success', $order->id)
                ->with('success', 'Pembayaran Anda sudah diproses. Tidak perlu mengirim bukti lagi.');
        }

        // Validasi Foto
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:10240', // Maksimal 10MB
        ]);

        // Hapus bukti lama jika ada (opsional)
        if ($order->payment_proof && file_exists(public_path('uploads/proofs/' . $order->payment_proof))) {
            @unlink(public_path('uploads/proofs/' . $order->payment_proof));
        }

        // Proses Upload File
        if ($request->hasFile('payment_proof')) {
            $image     = $request->file('payment_proof');
            $imageName = 'proof_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/proofs'), $imageName);

            // Simpan nama file ke database
            $order->update([
                'payment_proof' => $imageName,
                // Status tetap 'pending', admin yang mengubah ke 'paid'
            ]);
        }

        return redirect()
            ->route('order.success', $order->id)
            ->with('success', 'Anda sudah mengirim bukti pembayaran. Silakan tunggu pesanan diproses oleh toko.');
    }
}
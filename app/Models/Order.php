<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // KITA IZINKAN KOLOM INI DIISI OTOMATIS
    protected $fillable = [
        'invoice_number',
        'user_id',
        'total_price',
        'payment_status',
        'order_status',
        'payment_proof'
    ];

    // Relasi ke User (Pemilik Pesanan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Item Barang (Isi Keranjang)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
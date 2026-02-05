<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // --- TAMBAHKAN BARIS INI ---
    // Memberitahu Laravel: "Tabel ini tidak punya kolom created_at & updated_at, jangan diisi!"
    public $timestamps = false; 

    protected $fillable = [
        'order_id',
        'product_id',
        'price_at_moment'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    // Izin kolom mana saja yang boleh diisi
    protected $fillable = [
        'sku',
        'name',
        'category_id',
        'weight',
        'karat_type',
        'stone_price',
        'labor_cost',
        'stock_status',
        'image_url',
        'description',
        'branch_location',
        'gold_color',        
        'collection'         
    ];

    // Relasi: Produk ini milik kategori apa?
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
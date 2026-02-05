<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldPrice extends Model
{
    use HasFactory;
    protected $fillable = ['karat_type', 'sell_price_per_gram', 'buyback_price_per_gram', 'updated_by'];
}
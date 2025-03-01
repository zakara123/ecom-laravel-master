<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsale extends Model
{
    use HasFactory;
    protected $fillable = [
        'session_id',
        'product_id',
        'product_variation_id',
        'product_name',
        'product_price',
        'product_price_converted',
        'product_unit',
        'user_id',
        'variation',
        'tax_sale',
        'tax_items',
        'quantity',
        'discount',
        'sales_type'
    ];
}

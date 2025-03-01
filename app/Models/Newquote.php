<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newquote extends Model
{
    use HasFactory;
    protected $fillable = [
        'session_id',
        'product_id',
        'product_variation_id',
        'product_name',
        'product_price',
        'order_price_bying',
        'product_price_converted',
        'order_price_buying_converted',
        'product_unit',
        'user_id',
        'variation',
        'tax_quote',
        'tax_items',
        'quantity',
        'discount',
        'quotes_type'
    ];
}

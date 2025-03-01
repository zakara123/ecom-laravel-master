<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotesProducts extends Model
{
    use HasFactory;
    protected $table = "quote_products";
    protected $fillable = [
        'quotes_id',
        'product_id',
        'product_variations_id',
        'order_price',
        'order_price_bying',
        'order_price_converted',
        'order_price_buying_converted',
        'quantity',
        'product_name',
        'tax_quote',
        'stock_id',
        'discount',
        'product_unit',
        'quotes_type',
        'have_stock_api'
    ];
}

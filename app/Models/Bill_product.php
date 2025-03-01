<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill_product extends Model
{
    use HasFactory;
    protected $fillable = [
        'bill_id',
        'product_id',
        'product_variations_id',
        'order_price',
        'quantity',
        'product_name',
        'product_unit',
        'tax_sale',
        'stock_id',
        'discount',
        'bills_type'
    ];
}

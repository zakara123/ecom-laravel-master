<?php

namespace App\Models;

use App\Models\Sales;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales_products extends Model
{
    use HasFactory;
    protected $fillable = [
        'sales_id',
        'product_id',
        'product_variations_id',
        'order_price',
        'order_price_converted',
        'quantity',
        'product_name',
        'tax_sale',
        'stock_id',
        'discount',
        'product_unit',
        'sales_type',
        'have_stock_api'
    ];
    public function products() 
    {
        return $this->hasOne(Products::Class);
    }
    public function sales()
    {
        return $this->belongsTo(Sales::class);
    }
}

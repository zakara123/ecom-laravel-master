<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSKU extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'products_id',
        'product_variation_id',
        'barcode',
        'sku',
        'material',
        'group',
        'type',
        'stock_warehouse',
        'colour'
    ];
}

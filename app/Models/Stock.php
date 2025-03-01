<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'products_id',
        'store_id',
        'product_variation_id',
        'quantity_stock',
        'is_primary',
        'barcode_value',
        'sku',
        'date_received'
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'products_id', 'id');
    }

    public function productVariationId()
    {
        return $this->hasMany(ProductVariation::class, 'id', 'product_variation_id');
    }
}

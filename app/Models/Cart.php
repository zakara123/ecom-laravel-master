<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'product_id',
        'product_variation_id',
        'product_name',
        'product_price',
        'user_id',
        'variation',
        'tax_sale',
        'tax_items',
        'quantity',
        'have_stock_api'
    ];
    protected $appends = ['product_image'];

    public function getProductImageAttribute(){
        return Product_image::where('products_id', $this->product_id)->first();
    }

    public function productImage()
    {
        return $this->belongsTo(Product_image::class, 'product_id', 'products_id');
    }

    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }
}

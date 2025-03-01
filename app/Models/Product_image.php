<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_image extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = ['products_id', 'src', 'name_product', 'active_thumbnail'];

    public function product_aactive_thumbnail_first()
    {
        return $this->images()->first();
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'product_id', 'products_id');
    }
}

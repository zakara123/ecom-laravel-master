<?php

namespace App\Models;

use App\Models\Rentals;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rentals_products extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sales_id',
        'product_id',
        'order_price',
        'quantity',
        'product_name',
        'frequency'
    ];
    
    public function products() 
    {
        return $this->hasOne(Products::class);
    }
    public function rentals()
    {
        return $this->belongsTo(Rentals::class);
    }
}

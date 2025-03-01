<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Category extends Model
{
    use Searchable;
    use HasFactory;

    protected $fillable = ['category','slug'];

    public function products()
    {
        return $this->belongsToMany(Products::class, 'category_products', 'id_category', 'id_product');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    use HasFactory;
    protected $fillable = [
        'attribute_id',
        'product_id',
        'attribute_name',
        'attribute_slug',
        'attribute_type',
        'attribute_value',
        'visibility',
        'position',
        'price',
        'specs',
    ];
}

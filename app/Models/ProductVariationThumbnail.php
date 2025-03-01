<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariationThumbnail extends Model
{
    use HasFactory;

    protected $table = 'product_variation_thumbnails';

    protected $guarded = [];
}

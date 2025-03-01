<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPosition extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'products_id',
        'position'
    ];
}

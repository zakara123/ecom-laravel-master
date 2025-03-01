<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSettings extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'value'
    ];
}

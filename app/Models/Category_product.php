<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Category_product extends Model
{
    use Searchable;
    use HasFactory;

    protected $fillable = ['id_category','id_product'];
}

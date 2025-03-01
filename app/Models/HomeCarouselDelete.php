<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeCarouselDelete extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'image',
        'description',
        'link',
        'active',
    ];

    // dd()
}

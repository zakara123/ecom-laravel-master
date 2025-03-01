<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageCollectionImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'image',
        'description',
        'link',
        'active',
        'width', // Add this line to store the width of the image
    ];
}

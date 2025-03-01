<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderMenuColor extends Model
{
    use HasFactory;
    protected $fillable = [
        'header_background',
        'header_menu_background',
        'header_background_hover',
        'header_color',
    ];
}

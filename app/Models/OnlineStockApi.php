<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineStockApi extends Model
{
    use HasFactory;
    protected $fillable = [
        'api_url',
        'username',
        'password'
    ];
}

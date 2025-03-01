<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesFile extends Model
{
    use HasFactory;
    protected $fillable = [
        'sales_id',
        'name',
        'type',
        'src',
        'date_generated',
        'date_send_by_mail'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock_history extends Model
{
    use HasFactory;
    protected $table = 'stock_history';
    protected $fillable = [
        'stock_id',
        'type_history',
        'quantity',
        'quantity_previous',
        'quantity_current',
        'sales_id',
        'stock_description',
        'stock_date'
    ];
}

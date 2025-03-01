<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LedgerOlderSales extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_sale_import',
        'id_sale_new',

    ];
}

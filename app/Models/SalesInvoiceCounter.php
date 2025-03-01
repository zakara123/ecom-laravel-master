<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesInvoiceCounter extends Model
{
    use HasFactory;
    protected $fillable = [
        'sales_id',
        'creditnote_id',
        'debitnote_id',
        'is_sales',
        'is_creditnote',
        'is_debitnote'
    ];
}

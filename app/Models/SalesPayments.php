<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesPayments extends Model
{
    use HasFactory;
    protected $fillable = [
        'sales_id',
        'payment_date',
        'payment_mode',
        'payment_reference',
        'matched_transaction',
        'id_creditnote',
        'id_debitnote',
        'is_pettycash',
        'amount',
        'due_amount',
        'created_at'
    ];
}

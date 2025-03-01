<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bills_payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'payment_date',
        'payment_mode',
        'payment_reference',
        'amount',
        'matched_transaction',
        'is_pettycash',
        'id_debitnote'
    ];
}

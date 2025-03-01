<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banking extends Model
{
    use HasFactory;
    protected $fillable = [
        'debit',
        'credit',
        'amount',
        'date',
        'reference',
        'description',
        'matching_status',
        'petty_cash_matched',
        'is_manual',
    ];
}

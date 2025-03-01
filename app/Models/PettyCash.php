<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCash extends Model
{
    use HasFactory;
    protected $fillable = [
        'debit',
        'credit',
        'amount',
        'date',
        'description',
        'matching_status',
        'is_account_payable',
        'ledger_account',
        'banking_matched',
    ];
}

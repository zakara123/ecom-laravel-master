<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_order',
        'debit',
        'credit',
        'amount',
        'date',
        'description',
        'name',
        'bills',
        'banking',
        'journal_id',
        'credit_card',
        'is_pettycash',
    ];
}

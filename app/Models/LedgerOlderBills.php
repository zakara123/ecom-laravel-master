<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LedgerOlderBills extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_bill_import',
        'id_bill_new',
    ];
}

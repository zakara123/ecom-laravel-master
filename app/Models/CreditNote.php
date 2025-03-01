<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditNote extends Model
{
    use HasFactory;
    protected $fillable = [
        'sales_id',
        'date',
        'amount',
        'reason',
        'responseId',
        'requestId',
        'status',
        'jsonRequest',
        'invoiceIdentifier',
        'irn',
        'qrCode',
        'infoMessages',
        'errorMessages'
    ];
}

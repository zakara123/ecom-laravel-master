<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebitNote extends Model
{
    use HasFactory;
    protected $fillable = [
        'bill_id',
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

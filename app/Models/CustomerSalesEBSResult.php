<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSalesEBSResult extends Model
{
    use HasFactory;
    protected $fillable = [
        'responseId',
        'requestId',
        'status',
        'jsonRequest',
        'customer_id',
        'invoiceIdentifier',
        'irn',
        'qrCode',
        'infoMessages',
        'errorMessages'
    ];
}

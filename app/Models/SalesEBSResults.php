<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesEBSResults extends Model
{
    use HasFactory;
    protected $fillable = [
        'responseId',
        'requestId',
        'status',
        'jsonRequest',
        'sale_id',
        'invoiceIdentifier',
        'irn',
        'qrCode',
        'infoMessages',
        'errorMessages'
    ];
}

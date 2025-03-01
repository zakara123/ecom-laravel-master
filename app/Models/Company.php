<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_name',
        'company_address',
        'brn_number',
        'vat_number',
        'tan',
        'company_email',
        'order_email',
        'company_phone',
        'company_fax',
        'whatsapp_number',
        'logo',
    ];
}

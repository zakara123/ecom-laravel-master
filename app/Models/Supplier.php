<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'brn',
        'vat',
        'vat_supplier',
        'halal_certified',
        'order_email',
        'credit_limit',
        'name_person',
        'email_address',
        'mobile',
        'office_phone',
        'status',
        'payment_frequency',
        'ordering_frequency',
        'delivery_days',
        'central_kitchen',
        'bank_name',
        'account_name',
        'account_number'
    ];
}

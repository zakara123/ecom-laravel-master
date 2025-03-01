<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $fillable = [
            'delivery_date',
            'due_date',
            'amount',
            'subtotal',
            'tax_amount',
            'status',
            'bill_reference',
            'comment',
            'payment_methode',
            'date_paied',
            'user_id',
            'id_store',
            'store',
            'tax_items',
            'id_supplier',
            'supplier_name',
            'supplier_email',
            'supplier_phone',
            'supplier_address'
    ];
}

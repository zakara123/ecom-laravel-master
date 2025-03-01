<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotes extends Model
{
    use HasFactory;
    protected $fillable = [
        'delivery_date',
        'amount',
        'subtotal',
        'tax_amount',
        'currency',
        'amount_converted',
        'subtotal_converted',
        'tax_amount_converted',
        'currency_amount',
        'status',
        'order_reference',
        'customer_id',
        'customer_firstname',
        'customer_lastname',
        'customer_address',
        'customer_city',
        'customer_email',
        'customer_phone',
        'comment',
        'internal_note',
        'date_paied',
        'user_id',
        'id_store',
        'tax_items',
        'date_resent_mail_quote',
        'date_resent_mail_invoice',
        'pickup_or_delivery',
        'id_store_pickup',
        'store_pickup',
        'date_pickup',
        'id_delivery',
        'delivery_name',
        'delivery_fee',
        'delivery_fee_tax'
    ];
}

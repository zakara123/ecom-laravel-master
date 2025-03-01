<?php

namespace App\Models;

use App\Models\Rentals;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentBillableProducts extends Model
{
    protected $table = "appointment_billable_products";

    protected $fillable = [
        'appointment_billable_id',
        'product_id',
        'product_variations_id',
        'order_price', // Add order_price to fillable array
        'quantity',
        'product_name',
        'product_unit',
        'tax_sale',
        'frequency',
    ];

}

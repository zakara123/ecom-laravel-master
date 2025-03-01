<?php

namespace App\Models;

use App\Models\Rentals_products;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rentals extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $fillable = [
        'status', // Add this line
        'customer_id',
        'customer_firstname',
        'customer_lastname',
        'customer_email',
        'customer_phone',
        'rental_start_date',
        'rental_end_date',
        'duration',
        'tax_items',
        'amount',
        'subtotal',
        'tax_amount',
        'id_store',
        'village_town',
        'delivery_address',
        'invoice_number'
        
    ];
    public function rentals_products() {
        return $this->hasMany(Rentals_products::class);
    }
}

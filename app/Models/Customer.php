<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstname',
        'lastname',
        'company_name',
        'address1',
        'address2',
        'city',
        'country',
        'email',
        'phone',
        'fax',
        'brn_customer',
        'vat_customer',
        'note_customer',
        'temp_password',
        'type',
        'date_of_birth',
        'work_address',
        'work_village',
        'other_address',
        'other_village',
        'whatsapp',
        'mobile_no',
        'user_id',
        'nid',
        'upi',
        'blood_group',
        'sex',
    ];

    

}

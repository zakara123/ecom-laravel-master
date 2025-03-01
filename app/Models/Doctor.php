<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;


class Doctor extends Model
{
    use HasFactory;
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'nationality',
        'nid_passport_no',
        'sex',
        'phone',
        'mobile',
        'whatsapp',
        'email',
        'address_1',
        'address_2',
        'village_town',
        'languages',
        'specialities',
        'user_id',
        'type',
        'public_page_status',
        'description',
        'longitude',
        'latitude',
        'fee'
    ];


}

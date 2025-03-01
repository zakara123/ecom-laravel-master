<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use DB;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'login',
        'role',
        'supplier',
        'id_store',
        'store',
        'zone',
        'phone',
        'access_online_store_orders',
        'sms_received',
        'sms_validate',
        'restaurant_stats',
        'zone_stats',
        'device_token',
        'alarm_notification',
        'email_verified_at',
        'password',
        'account_status',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $appends = ["customer_id","doctor_id","customer_upi"];

    public function getCustomerIdAttribute() {

        $item = DB::table("customers")->where("user_id",$this->id)->first();
        if($item){
            return $item->id;
        }else{
            return '';
        }
    }

    public function getDoctorIdAttribute() {

        $item = DB::table("doctors")->where("user_id",$this->id)->first();
        if($item){
            return $item->id;
        }else{
            return '';
        }
    }

    public function getCustomerUpiAttribute() {

        $item = DB::table("customers")->where("user_id",$this->id)->first();
        if($item){
            return $item->upi;
        }else{
            return '';
        }
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

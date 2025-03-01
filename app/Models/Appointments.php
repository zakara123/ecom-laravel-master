<?php

namespace App\Models;

use App\Models\Rentals_products;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Appointments extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status', // Add this line
        'customer_id',
        'patient_firstname',
        'patient_lastname',
        'patient_email',
        'patient_phone',
        'type',
        'specialist_type',
        'patient_date_of_birth',
        'patient_mobile_no',
        'appointment_date',
        'appointment_time',
        'consultation_mode',
        'phone_call_no',
        'consultation_place',
        'consultation_place_address',
        'method_of_communication',
        'village_town',
        'id_store',
        'doctor_id',
        'doctor_comment',
        'doctor_date',
        'appointment_comment',
        'doctor_status',
        'invoice_number'

    ];

    protected $appends = ['doctor_name'];

    public function getDoctorNameAttribute() {

        $item = DB::table("doctors")->where("id",$this->doctor_id)->first();
        if($item){
            return $item->first_name.' '. $item->last_name;
        }else{
            return '';
        }
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function getAppointmentDateTimeAttribute(){
        return $this->appointment_date.'T'.$this->appointment_time;
    }
    public function getAppointmentDateTimeDisplayAttribute(){
        $datetime=$this->appointment_date.' '.$this->appointment_time;
        if(!empty($datetime)){
            return \Carbon\Carbon::parse($datetime)->format('d/m/Y g:i A');
        }
        return '';
    }
    public function getDisplayDoctorNameAttribute(){
        return $this->doctor->first_name.' '.$this->doctor->last_name;
    }

}

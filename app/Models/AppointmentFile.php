<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentFile extends Model
{
    use HasFactory;
    protected $fillable = [
        'appointment_id',
        'name',
        'type',
        'src',
        'date_generated'
    ];
    public function appointment(){
        return $this->belongsTo(Appointments::class);
    }

}

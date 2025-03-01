<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentLog extends Model
{
    use HasFactory;

    protected $table = 'appointment_logs';

    protected $guarded = [];

    public function appointment(){
        $this->hasOne(Appointments::class, 'id', 'appointment_id');
    }
}

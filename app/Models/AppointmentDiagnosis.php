<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentDiagnosis extends Model
{
    protected $guarded=[];
    protected $table = 'appointment_diagnosis';
    protected $casts = [
        'diagnosis' => 'array',
        'p_diagnosis' => 'array',
    ];
    use HasFactory;
}

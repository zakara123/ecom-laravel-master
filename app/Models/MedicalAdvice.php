<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalAdvice extends Model
{
    use HasFactory;
    protected $table="medical_advices";
    protected $guarded=[];
}

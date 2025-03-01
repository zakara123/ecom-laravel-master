<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillFiles extends Model
{
    use HasFactory;
    protected $fillable = [
        'bill_id',
        'name',
        'type',
        'src',
        'date_generated',
        'date_send_by_mail'
    ];
}

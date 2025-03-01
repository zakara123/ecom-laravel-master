<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalFiles extends Model
{
    use HasFactory;
    protected $fillable = [
        'journal_entry_id',
        'src',
        'type'
    ];
}

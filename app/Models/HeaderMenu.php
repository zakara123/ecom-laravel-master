<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderMenu extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'link',
        'position',
        'parent',
    ];

    /*public function saveQuietly()
    {
        return static::withoutEvents(function() {
            return $this->save();
        });
    }*/


}

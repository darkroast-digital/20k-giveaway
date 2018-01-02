<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temp extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'ip',
        'last_active'
    ];
}

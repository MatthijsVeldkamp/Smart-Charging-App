<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Socket extends Model
{
    protected $fillable = [
        'tasmota_id',
        'name',
        'status'
    ];
}
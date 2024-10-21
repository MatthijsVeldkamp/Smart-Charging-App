<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartMeter extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'ip_address', 'type'];

    public function socket()
    {
        return $this->belongsTo(Socket::class);
    }
}

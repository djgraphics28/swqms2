<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['device_id', 'message', 'type', 'category'];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}

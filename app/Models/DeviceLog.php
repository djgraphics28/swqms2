<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceLog extends Model
{
    protected $fillable = [
        'device_id',
        'temperature',
        'ph_value',
        'voltage',
        'turbidity',
        'conductivity'
    ];

    /**
     * Get the device that owns the DeviceLog
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class, 'device_id', 'id');
    }
}

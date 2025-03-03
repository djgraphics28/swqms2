<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Model
{
    protected $fillable = [
        'code',
        'location',
        'lat',
        'lng',
    ];

    /**
     * Get all of the logs for the Device
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs(): HasMany
    {
        return $this->hasMany(DeviceLog::class, 'device_id', 'id');
    }

    /**
     * Get the latest_log associated with the Device
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function latest_log(): HasOne
    {
        return $this->hasOne(DeviceLog::class, 'device_id', 'id')->latest();
    }
}

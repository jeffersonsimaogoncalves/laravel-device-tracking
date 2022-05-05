<?php

namespace IvanoMatteo\LaravelDeviceTracking\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DeviceUser extends Pivot
{
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
    public function user()
    {
        return $this->belongsTo(Device::getUserClass());
    }
}

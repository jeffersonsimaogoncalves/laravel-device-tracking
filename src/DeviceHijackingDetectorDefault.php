<?php

namespace IvanoMatteo\LaravelDeviceTracking;

use Illuminate\Database\Eloquent\Model;
use IvanoMatteo\LaravelDeviceTracking\Models\Device;

class DeviceHijackingDetectorDefault implements DeviceHijackingDetector
{
    public function detect(Device $device, ?Model $user): ?string
    {
        if ($device->exists && $device->isDirty('device_type')) {
            return 'device_type mismatch';
        }

        return null;
    }
}

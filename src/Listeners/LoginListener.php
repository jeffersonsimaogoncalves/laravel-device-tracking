<?php

namespace IvanoMatteo\LaravelDeviceTracking\Listeners;

use DeviceTracker;
use Illuminate\Support\Facades\Auth;

class LoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        if (Auth::guard('web')->check()) {
            DeviceTracker::detectFindAndUpdate();
        }
    }
}

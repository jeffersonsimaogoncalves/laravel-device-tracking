<?php

namespace IvanoMatteo\LaravelDeviceTracking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Device extends Model
{
    use SoftDeletes;
    protected static $class;


    protected $guarded = [];
    protected $casts = [
        'data' => 'array',
    ];

    public function touch($attribute = null)
    {
        $this->{static::UPDATED_AT} = now();
    }
    /**
     * @return string user class fqn
     */
    public static function getUserClass()
    {
        if (isset(static::$class)) {
            return static::$class;
        }

        $u = config('laravel-device-tracking.user_model');

        if (!$u) {
            if (class_exists("App\\Models\\User")) {
                $u = "App\\Models\\User";
            } else if (class_exists("App\\User")) {
                $u = "App\\User";
            }
        }

        if (!class_exists($u)) {
            throw new HttpException(500, "class $u not found");
        }

        if (!is_subclass_of($u, Model::class)) {
            throw new HttpException(500, "class $u is not  model");
        }

        static::$class = $u;

        return $u;
    }

    public function user()
    {
        return $this->belongsToMany(static::getUserClass(), 'device_user')
            ->using(DeviceUser::class)
            ->withPivot('verified_at')->withTimestamps();
    }


    public function pivot()
    {
        return $this->hasMany(DeviceUser::class);
    }


    public function currentUserStatus()
    {
        return $this->hasOne(DeviceUser::class)
            ->where('user_id', '=', optional(Auth::user())->id);
    }

    public function isUsedBy($user_id)
    {
        $count = $this->user()
            ->where('device_user.user_id',$user_id)->count();

        return $count > 0;
    }
}

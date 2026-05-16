<?php

namespace App\Models;

use Spatie\Activitylog\Models\Activity as SpatieActivity;
use Illuminate\Database\Eloquent\Builder;

class ActivityLog extends SpatieActivity
{
    protected static function booted()
    {
        static::creating(function (ActivityLog $activity) {
            $activity->ip = request()->ip();
            $activity->user_agent = request()->userAgent();
        });
    }

    public function scopeForUser(Builder $query, $user)
    {
        return $query->where('causer_id', $user->id)
            ->where('causer_type', get_class($user));
    }
}

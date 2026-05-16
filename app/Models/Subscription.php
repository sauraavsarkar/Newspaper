<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Subscription extends Model
{
    use HasFactory, LogsActivity;
    
    protected static function booted()
    {
        static::created(function ($subscription) {
            $admins = User::role('Admin')->get();
            \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\SystemAlertNotification('new_subscription', [
                'user_name' => $subscription->user ? $subscription->user->name : 'Unknown User',
                'plan' => $subscription->plan,
            ]));
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['plan', 'status', 'subscribed_at', 'expires_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected $fillable = [
        'user_id',
        'plan',
        'subscribed_at',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'subscribed_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && ($this->expires_at === null || $this->expires_at->isFuture());
    }
}

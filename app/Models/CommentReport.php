<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CommentReport extends Model
{
    use LogsActivity;

    protected static function booted()
    {
        static::created(function ($report) {
            $moderators = User::role(['Moderator', 'Admin'])->get();
            
            // Notify for specific report
            \Illuminate\Support\Facades\Notification::send($moderators, new \App\Notifications\SystemAlertNotification('abuse_report', [
                'comment_id' => $report->comment_id,
                'reporter_name' => $report->user ? $report->user->name : 'Guest',
                'reason' => $report->reason,
            ]));

            // Check if author has multiple reports
            $author = $report->comment ? $report->comment->user : null;
            if ($author) {
                $reportCount = self::whereHas('comment', function($q) use ($author) {
                    $q->where('user_id', $author->id);
                })->count();

                if ($reportCount >= 5) {
                    \Illuminate\Support\Facades\Notification::send($moderators, new \App\Notifications\SystemAlertNotification('user_reported', [
                        'user_name' => $author->name,
                        'report_count' => $reportCount
                    ]));
                }
            }
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['comment_id', 'reason'])
            ->useLogName('moderation')
            ->setDescriptionForEvent(fn(string $eventName) => "Reported a comment");
    }
    protected $fillable = [
        'comment_id',
        'user_id',
        'reason',
    ];

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

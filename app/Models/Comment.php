<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Comment extends Model
{
    use SoftDeletes, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['body', 'article_id', 'user_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected $fillable = [
        'article_id',
        'user_id',
        'parent_id',
        'body',
    ];

    protected static function booted()
    {
        static::created(function ($comment) {
            // Notify article author
            if ($comment->article && $comment->article->author && $comment->user_id !== $comment->article->user_id) {
                $comment->article->author->notify(new \App\Notifications\ArticleEngagementNotification(
                    'comment',
                    $comment->article,
                    $comment->user,
                    ['comment_id' => $comment->id]
                ));
            }

            // Notify parent comment author (Reply)
            if ($comment->parent && $comment->parent->user && $comment->user_id !== $comment->parent->user_id) {
                $comment->parent->user->notify(new \App\Notifications\ArticleEngagementNotification(
                    'reply',
                    $comment->article,
                    $comment->user,
                    ['comment_id' => $comment->id, 'parent_id' => $comment->parent_id]
                ));
                
                // Also notify reader via ReaderAlertNotification
                $comment->parent->user->notify(new \App\Notifications\ReaderAlertNotification(
                    'reply',
                    [
                        'comment_id' => $comment->id,
                        'article_title' => $comment->article->title,
                        'url' => route('article.show', $comment->article->slug)
                    ],
                    $comment->user
                ));
            }

            // Spam Check
            if ($comment->isSpam()) {
                $moderators = User::role(['Moderator', 'Admin'])->get();
                \Illuminate\Support\Facades\Notification::send($moderators, new \App\Notifications\SystemAlertNotification('spam_flag', [
                    'comment_id' => $comment->id,
                    'user_name' => $comment->user ? $comment->user->name : 'Guest',
                    'body' => \Illuminate\Support\Str::limit($comment->body, 50),
                ]));
            }
        });
    }

    public function isSpam(): bool
    {
        $spammy = ['win free', 'click here', 'buy now', 'cheap', 'viagra', 'casino'];
        foreach ($spammy as $word) {
            if (stripos($this->body, $word) !== false) return true;
        }
        return false;
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }

    public function reports()
    {
        return $this->hasMany(CommentReport::class);
    }
}

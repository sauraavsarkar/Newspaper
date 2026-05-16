<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Article;
use App\Models\Comment;

class Reaction extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['type', 'reactable_id', 'reactable_type'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
    protected $fillable = [
        'reactable_id',
        'reactable_type',
        'user_id',
        'fingerprint',
        'type',
    ];

    protected static function booted()
    {
        static::created(function ($reaction) {
            // Only notify if there's a registered user associated
            if (!$reaction->user_id) return;

            $reactable = $reaction->reactable;
            
            if ($reactable instanceof Article) {
                if ($reactable->author && $reaction->user_id !== $reactable->user_id) {
                    $reactable->author->notify(new \App\Notifications\ArticleEngagementNotification(
                        'reaction',
                        $reactable,
                        $reaction->user,
                        ['reaction_type' => $reaction->type]
                    ));
                }
            } elseif ($reactable instanceof Comment) {
                if ($reactable->user && $reaction->user_id !== $reactable->user_id) {
                    $reactable->user->notify(new \App\Notifications\ReaderAlertNotification(
                        'reaction',
                        [
                            'comment_id' => $reactable->id,
                            'article_title' => $reactable->article ? $reactable->article->title : 'Article',
                            'reaction_type' => $reaction->type,
                            'url' => $reactable->article ? route('article.show', $reactable->article->slug) : '#'
                        ],
                        $reaction->user
                    ));
                }
            }
        });
    }

    public function reactable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ArticleReadingProgress extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['article_id', 'scroll_percentage'])
            ->logOnlyDirty()
            ->useLogName('reading')
            ->setDescriptionForEvent(fn(string $eventName) => $eventName === 'created' ? 'Started reading article' : 'Reading progress updated');
    }
    protected $table = 'article_reading_progress';

    protected $fillable = [
        'user_id',
        'article_id',
        'scroll_percentage',
        'last_read_at',
    ];

    protected $casts = [
        'last_read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}

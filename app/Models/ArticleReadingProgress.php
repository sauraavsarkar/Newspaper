<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleReadingProgress extends Model
{
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

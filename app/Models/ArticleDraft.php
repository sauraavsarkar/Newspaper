<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleDraft extends Model
{
    protected $fillable = [
        'article_id',
        'user_id',
        'title',
        'excerpt',
        'content',
        'featured_image',
        'seo_metadata',
    ];

    protected $casts = [
        'seo_metadata' => 'array',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

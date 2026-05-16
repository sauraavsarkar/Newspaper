<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleVersion extends Model
{
    protected $fillable = [
        'article_id',
        'version_number',
        'title',
        'excerpt',
        'content',
        'featured_image',
        'seo_metadata',
        'user_id',
        'trigger_type', // auto, manual, submitted, approved, rejected, published
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

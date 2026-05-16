<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Article extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'category_id', 'status', 'is_featured', 'is_breaking', 'published_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public ?string $versionTrigger = null;


    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'status',
        'is_featured',
        'is_breaking',
        'published_at',
        'editor_id',
        'resubmitted_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'resubmitted_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_breaking' => 'boolean',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function editorialRemarks(): HasMany
    {
        return $this->hasMany(EditorialRemark::class);
    }

    /**
     * Get all views for this article.
     */
    public function views(): HasMany
    {
        return $this->hasMany(ArticleView::class);
    }

    /**
     * Get users who saved this article.
     */
    public function savedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_saved_articles')
            ->withPivot('saved_at');
    }

    /**
     * Get all reactions for this article.
     */
    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }

    /**
     * Get all comments for this article.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the full URL for the featured image.
     */
    public function getFeaturedImageUrlAttribute(): string
    {
        return $this->featured_image 
            ? \Illuminate\Support\Facades\Storage::url($this->featured_image) 
            : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=2070&auto=format&fit=crop';
    }

    /**
     * Get all time views count.
     */
    public function getTotalViewsAttribute(): int
    {
        return $this->views()->count();
    }

    public function versions(): HasMany
    {
        return $this->hasMany(ArticleVersion::class);
    }

    public function drafts(): HasMany
    {
        return $this->hasMany(ArticleDraft::class);
    }

    /**
     * Scope a query to only include trending articles.
     */
    public function scopeTrending(Builder $query, int $days = 7, int $limit = 5): Builder
    {
        return $query->where('status', 'published')
            ->withCount(['views as trending_score' => function ($q) use ($days) {
                $q->where('viewed_at', '>=', now()->subDays($days));
            }])
            ->orderByDesc('trending_score')
            ->limit($limit);
    }
}

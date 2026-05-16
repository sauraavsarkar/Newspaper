<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
     * Record a view for this article (throttled by IP - 1 per hour).
     */
    public function recordView(?int $userId = null, ?string $ip = null, ?string $userAgent = null, ?string $referer = null): bool
    {
        // Throttle: only 1 view per IP per article per minute (reduced from hour for live feedback)
        $recentView = $this->views()
            ->where('ip_address', $ip)
            ->where('viewed_at', '>=', now()->subMinute())
            ->exists();

        if ($recentView) {
            return false;
        }

        $this->views()->create([
            'user_id' => $userId,
            'ip_address' => $ip,
            'user_agent' => $userAgent,
            'referer' => $referer,
            'viewed_at' => now(),
        ]);

        // Trending notification (e.g., at 10, 50, 100 views for testing, can be adjusted)
        $totalViews = $this->views()->count();
        if (in_array($totalViews, [10, 50, 100, 500, 1000])) {
            if ($this->author) {
                $this->author->notify(new \App\Notifications\ArticleEngagementNotification('trending', $this));
            }
        }

        return true;
    }

    /**
     * Scope: add view count as a subquery.
     */
    public function scopeWithViewCount($query)
    {
        return $query->withCount('views as view_count');
    }

    /**
     * Scope: trending articles based on view velocity.
     * $time can be integer (days) or a Carbon instance for more precision.
     */
    public function scopeTrending($query, $time = 7, int $limit = 10)
    {
        $since = is_numeric($time) ? now()->subDays($time) : $time;

        return $query->where('status', 'published')
            ->withCount(['views as trending_score' => function ($q) use ($since) {
                $q->where('viewed_at', '>=', $since);
            }])
            ->orderByDesc('trending_score')
            ->limit($limit);
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

    protected static function booted()
    {
        static::updated(function ($article) {
            // Notify category followers when published
            if ($article->wasChanged('status') && $article->status === 'published') {
                if ($article->category) {
                    $followers = $article->category->followers;
                    foreach ($followers as $user) {
                        // Skip author
                        if ($user->id === $article->user_id) continue;
                        
                        $user->notify(new \App\Notifications\ReaderAlertNotification('new_article', [
                            'article_id' => $article->id,
                            'article_title' => $article->title,
                            'category_name' => $article->category->name,
                            'url' => route('article.show', $article->slug)
                        ]));
                    }
                }
            }
        });

        static::deleting(function ($article) {
            // Cleanup physical image file
            if ($article->featured_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($article->featured_image);
            }
        });
    }
}

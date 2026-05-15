<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    use HasFactory;

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
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_breaking' => 'boolean',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
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
     * Scope: trending articles based on view velocity over the last N days.
     */
    public function scopeTrending($query, int $days = 7, int $limit = 10)
    {
        return $query->where('status', 'published')
            ->withCount(['views as trending_score' => function ($q) use ($days) {
                $q->where('viewed_at', '>=', now()->subDays($days));
            }])
            ->orderByDesc('trending_score')
            ->limit($limit);
    }

    /**
     * Get all time views count (legacy getter).
     */
    public function getViewsTotalAttribute(): int
    {
        return $this->views()->count();
    }
}

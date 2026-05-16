<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class TrendingService
{
    /**
     * Get trending articles based on view velocity within a specific time range.
     *
     * @param int|Carbon $time Days or Carbon instance
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTrendingArticles($time = 24, int $limit = 5)
    {
        $since = is_numeric($time) ? now()->subHours($time) : $time;

        return Article::where('status', 'published')
            ->withCount(['views as trending_score' => function ($query) use ($since) {
                $query->where('viewed_at', '>=', $since);
            }])
            ->orderByDesc('trending_score')
            ->limit($limit)
            ->get();
    }

    /**
     * Get top articles by total views (all time).
     */
    public function getTopArticles(int $limit = 10)
    {
        return Article::where('status', 'published')
            ->withCount('views as total_views')
            ->orderByDesc('total_views')
            ->limit($limit)
            ->get();
    }
}

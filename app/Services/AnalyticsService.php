<?php

namespace App\Services;

use App\Models\Article;
use App\Models\ArticleView;
use Illuminate\Support\Facades\Request;

class AnalyticsService
{
    /**
     * Record a view for an article with throttling logic.
     */
    public function recordArticleView(Article $article, ?int $userId = null): bool
    {
        $ip = Request::ip();
        $userAgent = Request::userAgent();
        $referer = Request::header('referer');

        // Throttle: only 1 view per IP per article per minute
        $recentView = ArticleView::where('article_id', $article->id)
            ->where('ip_address', $ip)
            ->where('viewed_at', '>=', now()->subMinute())
            ->exists();

        if ($recentView) {
            return false;
        }

        $article->views()->create([
            'user_id' => $userId,
            'ip_address' => $ip,
            'user_agent' => $userAgent,
            'referer' => $referer,
            'viewed_at' => now(),
        ]);

        // Check for engagement milestones (can move to a separate EngagementService or Event)
        $this->checkEngagementMilestones($article);

        return true;
    }

    /**
     * Check if article has reached engagement milestones to notify author.
     */
    protected function checkEngagementMilestones(Article $article): void
    {
        $totalViews = $article->views()->count();
        
        // Trending notification milestones
        if (in_array($totalViews, [10, 50, 100, 500, 1000])) {
            if ($article->author) {
                $article->author->notify(new \App\Notifications\ArticleEngagementNotification('trending', $article));
            }
        }
    }
}

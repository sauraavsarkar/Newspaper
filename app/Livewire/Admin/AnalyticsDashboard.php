<?php

namespace App\Livewire\Admin;

use App\Models\Article;
use App\Models\ArticleView;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Carbon\Carbon;

#[Layout('layouts.app')]
class AnalyticsDashboard extends Component
{
    public string $period = '7'; // days

    public function render()
    {
        $days = (int) $this->period;
        $startDate = now()->subDays($days);

        // === KPI Cards ===
        $totalViews = ArticleView::count();
        $periodViews = ArticleView::where('viewed_at', '>=', $startDate)->count();
        $previousPeriodViews = ArticleView::whereBetween('viewed_at', [
            now()->subDays($days * 2),
            $startDate
        ])->count();
        $viewsGrowth = $previousPeriodViews > 0
            ? round((($periodViews - $previousPeriodViews) / $previousPeriodViews) * 100, 1)
            : ($periodViews > 0 ? 100 : 0);

        $totalArticles = Article::count();
        $publishedArticles = Article::where('status', 'published')->count();
        $draftArticles = Article::where('status', 'draft')->count();
        $pendingArticles = Article::whereIn('status', ['submitted', 'in_review'])->count();

        $uniqueVisitors = ArticleView::where('viewed_at', '>=', $startDate)
            ->distinct('ip_address')
            ->count('ip_address');

        $avgViewsPerArticle = $publishedArticles > 0
            ? round($totalViews / $publishedArticles, 1)
            : 0;

        // === Views Over Time Chart Data ===
        $viewsOverTime = ArticleView::where('viewed_at', '>=', $startDate)
            ->select(DB::raw('DATE(viewed_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Fill missing dates with 0
        $chartLabels = [];
        $chartData = [];
        $viewsByDate = $viewsOverTime->pluck('count', 'date')->toArray();

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('M d');
            $chartData[] = $viewsByDate[$date] ?? 0;
        }

        // === Top Articles ===
        $topArticles = Article::where('status', 'published')
            ->with(['author', 'category'])
            ->withCount(['views as period_views' => function ($q) use ($startDate) {
                $q->where('viewed_at', '>=', $startDate);
            }])
            ->withCount('views as total_views')
            ->orderByDesc('period_views')
            ->orderByDesc('total_views')
            ->limit(10)
            ->get();

        // === Category Performance ===
        $categoryStats = Category::withCount(['articles as published_count' => function ($q) {
                $q->where('status', 'published');
            }])
            ->withCount(['articles as view_count' => function ($q) use ($startDate) {
                $q->join('article_views', 'articles.id', '=', 'article_views.article_id')
                  ->where('article_views.viewed_at', '>=', $startDate);
            }])
            ->orderByDesc('view_count')
            ->take(8)
            ->get();

        $categoryLabels = $categoryStats->pluck('name')->values()->toArray();
        $categoryData = $categoryStats->pluck('view_count')->values()->toArray();

        // === Top Authors ===
        $topAuthors = User::whereHas('articles', function ($q) {
                $q->where('status', 'published');
            })
            ->withCount(['articles as published_count' => function ($q) {
                $q->where('status', 'published');
            }])
            ->withCount(['articles as view_count' => function ($q) use ($startDate) {
                $q->join('article_views', 'articles.id', '=', 'article_views.article_id')
                  ->where('article_views.viewed_at', '>=', $startDate);
            }])
            ->orderByDesc('view_count')
            ->take(5)
            ->get();

        // === Hourly Distribution ===
        $hourlyViews = ArticleView::where('viewed_at', '>=', $startDate)
            ->select(DB::raw('HOUR(viewed_at) as hour'), DB::raw('COUNT(*) as count'))
            ->groupBy('hour')
            ->orderBy('hour')
            ->pluck('count', 'hour')
            ->toArray();

        $hourlyLabels = [];
        $hourlyData = [];
        for ($h = 0; $h < 24; $h++) {
            $hourlyLabels[] = sprintf('%02d:00', $h);
            $hourlyData[] = $hourlyViews[$h] ?? 0;
        }

        // === Device Breakdown ===
        $deviceRaw = ArticleView::where('viewed_at', '>=', $startDate)
            ->select(DB::raw("
                CASE 
                    WHEN user_agent LIKE '%tablet%' OR user_agent LIKE '%ipad%' OR user_agent LIKE '%playbook%' THEN 'Tablet'
                    WHEN user_agent LIKE '%mobile%' OR user_agent LIKE '%iphone%' OR user_agent LIKE '%android%' THEN 'Mobile'
                    ELSE 'Desktop'
                END as device_type,
                COUNT(*) as count
            "))
            ->groupBy('device_type')
            ->pluck('count', 'device_type')
            ->toArray();

        $deviceLabels = ['Mobile', 'Tablet', 'Desktop'];
        $deviceData = [
            $deviceRaw['Mobile'] ?? 0,
            $deviceRaw['Tablet'] ?? 0,
            $deviceRaw['Desktop'] ?? 0,
        ];

        // === Recent Views (live feed) ===
        $recentViews = ArticleView::with(['article.author', 'article.category', 'user'])
            ->latest('viewed_at')
            ->limit(15)
            ->get();

        return view('livewire.admin.analytics-dashboard', [
            'totalViews' => $totalViews,
            'periodViews' => $periodViews,
            'viewsGrowth' => $viewsGrowth,
            'totalArticles' => $totalArticles,
            'publishedArticles' => $publishedArticles,
            'draftArticles' => $draftArticles,
            'pendingArticles' => $pendingArticles,
            'uniqueVisitors' => $uniqueVisitors,
            'avgViewsPerArticle' => $avgViewsPerArticle,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'topArticles' => $topArticles,
            'categoryLabels' => $categoryLabels,
            'categoryData' => $categoryData,
            'categoryStats' => $categoryStats,
            'topAuthors' => $topAuthors,
            'hourlyLabels' => $hourlyLabels,
            'hourlyData' => $hourlyData,
            'deviceLabels' => $deviceLabels,
            'deviceData' => $deviceData,
            'recentViews' => $recentViews,
        ]);
    }
}

<?php

namespace App\Livewire\Reader;

use Livewire\Component;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.public')]
class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();
        
        // Greeting based on time of day
        $hour = now()->hour;
        $greeting = 'Good evening';
        if ($hour < 12) {
            $greeting = 'Good morning';
        } elseif ($hour < 17) {
            $greeting = 'Good afternoon';
        }

        // Breaking News
        $breakingNews = Article::where('is_breaking', true)
            ->where('status', 'published')
            ->latest('published_at')
            ->limit(5)
            ->get();

        // Morning Digest (Followed categories OR most viewed last 12 hours)
        $followedCategoryIds = $user->followedCategories()->pluck('categories.id');
        
        $morningDigest = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->when($followedCategoryIds->isNotEmpty(), function ($query) use ($followedCategoryIds) {
                return $query->whereIn('category_id', $followedCategoryIds);
            })
            ->where('published_at', '>=', now()->subHours(12))
            ->latest('published_at')
            ->limit(6)
            ->get();

        // If digest is empty, get most viewed in last 12 hours
        if ($morningDigest->isEmpty()) {
            $morningDigest = Article::with(['category', 'author'])
                ->where('status', 'published')
                ->where('published_at', '>=', now()->subHours(12))
                ->trending(now()->subHours(12), 6)
                ->get();
        }

        // Continue Reading
        $continueReading = $user->continueReadingArticles()
            ->with(['category', 'author'])
            ->limit(4)
            ->get();

        // Trending Right Now
        $trending = Article::where('status', 'published')
            ->trending(now()->subHours(24), 5)
            ->get();

        // Saved Articles
        $savedArticles = $user->savedArticles()
            ->with(['category', 'author'])
            ->latest('user_saved_articles.saved_at')
            ->limit(6)
            ->get();

        // Followed Categories (and some suggestions)
        $followedCategories = $user->followedCategories()->get();
        $suggestedCategories = Category::whereNotIn('id', $followedCategories->pluck('id'))
            ->withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->limit(5)
            ->get();

        return view('livewire.reader.dashboard', [
            'greeting' => $greeting,
            'breakingNews' => $breakingNews,
            'morningDigest' => $morningDigest,
            'continueReading' => $continueReading,
            'trending' => $trending,
            'savedArticles' => $savedArticles,
            'followedCategories' => $followedCategories,
            'suggestedCategories' => $suggestedCategories,
            'today' => now()->format('l, F j, Y'),
        ]);
    }
}

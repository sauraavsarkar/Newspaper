<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Article;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

#[Layout('layouts.public')]
class Home extends Component
{
    use WithPagination;
    #[Url]
    public $search = '';

    public function render()
    {
        // Fetch featured article for the Hero section
        $featuredArticle = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->where('is_featured', true)
            ->latest('published_at')
            ->first();

        // Fetch breaking news for the ticker
        $breakingNews = Article::where('status', 'published')
            ->where('is_breaking', true)
            ->latest('published_at')
            ->limit(5)
            ->get();

        // Fetch trending articles (most viewed in last 6 hours)
        $trendingArticles = Article::with('category')
            ->trendingSixHours(5)
            ->get();

        // Fetch latest articles based on search
        $latestArticles = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->when($this->search, function ($query) {
                return $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%');
                });
            })
            ->when(!$this->search && $featuredArticle, function ($query) use ($featuredArticle) {
                return $query->where('id', '!=', $featuredArticle->id);
            })
            ->latest('published_at')
            ->paginate(12);

        return view('livewire.public.home', [
            'featuredArticle' => $this->search ? null : $featuredArticle,
            'latestArticles' => $latestArticles,
            'trendingArticles' => $trendingArticles,
            'breakingNews' => $breakingNews,
        ]);
    }
}

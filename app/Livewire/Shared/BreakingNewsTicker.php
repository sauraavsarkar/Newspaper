<?php

namespace App\Livewire\Shared;

use App\Models\Article;
use Livewire\Component;

class BreakingNewsTicker extends Component
{
    public function render()
    {
        $breakingNews = Article::where('is_breaking', true)
            ->where('status', 'published')
            ->latest('published_at')
            ->limit(5)
            ->get();

        return view('livewire.shared.breaking-news-ticker', [
            'breakingNews' => $breakingNews
        ]);
    }
}

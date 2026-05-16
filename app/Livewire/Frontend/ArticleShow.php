<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Article;
use Livewire\Attributes\Layout;

#[Layout('layouts.public')]
class ArticleShow extends Component
{
    public $article;
    public int $viewCount = 0;

    public function mount($slug)
    {
        $this->article = Article::where('slug', $slug)
            ->where('status', 'published')
            ->with(['author', 'category', 'tags'])
            ->firstOrFail();

        // Record the view
        $this->article->recordView(
            userId: auth()->id(),
            ip: request()->ip(),
            userAgent: request()->userAgent(),
            referer: request()->header('referer')
        );

        $this->viewCount = $this->article->total_views;
    }

    public function updateReadingProgress($percentage)
    {
        if (auth()->check()) {
            \App\Models\ArticleReadingProgress::updateOrCreate(
                ['user_id' => auth()->id(), 'article_id' => $this->article->id],
                ['scroll_percentage' => max(0, min(100, $percentage))]
            );
        }
    }

    public function render()
    {
        return view('livewire.frontend.article-show')
            ->title($this->article->title);
    }
}

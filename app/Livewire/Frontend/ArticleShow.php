<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Article;
use Livewire\Attributes\Layout;

#[Layout('layouts.public')]
class ArticleShow extends Component
{
    public $article;

    public function mount($slug)
    {
        $this->article = Article::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.frontend.article-show')
            ->title($this->article->title);
    }
}

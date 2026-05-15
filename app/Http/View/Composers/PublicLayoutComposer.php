<?php

namespace App\Http\View\Composers;

use App\Models\Article;
use Illuminate\View\View;

class PublicLayoutComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $breakingNews = Article::where('status', 'published')
            ->where('is_breaking', true)
            ->latest('published_at')
            ->limit(5)
            ->get();

        $view->with('globalBreakingNews', $breakingNews);
    }
}

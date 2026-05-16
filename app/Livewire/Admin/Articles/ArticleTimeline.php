<?php

namespace App\Livewire\Admin\Articles;

use App\Models\Article;
use App\Models\ActivityLog;
use Livewire\Component;

class ArticleTimeline extends Component
{
    public Article $article;

    public function render()
    {
        $activities = ActivityLog::where('subject_id', $this->article->id)
            ->where('subject_type', Article::class)
            ->with(['causer'])
            ->latest()
            ->get();

        return view('livewire.admin.articles.article-timeline', [
            'activities' => $activities,
        ]);
    }
}

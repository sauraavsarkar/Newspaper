<?php

namespace App\Observers;

use App\Models\Article;
use App\Notifications\ReaderAlertNotification;
use Illuminate\Support\Facades\Storage;

class ArticleObserver
{
    /**
     * Handle the Article "updated" event.
     */
    public function updated(Article $article): void
    {
        // Fire Event when published
        if ($article->wasChanged('status') && $article->status === 'published') {
            event(new \App\Events\ArticlePublished($article));
        }
    }

    /**
     * Handle the Article "deleting" event.
     */
    public function deleting(Article $article): void
    {
        // Cleanup physical image file
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }
    }
}

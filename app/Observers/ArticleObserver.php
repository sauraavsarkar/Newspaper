<?php

namespace App\Observers;

use App\Models\Article;
use App\Notifications\ReaderAlertNotification;
use Illuminate\Support\Facades\Storage;

class ArticleObserver
{
    /**
     * Handle the Article "saved" event.
     */
    public function saved(Article $article): void
    {
        $triggerType = $article->versionTrigger;

        if (!$triggerType) {
            // Deduce trigger from status change if not explicitly provided
            if ($article->wasChanged('status')) {
                $triggerType = match($article->status) {
                    'submitted' => 'submitted',
                    'approved' => 'approved',
                    'rejected' => 'rejected',
                    'published' => 'published',
                    default => 'status_change',
                };
            }
        }

        if ($triggerType) {
            app(\App\Services\VersionService::class)->snapshot($article, $triggerType, auth()->id());
        }
    }

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

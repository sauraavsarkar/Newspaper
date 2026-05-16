<?php

namespace App\Listeners;

use App\Events\ArticlePublished;
use App\Notifications\ReaderAlertNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendArticleNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(ArticlePublished $event): void
    {
        $article = $event->article;

        if ($article->category) {
            $followers = $article->category->followers;
            foreach ($followers as $user) {
                // Skip author
                if ($user->id === $article->user_id) continue;
                
                $user->notify(new ReaderAlertNotification('new_article', [
                    'article_id' => $article->id,
                    'article_title' => $article->title,
                    'category_name' => $article->category->name,
                    'url' => route('article.show', $article->slug)
                ]));
            }
        }
    }
}

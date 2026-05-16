<?php

namespace App\Notifications;

use App\Models\Article;
use App\Models\ArticleVersion;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VersionRestoredNotification extends Notification
{
    use Queueable;

    public $article;
    public $version;
    public $restorer;

    /**
     * Create a new notification instance.
     */
    public function __construct(Article $article, ArticleVersion $version, User $restorer)
    {
        $this->article = $article;
        $this->version = $version;
        $this->restorer = $restorer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'version_restored',
            'message' => "{$this->restorer->name} restored Version {$this->version->version_number} of your article '{$this->article->title}'.",
            'article_id' => $this->article->id,
            'version_id' => $this->version->id,
            'restorer_id' => $this->restorer->id,
            'action_url' => route('articles.edit', $this->article->id) . '#versions',
        ];
    }
}

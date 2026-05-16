<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ArticleEngagementNotification extends Notification
{
    use Queueable;

    protected $type; // comment, reply, reaction, trending
    protected $article;
    protected $triggerUser;
    protected $extraData;

    /**
     * Create a new notification instance.
     */
    public function __construct($type, $article, $triggerUser = null, $extraData = [])
    {
        $this->type = $type;
        $this->article = $article;
        $this->triggerUser = $triggerUser;
        $this->extraData = $extraData;
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
        $messages = [
            'comment' => 'Someone commented on your article',
            'reply' => 'Someone replied to your comment',
            'reaction' => 'Someone reacted to your article',
            'trending' => 'Your article is trending 🔥',
        ];

        return [
            'type' => 'engagement',
            'engagement_type' => $this->type,
            'article_id' => $this->article->id,
            'article_title' => $this->article->title,
            'trigger_user_id' => $this->triggerUser ? $this->triggerUser->id : null,
            'trigger_user_name' => $this->triggerUser ? $this->triggerUser->name : 'Someone',
            'extra' => $this->extraData,
            'message' => $messages[$this->type] ?? 'New engagement on your article',
            'url' => route('article.show', $this->article->slug),
        ];
    }
}

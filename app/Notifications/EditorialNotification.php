<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EditorialNotification extends Notification
{
    use Queueable;

    protected $type;
    protected $article;
    protected $triggerUser;

    /**
     * Create a new notification instance.
     */
    public function __construct($type, $article = null, $triggerUser = null)
    {
        $this->type = $type; // submitted, resubmitted, assigned, breaking_toggled
        $this->article = $article;
        $this->triggerUser = $triggerUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];

        // Email editors for submissions and assignments
        if (in_array($this->type, ['submitted', 'assigned', 'resubmitted'])) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $messages = [
            'submitted' => 'A new article has been submitted for your review.',
            'resubmitted' => 'A journalist has revised and resubmitted an article.',
            'assigned' => 'You have been assigned a new article to review.',
        ];

        return (new MailMessage)
            ->subject('Editorial Alert: ' . ($this->article ? $this->article->title : 'New Task'))
            ->line($messages[$this->type] ?? 'New editorial event.')
            ->action('Open Editor', route('article.show', $this->article->slug))
            ->line('Thank you for your hard work!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $messages = [
            'submitted' => 'New article submitted for review',
            'resubmitted' => 'Journalist revised and resubmitted an article',
            'assigned' => 'Admin assigned you a new article',
            'breaking_toggled' => 'Breaking news was toggled by admin',
        ];

        return [
            'type' => 'editorial',
            'editorial_type' => $this->type,
            'article_id' => $this->article ? $this->article->id : null,
            'article_title' => $this->article ? $this->article->title : null,
            'trigger_user_id' => $this->triggerUser ? $this->triggerUser->id : null,
            'trigger_user_name' => $this->triggerUser ? $this->triggerUser->name : null,
            'message' => $messages[$this->type] ?? 'Editorial update',
            'url' => $this->article ? route('article.show', $this->article->slug) : '#',
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReaderAlertNotification extends Notification
{
    use Queueable;

    protected $type;
    protected $data;
    protected $triggerUser;

    /**
     * Create a new notification instance.
     */
    public function __construct($type, $data = [], $triggerUser = null)
    {
        $this->type = $type;
        $this->data = $data;
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
        
        if ($this->type === 'breaking_news') {
            $channels[] = 'broadcast';
        }

        return $channels;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $messages = [
            'reply' => 'Someone replied to your comment',
            'reaction' => 'Someone reacted to your comment',
            'new_article' => 'New article in a category you follow',
            'breaking_news' => '🚨 Breaking News: ' . ($this->data['title'] ?? ''),
            'subscription_expiring' => 'Your subscription is expiring in 3 days',
            'weekly_digest' => 'Your weekly reading summary is ready',
        ];

        return [
            'type' => 'reader',
            'reader_type' => $this->type,
            'trigger_user_id' => $this->triggerUser ? $this->triggerUser->id : null,
            'trigger_user_name' => $this->triggerUser ? $this->triggerUser->name : 'Someone',
            'message' => $messages[$this->type] ?? 'New update for you',
            'data' => $this->data,
            'url' => $this->data['url'] ?? '#',
        ];
    }
}

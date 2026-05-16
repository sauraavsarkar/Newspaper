<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ArticleStatusNotification extends Notification
{
    use Queueable;

    protected $article;
    protected $status;
    protected $remark;

    /**
     * Create a new notification instance.
     */
    public function __construct($article, $status, $remark = null)
    {
        $this->article = $article;
        $this->status = $status; // approved, rejected, published, revision
        $this->remark = $remark;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];
        
        if ($this->status === 'approved' || $this->status === 'published') {
            $channels[] = 'broadcast';
        }

        // Email if user hasn't opted out
        $prefs = is_array($notifiable->preferences) ? $notifiable->preferences : json_decode($notifiable->preferences ?? '[]', true);
        if ($prefs['email_notifications'] ?? true) {
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
            'approved' => 'Your article was approved',
            'rejected' => 'Your article was rejected',
            'published' => 'Your article was published',
            'revision' => 'Editor requested a revision on your article',
        ];

        $mail = (new MailMessage)
            ->subject('Article Update: ' . $this->article->title)
            ->line($messages[$this->status] ?? 'Article status updated')
            ->action('View Article', route('article.show', $this->article->slug));

        if ($this->remark) {
            $mail->line('Feedback from Editor: ' . $this->remark);
        }

        return $mail->line('Thank you for using our platform!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $icons = [
            'approved' => '✅',
            'rejected' => '❌',
            'published' => '🌐',
            'revision' => '📝',
        ];

        $messages = [
            'approved' => 'Your article was approved',
            'rejected' => 'Your article was rejected',
            'published' => 'Your article was published',
            'revision' => 'Editor requested a revision on your article',
        ];

        return [
            'type' => 'article_status',
            'status' => $this->status,
            'article_id' => $this->article->id,
            'article_title' => $this->article->title,
            'message' => ($messages[$this->status] ?? 'Article status updated') . ' ' . ($icons[$this->status] ?? ''),
            'remark' => $this->remark,
            'url' => route('article.show', $this->article->slug), // Adjust route as needed
            'icon' => $icons[$this->status] ?? '🔔',
        ];
    }
}

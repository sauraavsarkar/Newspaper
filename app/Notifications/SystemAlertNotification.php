<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SystemAlertNotification extends Notification
{
    use Queueable;

    protected $type;
    protected $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($type, $data = [])
    {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];

        // Email admins for critical events
        if (in_array($this->type, ['system_error', 'new_subscription', 'abuse_report'])) {
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
            'system_error' => 'Critical System Error / Failed Job',
            'new_subscription' => 'Revenue Alert: New Subscription',
            'abuse_report' => 'Action Required: Content Abuse Report',
        ];

        $mail = (new MailMessage)
            ->subject('System Alert: ' . ($messages[$this->type] ?? 'Notification'))
            ->line($messages[$this->type] ?? 'A system event requires your attention.');

        if ($this->type === 'system_error') {
            $mail->line('Error: ' . ($this->data['error'] ?? 'Unknown Error'))
                 ->line('Job: ' . ($this->data['job'] ?? 'N/A'));
        }

        return $mail->action('Open Dashboard', url('/admin'))
                    ->line('Platform Integrity Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $messages = [
            'abuse_report' => 'New comment abuse report filed',
            'spam_flag' => 'Comment flagged as spam by system',
            'user_reported' => 'Reader account reported by multiple users',
            'new_user' => 'New user registered: ' . ($this->data['name'] ?? 'Unknown'),
            'new_subscription' => 'New subscription purchased',
            'first_article' => 'A journalist submitted their first article',
            'system_error' => 'System error or failed queue job',
            'daily_summary' => 'Daily CMS Summary available',
        ];

        return [
            'type' => 'system',
            'system_type' => $this->type,
            'message' => $messages[$this->type] ?? 'System alert',
            'data' => $this->data,
            'url' => $this->data['url'] ?? '#',
        ];
    }
}

<?php

namespace App\Livewire\Admin\Notifications;

use Livewire\Component;

use App\Services\NotificationGrouper;

class NotificationBell extends Component
{
    public function getListeners()
    {
        $userId = auth()->id();
        return [
            "echo-notification:App.Models.User.{$userId},notification" => '$refresh',
            'notification-received' => '$refresh', // Manual fallback
        ];
    }

    public function markAsRead($id)
    {
        // Handle both single ID and array of IDs (from grouped)
        if (is_string($id) && str_starts_with($id, '[')) {
            $ids = json_decode($id, true);
        } else {
            $ids = is_array($id) ? $id : [$id];
        }

        auth()->user()->unreadNotifications()->whereIn('id', $ids)->update(['read_at' => now()]);
        $this->dispatch('notification-read');
    }

    public function readAndRedirect($id, $url)
    {
        $this->markAsRead($id);
        if ($url && $url !== '#') {
            return redirect($url);
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }

    public function render()
    {
        $user = auth()->user();
        if (!$user) return <<<'HTML'
            <div></div>
        HTML;

        $unreadCount = $user->unreadNotifications()->count();
        $notifications = $user->unreadNotifications()->latest()->take(15)->get();
        $grouped = NotificationGrouper::group($notifications);

        return view('livewire.admin.notifications.notification-bell', [
            'unreadCount' => $unreadCount,
            'notifications' => $grouped,
        ]);
    }
}

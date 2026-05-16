<?php

namespace App\Livewire\Admin\Notifications;

use Livewire\Component;

use Livewire\WithPagination;
use App\Services\NotificationGrouper;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class NotificationCenter extends Component
{
    use WithPagination;

    public $filter = 'all'; // all, unread

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function markAsRead($id)
    {
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

    public function delete($id)
    {
        $ids = is_array($id) ? $id : [$id];
        auth()->user()->notifications()->whereIn('id', $ids)->delete();
    }

    public function render()
    {
        $query = auth()->user()->notifications();

        if ($this->filter === 'unread') {
            $query->whereNull('read_at');
        }

        $paginator = $query->latest()->paginate(30);
        $grouped = NotificationGrouper::group(collect($paginator->items()));

        return view('livewire.admin.notifications.notification-center', [
            'notifications' => $grouped,
            'paginator' => $paginator
        ]);
    }
}

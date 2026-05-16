<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\InteractsWithQueue;

class NotificationJobFailedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(JobFailed $event): void
    {
        $admins = \App\Models\User::role('Admin')->get();
        if ($admins->isNotEmpty()) {
            \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\SystemAlertNotification('system_error', [
                'job' => $event->job->resolveName(),
                'error' => $event->exception->getMessage(),
            ]));
        }
    }
}

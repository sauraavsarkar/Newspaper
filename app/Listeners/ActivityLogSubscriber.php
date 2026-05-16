<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use Illuminate\Events\Dispatcher;

class ActivityLogSubscriber
{
    /**
     * Handle user login events.
     */
    public function handleUserLogin($event) {
        activity('auth')
            ->causedBy($event->user)
            ->log('Logged in');
    }

    /**
     * Handle user logout events.
     */
    public function handleUserLogout($event) {
        if ($event->user) {
            activity('auth')
                ->causedBy($event->user)
                ->log('Logged out');
        }
    }

    /**
     * Handle user login failure events.
     */
    public function handleUserLoginFailed($event) {
        activity('auth')
            ->withProperties(['credentials' => $event->credentials])
            ->log('Failed login attempt');
    }

    /**
     * Handle user password reset events.
     */
    public function handlePasswordReset($event) {
        activity('auth')
            ->causedBy($event->user)
            ->log('Password changed');
    }

    /**
     * Handle email verification events.
     */
    public function handleVerified($event) {
        activity('auth')
            ->causedBy($event->user)
            ->log('Email verified');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return void
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            Login::class => 'handleUserLogin',
            Logout::class => 'handleUserLogout',
            Failed::class => 'handleUserLoginFailed',
            PasswordReset::class => 'handlePasswordReset',
            Verified::class => 'handleVerified',
        ];
    }
}

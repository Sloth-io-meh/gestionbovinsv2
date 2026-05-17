<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;

class LogAuthenticationEvents
{
    public function handleLogin(Login $event)
    {
        activity('auth')
            ->causedBy($event->user)
            ->log('User logged in');
    }

    public function handleLogout(Logout $event)
    {
        if ($event->user) {
            activity('auth')
                ->causedBy($event->user)
                ->log('User logged out');
        }
    }

    public function handleFailed(Failed $event)
    {
        activity('auth')
            ->withProperties(['email' => $event->credentials['email'] ?? 'unknown'])
            ->log('Failed login attempt');
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners\LogAuthenticationEvents;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(Login::class, [LogAuthenticationEvents::class, 'handleLogin']);
        Event::listen(Logout::class, [LogAuthenticationEvents::class, 'handleLogout']);
        Event::listen(Failed::class, [LogAuthenticationEvents::class, 'handleFailed']);

        Gate::define('admin', function (User $user) {
            return $user->is_admin === true;
        });
    }
}

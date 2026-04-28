<?php

namespace App\Providers;

use App\Mail\WelcomeNewUser;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Verified::class => [],
    ];

    public function boot(): void
    {
        User::observe(UserObserver::class);

        Event::listen(
            Verified::class,
            function (Verified $event) {
                /** @var \App\Models\User $user */
                $user = $event->user;
                Mail::to($user->email)
                    ->queue(new WelcomeNewUser($user));
            }
        );
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}

<?php

namespace App\Providers;


use App\Events\TweetCreatedEvent;
use App\Listeners\SendTweetCreatedNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\Tweet;
use App\Models\TweetFavorite;
use App\Models\UserNotification;
use App\Observers\TweetObserver;
use App\Observers\UserNotificationObserver;
use App\Observers\TweetFavoriteObserver;
use Throwable;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        TweetCreatedEvent::class => [
            SendTweetCreatedNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Tweet::observe(TweetObserver::class);
        UserNotification::observe(UserNotificationObserver::class);
        TweetFavorite::observe(TweetFavoriteObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}

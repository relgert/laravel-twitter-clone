<?php

namespace App\Observers;

use App\Models\UserNotification;

class UserNotificationObserver
{
    /**
     * Handle the Tweet "created" event.
     */
    public function created(UserNotification $tweet): void
    {
        //TweetCreatedEvent::dispatch($tweet);
    }

    /**
     * Handle the Tweet "updated" event.
     */
    public function updated(UserNotification $tweet): void
    {
        //
    }

    /**
     * Handle the Tweet "deleted" event.
     */
    public function deleted(UserNotification $tweet): void
    {
        //
    }

    /**
     * Handle the Tweet "restored" event.
     */
    public function restored(UserNotification $tweet): void
    {
        //
    }

    /**
     * Handle the Tweet "force deleted" event.
     */
    public function forceDeleted(UserNotification $tweet): void
    {
        //
    }
}

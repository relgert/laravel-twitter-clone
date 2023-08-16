<?php

namespace App\Observers;

use App\Models\Tweet;
use App\Events\TweetFavoritedNotificationEvent;

class TweetObserver
{
    /**
     * Handle the Tweet "created" event.
     */
    public function created(Tweet $notification): void
    {
        TweetFavoritedNotificationEvent::dispatch($notification);
    }

    /**
     * Handle the Tweet "updated" event.
     */
    public function updated(Tweet $notification): void
    {
        //
    }

    /**
     * Handle the Tweet "deleted" event.
     */
    public function deleted(Tweet $notification): void
    {
        //
    }

    /**
     * Handle the Tweet "restored" event.
     */
    public function restored(Tweet $notification): void
    {
        //
    }

    /**
     * Handle the Tweet "force deleted" event.
     */
    public function forceDeleted(Tweet $notification): void
    {
        //
    }
}

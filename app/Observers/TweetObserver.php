<?php

namespace App\Observers;

use App\Models\Tweet;
use App\Events\TweetCreatedEvent;

class TweetObserver
{
    /**
     * Handle the Tweet "created" event.
     */
    public function created(Tweet $tweet): void
    {
        TweetCreatedEvent::dispatch($tweet);
    }

    /**
     * Handle the Tweet "updated" event.
     */
    public function updated(Tweet $tweet): void
    {
        //
    }

    /**
     * Handle the Tweet "deleted" event.
     */
    public function deleted(Tweet $tweet): void
    {
        //
    }

    /**
     * Handle the Tweet "restored" event.
     */
    public function restored(Tweet $tweet): void
    {
        //
    }

    /**
     * Handle the Tweet "force deleted" event.
     */
    public function forceDeleted(Tweet $tweet): void
    {
        //
    }
}

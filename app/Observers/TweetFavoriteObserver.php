<?php

namespace App\Observers;

use App\Models\TweetFavorite;
use App\Models\UserNotification;
use Auth;


class TweetFavoriteObserver
{
    /**
     * Handle the Tweet "created" event.
     */
    public function created(TweetFavorite $tweet): void
    {
        //TweetCreatedEvent::dispatch($tweet);
        $notification = new UserNotification;
        $notification->user_id = $tweet->user_id;
        $notification->notifier_user_id = Auth::user()->id;
        $notification->source_id = $tweet->id;
        $notification->source_type = 'favorite';
        $notification->save();
    }

    /**
     * Handle the Tweet "updated" event.
     */
    public function updated(TweetFavorite $tweet): void
    {
        //
    }

    /**
     * Handle the Tweet "deleted" event.
     */
    public function deleted(TweetFavorite $tweet): void
    {
        //
    }

    /**
     * Handle the Tweet "restored" event.
     */
    public function restored(TweetFavorite $tweet): void
    {
        //
    }

    /**
     * Handle the Tweet "force deleted" event.
     */
    public function forceDeleted(TweetFavorite $tweet): void
    {
        //
    }
}

<?php

namespace App\Observers;

use App\Models\TweetFavorite;
use App\Models\UserNotification;
use App\Models\Tweet;


class TweetFavoriteObserver
{
    /**
     * Handle the Tweet "created" event.
     */
    public function created(TweetFavorite $favorited): void
    {



        $favoritedTweet = Tweet::find($favorited->tweet_id);
        if($favoritedTweet->user_id == $favorited->user_id){
            return;
        }

        $notification = new UserNotification;
        $notification->user_id = $favoritedTweet->user_id;
        $notification->notifier_user_id = $favorited->user_id;
        $notification->source_id = $favorited->tweet_id;
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

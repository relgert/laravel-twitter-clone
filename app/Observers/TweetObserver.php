<?php

namespace App\Observers;

use App\Models\Tweet;
use App\Models\User;
use App\Events\TweetCreatedEvent;
use App\Events\TweetUpdateEvent;
use Auth;

class TweetObserver
{
    /**
     * Handle the Tweet "created" event.
     */
    public function created(Tweet $tweet): void
    {
        $tweet = Tweet::where('id',$tweet->id)->with('parent','parent.user','user')->first();

        $user = User::where('id',$tweet->user_id)->first();

        TweetCreatedEvent::dispatch($tweet,$user);


    }

    /**
     * Handle the Tweet "updated" event.
     */
    public function updated(Tweet $tweet): void
    {

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

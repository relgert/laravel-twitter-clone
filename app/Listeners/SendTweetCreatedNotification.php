<?php

namespace App\Listeners;

use App\Events\TweetCreatedEvent;
use App\Events\TimeLineUpdateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Models\UserFollower;
use App\Models\UserNotification;
use Illuminate\Database\Eloquent\Collection;
use Auth;

class SendTweetCreatedNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TweetCreatedEvent $event): void
    {
        $tweet = $event->tweet;
        $user = $event->user;

        if($tweet->user_id != $event->user->id && ($tweet->is_retweet || $tweet->is_reply)){
            $notification = new UserNotification;
            $notification->user_id = $tweet->user_id;
            $notification->notifier_user_id = $user->id;
            $notification->source_id = $tweet->id;
            $notification->source_type = $tweet->is_retweet?'retweet':'reply';
            $notification->save();
        }

        foreach (UserFollower::where('followed_user_id', $tweet->user_id)->lazy() as $follower) {
            TimeLineUpdateEvent::dispatch($event->tweet,$follower);
        }
    }
}

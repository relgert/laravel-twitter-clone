<?php

namespace App\Observers;

use App\Models\UserFollower;
use App\Models\UserNotification;


class UserFollowerObserver
{
    /**
     * Handle the Tweet "created" event.
     */
    public function created(UserFollower $userFollower): void
    {


        if($userFollower->followed_user_id == $userFollower->follower_user_id){
            return;
        }

        $notification = new UserNotification;
        $notification->user_id = $userFollower->followed_user_id;
        $notification->notifier_user_id = $userFollower->follower_user_id;
        $notification->source_type = 'follow';
        $notification->save();
    }

    /**
     * Handle the Tweet "updated" event.
     */
    public function updated(UserFollower $userFollower): void
    {
        //
    }

    /**
     * Handle the Tweet "deleted" event.
     */
    public function deleted(UserFollower $userFollower): void
    {
        //
    }

    /**
     * Handle the Tweet "restored" event.
     */
    public function restored(UserFollower $userFollower): void
    {
        //
    }

    /**
     * Handle the Tweet "force deleted" event.
     */
    public function forceDeleted(UserFollower $userFollower): void
    {
        //
    }
}

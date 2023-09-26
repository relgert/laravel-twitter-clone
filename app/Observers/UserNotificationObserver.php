<?php

namespace App\Observers;

use App\Models\UserNotification;
use App\Models\User;
use App\Events\NotificationUpdateEvent;

class UserNotificationObserver
{
    /**
     * Handle the Tweet "created" event.
     */
    public function created(UserNotification $notification): void
    {
        $user = User::find($notification['user_id']);
        $user->increment('pending_notifications', 1);
        NotificationUpdateEvent::dispatch($user);
    }

    /**
     * Handle the Tweet "updated" event.
     */
    public function updated(UserNotification $notification): void
    {
        //
    }

    /**
     * Handle the Tweet "deleted" event.
     */
    public function deleted(UserNotification $notification): void
    {
        //
    }

    /**
     * Handle the Tweet "restored" event.
     */
    public function restored(UserNotification $notification): void
    {
        //
    }

    /**
     * Handle the Tweet "force deleted" event.
     */
    public function forceDeleted(UserNotification $notification): void
    {
        //
    }
}

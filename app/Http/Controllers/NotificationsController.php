<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Tweet;
use App\Models\TweetFavorite;
use App\Models\UserNotification;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Container\Container;
use Illuminate\Validation\Rule;


class NotificationsController extends Controller
{
    public function index(Request $request)
    {

        User::where('id',Auth::id())->update(['pending_notifications'=> 0]);
        return Inertia::render('Notifications');

    }

    public function notifications_list(Request $request)
    {
        $notifications = UserNotification::with('notifierUser','notifiedTweet')
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(10);
            return $notifications->toArray();
    }
}

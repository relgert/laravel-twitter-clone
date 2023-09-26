<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Tweet;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


// Broadcast::channel('tweets.{tweetId}',  function (User $user, int $tweetId) {
//     return $user->id === Tweet::findOrNew($tweetId)->user_id;
// });

// Broadcast::channel('tweets.1',  function (User $user, int $tweetId) {
//     return true;
// });



Broadcast::channel('user.{userId}',  function (User $user, int $userId) {
    return $user->id === $userId;
});

Broadcast::channel('main',  function (User $user) {
    return true;
});

Broadcast::channel('tweet_update.{tweetId}',  function (User $user, int $tweetId) {
    return true;
});



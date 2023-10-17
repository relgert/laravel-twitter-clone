<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFollower extends Model
{
    use HasFactory;




    public function followed(): BelongsTo
    {
        return $this->belongsTo(User::class,'followed_user_id');
    }

    public function follower(): BelongsTo
    {
        return $this->belongsTo(User::class,'follower_user_id');
    }


    static public function follow(User $followed,User $follower){


        $userFollower = new UserFollower;
        $userFollower->followed_user_id = $followed->id;
        $userFollower->follower_user_id = $follower->id;

        if(!$userFollower->save()){
            return false;
        }

        $follower->increment_counter('following_count');
        $followed->increment_counter('followers_count');
        return true;

    }

    static public function unfollow(User $followed,User $follower){
        $currentFollow = UserFollower::where('followed_user_id', $followed->id)->where('follower_user_id', $follower->id);
        if(!$currentFollow){
            return false;
        }
        $currentFollow->delete();
        $follower->decrement_counter('following_count');
        $followed->decrement_counter('followers_count');
        return true;
    }
}

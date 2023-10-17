<?php

namespace App\Jobs\Simulation;

use App\Models\User;
use App\Models\Tweet;
use App\Models\UserFollower;


class Simulation
{

    public static function tweet($simulationUser){
        $followed = UserFollower::where('follower_user_id',$simulationUser->id)->inRandomOrder()->first();
        Tweet::factory(1)->create([
            'user_id' => $followed->followed_user_id
        ]);
    }


    public static function likeTweet($simulationUser){
        $user = User::where('id','!=',$simulationUser->id)->inRandomOrder()->first();
        $tweet = Tweet::where('user_id',$simulationUser->id)->inRandomOrder()->first();
        Tweet::favorite($tweet,$user);
    }

    public static function follow($simulationUser){
        $follexcludedowed = UserFollower::where('followed_user_id','!=',$simulationUser->id)->pluck('follower_user_id')->toArray();
        $user = User::WhereNotIn('id',$follexcludedowed)->inRandomOrder()->first();
        if(!$user){
            return;
        }
        UserFollower::follow($simulationUser,$user);
    }

    public static function reply($simulationUser){
        $followed = UserFollower::where('follower_user_id',$simulationUser->id)->inRandomOrder()->first();
        $tweet = Tweet::where('user_id',$simulationUser->id)->where('type','tweet')->inRandomOrder()->first();

        Tweet::factory(1)->create([
            'user_id' => $followed->followed_user_id,
            'type'=>'reply',
            'parent_id'=>$tweet->id,
        ]);
    }

    public static function retweet($simulationUser){
        $followed = UserFollower::where('follower_user_id',$simulationUser->id)->inRandomOrder()->first();
        $tweet = Tweet::where('user_id',$simulationUser->id)->where('type','tweet')->inRandomOrder()->first();

        if(!$tweet){
            return;
        }

        Tweet::factory(1)->create([
            'user_id' => $followed->followed_user_id,
            'type'=>'retweet',
            'parent_id'=>$tweet->id,
        ]);
    }

    public static function quote($simulationUser){
        $followed = UserFollower::where('follower_user_id',$simulationUser->id)->inRandomOrder()->first();
        $tweet = Tweet::where('user_id',$simulationUser->id)->where('type','tweet')->inRandomOrder()->first();

        Tweet::factory(1)->create([
            'user_id' => $followed->followed_user_id,
            'type'=>'quote',
            'parent_id'=>$tweet->id,
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsToMany;

class Tweet extends Model
{
    use HasFactory;


    public function replies(): BelongsToMany
    {
        return $this->belongsToMany(Tweet::class,'tweet_replies','tweet_id','reply_id');
    }

    public function retweets(): BelongsToMany
    {
        return $this->belongsToMany(Tweet::class,'tweet_retweets','tweet_id','retweet_id');
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'tweet_favorites','tweet_id','user_id');
    }

    // public function favorites(): HasMany
    // {
    //     return $this->hasMany(TweetFavorites::class,'tweet_id');
    // }

    // public function retweets(): HasMany
    // {
    //     return $this->hasMany(TweetRetweets::class,'tweet_id');
    // }
}

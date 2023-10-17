<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasMany;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Events\TweetUpdateEvent;

use Auth;

class Tweet extends Model
{
    use HasFactory;
    protected $appends= ['liked_by_user','retweeted_by_user','quoted_by_user','media'];

    public function getMediaAttribute()
    {
        $url = null;
        if( $this->path && strpos($this->path,'http') === 0){
            $url = $this->path;
        }else if($this->path){
            $url = '/storage/'.$this->path;
        }
        return $url;
    }

    public function getLikedByUserAttribute()
    {
        $favorite = null;
        if(Auth::user()){
            $favorite = TweetFavorite::where('tweet_id', $this->id)->where('user_id',Auth::user()->id)->first();
        }
        return ($favorite)?true:false;
    }

    public function getRetweetedByUserAttribute()
    {
        $retweeted = null;
        if(Auth::user()){
            $retweeted = Tweet::where('parent_id', $this->id)->where('type','retweet')->where('user_id',Auth::user()->id)->first();
        }
        return ($retweeted)?true:false;
    }

    public function getQuotedByUserAttribute()
    {
        $quoted = null;
        if(Auth::user()){
            $quoted = Tweet::where('parent_id', $this->id)->where('type','quote')->where('user_id',Auth::user()->id)->first();
        }
        return ($quoted)?true:false;
    }



    public function replies(): HasMany
    {
        return $this->hasMany(Tweet::class, 'parent_id')->where('type','reply');
    }

    public function retweets(): HasMany
    {
        return $this->hasMany(Tweet::class, 'parent_id')->where('type','retweet');
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'tweet_favorites','tweet_id','user_id');
    }

    public function parent(): BelongsTo
    {
        return $this->BelongsTo(Tweet::class,'parent_id');
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class,'user_id');
    }

    // public function favorites(): HasMany
    // {
    //     return $this->hasMany(TweetFavorites::class,'tweet_id');
    // }

    // public function retweets(): HasMany
    // {
    //     return $this->hasMany(TweetRetweets::class,'tweet_id');
    // }


    public function increment_counter($counter = 'count_favorites'){
        $this->increment($counter, 1);
        TweetUpdateEvent::dispatch($this);
    }

    public function decrement_counter($counter = 'count_favorites'){
        $this->decrement($counter, 1);
        TweetUpdateEvent::dispatch($this);
    }


    static public function favorite(Tweet $tweet, User $user){
        $tweetFavorite = new TweetFavorite;
        $tweetFavorite->tweet_id = $tweet->id;
        $tweetFavorite->user_id = $user->id;
        if($tweetFavorite->save()){
            $tweet = Tweet::where('id',$tweet->id)->first();
            $tweet->increment_counter('count_favorites');
        }
        return Tweet::where('id',$tweet->id)->with('parent','parent.user','user')->first();
    }
}

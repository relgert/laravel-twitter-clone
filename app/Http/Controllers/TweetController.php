<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Models\TweetFavorite;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Validation\Rule;

class TweetController extends Controller
{
    public function index()
    {
        return Inertia::render('Index', [
            'tweetPagination' => []
        ]);
    }


    public function timeline(Request $request){
        usleep(150000);
        $tweets = Tweet::with('favorites','parent')
        ->with(['replies'=>function($query) {
            return $query->limit(1);
        }])
        ->where('is_reply', null)
        ->orderBy('id', 'desc')
        ->paginate(10);


        if($request->wantsJson()){
            return $tweets->toArray();
        }else{
            return Inertia::render('Index', [
                'tweetPagination' => $tweets
            ]);
        }
    }


    public function show(Tweet $tweet): Response
    {
        return Inertia::render('Show', [
            'tweet' => $tweet
        ]);
    }


    public function store(Request $request){

        $faker = Container::getInstance()->make(Generator::class);

        $newTweet = new Tweet;
        $newTweet->user_id = Auth::id();
        $newTweet->text = $faker->sentence(6);

        $newTweet->save();
        //return redirect('/users/create');
    }


    public function favorite_tweet(Request $request){
        $valid = $request->validate([
            'tweet_id' => [
                Rule::unique('tweet_favorites')
                  ->where('tweet_id', $request->tweet_id)
                  ->where('user_id', Auth::user()->id)
            ],
        ]);

        $tweetFavorite = new TweetFavorite;
        $tweetFavorite->tweet_id = $valid['tweet_id'];
        $tweetFavorite->user_id = Auth::user()->id;
        if($tweetFavorite->save()){
            Tweet::where('id',$valid['tweet_id'])->increment('count_favorites', 1);
        }
        $tweet = Tweet::where('id',$valid['tweet_id'])->first();

        if($request->wantsJson()){
            return $tweet->toArray();
        }
    }

    public function unfavorite_tweet(Request $request){
        $valid = $request->validate([
            'tweet_id' => [
                'required'
            ],
        ]);

        $tweetFavorite = TweetFavorite::where('tweet_id',$valid['tweet_id'])->where('user_id',Auth::user()->id)->first();
        if($tweetFavorite){
            $tweetFavorite->delete();
            Tweet::where('id',$valid['tweet_id'])->decrement('count_favorites', 1);
        }

        $tweet = Tweet::where('id',$valid['tweet_id'])->first();


        if($request->wantsJson()){
            return $tweet->toArray();
        }
    }
}

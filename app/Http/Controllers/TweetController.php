<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tweet;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use Faker\Generator;
use Illuminate\Container\Container;


class TweetController extends Controller
{
    public function index(Request $request)
    {
        $tweets = Tweet::with('favorites','parent')
        ->with(['replies'=>function($query) {
            return $query->limit(1);
        }])
        ->where('is_reply', null)
        ->orderBy('id', 'desc')
        ->paginate(3);


        if($request->wantsJson()){
            return $tweets->toArray();
        }else{
            return Inertia::render('Index', [
                'tweetPagination' => $tweets
            ]);
        }
    }


    public function timeline(){
        return Inertia::render('Timeline', [
            'tweetPagination' => []
        ]);
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

}

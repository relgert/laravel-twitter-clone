<?php

namespace App\Http\Controllers;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TweetController extends Controller
{
    public function show(Tweet $tweet): Response
    {
        return Inertia::render('Show', [
            'tweet' => $tweet
        ]);
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function show(Article $article): Response
    {
        return Inertia::render('Show', [
            'article' => $article
        ]);
    }
}

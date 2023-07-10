<?php
use App\Models\Article;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



use Illuminate\Session\Middleware\AuthenticateSession;



Route::get('/', function () {
    return Inertia::render('Index', [
        'articles' => Article::latest()->get(),
    ]);
})->name('home');

Route::get('/posts/{article:id}', [ArticleController::class, 'show'])->name('article.show');



Route::post('/authenticate', [LoginController::class, 'authenticate']);
//

Route::view('/home','welcome')->name('home2');
Route::view('login','login')->name('login')->middleware('guest');
//Route::view('dashboard','dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout']);
    Route::view('dashboard','dashboard');

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'show']);

    Route::get('/users/create', [UserController::class, 'create']);
    Route::post('/users/create', [UserController::class, 'create_action']);

    Route::get('/users/edit/{id}', [UserController::class, 'edit']);
    Route::post('/users/edit/{id}', [UserController::class, 'edit_action']);
});

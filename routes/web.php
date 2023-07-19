<?php
use App\Models\Tweet;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



use Illuminate\Session\Middleware\AuthenticateSession;


Route::get('/', [TweetController::class, 'index'])->name('home');
Route::get('/timeline', [TweetController::class, 'timeline'])->name('timeline');


// Route::get('/', function () {
//     return Inertia::render('Index', [
//         'tweetPagination' => Tweet::with('favorites','parent')
//         ->with(['replies'=>function($query) {
//             return $query->limit(1);
//         }])
//         ->where('is_reply', null)
//         ->paginate(3)
//     ]);
// })->name('home');

Route::get('/login', function () {
    return Inertia::render('Login');
})->name('login')->middleware('guest');

Route::get('/tweet/{tweet:id}', [TweetController::class, 'show'])->name('tweet.show');



Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
//

Route::view('/home','welcome')->name('home2');
//Route::view('login','login')->name('login')->middleware('guest');
//Route::view('dashboard','dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::view('dashboard','dashboard');

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'show']);

    Route::get('/users/create', [UserController::class, 'create']);
    Route::post('/users/create', [UserController::class, 'create_action']);

    Route::get('/users/edit/{id}', [UserController::class, 'edit']);
    Route::post('/users/edit/{id}', [UserController::class, 'edit_action']);

    Route::get('/tweets', [TweetController::class, 'store'])->name('tweet.add');
});



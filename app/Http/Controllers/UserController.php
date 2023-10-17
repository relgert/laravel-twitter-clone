<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\UserFollower;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Container\Container;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use App\Models\SimulationJob;


class UserController extends Controller
{
    function index(){

        return view('user.index', [
            'users' => User::get()
        ]);
    }


    function profile(User $user,Request $request){
        return Inertia::render('Profile', [
            'profileUser' => $user
        ]);

    }

    public function show(string $id): View{
        return view('user.profile', [
            'user' => User::findOrFail($id)
        ]);
    }


    public function create(Request $request){
        // $credentials = $request->validate([
        //     'email' => ['required', 'email'],
        //     'password' => ['required'],
        // ]);

        //dd(2);
        return view('user.create');


        // return back()->withErrors([
        //     'email' => 'The provided credentials do not match our records.',
        // ])->onlyInput('email');
    }


    public function edit($id){
        return view('user.edit', [
            'user' => User::find($id)
        ]);
    }

    public function edit_action(Request $request,$id): RedirectResponse{
        $credentials = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email']
         ]);
        $User = User::find($id);
        $User->fill($request->all());
        $User->save();
        return redirect('/users');
    }


    public function create_action(Request $request): RedirectResponse{
        $credentials = $request->validate([
                'name' => ['required'],
                'email' => ['required', 'email','unique:users'],
                'password' => ['required'],
             ]);
        $User = User::create($credentials);
        return redirect('/users/create');
    }

    public function follow_user(User $user,Request $request){
        $follower = User::find(Auth::user()->id);

        $valid = $request->validate([
            'id' => [
                Rule::unique('user_followers')
                  ->where('followed_user_id', $user->id)
                  ->where('follower_user_id', $follower->id)
            ],
        ]);

        UserFollower::follow($user,$follower);

        return User::find($user->id);
    }

    public function un_follow_user(User $user,Request $request){
        $follower = User::find(Auth::user()->id);
        UserFollower::unfollow($user,$follower);
        return User::find($user->id);
    }


    function start_simulation(){
        return SimulationJob::startSimulation(Auth::user());
    }
}

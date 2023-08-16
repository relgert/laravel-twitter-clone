<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\UserFollowers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    function index(){

        return view('user.index', [
            'users' => User::get()
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

    public function follow_user(Request $request): RedirectResponse{




        $valid = $request->validate([
            'followed_user_id' => [
                Rule::unique('user_followers')
                  ->where('followed_user_id', $request->followed_user_id)
                  ->where('follower_user_id', Auth::user()->id)
            ],
        ]);


        $userFollower = new UserFollowers;
        $userFollower->followed_user_id = $valid['followed_user_id'];
        $userFollower->follower_user_id = Auth::user()->id;
        $userFollower->save();

        return redirect('/');
    }
}

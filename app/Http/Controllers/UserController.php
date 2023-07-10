<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

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
}

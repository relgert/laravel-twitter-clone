<?php

namespace Database\Seeders;

use App\Models\Tweet;
use App\Models\User;
use App\Models\UserFollower;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    private $users = 99;
    private $tweets = 1000;
    private $followersMax = 10;
    private $followersMin = 30;

    public function run()
    {
        User::factory(1)->create([
            'email'=>'vince.terry@gmail.com',
            'password'=>bcrypt('password')
        ]);

        User::factory($this->users)->create();

        Tweet::factory($this->tweets)->create();

        $this->followers();
    }


    public function followers(){
        $users = User::get();
        foreach($users as $user){
            $followUsers = User::where('id','!=',$user->id)->limit(rand($this->followersMin,$this->followersMax))->get();
            foreach($followUsers as $follow){
                UserFollower::follow($follow,$user);
            }
        }
    }
}

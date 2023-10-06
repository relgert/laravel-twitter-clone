<?php

namespace Database\Seeders;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::factory(1)->create([
            'email'=>'vince.terry@gmail.com',
            'password'=>bcrypt('password')
        ]);

        User::factory(10)->create();

        Tweet::factory(150)->create();
    }
}

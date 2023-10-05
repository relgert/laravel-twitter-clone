<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{

    use RefreshDatabase;



    public function test_user_create_and_delete(): void
    {
        $this->seed();
        $user = User::first();
        $this->assertModelExists($user);
        $user->delete();
        $this->assertModelMissing($user);
    }
}

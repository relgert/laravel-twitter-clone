<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AccessTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $this->assertGuest();
    }


    public function test_login(){
        $user = User::factory()->create([
            'password' => bcrypt($password = 'secret-password'),
        ]);

        $response = $this->post('/authenticate', [
            'email' => $user->email,
            'password' => 'secret-password',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    public function test_guest(){
        $response = $this->get('/');
        $this->assertGuest();
    }
}

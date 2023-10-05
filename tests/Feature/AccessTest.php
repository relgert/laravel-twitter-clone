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


    public function test_user_can_login_with_correct_credentials(){
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

    public function test_user_cant_login_with_incorrect_credentials(){
        $user = User::factory()->create([
            'password' => bcrypt($password = 'secret-password'),
        ]);

        $response = $this->post('/authenticate', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_user_cant_access_protected_urls(){
        $response = $this->get('/');
        $this->assertGuest();
        $response->assertRedirect('/login');
    }
}

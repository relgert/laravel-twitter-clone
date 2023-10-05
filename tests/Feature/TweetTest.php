<?php

namespace Tests\Feature;



use Tests\TestCase;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class TweetTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_tweet_create_and_delete(): void
    {
        $this->seed();
        $tweet = Tweet::first();
        $this->assertModelExists($tweet);
        $tweet->delete();
        $this->assertModelMissing($tweet);
    }

    public function test_create_tweet_with__image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->json('POST', '/tweets', [
            'text'=>'see',
            'file' => UploadedFile::fake()->image('avatar.png')
        ]);

        Storage::disk('public')->assertExists($response->getData()->path);
        Storage::disk('public')->assertMissing('missing.png');
    }

    public function test_tweet_timeline():void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->seed();
        $response = $this->json('GET','/timeline');

        $response->assertJsonFragment(['current_page' => 1]);
        $response->assertJsonCount(10, 'data');

        $response = $this->json('GET','/timeline?page=2');
        $response->assertJsonFragment(['current_page' => 2]);
    }
}

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

        $response->assertStatus(200);
        Storage::disk('public')->assertExists($response->getData()->path);
        Storage::disk('public')->assertMissing('missing.png');
    }

    public function test_retweet_tweet(): void
    {

        $user1 = User::factory()->create();
        $tweet = Tweet::factory()->create(['user_id'=>$user1->id]);

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->json('POST', '/tweets/'.$tweet->id.'/retweet');
        $response->assertStatus(200);
    }

    public function test_reply_tweet_with__image(): void
    {
        Storage::fake('public');

        $user1 = User::factory()->create();
        $tweet = Tweet::factory()->create(['user_id'=>$user1->id]);

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->json('POST', '/tweets/'.$tweet->id.'/reply', [
            'text'=>'see',
            'file' => UploadedFile::fake()->image('avatar.png')
        ]);

        $response->assertStatus(200);
        Storage::disk('public')->assertExists($response->getData()->path);
        Storage::disk('public')->assertMissing('missing.png');
    }

    public function test_quote_tweet_with__image(): void
    {
        Storage::fake('public');

        $user1 = User::factory()->create();
        $tweet = Tweet::factory()->create(['user_id'=>$user1->id]);

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->json('POST', '/tweets/'.$tweet->id.'/quote', [
            'text'=>'see',
            'file' => UploadedFile::fake()->image('avatar.png')
        ]);

        $response->assertStatus(200);
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

    public function test_user_can_favorite_tweet():void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tweet = Tweet::factory()->create();

        $response = $this->json('POST', '/favorite_tweet', [
            'tweet_id'=>$tweet->id,
        ]);

        $response->assertJsonFragment(['liked_by_user' => true]);
    }

    public function test_user_cant_favorite_twice():void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tweet = Tweet::factory()->create();

        $response = $this->json('POST', '/favorite_tweet', [
            'tweet_id'=>$tweet->id,
        ]);

        $response->assertJsonFragment(['liked_by_user' => true]);

        $response = $this->json('POST', '/favorite_tweet', [
            'tweet_id'=>$tweet->id,
        ]);

        $response->assertStatus(422);

        $response->assertJsonFragment(['message' => 'The tweet id has already been taken.']);
    }

    public function test_user_can_unfavorite():void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tweet = Tweet::factory()->create();

        $response = $this->json('POST', '/favorite_tweet', [
            'tweet_id'=>$tweet->id,
        ]);

        $response->assertJsonFragment(['liked_by_user' => true]);


        $response = $this->json('POST', '/unfavorite_tweet', [
            'tweet_id'=>$tweet->id,
        ]);

        $response->assertJsonFragment(['liked_by_user' => false]);
    }

    public function test_user_cant_unfavorite_twice():void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tweet = Tweet::factory()->create();

        $response = $this->json('POST', '/favorite_tweet', [
            'tweet_id'=>$tweet->id,
        ]);

        $response->assertJsonFragment(['liked_by_user' => true]);


        $response = $this->json('POST', '/unfavorite_tweet', [
            'tweet_id'=>$tweet->id,
        ]);

        $response->assertJsonFragment(['liked_by_user' => false]);

        $response = $this->json('POST', '/unfavorite_tweet', [
            'tweet_id'=>$tweet->id,
        ]);

        $response->assertStatus(422);

        $response->assertJsonFragment(['message' => 'The tweet is not favorited by user.']);
    }
}

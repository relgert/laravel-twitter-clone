<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tweet>
 */
class TweetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $img = fake()->userName();
        return [
            'user_id'=>User::inRandomOrder()->first(),
            'text' => $this->faker->sentence(6),
            'path' => 'https://picsum.photos/seed/'.$img.'/600/400'
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->realText(50);
        return [
            'title' => $title,
            'image' => fake()->imageUrl,
            'blog' => fake()->realText(5000),
            'user_id' => 1
        ];
    }
}

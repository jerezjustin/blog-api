<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $title = fake()->sentence(),
            'slug' => (string) str($title)->slug(),
            'content' => fake()->paragraphs(random_int(1, 5), true),
            'is_draft' => fake()->boolean(),
            'user_id' => User::factory()->create(),
        ];
    }
}

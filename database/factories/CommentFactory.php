<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $commentableType = fake()->randomElement([Post::class, Comment::class]);

        $commentableId = $commentableType::factory()->create();

        return [
            'user_id' => User::factory()->create(),
            'commentable_id' => $commentableId,
            'commentable_type' => $commentableType,
            'content' => fake()->paragraph()
        ];
    }
}

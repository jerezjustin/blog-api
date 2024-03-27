<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\PostDTO;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class PostService
{
    public function getPaginated(): Collection
    {
        return Post::all();
    }

    public function create(array $data): Post
    {
        $postDTO = PostDTO::fromArray($data);

        $post = Post::create($postDTO->toArray());

        if (isset($data['categories'])) {
            $post->categories()->attach($data['categories']);
        }

        return $post;
    }

    public function update(array $data, Post $post): Post
    {
        $updatedPost = PostDTO::fromArray($data);

        $post->update([...$updatedPost->toArray(), 'user_id' => $post->user_id]);

        if (isset($data['categories'])) {
            $post->categories()->sync($data['categories']);
        }

        return $post;
    }

    public function delete(Post $post): void
    {
        $post->delete();
    }
}

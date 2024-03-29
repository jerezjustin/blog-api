<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentPolicy
{
    public function store(User $user, Post $post): bool
    {
        return ! $post->is_draft;
    }

    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }
}

<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Role;
use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function viewAny(): bool
    {
        return true;
    }

    public function view(User $user, Post $post): bool
    {
        if ( ! $post->is_draft) {
            return true;
        }

        return $user->id === $post->user_id;
    }

    public function store(User $user): bool
    {
        return Role::Administrator === $user->role;
    }

    public function update(User $user, Post $post): bool
    {
        if (Role::Administrator === $user->role) {
            return true;
        }

        return $post->user_id === $user->id;
    }

    public function delete(User $user, Post $post): bool
    {
        if (Role::Administrator === $user->role) {
            return true;
        }

        return $post->user_id === $user->id;
    }
}

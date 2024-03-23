<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Role;
use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function viewAny(): bool
    {
        return true;
    }

    public function view(): bool
    {
        return true;
    }

    public function store(User $user): bool
    {
        return Role::Administrator === $user->role;
    }

    public function update(User $user, Category $category): bool
    {
        return Role::Administrator === $user->role;
    }

    public function delete(User $user, Category $category): bool
    {
        return Role::Administrator === $user->role;
    }
}

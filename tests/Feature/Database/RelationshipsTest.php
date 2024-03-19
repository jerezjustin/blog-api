<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

dataset('relationships', [
    [User::class, 'comments', Comment::class],
    [User::class, 'posts', Post::class],
    [Comment::class, 'comments', Comment::class],
    [Post::class, 'categories', Category::class],
    [Post::class, 'comments', Comment::class],
]);

test('models have valid relationship', function (string $parentClass, string $relationshipName, string $childClass): void {
    $parent = $parentClass::factory()->create();

    $child = $childClass::factory()->create();

    $parent->{$relationshipName}()->save($child);

    expect($parent->{$relationshipName}()->count() > 0)->toBeTrue();

    expect($parent->{$relationshipName}()->find($child->getKey()) instanceof $childClass)->toBeTrue();
})->with('relationships');

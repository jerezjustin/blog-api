<?php

declare(strict_types=1);

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\assertDatabaseMissing;

test('can update a comment', function (): void {
    $user = User::factory()->create();

    $post = Post::factory()->create();

    $comment = $post->comments()->create([
        'content' => 'Content example',
        'user_id' => $user->id
    ]);

    asUser($user)->put("api/v1/comments/{$comment->getRouteKey()}", [
        'content' => $updatedCommentContent = 'Updated content by ' . $user->name,
    ])->assertNoContent();

    $comment->refresh();

    expect($comment->content)->toBe($updatedCommentContent);
});

test('can delete a comment', function (): void {
    $user = User::factory()->create();

    $post = Post::factory()->create();

    $comment = $post->comments()->create([
        ...Comment::factory()->make()->toArray(),
        'user_id' => $user->id,
    ]);

    asUser($user)->delete("api/v1/comments/{$comment->getRouteKey()}")->assertNoContent();

    assertDatabaseMissing('comments', $comment->toArray());
});

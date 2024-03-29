<?php

declare(strict_types=1);

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

test('can reply to a comment', function (): void {
    $post = Post::factory()->create(['is_draft' => false]);

    $comment = $post->comments()->create([
        'content' => 'example comment',
        'user_id' => User::factory()->create()->id
    ]);

    asAdmin()->post("api/v1/comments/{$comment->getRouteKey()}/replies", [
        'content' => 'reply to example comment'
    ])->assertCreated();

    expect(1 === $comment->replies()->count())->toBeTrue();
});

test('can retrieve replies of a comment', function (): void {
    $post = Post::factory()->create(['is_draft' => false]);

    $comment = $post->comments()->create([
        'content' => 'example comment',
        'user_id' => User::factory()->create()->id
    ]);

    $replies = Comment::factory(3)->create([
        'commentable_id' => $comment->id,
        'commentable_type' => Comment::class
    ]);

    $expectedResponse = CommentResource::collection($replies)->response()->getData(true)['data'];

    get("api/v1/comments/{$comment->getRouteKey()}/replies")
        ->assertOk()
        ->assertJson($expectedResponse);
});

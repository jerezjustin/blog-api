<?php

declare(strict_types=1);

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

test('can comment a post', function (): void {
    $post = Post::factory()->create(['is_draft' => false]);

    $response = asAdmin()->post("api/v1/posts/{$post->getRouteKey()}/comments", [
        'content' => 'Test comment content'
    ]);

    $response->assertCreated();

    expect(1 === $post->comments()->count())->toBeTrue();
});

test('cannot comment a post that is still a draft', function (): void {
    $post = Post::factory()->create(['is_draft' => true]);

    asAdmin()->post("api/v1/posts/{$post->getRouteKey()}/comments", [
        'content' => 'Test comment content'
    ])->assertForbidden();
});

test('can retrieve the comments of a post', function (): void {
    $post = Post::factory()->create(['is_draft' => false]);

    $comments = Comment::factory(3)->create([
        'commentable_id' => $post->id,
        'commentable_type' => Post::class
    ]);

    $expectedResponse = CommentResource::collection($comments)->response()->getData(true)['data'];

    get("/api/v1/posts/{$post->getRouteKey()}/comments")
        ->assertOk()
        ->assertJson($expectedResponse);
});

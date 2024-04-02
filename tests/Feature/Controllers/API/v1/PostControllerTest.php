<?php

declare(strict_types=1);

use App\Enums\Role;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostSummaryResource;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

test('can show paginated posts', function (): void {
    $posts = Post::factory(1)->create();

    $expectedPostsCollection = PostSummaryResource::collection($posts);

    get('/api/v1/posts')
        ->assertOk()
        ->assertJson($expectedPostsCollection->response()->getData(true));
});

test('can show    specific post', function (): void {
    $post = Post::factory()->create();

    get('api/v1/posts/' . $post->getRouteKey())
        ->assertOk()
        ->assertJson((new PostResource($post))->response()->getData(true)['data']);
});

test('can create a new post', function (): void {
    $user = User::factory()->create(['role' => Role::Administrator]);

    $postData = Post::factory()->make(['user_id' => $user->getKey()])->toArray();

    $response = asAdmin($user)->post('/api/v1/posts', $postData);

    $response
        ->assertCreated()
        ->assertJsonFragment($postData);
});

test('can update an existing post', function (): void {
    $post = Post::factory()->create();

    $post->categories()->attach(Category::factory(3)->create());

    asAdmin()->put('/api/v1/posts/' . $post->getRouteKey(), $updatedData = [
        'title' => 'Updated Post Title',
        'slug' => 'updated-post-title',
        'content' => 'Updated Post Content',
        'categories' => $post->categories()->limit(2)->get()->pluck('id'),
    ]);

    unset($updatedData['categories']);

    expect(2 === $post->categories()->count())->toBeTrue();

    assertDatabaseHas('posts', $updatedData);
});

test('can delete an existing post', function (): void {
    $post = Post::factory()->create();

    asAdmin()
        ->delete('/api/v1/posts/' . $post->getRouteKey())
        ->assertNoContent();

    assertDatabaseMissing('posts', $post->toArray());
});

<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function __construct(private readonly PostService $postService) {}

    public function index(): JsonResponse
    {
        $posts = $this->postService->getPaginated();

        $posts->load('categories', 'user');

        return response()->json(PostResource::collection($posts), Response::HTTP_OK);
    }

    public function show(Post $post): JsonResponse
    {
        $post->load('categories', 'user');

        return response()->json(new PostResource($post), Response::HTTP_OK);
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        Gate::authorize('store', Post::class);

        $post = $this->postService->create([
            ...$request->toArray(),
            'user_id' => request()->user()->id
        ]);

        return response()->json(new PostResource($post), Response::HTTP_CREATED);
    }

    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        Gate::authorize('update', $post);

        $posts = $this->postService->update($request->toArray(), $post);

        return response()->json(new PostResource($post), Response::HTTP_NO_CONTENT);
    }

    public function destroy(Post $post): JsonResponse
    {
        Gate::authorize('delete', $post);

        $this->postService->delete($post);

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }
}

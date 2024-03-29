<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpsertCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PostCommentController extends Controller
{
    public function __construct(private readonly CommentService $commentService) {}

    public function index(Post $post): JsonResponse
    {
        $post->load('comments');

        $comments = $post->comments;

        return response()->json(CommentResource::collection($comments), Response::HTTP_OK);
    }

    public function store(UpsertCommentRequest $request, Post $post): JsonResponse
    {
        Gate::authorize('store', [Comment::class, $post]);

        $this->commentService->create($post, $request->validated());

        return response()->json(status: Response::HTTP_CREATED);
    }
}

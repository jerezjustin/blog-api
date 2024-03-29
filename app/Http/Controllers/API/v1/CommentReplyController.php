<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpsertCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CommentReplyController extends Controller
{
    public function __construct(private readonly CommentService $commentService) {}

    public function index(Comment $comment): JsonResponse
    {
        $comment->load('replies');

        $replies = $comment->replies;

        return response()->json(CommentResource::collection($replies), Response::HTTP_OK);
    }

    public function store(UpsertCommentRequest $request, Comment $comment): JsonResponse
    {
        $comment = $this->commentService->reply($comment, $request->validated());

        return response()->json(status: Response::HTTP_CREATED);
    }
}

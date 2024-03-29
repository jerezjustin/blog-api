<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpsertCommentRequest;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    public function __construct(private readonly CommentService $commentService) {}

    public function update(UpsertCommentRequest $request, Comment $comment): JsonResponse
    {
        Gate::authorize('update', $comment);

        $this->commentService->update($comment, $request->validated());

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }

    public function destroy(Comment $comment): JsonResponse
    {
        Gate::authorize('update', $comment);

        $this->commentService->delete($comment);

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }
}

<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CommentDTO;
use App\Models\Comment;
use App\Models\Post;

class CommentService
{
    public function create(Post $post, array $data): Comment
    {
        $commentData = CommentDTO::fromArray($data);

        $comment = $post->comments()->create([
            ...$commentData->toArray(),
            'user_id' => request()->user()->id,
        ]);

        return $comment;
    }

    public function update(Comment $comment, array $data): Comment
    {
        $commentData = CommentDTO::fromArray($data);

        $comment->update([
            ...$commentData->toArray(),
            'user_id' => $comment->user_id
        ]);

        return $comment;
    }

    public function reply(Comment $comment, array $data): Comment
    {
        $replyData = CommentDTO::fromArray($data);

        $reply = $comment->replies()->create([
            ...$replyData->toArray(),
            'user_id' => request()->user()->id,
        ]);

        return $reply;
    }

    public function delete(Comment $comment): void
    {
        $comment->delete();
    }
}

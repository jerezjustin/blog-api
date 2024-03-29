<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'is_draft' => (bool) $this->is_draft,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'comments' => CommentResource::collection($this->whenLoaded('comments'))
        ];
    }
}

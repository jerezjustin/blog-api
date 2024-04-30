<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostSummaryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'is_draft' => (bool) $this->is_draft,
            'created_at' => $this->created_at,
            'author' => $this->whenLoaded('user', fn() => [
                'id' => $this->user->id,
                'name' => $this->user->name
            ]),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'comments_count' => $this->whenLoaded('comments', fn() => $this->comments->count()),
        ];
    }
}

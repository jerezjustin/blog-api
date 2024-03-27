<?php

declare(strict_types=1);

namespace App\DTO;

readonly class PostDTO
{
    public function __construct(
        public string $title,
        public string $slug,
        public string $content,
        public bool $isDraft = false,
        public ?int $userId = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $title = (string) (data_get($data, 'title')),
            slug: (string) (data_get($data, 'slug', str($title)->slug())),
            content: (string) (data_get($data, 'content')),
            isDraft: (bool) (data_get($data, 'is_draft')),
            userId: isset($data['user_id']) ? (int) $data['user_id'] : null,
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'is_draft' => $this->isDraft,
            'user_id' => $this->userId,
        ];
    }
}

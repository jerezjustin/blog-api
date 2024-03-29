<?php

declare(strict_types=1);

namespace App\DTO;

readonly class CommentDTO
{
    public function __construct(public string $content) {}

    public static function fromArray(array $data): self
    {
        return new self(
            content: (string) data_get($data, 'content'),
        );
    }

    public function toArray(): array
    {
        return [
            'content' => $this->content
        ];
    }
}

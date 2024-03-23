<?php

declare(strict_types=1);

namespace App\DTO;

readonly class CategoryDTO
{
    public function __construct(public string $name, public ?string $slug)
    {
        if ( ! $slug) {
            $this->slug = str($name)->slug();
        }
    }

    public static function fromArray(array $data)
    {
        return new self(
            name: $data['name'],
            slug: $data['slug'] ?? str($data['name'])->slug()->toString()
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\DTO;

use App\Models\Category;
use Illuminate\Validation\ValidationException;

readonly class CategoryDTO
{
    public function __construct(public string $name, public string $slug)
    {
        if (Category::where('slug', $this->slug)->exists()) {
            throw ValidationException::withMessages(['slug' => 'Category name has already been taken.']);
        }
    }

    public static function fromArray(array $data)
    {
        return new self(
            name: $name = (string) data_get($data, 'name'),
            slug: (string) data_get($data, 'slug', str($name)->slug())
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

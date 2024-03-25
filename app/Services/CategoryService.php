<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CategoryDTO;
use App\Models\Category;

class CategoryService
{
    public function create(array $data): Category
    {
        $category = CategoryDTO::fromArray($data);

        return Category::create($category->toArray());
    }

    public function update(array $data, Category $category): Category
    {
        $updatedCategory = CategoryDTO::fromArray($data);

        $category->update($updatedCategory->toArray());

        return $category;
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }
}

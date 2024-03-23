<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CategoryDTO;
use App\Models\Category;
use Illuminate\Validation\ValidationException;

class CategoryService
{
    public function create(array $data): Category
    {
        $category = CategoryDTO::fromArray($data);

        $this->validateCategory($category);

        return Category::create($category->toArray());
    }

    public function update(array $data, Category $category): Category
    {
        $updatedCategory = CategoryDTO::fromArray($data);

        $this->validateCategory($updatedCategory);

        $category->update($updatedCategory->toArray());

        return $category;
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }

    protected function validateCategory(CategoryDTO $category): void
    {
        if (Category::where('slug', $category->slug)->exists()) {
            throw ValidationException::withMessages(['slug' => 'Category name has already been taken.']);
        }
    }
}

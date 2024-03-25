<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\UpsertCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function __construct(private readonly CategoryService $categoryService) {}

    public function index(): JsonResponse
    {
        $categories = Category::all();

        return response()->json(CategoryResource::collection($categories), Response::HTTP_OK);
    }

    public function store(UpsertCategoryRequest $request): JsonResponse
    {
        Gate::authorize('store', Category::class);

        $category = $this->categoryService->create($request->toArray());

        return response()->json(new CategoryResource($category), Response::HTTP_CREATED);
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json(new CategoryResource($category), Response::HTTP_OK);
    }

    public function update(UpsertCategoryRequest $request, Category $category): JsonResponse
    {
        Gate::authorize('update', $category);

        $category = $this->categoryService->update($request->toArray(), $category);

        return response()->json(new CategoryResource($category), Response::HTTP_OK);
    }

    public function destroy(Category $category): JsonResponse
    {
        Gate::authorize('delete', $category);

        $this->categoryService->delete($category);

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }
}

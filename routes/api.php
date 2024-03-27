<?php

declare(strict_types=1);

use App\Http\Controllers\API\v1\CategoryController;
use App\Http\Controllers\API\v1\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::resource('/categories', CategoryController::class)->only(['index', 'show']);
    Route::resource('/categories', CategoryController::class)->only(['store', 'update', 'destroy'])->middleware('auth');

    Route::resource('/posts', PostController::class)->only(['index', 'show']);
    Route::resource('/posts', PostController::class)->only(['store', 'update', 'destroy'])->middleware('auth');
});

Route::middleware(['auth:sanctum'])->get('/user', fn(Request $request) => $request->user());

<?php

declare(strict_types=1);

use App\Http\Controllers\API\v1\CategoryController;
use App\Http\Controllers\API\v1\CommentController;
use App\Http\Controllers\API\v1\CommentReplyController;
use App\Http\Controllers\API\v1\PostCommentController;
use App\Http\Controllers\API\v1\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::resource('/categories', CategoryController::class)->only(['index', 'show']);
    Route::resource('/categories', CategoryController::class)->only(['store', 'update', 'destroy'])->middleware('auth');

    Route::resource('/posts', PostController::class)->only(['index', 'show']);
    Route::resource('/posts', PostController::class)->only(['store', 'update', 'destroy'])->middleware('auth');


    Route::get('/posts/{post}/comments', [PostCommentController::class, 'index'])->name('posts.comments.index');
    Route::post('/posts/{post}/comments', [PostCommentController::class, 'store'])
        ->name('posts.comments.store')
        ->middleware('auth');

    Route::get('/comments/{comment}/replies', [CommentReplyController::class, 'index'])->name('comments.replies.index');
    Route::post('/comments/{comment}/replies', [CommentReplyController::class, 'store'])
        ->name('comments.replies.store')
        ->middleware('auth');
    Route::resource('/comments', CommentController::class)->only(['update', 'destroy']);
});

Route::middleware(['auth:sanctum'])->get('/user', fn(Request $request) => $request->user());

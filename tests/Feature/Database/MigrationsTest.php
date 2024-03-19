<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

uses(RefreshDatabase::class);

dataset('tables', [
    'users',
    'posts',
    'comments',
    'categories',
    'category_post'
]);

test('migrations are executed correctly', function (string $table): void {
    expect(Schema::hasTable($table))->toBe(true);
})->with('tables');

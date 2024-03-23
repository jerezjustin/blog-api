<?php

declare(strict_types=1);

use App\Enums\Role;
use App\Models\Category;

use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

test('can show all categories', function (): void {
    Category::factory(5)->create();

    $response = get('api/v1/categories');

    $response->assertOk();
});

test('can show a specific category', function (): void {
    $category = Category::factory()->create();

    $response = get('api/v1/categories/' . $category->getRouteKey());

    $response->assertOk()->assertJsonFragment([
        'id' => $category->id,
        'name' => $category->name,
        'slug' => $category->slug
    ]);
});

test('can create a new category', function (): void {
    $categoryData = Category::factory()->make();

    asAdmin()->post('api/v1/categories', [
        'name' => $categoryData->name
    ])->assertCreated();

    assertDatabaseHas('categories', $categoryData->toArray());
});

test('category name cannot exceed', function (): void {
    asAdmin()->post('api/v1/categories', [
        'name' => str()->random(100)
    ])->assertSessionHasErrors(['name']);
});

test('cannot create a category with an already taken name', function (): void {
    Category::create([
        'name' => $name = 'Test Category',
        'slug' => str($name)->slug()
    ]);

    actingAs(User::factory()->create([
        'role' => Role::Administrator
    ]));

    post('api/v1/categories', [
        'name' => $name
    ])->assertSessionHasErrors(['slug']);
});

test('can update a category', function (): void {
    $category = Category::factory()->create();

    asAdmin()->put('api/v1/categories/' . $category->getRouteKey(), [
        'name' => $updatedName = 'Updated Category Name'
    ])->assertOk();

    assertDatabaseHas('categories', ['name' => $updatedName]);
});

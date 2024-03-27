<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'unique:posts,slug'],
            'content' => ['required'],
            'is_draft' => ['boolean'],
            'user_id' => ['integer', 'exists:users,id'],
            'categories.*' => ['exists:categories,id'],
        ];
    }
}

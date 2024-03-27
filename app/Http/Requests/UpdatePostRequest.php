<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function rules(): array
    {
        $post = $this->route('post');

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'unique:posts,slug,' . $post->id],
            'content' => ['required'],
            'is_draft' => ['boolean'],
            'categories.*' => ['exists:categories,id'],
        ];
    }
}

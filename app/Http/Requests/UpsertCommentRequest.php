<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpsertCommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content' => ['required']
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Requests\API\v1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpsertCategoryRequest extends FormRequest
{
    public function rules(): ValidationRule|array
    {
        return [
            'name' => ['required', 'max:50']
        ];
    }
}

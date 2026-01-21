<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required','string','max:100'],
            'slug'        => [
                'required','string','max:120','regex:/^[a-z0-9-]+$/',
                Rule::unique('categories','slug')->ignore($this->route('category')),
            ],
            'description' => ['nullable','string','max:500'],
            'is_active'   => ['boolean'],
        ];
    }
}

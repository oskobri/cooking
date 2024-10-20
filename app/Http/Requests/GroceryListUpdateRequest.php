<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroceryListUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'serving_count' => ['sometimes', 'integer'],
            'recipes' => ['sometimes', 'array'],
            'recipes.*' => ['sometimes', 'exists:recipes,id'],
        ];
    }

    public function getInput(): array
    {
        return $this->safe(['name', 'serving_count']);
    }
}

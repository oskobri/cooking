<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroceryListRecipeUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'done' => ['required', 'boolean'],
        ];
    }
}

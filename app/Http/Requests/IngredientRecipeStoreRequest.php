<?php

namespace App\Http\Requests;

use App\Enums\IngredientUnit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IngredientRecipeStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'unit' => ['nullable', Rule::enum(IngredientUnit::class)],
            'quantity' => ['required', 'numeric']
        ];
    }
}

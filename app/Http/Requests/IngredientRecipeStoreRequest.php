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
            // TODO verify if ingredient is set or not
            'name' => ['nullable', 'string', 'max:191'],
            'unit' => ['nullable', Rule::enum(IngredientUnit::class)],
            'quantity' => ['required', 'numeric']
        ];
    }
}

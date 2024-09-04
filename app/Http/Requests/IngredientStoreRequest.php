<?php

namespace App\Http\Requests;

use App\Enums\IngredientUnit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IngredientStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'default_unit' => ['required', Rule::enum(IngredientUnit::class)],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroceryListStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'serving_count' => ['required', 'integer'],
            'recipes' => ['required', 'array'],
            'recipes.*' => ['required', 'exists:recipes,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['name' => $this->name ?? 'Liste de courses du ' . now()->translatedFormat('d F Y')]);
    }

    public function getInput(): array
    {
        return $this->safe(['name', 'serving_count']);
    }
}

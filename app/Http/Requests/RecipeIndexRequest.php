<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page' => ['nullable', 'integer'],
            'sort' => ['nullable', 'in:kcal,preparation_time,total_time,name'],
        ];
    }
}

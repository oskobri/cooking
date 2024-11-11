<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page' => ['nullable', 'integer'],
            'sort' => ['nullable', 'in:kcal,preparation_time,total_time,name,created_at'],
            'sort_direction' => ['nullable', 'in:asc,desc'],
            'search' => ['nullable', 'string'],
        ];
    }

    public function sort(): string
    {
        return $this->input('sort', 'created_at');
    }

    public function sortDirection(): string
    {
        return match ($this->input('sort', $this->sort())) {
            'created_at' => 'desc',
            default => 'asc',
        };
    }
}

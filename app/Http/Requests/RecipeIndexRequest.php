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
        ];
    }

    public function defaultSort(): string
    {
        return 'created_at';
    }

    public function defaultSortDirection(): string
    {
        return match($this->input('sort', $this->defaultSort())) {
            'created_at' => 'desc',
            default => 'asc',
        };
    }
}

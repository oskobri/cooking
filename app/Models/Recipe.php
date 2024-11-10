<?php

namespace App\Models;

use App\Enums\RecipeSource;
use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipe extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BelongsToUser;

    protected $guarded = [];

    protected $casts = [
        'source' => RecipeSource::class,
    ];

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class)
            ->withPivot(['quantity', 'unit'])
            ->orderBy('name');
    }

    public function scopeAccessible(Builder $query): Builder
    {
        return $query
            ->where('published', true)
            ->where(fn (Builder $query) => $query
                ->where('public', true)
                ->when(auth()->check(), fn (Builder $query) => $query
                    ->orWhereBelongsTo(auth()->user())
                )
            );
    }
}

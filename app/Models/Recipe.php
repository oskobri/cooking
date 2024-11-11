<?php

namespace App\Models;

use App\Enums\RecipeSource;
use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    public function ratings(): HasMany
    {
        return $this->hasMany(RecipeRating::class);
    }

    public function userRating(): HasOne
    {
        return $this->hasOne(RecipeRating::class)->whereBelongsTo(auth()->user());
    }

    public function usersWhoFavorited(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'recipe_favorites');
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

    public function scopeSearch(Builder $query, string $search = null): Builder
    {
        return $query->when($search, fn (Builder $query) => $query
            ->selectRaw(
                "(CASE
                    WHEN recipes.name = ? THEN 1
                    WHEN EXISTS (
                        SELECT 1
                        FROM ingredient_recipe
                        JOIN ingredients ON ingredients.id = ingredient_recipe.ingredient_id
                        WHERE ingredient_recipe.recipe_id = recipes.id
                          AND ingredients.name = ?
                    ) THEN 1
                    ELSE 0
                  END) as exact_match", [$search, $search]
            )
                ->where(fn (Builder $query) => $query
                    ->where('name', 'like', '%' . $search . '%')
                    ->orWhereHas('ingredients', fn (Builder $query) => $query
                        ->where('name', 'like', '%' . $search . '%')
                    )
                )
                ->orderByDesc('exact_match')
        );
    }
}

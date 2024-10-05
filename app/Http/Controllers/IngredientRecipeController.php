<?php

namespace App\Http\Controllers;

use App\Http\Requests\IngredientRecipeStoreRequest;
use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;

class IngredientRecipeController extends Controller
{
    public function store(IngredientRecipeStoreRequest $request, Recipe $recipe, ?Ingredient $ingredient = null): IngredientResource
    {
        if (!$ingredient) {
            $ingredient = Ingredient::query()
                ->where('name', $request->name)
                ->first() ??
                Ingredient::create([
                    'name' => $request->name,
                    'default_unit' => $request->unit,
                ]);
        }

        $recipe->ingredients()->attach($ingredient->id, $request->safe(['unit', 'quantity']));

        return IngredientResource::make($ingredient);
    }

    public function destroy(Ingredient $ingredient, Recipe $recipe): JsonResponse
    {
        $ingredient->recipes()->detach($recipe);

        return response()->json(null, 204);
    }
}

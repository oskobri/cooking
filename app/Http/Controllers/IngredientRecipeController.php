<?php

namespace App\Http\Controllers;

use App\Http\Requests\IngredientRecipeStoreRequest;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;

class IngredientRecipeController extends Controller
{
    public function store(IngredientRecipeStoreRequest $request, Ingredient $ingredient, Recipe $recipe): JsonResponse
    {
        $ingredient->recipes()->attach($recipe, $request->validated());

        return response()->json(null, 201);
    }

    public function destroy(Ingredient $ingredient, Recipe $recipe): JsonResponse
    {
        $ingredient->recipes()->detach($recipe);

        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroceryListRecipeUpdateRequest;
use App\Models\GroceryList;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class GroceryListRecipeController extends Controller
{
    public function update(GroceryListRecipeUpdateRequest $request, GroceryList $groceryList, Recipe $recipe): JsonResponse
    {
        Gate::authorize('update', $groceryList);

        $groceryList->recipes()->updateExistingPivot($recipe->getKey(), ['done' => $request->done]);

        return response()->json();
    }
}

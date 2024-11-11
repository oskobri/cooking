<?php

namespace App\Http\Controllers;

use App\Models\Recipe;

class RecipeFavoriteController extends Controller
{
    public function __invoke(Recipe $recipe)
    {
        auth()->user()->favoriteRecipes()->toggle($recipe->id);

        return response()->json();
    }
}

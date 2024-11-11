<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeRatingRequest;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;

class RecipeRatingController extends Controller
{
    public function rate(RecipeRatingRequest $request, Recipe $recipe): JsonResponse
    {
        $recipe->ratings()->updateOrCreate(
            ['user_id' => $request->user()->getKey()],
            $request->safe(['rating'])
        );

        return response()->json();
    }
}

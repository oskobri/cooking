<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;

class RecipeGuestController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        // Todo define what recipes we want to return
        $recipes = Recipe::query()
            ->where('published', true)
            ->where('public', true)
            ->select(['id', 'name', 'picture', 'preparation_time', 'total_time', 'kcal'])
            ->with(['ingredients'])
            ->paginate();

        return RecipeResource::collection($recipes);
    }



    public function show(Recipe $recipe): RecipeResource
    {
        Gate::authorize('view', $recipe);

        $recipe->load(['ingredients']);

        return RecipeResource::make($recipe);
    }
}

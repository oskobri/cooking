<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeIndexRequest;
use App\Http\Requests\RecipeStoreRequest;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;

class RecipeController extends Controller
{
    public function index(RecipeIndexRequest $request): AnonymousResourceCollection
    {
        $recipes = Recipe::query()
            ->accessible()
            ->select(['id', 'name', 'picture', 'preparation_time', 'total_time', 'kcal', 'public', 'published'])
            ->with(['ingredients', 'userRating'])
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->orderBy(
                $request->input('sort', $request->defaultSort()),
                $request->input('sort_direction', $request->defaultSortDirection())
            )
            ->paginate();

        return RecipeResource::collection($recipes);
    }

    public function show(Recipe $recipe): RecipeResource
    {
        Gate::authorize('view', $recipe);

        $recipe->load(['ingredients']);

        return RecipeResource::make($recipe);
    }

    public function store(RecipeStoreRequest $request): RecipeResource
    {
        $recipe = Recipe::create($request->validated());

        return RecipeResource::make($recipe);
    }

    public function update(RecipeStoreRequest $request, Recipe $recipe): RecipeResource
    {
        Gate::authorize('update', $recipe);

        $recipe->update($request->validated());

        return RecipeResource::make($recipe);
    }

    public function destroy(Recipe $recipe): JsonResponse
    {
        Gate::authorize('delete', $recipe);

        $recipe->delete();

        return response()->json(null, 204);
    }
}

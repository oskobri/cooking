<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeIndexRequest;
use App\Http\Requests\RecipeStoreRequest;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RecipeController extends Controller
{
    public function index(RecipeIndexRequest $request): AnonymousResourceCollection
    {
        $recipes = Recipe::query()
            ->select(['id', 'name', 'picture', 'preparation_time', 'total_time', 'kcal'])
            ->with(['ingredients'])
            ->orderBy($request->input('sort', 'id'))
            ->paginate();

        return RecipeResource::collection($recipes);
    }

    public function show(Recipe $recipe): RecipeResource
    {
        $recipe->load(['ingredients']);

        return RecipeResource::make($recipe);
    }

    public function store(RecipeStoreRequest $request): RecipeResource
    {
        $recipe = Recipe::create($request->validated());

        return RecipeResource::make($recipe);
    }

    public function update(RecipeStoreRequest $request, Recipe $recipe)
    {
        $recipe->update($request->validated());

        return RecipeResource::make($recipe);
    }

    public function destroy(Recipe $recipe): JsonResponse
    {
        $recipe->delete();

        return response()->json(null, 204);
    }
}

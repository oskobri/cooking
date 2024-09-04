<?php

namespace App\Http\Controllers;

use App\Http\Requests\IngredientStoreRequest;
use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IngredientController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $ingredients = Ingredient::query()
            ->paginate();

        return IngredientResource::collection($ingredients);
    }

    public function store(IngredientStoreRequest $request): IngredientResource
    {
        $ingredient = Ingredient::create($request->validated());

        return IngredientResource::make($ingredient);
    }

    public function show(Ingredient $ingredient): IngredientResource
    {
        return IngredientResource::make($ingredient);
    }

    public function update(IngredientStoreRequest $request, Ingredient $ingredient)
    {
        $ingredient->update($request->validated());

        return IngredientResource::make($ingredient);
    }

    public function destroy(Ingredient $ingredient): JsonResponse
    {
        $ingredient->delete();

        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroceryListStoreRequest;
use App\Http\Requests\GroceryListUpdateRequest;
use App\Http\Resources\GroceryListResource;
use App\Models\GroceryList;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class GroceryListController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $groceryLists = GroceryList::query()
            ->forMe()
            ->with(['recipes:id,name,picture,preparation_time,total_time,kcal'])
            ->latest()
            ->paginate();

        return GroceryListResource::collection($groceryLists);
    }

    public function last(): GroceryListResource
    {
        return GroceryListResource::make(
            GroceryList::query()
                ->forMe()
                ->latest()
                ->firstOrFail()
        );
    }

    public function show(GroceryList $groceryList): GroceryListResource
    {
        Gate::authorize('view', $groceryList);

        return GroceryListResource::make($groceryList->load('recipes.ingredients'));
    }

    public function store(GroceryListStoreRequest $request): GroceryListResource
    {
        $groceryList = $request->user()->groceryLists()->create($request->getInput());

        $groceryList->recipes()->sync($request->recipes);

        return GroceryListResource::make($groceryList);
    }

    public function update(GroceryListUpdateRequest $request, GroceryList $groceryList): GroceryListResource
    {
        Gate::authorize('update', $groceryList);

        $groceryList->update($request->getInput());

        if ($request->recipes) {
            $groceryList->recipes()->sync($request->recipes);
        }

        return GroceryListResource::make($groceryList->refresh()->load('recipes'));
    }

    public function destroy(GroceryList $groceryList): Response
    {
        Gate::authorize('delete', $groceryList);

        $groceryList->delete();

        return response()->noContent();
    }
}

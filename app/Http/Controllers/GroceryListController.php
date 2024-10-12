<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroceryListStoreRequest;
use App\Http\Requests\GroceryListUpdateRequest;
use App\Http\Resources\GroceryListResource;
use App\Models\GroceryList;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class GroceryListController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $groceryLists = GroceryList::query()
            ->with([
                'recipes:id,name,picture,preparation_time,total_time,kcal'
            ])
            ->latest()
            ->paginate();

        return GroceryListResource::collection($groceryLists);
    }

    public function store(GroceryListStoreRequest $request): GroceryListResource
    {
        $groceryList = GroceryList::query()->create($request->validated());

        return GroceryListResource::make($groceryList);
    }

    public function show(GroceryList $groceryList): GroceryListResource
    {
        return GroceryListResource::make($groceryList);
    }

    public function update(GroceryListUpdateRequest $request, GroceryList $groceryList): GroceryListResource
    {
        $groceryList->update($request->validated());

        return GroceryListResource::make($groceryList->refresh());
    }

    public function destroy(GroceryList $groceryList): Response
    {
        $groceryList->delete();

        return response()->noContent();
    }
}

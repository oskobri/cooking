<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroceryListStoreRequest;
use App\Http\Requests\GroceryListUpdateRequest;
use App\Http\Resources\GroceryListResource;
use App\Models\GroceryList;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Throwable;

class GroceryListController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $groceryLists = auth()->user()
            ->groceryLists()
            ->with([
                'recipes' => fn ($query) => $query
                    ->select('recipes.id', 'name', 'picture', 'preparation_time', 'total_time', 'kcal')
                    ->orderByPivot('done')
            ])
            ->latest()
            ->paginate();

        return GroceryListResource::collection($groceryLists);
    }

    /**
     * @throws Throwable
     */
    public function last(): GroceryListResource
    {
        throw_if(is_null(auth()->user()->latestGroceryList), ModelNotFoundException::class);

        return GroceryListResource::make(
            auth()->user()->latestGroceryList
        );
    }

    public function show(GroceryList $groceryList): GroceryListResource
    {
        Gate::authorize('view', $groceryList);

        $groceryList
            ->load([
                'recipes' => fn ($query) => $query
                    ->select('recipes.id', 'name', 'picture', 'preparation_time', 'total_time', 'kcal')
                    ->orderByPivot('done'),
                'recipes.ingredients'
            ]);

        return GroceryListResource::make($groceryList);
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

<?php

namespace App\Http\Resources;

use App\Models\GroceryList;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin GroceryList
 */
class GroceryListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getKey(),
            'name' => $this->name,
            'servingCount' => $this->serving_count,
            'recipes' => RecipeResource::collection($this->whenLoaded('recipes')),
            'recipeUpdatedAt' => $this->recipe_updated_at,
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Ingredient
 */
class IngredientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getKey(),
            'name' => $this->name,
            'defaultUnit' => $this->default_unit,
            $this->mergeWhen($this->hasPivotLoaded('ingredient_recipe'), fn () => [
                'quantity' => $this->pivot->quantity == 0 ? null : $this->pivot->quantity,
                'unit' => $this->default_unit ?? $this->pivot->unit
            ])
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class RecipeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getKey(),
            'name' => $this->name,
            'picture' => Storage::disk('public')->url('images/recipes/' . $this->picture),
            'url' => $this->url,
            'source' => $this->source,
            'ingredients' => IngredientResource::collection($this->whenLoaded('ingredients'))
        ];
    }
}

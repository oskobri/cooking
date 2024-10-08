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
            'preparationTime' => $this->preparation_time,
            'totalTime' => $this->total_time,
            'kcal' => $this->kcal,
            'instructions' => $this->when($this->instructions, nl2br($this->instructions)),
            'ingredients' => IngredientResource::collection($this->whenLoaded('ingredients'))
        ];
    }
}

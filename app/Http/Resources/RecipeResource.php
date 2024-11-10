<?php

namespace App\Http\Resources;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin Recipe
 */
class RecipeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getKey(),
            'name' => $this->name,
            'public' => $this->when($this->public, $this->public),
            'published' => $this->when($this->published, $this->published),
            'picture' => $this->when($this->picture, Storage::disk('public')->url($this->picture)),
            'url' => $this->when($this->url, $this->url),
            'source' => $this->when($this->source, $this->source),
            'preparationTime' => $this->when($this->preparation_time, $this->preparation_time),
            'totalTime' => $this->when($this->total_time, $this->total_time),
            'kcal' => $this->when($this->kcal, $this->kcal),
            'rating' => $this->whenLoaded('userRating', fn () => $this->userRating->rating),
            'avgRating' => $this->when('ratings_avg_rating', $this->ratings_avg_rating),
            'ratingsCount' => $this->whenCounted('ratings', $this->ratings_count),
            'instructions' => $this->when($this->instructions, nl2br($this->instructions)),
            'ingredients' => IngredientResource::collection($this->whenLoaded('ingredients')),
        ];
    }
}

<?php

namespace App\Jobs;

use App\Enums\IngredientUnit;
use App\Enums\RecipeSource;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Services\Ai\RecipeAi;
use App\Services\DownloadImageFromUrl;
use App\Services\Spiders\GenericBodySpider;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use RoachPHP\Roach;
use RoachPHP\Spider\Configuration\Overrides;

class ImportRecipeFromUrl implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly string $url) {}

    public function handle(): void
    {
        if (Recipe::query()->where(['url' => $this->url])->exists()) {
            return;
        }

        $body = $this->getBodyFromUrl();

        if (!$body) {
            return;
        }

        $recipeData = RecipeAi::getRecipeFromBody($body);

        if (!$recipeData) {
            return;
        }

        Log::info('Recette :' . $this->url, $recipeData);

        $recipe = Recipe::query()->firstOrCreate(
            [
                'url' => $this->url,
                'source' => RecipeSource::fromUrl($this->url)
            ],
            [
                'name' => $recipeData['name'],
                'preparation_time' => $recipeData['preparation_time'],
                'total_time' => $recipeData['total_time'],
                'kcal' => $recipeData['kcal'],
                'instructions' => $recipeData['instructions'] ? implode("\n\n", array_column($recipeData['instructions'], 'details')) : null,
            ],
        );

        if (!$recipe->wasRecentlyCreated) {
            return;
        }

        if ($recipeData['picture_url']) {
            $fileName = (new DownloadImageFromUrl)(
                'images/recipes/',
                'recipe-' . $recipe->getkey(),
                $recipeData['picture_url']
            );
            $recipe->update([
                'picture' => "images/recipes/$fileName"
            ]);
        }

        $ingredients = [];

        foreach (['ingredients', 'additional_ingredients'] as $ingredientKey) {
            foreach ($recipeData[$ingredientKey] as $ingredientData) {
                $ingredient = Ingredient::query()
                    ->firstOrCreate(
                        ['name' => $ingredientData['name']],
                        ['default_unit' => IngredientUnit::findFromExternalUnit($ingredientData['unit'])]
                    );
                $ingredients[$ingredient->id] = [
                    'quantity' => $this->extractNumber($ingredientData['quantity']),
                    'unit' => IngredientUnit::findFromExternalUnit($ingredientData['unit']),
                ];
            }
        }
        $recipe->ingredients()->attach($ingredients);
    }

    private function getBodyFromUrl(): ?string
    {
        $items = Roach::collectSpider(
            GenericBodySpider::class,
            new Overrides(startUrls: [$this->url]),
        );

        return $items[0]->get('body');
    }

    private function extractNumber($input): ?float
    {
        $replacements = [
            '½' => '1/2',
            '⅓' => '1/3',
            '¼' => '1/4',
            '¾' => '3/4',
            '⅔' => '2/3',
        ];

        $input = str_replace(array_keys($replacements), array_values($replacements), $input);

        // Keep only number, comma and /
        $result = preg_replace('/[^0-9,.-\/]/', '', $input);

        // Check if it's a fraction
        if (preg_match('/(\d+)\/(\d+)/', $result, $matches)) {
            $numerator = (float) $matches[1];
            $denominator = (float) $matches[2];
            $result = str_replace($matches[0], $numerator / $denominator, $result);
        }

        $result = str_replace(',', '.', $result);

        return $result !== '0' ? round((float) $result, 2) : null;
    }
}

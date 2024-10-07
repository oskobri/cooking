<?php

namespace App\Jobs;

use App\Enums\IngredientUnit;
use App\Enums\RecipeSource;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Services\Ai\OpenAi;
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

    public function __construct(private readonly string $url)
    {
    }

    public function handle(): void
    {
        $body = $this->getBodyFromUrl();

        if (!$body) {
            return;
        }

        $recipeData = $this->getRecipeFromBody($body);

        if (!$recipeData) {
            return;
        }

        Log::info('Recette :' . $this->url, $recipeData);

        $recipe = Recipe::query()->firstOrCreate(
            [
                'name' => $recipeData['name'],
                'url' => $this->url,
                'source' => RecipeSource::fromUrl($this->url)
            ],
        );

        if (!$recipe->wasRecentlyCreated) {
            return;
        }

        if ($recipeData['picture_url']) {
            $recipe->update([
                'picture' => (new DownloadImageFromUrl)(
                    'images/recipes/',
                    'recipe-' . $recipe->getkey(),
                    $recipeData['picture_url']
                )
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

    private function getRecipeFromBody(string $body): ?array
    {
        $ai = (new OpenAi);
        $ai->additionalParameters = $this->openAiResponseFormat();

        $response = $ai->chat("Analyse ce document html. Récupère le nom et l'image de la recette, tous les ingrédients que tu trouves dans le html ainsi que les instructions. Il est possible qu'il y ait des ingrédients supplémentaires comme poivre, sel, vinaigre, huile d'olive, ...Des ingrédients qu'on pourrait avoir chez soi, je les veux aussi dans la liste des ingrédients supplémentaires. Voici le html: $body");

        return $response ? json_decode($response, true) : null;
    }

    private function openAiResponseFormat(): array
    {
        return [
            'response_format' => [
                'type' => 'json_schema',
                'json_schema' => [
                    'name' => 'recipe',
                    'strict' => true,
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'name' => [
                                'type' => 'string',
                            ],
                            'picture_url' => [
                                'type' => 'string',
                            ],
                            'ingredients' => [
                                'type' => 'array',
                                'items' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'name' => [
                                            'type' => 'string',
                                        ],
                                        'quantity' => [
                                            'type' => 'string',
                                        ],
                                        'unit' => [
                                            'type' => 'string',
                                        ],
                                    ],
                                    'required' => [
                                        'name',
                                        'quantity',
                                        'unit',
                                    ],
                                    'additionalProperties' => false,
                                ],
                            ],
                            'additional_ingredients' => [
                                'type' => 'array',
                                'items' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'name' => [
                                            'type' => 'string',
                                        ],
                                        'quantity' => [
                                            'type' => 'string',
                                        ],
                                        'unit' => [
                                            'type' => 'string',
                                        ],
                                    ],
                                    'required' => [
                                        'name',
                                        'quantity',
                                        'unit',
                                    ],
                                    'additionalProperties' => false,
                                ],
                            ],
                            'instructions' => [
                                'type' => 'array',
                                'items' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'details' => [
                                            'type' => 'string',
                                        ],
                                    ],
                                    'required' => [
                                        'details',
                                    ],
                                    'additionalProperties' => false,
                                ],
                            ],
                            'total_time' => [
                                'type' => 'string',
                            ],
                            'preparation_time' => [
                                'type' => 'string',
                            ]
                        ],
                        'required' => [
                            'name',
                            'picture_url',
                            'ingredients',
                            'additional_ingredients',
                            'instructions',
                            'total_time',
                            'preparation_time',
                        ],
                        'additionalProperties' => false,
                    ],
                ],
            ]
        ];
    }

    /**
     * TODO move to helpers or other
     */
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

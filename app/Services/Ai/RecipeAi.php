<?php

namespace App\Services\Ai;

use App\Enums\IngredientUnit;

class RecipeAi
{
    /**
     * Sends OpenAi the html content of a website to be analysed and formatted in json format
     */
    public static function getRecipeFromBody(string $body): ?array
    {
        $ai = (new OpenAi);
        $ai->additionalParameters = static::openAiResponseFormat();

        $response = $ai->chat("Analyse ce document html: $body");

        return $response ? json_decode($response, true) : null;
    }


    public static function openAiResponseFormat(): array
    {
        $ingredientUnits = static::getIngredientUnits();
        $enums = IngredientUnit::values();

        return [
            "response_format" => [
                "type" => "json_schema",
                "json_schema" => [
                    "name" => "recipe",
                    "strict" => true,
                    "schema" => [
                        "type" => "object",
                        "properties" => [
                            "name" => [
                                "type" => "string",
                                "description" => "Le nom de la recette"
                            ],
                            "picture_url" => [
                                "type" => "string",
                                "description" => "L'url de l'image de la recette"
                            ],
                            "kcal" => [
                                "type" => "number",
                                "description" => "Le nombre de kcal par portion"
                            ],
                            "ingredients" => [
                                "type" => "array",
                                "items" => static::ingredientItemsStructure($ingredientUnits, $enums),
                            ],
                            "additional_ingredients" => [
                                "type" => "array",
                                "description" => "Liste des ingrédients supplémentaires comme poivre, sel, vinaigre, huile d'olive, ...Des ingrédients qu'on pourrait avoir chez soi",
                                "items" => static::ingredientItemsStructure($ingredientUnits, $enums),
                            ],
                            "total_time" => [
                                "type" => "number",
                                "description" => "Temps total en minutes",
                            ],
                            "preparation_time" => [
                                "type" => "number",
                                "description" => "Temps de préparation en minutes",
                            ],
                            "instructions" => [
                                "type" => "array",
                                "items" => [
                                    "type" => "object",
                                    "properties" => [
                                        "details" => [
                                            "type" => "string",
                                        ],
                                    ],
                                    "required" => [
                                        "details",
                                    ],
                                    "additionalProperties" => false,
                                ],
                            ],
                        ],
                        "required" => [
                            "name",
                            "picture_url",
                            "ingredients",
                            "additional_ingredients",
                            "instructions",
                            "total_time",
                            "preparation_time",
                            "kcal"
                        ],
                        "additionalProperties" => false,
                    ],
                ],
            ]
        ];
    }

    private static function ingredientItemsStructure(string $ingredientUnits, array $enums): array
    {
        return [
            "type" => "object",
            "properties" => [
                "name" => [
                    "type" => "string",
                ],
                "quantity" => [
                    "type" => "number",
                    "description" => "Si tu as des fractions (1/2, ⅓, 2/3, ...) transforme les en float."
                ],
                "unit" => [
                    "type" => ["string", "null"],
                    "description" => "L'unité de mesure de la quantité. $ingredientUnits",
                    "enums" => $enums,
                ],
            ],
            "required" => [
                "name",
                "quantity",
                "unit",
            ],
            "additionalProperties" => false,
        ];
    }

    private static function getIngredientUnits(): string
    {
        $ingredientUnits = IngredientUnit::labels();

        return implode(", ", array_map(
                static fn ($value, $key) => "$value: $key",
                $ingredientUnits,
                array_keys($ingredientUnits))
        );
    }
}

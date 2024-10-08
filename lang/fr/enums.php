<?php

use App\Enums\IngredientUnit;
use App\Models\Ingredient;

return [
    IngredientUnit::class => [
        IngredientUnit::Soup_spoon->value => "cuillère à soupe",
        IngredientUnit::Coffee_spoon->value => "cuillère à café",
        IngredientUnit::Ml->value => "ml",
        IngredientUnit::Cl->value => "cl",
        IngredientUnit::Dl->value => "dl",
        IngredientUnit::L->value => "litre",
        IngredientUnit::g->value => "g",
        IngredientUnit::Kg->value => "kg",
        IngredientUnit::Botte->value => "botte",
    ]
];

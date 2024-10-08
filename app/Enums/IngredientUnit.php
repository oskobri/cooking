<?php

namespace App\Enums;

enum IngredientUnit: string
{
    use Enumerable;

    case Soup_spoon = 'cs';
    case Coffee_spoon = 'cc';
    case Ml = 'ml';
    case Cl = 'cl';
    case Dl = 'dl';
    case L = 'l';
    case g = 'g';
    case Kg = 'kg';
    case Botte = 'botte';

    public static function findFromExternalUnit(?string $externalUnit = null): ?IngredientUnit
    {
        foreach(self::cases() as $case) {
            if(strtolower(trim($case->value)) === strtolower($externalUnit)) {
                return $case;
            }
        }

        return null;
    }
}

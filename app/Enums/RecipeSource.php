<?php

namespace App\Enums;

enum RecipeSource: string
{
    case HelloFresh = 'hellofresh';

    public static function fromUrl(string $url): ?RecipeSource
    {
        $parsedUrl = parse_url($url);

        foreach(self::cases() as $case) {
            if (str_contains($parsedUrl['host'], $case->value)) {
                return $case;
            }
        }

        return null;
    }
}

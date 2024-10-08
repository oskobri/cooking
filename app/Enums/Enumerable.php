<?php

namespace App\Enums;

trait Enumerable
{
    public static function labels(): array
    {
        return __('enums.' . static::class);
    }

    public static function values(): array
    {
        return array_map(static fn($case) => $case->value, static::cases());
    }
}

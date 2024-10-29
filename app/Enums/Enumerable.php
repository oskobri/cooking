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

    public static function toArray(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_column(self::cases(), 'value')
        );
    }
}

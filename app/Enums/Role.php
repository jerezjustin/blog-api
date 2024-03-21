<?php

declare(strict_types=1);

namespace App\Enums;

enum Role: string
{
    case Administrator = 'administrator';

    case User = 'user';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

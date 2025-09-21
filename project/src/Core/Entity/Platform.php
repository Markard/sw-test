<?php

declare(strict_types=1);

namespace App\Core\Entity;

enum Platform: string
{
    case Ios = 'ios';
    case Android = 'android';

    // it's a workaround to a bug of the SF denormalizer - http://github.com/symfony/symfony/issues/52705
    public static function values(): array
    {
        return array_merge(array_column(self::cases(), 'value'));
    }
}

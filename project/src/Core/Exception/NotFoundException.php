<?php

declare(strict_types=1);

namespace App\Core\Exception;

use RuntimeException;

final class NotFoundException extends RuntimeException
{
    public function __construct(string $configType)
    {
        parent::__construct("{$configType} not found");
    }
}
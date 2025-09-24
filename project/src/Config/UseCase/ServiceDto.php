<?php

declare(strict_types=1);

namespace App\Config\UseCase;

final readonly class ServiceDto
{
    public function __construct(private(set) string $url)
    {
    }
}
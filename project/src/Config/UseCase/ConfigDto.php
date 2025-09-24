<?php
declare(strict_types=1);

namespace App\Config\UseCase;

final readonly class ConfigDto
{
    public function __construct(private(set) ServiceDto $backend, private(set) ServiceDto $notifications)
    {
    }
}
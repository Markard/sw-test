<?php
declare(strict_types=1);

namespace App\Config\UseCase;

use App\Core\Entity\Asset;

final readonly class ConfigDto
{
    public function __construct(
        private(set) ServiceDto $backend,
        private(set) ServiceDto $notifications,
        private(set) AssetDto $assetDto,
        private(set) DefinitionDto $definitionDto,
    ) {
    }
}
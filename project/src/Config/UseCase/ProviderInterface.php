<?php

declare(strict_types=1);

namespace App\Config\UseCase;

use App\Core\Entity\Platform;

interface ProviderInterface
{
    public function getConfig(
        SemVer $appVersion,
        Platform $platform,
        ?SemVer $assetsVersion,
        ?SemVer $definitionVersion,
    ): ConfigDto;
}
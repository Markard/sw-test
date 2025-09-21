<?php

declare(strict_types=1);

namespace App\Core\Fixture;

use App\Core\Entity\Platform;

final readonly class ResultFixture
{
    public function __construct(
        private(set) Platform $platform,
        private(set) string $hash,
        private(set) int $majorVersion,
        private(set) int $minorVersion,
        private(set) int $patchVersion,
    ) {
    }
}
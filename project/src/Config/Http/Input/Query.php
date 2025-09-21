<?php

declare(strict_types=1);

namespace App\Config\Http\Input;

use App\Core\Entity\Platform;
use Symfony\Component\Validator\Constraints as Assert;

final class Query
{
    public function __construct(
        public $appVersion,
        #[Assert\NotNull]
        #[Assert\Choice(callback: [Platform::class, 'values'])]
        public $platform,
        public $assetsVersion,
        public $definitionsVersion,
    ) {
    }
}
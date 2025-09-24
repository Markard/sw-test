<?php

declare(strict_types=1);

namespace App\Config\Http\Input;

use App\Core\Entity\Platform;
use Symfony\Component\Validator\Constraints as Assert;

final class Query
{
    public function __construct(
        #[Assert\NotBlank]
        public string $appVersion,
        #[Assert\NotBlank]
        #[Assert\Choice(callback: [Platform::class, 'values'])]
        public string $platform,
        public $assetsVersion,
        public string $definitionsVersion,
    ) {
    }
}
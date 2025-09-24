<?php

declare(strict_types=1);

namespace App\Config\UseCase;

use App\Core\Entity\Asset;
use App\Core\Entity\AssetUrl;

final readonly class AssetDto
{
    private(set) string $version;
    private(set) string $hash;
    private(set) array $urls;

    public function __construct(Asset $asset, AssetUrl ...$assetUrls)
    {
        $this->version = $asset->getVersionAsString();
        $this->hash = $asset->hash;
        $this->urls = array_map(fn(AssetUrl $a) => $a->url, $assetUrls);
    }
}
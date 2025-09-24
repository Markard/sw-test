<?php

declare(strict_types=1);

namespace App\Config\UseCase;

use App\Core\Entity\Definition;
use App\Core\Entity\DefinitionUrl;

final readonly class DefinitionDto
{
    private(set) string $version;
    private(set) string $hash;
    private(set) array $urls;

    public function __construct(Definition $definition, DefinitionUrl ...$definitionUrls)
    {
        $this->version = $definition->getVersionAsString();
        $this->hash = $definition->hash;
        $this->urls = array_map(fn(DefinitionUrl $a) => $a->url, $definitionUrls);
    }
}
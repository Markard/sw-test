<?php

declare(strict_types=1);

namespace App\Core\Entity;

use App\Core\Infrastructure\Doctrine\Timestampable\HasCreatedAtTimestamp;
use App\Core\Repository\DefinitionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: DefinitionRepository::class)]
#[ORM\Table(name: 'definition')]
#[ORM\Index(name: 'idx__definition__major__minor__patch', columns: ['major_version', 'minor_version', 'patch_version'])]
final class Definition
{
    use HasCreatedAtTimestamp;

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: Types::BIGINT, nullable: false)]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private(set) int $id;

    public function __construct(
        #[ORM\Column(name: 'platform', type: Types::STRING, nullable: false, enumType: Platform::class)]
        private(set) readonly Platform $platform,
        #[ORM\Column(name: 'major_version', type: Types::INTEGER, nullable: false)]
        private(set) readonly int $majorVersion,
        #[ORM\Column(name: 'minor_version', type: Types::INTEGER, nullable: false)]
        private(set) readonly int $minorVersion,
        #[ORM\Column(name: 'patch_version', type: Types::INTEGER, nullable: false)]
        private(set) readonly int $patchVersion,
        #[ORM\Column(name: 'hash', type: Types::STRING, nullable: false)]
        private(set) readonly string $hash,
    ) {
    }

    public function getVersionAsString(): string
    {
        return implode('.', [$this->majorVersion, $this->minorVersion, $this->patchVersion]);
    }
}
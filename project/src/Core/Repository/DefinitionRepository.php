<?php

declare(strict_types=1);

namespace App\Core\Repository;

use App\Config\UseCase\SemVer;
use App\Core\Entity\Definition;
use App\Core\Entity\Platform;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DefinitionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Definition::class);
    }

    public function getByVersion(Platform $platform, SemVer $appVersion, ?SemVer $definitionVersion): ?Definition
    {
        if ($definitionVersion !== null) {
            return $this->findOneBy([
                'platform' => $platform->value,
                'majorVersion' => $definitionVersion->major,
                'minorVersion' => $definitionVersion->minor,
                'patchVersion' => $definitionVersion->patch,
            ]);
        }

        return $this->findOneBy([
            'majorVersion' => $appVersion->major,
            'minorVersion' => $appVersion->minor,
        ], ['patchVersion' => 'desc']);
    }
}
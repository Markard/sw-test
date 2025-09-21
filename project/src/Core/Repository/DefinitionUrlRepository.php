<?php

declare(strict_types=1);

namespace App\Core\Repository;

use App\Core\Entity\DefinitionUrl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DefinitionUrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DefinitionUrl::class);
    }
}
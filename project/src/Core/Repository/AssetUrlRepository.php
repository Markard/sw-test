<?php
declare(strict_types=1);

namespace App\Core\Repository;

use App\Core\Entity\AssetUrl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class AssetUrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssetUrl::class);
    }
}
<?php
declare(strict_types=1);

namespace App\Core\Repository;

use App\Core\Entity\ServiceUrl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ServiceUrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceUrl::class);
    }
}
<?php
declare(strict_types=1);

namespace App\Core\Repository;

use App\Config\UseCase\ServiceUrlRepositoryInterface;
use App\Core\Entity\Service;
use App\Core\Entity\ServiceUrl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ServiceUrlRepository extends ServiceEntityRepository implements ServiceUrlRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceUrl::class);
    }

    public function findServiceUrl(Service $service): ServiceUrl
    {
        return $this->findOneBy(['service' => $service->value]);
    }
}
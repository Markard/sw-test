<?php

declare(strict_types=1);

namespace App\Core\Entity;

use App\Core\Infrastructure\Doctrine\Timestampable\Timestampable;
use App\Core\Repository\ServiceUrlRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceUrlRepository::class)]
#[ORM\Table(name: 'service_url')]
final class ServiceUrl
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: Types::BIGINT, nullable: false)]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private(set) int $id;

    #[ORM\Column(name: 'url', type: Types::STRING, nullable: false)]
    private(set) string $url;

    #[ORM\Column(name: 'service', type: Types::STRING, unique: true, nullable: false, enumType: Service::class)]
    private string $service;

    public function getService(): Service
    {
        return Service::from($this->service);
    }
}
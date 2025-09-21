<?php

declare(strict_types=1);

namespace App\Core\Entity;

use App\Core\Infrastructure\Doctrine\Timestampable\Timestampable;
use App\Core\Repository\AssetUrlRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssetUrlRepository::class)]
#[ORM\Table(name: 'asset_url')]
final class AssetUrl
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: Types::INTEGER, nullable: false)]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private(set) int $id;

    #[ORM\Column(name: 'url', type: Types::STRING, nullable: false)]
    private(set) string $url;
}
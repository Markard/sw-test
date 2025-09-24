<?php
declare(strict_types=1);

namespace App\Core\Repository;

use App\Config\UseCase\SemVer;
use App\Core\Entity\Asset;
use App\Core\Entity\Platform;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class AssetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Asset::class);
    }

    public function getByVersion(Platform $platform, SemVer $appVersion, ?SemVer $assetsVersion): ?Asset
    {
        if ($assetsVersion !== null) {
            return $this->findOneBy([
                'platform' => $platform->value,
                'majorVersion' => $assetsVersion->major,
                'minorVersion' => $assetsVersion->minor,
                'patchVersion' => $assetsVersion->patch,
            ]);
        }

        return $this->findOneBy(['majorVersion' => $appVersion->major], [
            'minorVersion' => 'desc',
            'patchVersion' => 'desc',
        ]);
    }
}
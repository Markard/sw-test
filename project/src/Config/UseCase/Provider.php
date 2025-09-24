<?php
declare(strict_types=1);

namespace App\Config\UseCase;

use App\Core\Entity\Platform;
use App\Core\Entity\Service;
use App\Core\Exception\NotFoundException;
use App\Core\Repository\AssetRepository;
use App\Core\Repository\AssetUrlRepository;
use App\Core\Repository\DefinitionRepository;
use App\Core\Repository\DefinitionUrlRepository;

final readonly class Provider
{
    public function __construct(
        private ServiceUrlRepositoryInterface $serviceUrlRepo,
        private AssetRepository $assetRepo,
        private DefinitionRepository $definitionRepo,
        private AssetUrlRepository $assetUrlRepo,
        private DefinitionUrlRepository $definitionUrlRepo,
    ) {
    }

    public function getConfig(
        SemVer $appVersion,
        Platform $platform,
        ?SemVer $assetsVersion,
        ?SemVer $definitionVersion,
    ): ConfigDto {
        $asset = $this->assetRepo->getByVersion($platform, $appVersion, $assetsVersion);
        if (!$asset) {
            throw new NotFoundException('Asset');
        }

        $definition = $this->definitionRepo->getByVersion($platform, $appVersion, $definitionVersion);
        if (!$definition) {
            throw new NotFoundException('Definition');
        }

        $assetUrls = $this->assetUrlRepo->findAll();
        $definitionUrls = $this->definitionUrlRepo->findAll();

        $backendServiceUrl = $this->serviceUrlRepo->findServiceUrl(Service::BackendEntryPoint);
        $notificationsServiceUrl = $this->serviceUrlRepo->findServiceUrl(Service::Notifications);

        return new ConfigDto(
            backend: new ServiceDto($backendServiceUrl->url),
            notifications: new ServiceDto($notificationsServiceUrl->url),
            assetDto: new AssetDto($asset, ...$assetUrls),
            definitionDto: new DefinitionDto($definition, ...$definitionUrls),
        );
    }
}
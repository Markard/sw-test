<?php
declare(strict_types=1);

namespace App\Config\UseCase;

use App\Core\Entity\Platform;
use App\Core\Entity\Service;

final readonly class Provider
{
    public function __construct(private ServiceUrlRepositoryInterface $serviceUrlRepo)
    {
    }

    public function getConfig(
        SemVer $appVersion,
        Platform $platform,
        ?SemVer $assetsVersion,
        ?SemVer $definitionVersion,
    ): ConfigDto {
        $backendServiceUrl = $this->serviceUrlRepo->findServiceUrl(Service::BackendEntryPoint);
        $notificationsServiceUrl = $this->serviceUrlRepo->findServiceUrl(Service::Notifications);

        return new ConfigDto(
            backend: new ServiceDto($backendServiceUrl->url),
            notifications: new ServiceDto($notificationsServiceUrl->url)
        );
    }
}
<?php

declare(strict_types=1);

namespace App\Config\UseCase;

use App\Core\Entity\Platform;
use Redis;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class CacheableProvider implements ProviderInterface
{
    const int TTL_IN_SECONDS = 3600;

    public function __construct(
        private Provider $provider,
        #[Autowire('@snc_redis.default')]
        private Redis $client,
    ) {
    }

    public function getConfig(
        SemVer $appVersion,
        Platform $platform,
        ?SemVer $assetsVersion,
        ?SemVer $definitionVersion,
    ): ConfigDto {
        $cacheKey = $this->getCacheKey(
            appVersion: $appVersion,
            assetsVersion: $assetsVersion,
            definitionVersion: $definitionVersion,
        );
        $configDto = $this->getData($cacheKey);
        if (!$configDto) {
            $configDto = $this->provider->getConfig($appVersion, $platform, $assetsVersion, $definitionVersion);
            $this->client->setex($cacheKey, self::TTL_IN_SECONDS, serialize($configDto));
        }

        return $configDto;
    }

    private function getCacheKey(
        SemVer $appVersion,
        ?SemVer $assetsVersion,
        ?SemVer $definitionVersion,
    ): string {
        $aVer = $assetsVersion ?? $appVersion;
        $dVer = $definitionVersion ?? $appVersion;

        return $aVer->getAsString().'-'.$dVer->getAsString();
    }

    private function getData(string $key): ?ConfigDto
    {
        $value = $this->client->get($key);
        if (!$value) {
            return null;
        }

        return unserialize($value);
    }
}
<?php

declare(strict_types=1);

namespace App\Core\Fixture;

use App\Core\Entity\Platform;
use JsonException;

abstract readonly class Deserializer
{
    /**
     * @return array<ResultFixture>
     *
     * @throws JsonException
     */
    public static function deserialize(string $filename): array
    {
        $results = [];
        $jsonString = file_get_contents($filename);
        $json = json_decode($jsonString, true, 512, JSON_THROW_ON_ERROR);
        foreach (Platform::cases() as $platform) {
            foreach ($json[$platform->value] as $asset) {
                $version = explode('.', $asset['version']);
                $results[] = new ResultFixture(
                    platform: $platform,
                    hash: $asset['hash'],
                    majorVersion: (int)$version[0],
                    minorVersion: (int)$version[1],
                    patchVersion: (int)$version[2]
                );
            }
        }

        return $results;
    }
}
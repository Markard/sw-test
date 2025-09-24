<?php

declare(strict_types=1);

namespace App\Config\UseCase;

final readonly class SemVer
{
    private(set) int $major;
    private(set) int $minor;
    private(set) int $patch;

    public function __construct(string $semver)
    {
        $versions = explode('.', $semver);
        $this->major = (int)$versions[0];
        $this->minor = (int)$versions[1];
        $this->patch = (int)$versions[2];
    }

    public function getAsString(): string
    {
        return implode('.', [$this->major, $this->minor, $this->patch]);
    }
}
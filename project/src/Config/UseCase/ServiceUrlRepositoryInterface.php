<?php

declare(strict_types=1);

namespace App\Config\UseCase;

use App\Core\Entity\Service;
use App\Core\Entity\ServiceUrl;

interface ServiceUrlRepositoryInterface
{
    public function findServiceUrl(Service $service): ServiceUrl;
}
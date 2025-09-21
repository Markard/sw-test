<?php

declare(strict_types=1);

namespace App\Config\Http;

use App\Config\Http\Input\Query;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    #[Route('/config', methods: ['GET'])]
    public function getConfig(
        #[MapQueryString] Query $query,
    ): JsonResponse {
        return new JsonResponse([123]);
    }
}
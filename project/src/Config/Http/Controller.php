<?php

declare(strict_types=1);

namespace App\Config\Http;

use App\Config\Http\Output\Output;
use App\Config\UseCase\Provider;
use App\Config\UseCase\SemVer;
use App\Core\Entity\Platform;
use App\Core\Exception\NotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    public function __construct(private readonly Provider $provider)
    {
    }

    #[Route('/config', methods: ['GET'])]
    public function getConfig(
        #[MapQueryParameter(
            filter: FILTER_VALIDATE_REGEXP,
            options: ['regexp' => '/^(0|[1-9]\d*)\.(0|[1-9]\d*)\.(0|[1-9]\d*)$/'],
            validationFailedStatusCode: Response::HTTP_BAD_REQUEST
        )]
        string $appVersion,
        #[MapQueryParameter(
            filter: FILTER_VALIDATE_REGEXP,
            options: ['regexp' => '/^(android|ios)$/'],
            validationFailedStatusCode: Response::HTTP_BAD_REQUEST
        )]
        string $platform,
        #[MapQueryParameter(
            filter: FILTER_VALIDATE_REGEXP,
            options: ['regexp' => '/^(0|[1-9]\d*)\.(0|[1-9]\d*)\.(0|[1-9]\d*)$/'],
            validationFailedStatusCode: Response::HTTP_BAD_REQUEST
        )]
        ?string $assetsVersion = null,
        #[MapQueryParameter(
            filter: FILTER_VALIDATE_REGEXP,
            options: ['regexp' => '/^(0|[1-9]\d*)\.(0|[1-9]\d*)\.(0|[1-9]\d*)$/'],
            validationFailedStatusCode: Response::HTTP_BAD_REQUEST
        )]
        ?string $definitionsVersion = null
    ): JsonResponse {
        $appVersion = new SemVer($appVersion);
        $platform = Platform::from($platform);
        $assetsVersion = $assetsVersion ? new SemVer($assetsVersion) : null;
        $definitionsVersion = $definitionsVersion ? new SemVer($definitionsVersion) : null;

        try {
            $configDto = $this->provider->getConfig(
                appVersion: $appVersion,
                platform: $platform,
                assetsVersion: $assetsVersion,
                definitionVersion: $definitionsVersion
            );
        } catch (NotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e);
        }

        return new JsonResponse(new Output($configDto));
    }
}
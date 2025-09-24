<?php

declare(strict_types=1);

namespace App\Config\Http\Output;

use App\Config\UseCase\ConfigDto;
use JsonSerializable;

final readonly class Output implements JsonSerializable
{
    public function __construct(private ConfigDto $config)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'backend_entry_point' => [
                'jsonrpc_url' => $this->config->backend->url,
            ],
            'notifications' => [
                'jsonrpc_url' => $this->config->notifications->url,
            ],
            'assets' => [
                'version' => $this->config->assetDto->version,
                'hash' => $this->config->assetDto->hash,
                'urls' => $this->config->assetDto->urls,
            ],
            'definition' => [
                'version' => $this->config->definitionDto->version,
                'hash' => $this->config->definitionDto->hash,
                'urls' => $this->config->definitionDto->urls,
            ],
        ];
    }
}
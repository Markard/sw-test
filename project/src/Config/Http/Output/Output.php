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
        ];
    }
}
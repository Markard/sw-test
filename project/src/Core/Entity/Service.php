<?php

declare(strict_types=1);

namespace App\Core\Entity;

enum Service: string
{
    case BackendEntryPoint = 'backend_entry_point';
    case Notifications = 'notifications';
}

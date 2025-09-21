<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Doctrine\Timestampable;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait HasCreatedAtTimestamp
{
    #[ORM\Column(name: 'created_at', type: Types::DATETIME_MUTABLE, nullable: false)]
    private(set) DateTime $createdAt;

    #[ORM\PrePersist]
    public function onCreate(): void
    {
        $this->createdAt = $this->createdAt ?? new DateTime();
    }
}
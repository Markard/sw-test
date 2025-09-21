<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Doctrine\Timestampable;


use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;

trait Timestampable
{
    use HasCreatedAtTimestamp {
        onCreate as private onCreateCreatedAt;
    }

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_MUTABLE, nullable: false)]
    private(set) DateTime $updatedAt;

    #[ORM\PrePersist]
    public function onCreate(): void
    {
        $this->onCreateCreatedAt();
        $this->updatedAt = $this->updatedAt ?? new DateTime();
    }

    #[ORM\PreUpdate]
    public function onUpdate(PreUpdateEventArgs $event): void
    {
        if (!$event->hasChangedField('updatedAt')) {
            $this->updatedAt = new DateTime();
        }
    }
}
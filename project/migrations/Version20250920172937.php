<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Core\Entity\Service;
use DateTime;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250920172937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Load fixtures for "service_url" table';
    }

    public function up(Schema $schema): void
    {
        $this->connection->insert('service_url', [
            'service' => Service::BackendEntryPoint->value,
            'url' => 'api.application.com/jsonrpc/v2',
            'created_at' => new DateTime()->format('Y-m-d H:i:s'),
            'updated_at' => new DateTime()->format('Y-m-d H:i:s'),
        ]);
        $this->connection->insert('service_url', [
            'service' => Service::Notifications->value,
            'url' => 'notifications.application.com/jsonrpc/v1',
            'created_at' => new DateTime()->format('Y-m-d H:i:s'),
            'updated_at' => new DateTime()->format('Y-m-d H:i:s'),
        ]);
    }

    public function down(Schema $schema): void
    {
        $this->connection->delete('service_url', ['service' => Service::BackendEntryPoint->value]);
        $this->connection->delete('service_url', ['service' => Service::Notifications->value]);
    }
}

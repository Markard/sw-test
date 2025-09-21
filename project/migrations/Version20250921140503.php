<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use DateTime;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250921140503 extends AbstractMigration
{
    const string DHM_CDN_APPLICATION_COM = 'dhm.cdn.application.com';
    const string EHZ_CDN_APPLICATION_COM = 'ehz.cdn.application.com';

    public function getDescription(): string
    {
        return 'Upload data to "asset_url" table';
    }

    public function up(Schema $schema): void
    {
        $this->connection->insert('asset_url', [
            'url' => self::DHM_CDN_APPLICATION_COM,
            'created_at' => new DateTime()->format('Y-m-d H:i:s'),
            'updated_at' => new DateTime()->format('Y-m-d H:i:s'),
        ]);
        $this->connection->insert('asset_url', [
            'url' => self::EHZ_CDN_APPLICATION_COM,
            'created_at' => new DateTime()->format('Y-m-d H:i:s'),
            'updated_at' => new DateTime()->format('Y-m-d H:i:s'),
        ]);
    }

    public function down(Schema $schema): void
    {
        $this->connection->delete('asset_url', ['url' => self::DHM_CDN_APPLICATION_COM]);
        $this->connection->delete('asset_url', ['url' => self::EHZ_CDN_APPLICATION_COM]);
    }
}

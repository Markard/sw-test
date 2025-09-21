<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use DateTime;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250921141230 extends AbstractMigration
{
    const string FMP_CDN_APPLICATION_COM = 'fmp.cdn.application.com';
    const string EAU_CDN_APPLICATION_COM = 'eau.cdn.application.com';

    public function getDescription(): string
    {
        return 'Upload data to "definition_url" table';
    }

    public function up(Schema $schema): void
    {
        $this->connection->insert('definition_url', [
            'url' => self::FMP_CDN_APPLICATION_COM,
            'created_at' => new DateTime()->format('Y-m-d H:i:s'),
            'updated_at' => new DateTime()->format('Y-m-d H:i:s'),
        ]);
        $this->connection->insert('definition_url', [
            'url' => self::EAU_CDN_APPLICATION_COM,
            'created_at' => new DateTime()->format('Y-m-d H:i:s'),
            'updated_at' => new DateTime()->format('Y-m-d H:i:s'),
        ]);
    }

    public function down(Schema $schema): void
    {
        $this->connection->delete('definition_url', ['url' => self::FMP_CDN_APPLICATION_COM]);
        $this->connection->delete('definition_url', ['url' => self::EAU_CDN_APPLICATION_COM]);
    }
}

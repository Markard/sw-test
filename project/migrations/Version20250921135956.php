<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250921135956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create "asset_url" table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE asset_url
(
    id         INT AUTO_INCREMENT NOT NULL,
    url        VARCHAR(255)       NOT NULL,
    updated_at DATETIME           NOT NULL,
    created_at DATETIME           NOT NULL,
    PRIMARY KEY (id)
) DEFAULT CHARACTER SET utf8mb4
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE asset_url');
    }
}

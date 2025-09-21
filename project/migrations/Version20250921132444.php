<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250921132444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create "definition" table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE definition
(
    id            BIGINT AUTO_INCREMENT NOT NULL,
    platform      VARCHAR(255)          NOT NULL,
    major_version INT                   NOT NULL,
    minor_version INT                   NOT NULL,
    patch_version INT                   NOT NULL,
    hash          VARCHAR(255)          NOT NULL,
    created_at    DATETIME              NOT NULL,
    PRIMARY KEY (id)
) DEFAULT CHARACTER SET utf8mb4
SQL;
        $this->addSql($sql);
        $this->addSql(
            'CREATE INDEX idx__definition__major__minor__patch ON definition (major_version, minor_version, patch_version)'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX idx__definition__major__minor__patch ON definition');
        $this->addSql('DROP TABLE definition');
    }
}

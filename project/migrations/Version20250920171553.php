<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250920171553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE service_url
(
    id         BIGINT AUTO_INCREMENT NOT NULL,
    url        VARCHAR(255)          NOT NULL,
    service    VARCHAR(255)          NOT NULL,
    updated_at DATETIME              NOT NULL,
    created_at DATETIME              NOT NULL,
    UNIQUE INDEX UNIQ_D62636D9E19D9AD2 (service),
    PRIMARY KEY (id)
) DEFAULT CHARACTER SET utf8mb4
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE service_url');
    }
}

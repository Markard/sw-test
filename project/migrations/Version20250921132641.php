<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Core\Fixture\Deserializer;
use DateTime;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250921132641 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Upload fixtures to "definition" table';
    }

    public function up(Schema $schema): void
    {
        $results = Deserializer::deserialize(getcwd().'/migrations/fixtures/definitions-fixtures.json');
        foreach ($results as $result) {
            $this->connection->insert('definition', [
                'platform' => $result->platform->value,
                'major_version' => $result->majorVersion,
                'minor_version' => $result->minorVersion,
                'patch_version' => $result->patchVersion,
                'hash' => $result->hash,
                'created_at' => new DateTime()->format('Y-m-d H:i:s'),
            ]);
        }

    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE TABLE definition');
    }
}

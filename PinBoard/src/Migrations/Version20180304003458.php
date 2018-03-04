<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180304003458 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_A8936DC5E4CCBDFC ON jobs');
        $this->addSql('DROP INDEX UNIQ_A8936DC525B3548 ON jobs');
        $this->addSql('ALTER TABLE jobs DROP name_pl, DROP name_fr');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE jobs ADD name_pl VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, ADD name_fr VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A8936DC5E4CCBDFC ON jobs (name_pl)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A8936DC525B3548 ON jobs (name_fr)');
    }
}

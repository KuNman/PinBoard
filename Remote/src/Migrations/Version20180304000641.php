<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180304000641 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE countries ADD country_pl VARCHAR(100) NOT NULL, ADD country_fr VARCHAR(100) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5D66EBAD6CF41F5A ON countries (country_pl)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5D66EBAD8A6397EE ON countries (country_fr)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_5D66EBAD6CF41F5A ON countries');
        $this->addSql('DROP INDEX UNIQ_5D66EBAD8A6397EE ON countries');
        $this->addSql('ALTER TABLE countries DROP country_pl, DROP country_fr');
    }
}

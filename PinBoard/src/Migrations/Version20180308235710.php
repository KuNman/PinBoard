<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180308235710 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tasks CHANGE city city VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE countries CHANGE country_en country_en VARCHAR(30) NOT NULL, CHANGE country_pl country_pl VARCHAR(30) NOT NULL, CHANGE country_fr country_fr VARCHAR(30) NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE countries CHANGE country_en country_en VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE country_pl country_pl VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE country_fr country_fr VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE tasks CHANGE city city JSON NOT NULL COMMENT \'(DC2Type:json_array)\'');
    }
}

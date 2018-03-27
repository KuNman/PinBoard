<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180307223654 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tasks CHANGE city city JSON NOT NULL COMMENT \'(DC2Type:json_array)\'');
        $this->addSql('ALTER TABLE jobs CHANGE name_en name_en VARCHAR(100) DEFAULT NULL, CHANGE name_pl name_pl VARCHAR(100) DEFAULT NULL, CHANGE name_fr name_fr VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE jobs CHANGE name_en name_en VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE name_pl name_pl VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE name_fr name_fr VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE tasks CHANGE city city LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:simple_array)\'');
    }
}

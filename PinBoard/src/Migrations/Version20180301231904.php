<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180301231904 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cities ADD area_id INT DEFAULT NULL, ADD city VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE cities ADD CONSTRAINT FK_D95DB16BBD0F409C FOREIGN KEY (area_id) REFERENCES areas (id)');
        $this->addSql('CREATE INDEX IDX_D95DB16BBD0F409C ON cities (area_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cities DROP FOREIGN KEY FK_D95DB16BBD0F409C');
        $this->addSql('DROP INDEX IDX_D95DB16BBD0F409C ON cities');
        $this->addSql('ALTER TABLE cities DROP area_id, DROP city');
    }
}

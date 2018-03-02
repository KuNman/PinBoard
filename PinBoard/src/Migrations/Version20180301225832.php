<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180301225832 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE areas DROP FOREIGN KEY FK_58B0B25CF92F3E70');
        $this->addSql('DROP INDEX IDX_58B0B25CF92F3E70 ON areas');
        $this->addSql('ALTER TABLE areas ADD country VARCHAR(100) DEFAULT NULL, DROP country_id');
        $this->addSql('ALTER TABLE areas ADD CONSTRAINT FK_58B0B25C5373C966 FOREIGN KEY (country) REFERENCES countries (country)');
        $this->addSql('CREATE INDEX IDX_58B0B25C5373C966 ON areas (country)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE areas DROP FOREIGN KEY FK_58B0B25C5373C966');
        $this->addSql('DROP INDEX IDX_58B0B25C5373C966 ON areas');
        $this->addSql('ALTER TABLE areas ADD country_id INT DEFAULT NULL, DROP country');
        $this->addSql('ALTER TABLE areas ADD CONSTRAINT FK_58B0B25CF92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('CREATE INDEX IDX_58B0B25CF92F3E70 ON areas (country_id)');
    }
}

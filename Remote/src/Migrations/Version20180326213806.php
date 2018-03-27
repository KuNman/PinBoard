<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180326213806 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(50) NOT NULL, password VARCHAR(64) NOT NULL, role VARCHAR(10) DEFAULT \'user\' NOT NULL, langs VARCHAR(100) DEFAULT \'user\', UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tasks (id INT AUTO_INCREMENT NOT NULL, job_id INT NOT NULL, country_id INT NOT NULL, area_id INT NOT NULL, user_id INT NOT NULL, city VARCHAR(255) NOT NULL, availability DATE NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_50586597BE04EA9 (job_id), INDEX IDX_50586597F92F3E70 (country_id), INDEX IDX_50586597BD0F409C (area_id), INDEX IDX_50586597A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE countries (id INT AUTO_INCREMENT NOT NULL, country_en VARCHAR(30) NOT NULL, country_pl VARCHAR(30) NOT NULL, country_fr VARCHAR(30) NOT NULL, UNIQUE INDEX UNIQ_5D66EBADB54F9862 (country_en), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, price INT NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cities (id INT AUTO_INCREMENT NOT NULL, area_id INT DEFAULT NULL, country_id INT DEFAULT NULL, city VARCHAR(30) NOT NULL, UNIQUE INDEX UNIQ_D95DB16B2D5B0234 (city), INDEX IDX_D95DB16BBD0F409C (area_id), INDEX IDX_D95DB16BF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jobs (id INT AUTO_INCREMENT NOT NULL, name_en VARCHAR(100) DEFAULT NULL, name_pl VARCHAR(100) DEFAULT NULL, name_fr VARCHAR(100) DEFAULT NULL, UNIQUE INDEX UNIQ_A8936DC53D773AC4 (name_en), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE areas (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, area VARCHAR(30) NOT NULL, INDEX IDX_58B0B25CF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597BE04EA9 FOREIGN KEY (job_id) REFERENCES jobs (id)');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597F92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597BD0F409C FOREIGN KEY (area_id) REFERENCES areas (id)');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE cities ADD CONSTRAINT FK_D95DB16BBD0F409C FOREIGN KEY (area_id) REFERENCES areas (id)');
        $this->addSql('ALTER TABLE cities ADD CONSTRAINT FK_D95DB16BF92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('ALTER TABLE areas ADD CONSTRAINT FK_58B0B25CF92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_50586597A76ED395');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_50586597F92F3E70');
        $this->addSql('ALTER TABLE cities DROP FOREIGN KEY FK_D95DB16BF92F3E70');
        $this->addSql('ALTER TABLE areas DROP FOREIGN KEY FK_58B0B25CF92F3E70');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_50586597BE04EA9');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_50586597BD0F409C');
        $this->addSql('ALTER TABLE cities DROP FOREIGN KEY FK_D95DB16BBD0F409C');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE tasks');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE countries');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE cities');
        $this->addSql('DROP TABLE jobs');
        $this->addSql('DROP TABLE areas');
    }
}

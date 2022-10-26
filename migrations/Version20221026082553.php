<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221026082553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sign_in (id INT AUTO_INCREMENT NOT NULL, signinuser_id INT DEFAULT NULL, hoursignin LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', localitation VARCHAR(255) DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, updated TINYINT(1) NOT NULL, INDEX IDX_E629950B4D33EB4 (signinuser_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sign_out (id INT AUTO_INCREMENT NOT NULL, signoutuser_id INT DEFAULT NULL, hoursignout LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', localitation VARCHAR(255) DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, updated TINYINT(1) NOT NULL, INDEX IDX_BFE51D9D187B4DB0 (signoutuser_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sign_in ADD CONSTRAINT FK_E629950B4D33EB4 FOREIGN KEY (signinuser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sign_out ADD CONSTRAINT FK_BFE51D9D187B4DB0 FOREIGN KEY (signoutuser_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sign_in DROP FOREIGN KEY FK_E629950B4D33EB4');
        $this->addSql('ALTER TABLE sign_out DROP FOREIGN KEY FK_BFE51D9D187B4DB0');
        $this->addSql('DROP TABLE sign_in');
        $this->addSql('DROP TABLE sign_out');
        $this->addSql('DROP TABLE user');
    }
}

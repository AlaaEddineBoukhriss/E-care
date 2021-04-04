<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210403114152 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clinique (id INT AUTO_INCREMENT NOT NULL, nomcl VARCHAR(255) NOT NULL, adressecl VARCHAR(255) NOT NULL, numerocl INT NOT NULL, desccl VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medecin (id INT AUTO_INCREMENT NOT NULL, clinique_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, grade VARCHAR(255) NOT NULL, INDEX IDX_1BDA53C6265183A3 (clinique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, clinique_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, INDEX IDX_1ADAD7EB265183A3 (clinique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE medecin ADD CONSTRAINT FK_1BDA53C6265183A3 FOREIGN KEY (clinique_id) REFERENCES clinique (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB265183A3 FOREIGN KEY (clinique_id) REFERENCES clinique (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medecin DROP FOREIGN KEY FK_1BDA53C6265183A3');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB265183A3');
        $this->addSql('DROP TABLE clinique');
        $this->addSql('DROP TABLE medecin');
        $this->addSql('DROP TABLE patient');
    }
}

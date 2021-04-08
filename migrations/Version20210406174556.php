<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210406174556 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE patients (id INT AUTO_INCREMENT NOT NULL, clinique_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, INDEX IDX_2CCC2E2C265183A3 (clinique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE patients ADD CONSTRAINT FK_2CCC2E2C265183A3 FOREIGN KEY (clinique_id) REFERENCES clinique (id)');
        $this->addSql('ALTER TABLE patient ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD cin VARCHAR(255) NOT NULL, ADD adresse VARCHAR(255) NOT NULL, ADD num_tel VARCHAR(255) NOT NULL, ADD password VARCHAR(255) NOT NULL, ADD role VARCHAR(255) DEFAULT \'pat\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE patients');
        $this->addSql('ALTER TABLE patient DROP nom, DROP prenom, DROP cin, DROP adresse, DROP num_tel, DROP password, DROP role');
    }
}

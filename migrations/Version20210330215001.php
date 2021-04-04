<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330215001 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medecin (id INT AUTO_INCREMENT NOT NULL, clinique_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, grade VARCHAR(255) NOT NULL, INDEX IDX_1BDA53C6265183A3 (clinique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE medecin ADD CONSTRAINT FK_1BDA53C6265183A3 FOREIGN KEY (clinique_id) REFERENCES clinique (id)');
        $this->addSql('DROP TABLE pharmacie');
        $this->addSql('DROP TABLE representant');
        $this->addSql('ALTER TABLE patient ADD clinique_id INT DEFAULT NULL, ADD name VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD phone VARCHAR(255) NOT NULL, ADD adresse VARCHAR(255) NOT NULL, DROP nom_p, DROP prenom_p, DROP adresse_p, DROP numtell, DROP mdp, DROP taille, DROP poids, DROP maladie, DROP actions');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB265183A3 FOREIGN KEY (clinique_id) REFERENCES clinique (id)');
        $this->addSql('CREATE INDEX IDX_1ADAD7EB265183A3 ON patient (clinique_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pharmacie (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, numero INT NOT NULL, adresse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE representant (id INT AUTO_INCREMENT NOT NULL, nom_r VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom_r VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, numero_r INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE medecin');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB265183A3');
        $this->addSql('DROP INDEX IDX_1ADAD7EB265183A3 ON patient');
        $this->addSql('ALTER TABLE patient ADD nom_p VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD prenom_p VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD adresse_p VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD numtell INT NOT NULL, ADD mdp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD taille INT NOT NULL, ADD poids INT NOT NULL, ADD maladie VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD actions VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP clinique_id, DROP name, DROP email, DROP phone, DROP adresse');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331005216 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE caract_pat (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE medecin ADD role VARCHAR(255) DEFAULT \'med\' NOT NULL');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EBE9795579');
        $this->addSql('DROP INDEX UNIQ_1ADAD7EBE9795579 ON patient');
        $this->addSql('ALTER TABLE patient ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD cin VARCHAR(255) NOT NULL, ADD adresse VARCHAR(255) NOT NULL, ADD num_tel VARCHAR(255) NOT NULL, ADD password VARCHAR(255) NOT NULL, ADD role VARCHAR(255) DEFAULT \'pat\' NOT NULL, DROP cin_id');
        $this->addSql('ALTER TABLE representant_clinique DROP FOREIGN KEY FK_84BCC997E9795579');
        $this->addSql('DROP INDEX UNIQ_84BCC997E9795579 ON representant_clinique');
        $this->addSql('ALTER TABLE representant_clinique ADD cin VARCHAR(255) NOT NULL, ADD role VARCHAR(255) NOT NULL, DROP cin_id');
        $this->addSql('ALTER TABLE representant_para DROP FOREIGN KEY FK_DC663F94E9795579');
        $this->addSql('DROP INDEX UNIQ_DC663F94E9795579 ON representant_para');
        $this->addSql('ALTER TABLE representant_para ADD cin VARCHAR(255) NOT NULL, ADD role VARCHAR(255) NOT NULL, DROP cin_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE caract_pat');
        $this->addSql('ALTER TABLE medecin DROP role');
        $this->addSql('ALTER TABLE patient ADD cin_id INT DEFAULT NULL, DROP nom, DROP prenom, DROP cin, DROP adresse, DROP num_tel, DROP password, DROP role');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBE9795579 FOREIGN KEY (cin_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1ADAD7EBE9795579 ON patient (cin_id)');
        $this->addSql('ALTER TABLE representant_clinique ADD cin_id INT DEFAULT NULL, DROP cin, DROP role');
        $this->addSql('ALTER TABLE representant_clinique ADD CONSTRAINT FK_84BCC997E9795579 FOREIGN KEY (cin_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_84BCC997E9795579 ON representant_clinique (cin_id)');
        $this->addSql('ALTER TABLE representant_para ADD cin_id INT DEFAULT NULL, DROP cin, DROP role');
        $this->addSql('ALTER TABLE representant_para ADD CONSTRAINT FK_DC663F94E9795579 FOREIGN KEY (cin_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DC663F94E9795579 ON representant_para (cin_id)');
    }
}

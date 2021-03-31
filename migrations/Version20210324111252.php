<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210324111252 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medecin ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE patient ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE representant_clinique ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE representant_para ADD password VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medecin DROP password');
        $this->addSql('ALTER TABLE patient DROP password');
        $this->addSql('ALTER TABLE representant_clinique DROP password');
        $this->addSql('ALTER TABLE representant_para DROP password');
    }
}

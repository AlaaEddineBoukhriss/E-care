<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331143612 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient ADD id1_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB231CAD5A FOREIGN KEY (id1_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1ADAD7EB231CAD5A ON patient (id1_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB231CAD5A');
        $this->addSql('DROP INDEX UNIQ_1ADAD7EB231CAD5A ON patient');
        $this->addSql('ALTER TABLE patient DROP id1_id');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331144519 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medecin ADD id1_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE medecin ADD CONSTRAINT FK_1BDA53C6231CAD5A FOREIGN KEY (id1_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1BDA53C6231CAD5A ON medecin (id1_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medecin DROP FOREIGN KEY FK_1BDA53C6231CAD5A');
        $this->addSql('DROP INDEX UNIQ_1BDA53C6231CAD5A ON medecin');
        $this->addSql('ALTER TABLE medecin DROP id1_id');
    }
}

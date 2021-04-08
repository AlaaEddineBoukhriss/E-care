<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210407103330 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis_client ADD id_rclient_id INT NOT NULL, DROP id_rclient');
        $this->addSql('ALTER TABLE avis_client ADD CONSTRAINT FK_708E90EF4B5EC08B FOREIGN KEY (id_rclient_id) REFERENCES pharmacie (id)');
        $this->addSql('CREATE INDEX IDX_708E90EF4B5EC08B ON avis_client (id_rclient_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis_client DROP FOREIGN KEY FK_708E90EF4B5EC08B');
        $this->addSql('DROP INDEX IDX_708E90EF4B5EC08B ON avis_client');
        $this->addSql('ALTER TABLE avis_client ADD id_rclient VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP id_rclient_id');
    }
}

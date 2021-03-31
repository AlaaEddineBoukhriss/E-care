<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331145145 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE representant_para ADD id1_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE representant_para ADD CONSTRAINT FK_DC663F94231CAD5A FOREIGN KEY (id1_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DC663F94231CAD5A ON representant_para (id1_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE representant_para DROP FOREIGN KEY FK_DC663F94231CAD5A');
        $this->addSql('DROP INDEX UNIQ_DC663F94231CAD5A ON representant_para');
        $this->addSql('ALTER TABLE representant_para DROP id1_id');
    }
}

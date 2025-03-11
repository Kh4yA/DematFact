<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250304073132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devis CHANGE total_ht total_ht NUMERIC(10, 2) DEFAULT \'0\' NOT NULL, CHANGE total_ttc total_ttc NUMERIC(10, 2) DEFAULT \'0\' NOT NULL, CHANGE total_tva total_tva NUMERIC(10, 2) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE organisation CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devis CHANGE total_ht total_ht NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL, CHANGE total_ttc total_ttc NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL, CHANGE total_tva total_tva NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL');
        $this->addSql('ALTER TABLE organisation CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}

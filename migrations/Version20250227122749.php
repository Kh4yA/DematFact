<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250227122749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD tel_protable VARCHAR(255) DEFAULT NULL, ADD tel_fixe VARCHAR(255) DEFAULT NULL, ADD fax VARCHAR(255) DEFAULT NULL, ADD raison_sociale VARCHAR(255) DEFAULT NULL, ADD actif TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B9E6B1585');
        $this->addSql('DROP INDEX IDX_8B27C52B9E6B1585 ON devis');
        $this->addSql('ALTER TABLE devis DROP organisation_id, CHANGE total_ht total_ht NUMERIC(10, 2) DEFAULT \'0\' NOT NULL, CHANGE total_ttc total_ttc NUMERIC(10, 2) DEFAULT \'0\' NOT NULL, CHANGE total_tva total_tva NUMERIC(10, 2) DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP tel_protable, DROP tel_fixe, DROP fax, DROP raison_sociale, DROP actif');
        $this->addSql('ALTER TABLE devis ADD organisation_id INT DEFAULT NULL, CHANGE total_ht total_ht NUMERIC(10, 2) NOT NULL, CHANGE total_ttc total_ttc NUMERIC(10, 2) NOT NULL, CHANGE total_tva total_tva NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B9E6B1585 FOREIGN KEY (organisation_id) REFERENCES organisation (id)');
        $this->addSql('CREATE INDEX IDX_8B27C52B9E6B1585 ON devis (organisation_id)');
    }
}

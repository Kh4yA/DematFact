<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250305152111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client CHANGE prenom prenom VARCHAR(255) DEFAULT NULL, CHANGE rue rue VARCHAR(255) DEFAULT NULL, CHANGE ville ville VARCHAR(255) DEFAULT NULL, CHANGE code_postal code_postal VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE devis CHANGE total_ht total_ht NUMERIC(10, 2) DEFAULT \'0\' NOT NULL, CHANGE total_ttc total_ttc NUMERIC(10, 2) DEFAULT \'0\' NOT NULL, CHANGE total_tva total_tva NUMERIC(10, 2) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE devis_ligne CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE prix_unitaire_ht prix_unitaire_ht NUMERIC(10, 2) DEFAULT NULL, CHANGE taxe taxe VARCHAR(255) DEFAULT NULL, CHANGE ligne_totale_ht ligne_totale_ht NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE facture_ligne CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE prix_unitaire_ht prix_unitaire_ht NUMERIC(10, 2) DEFAULT NULL, CHANGE ligne_totale_ht ligne_totale_ht NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE prestation CHANGE prix_ht prix_ht NUMERIC(10, 2) DEFAULT NULL, CHANGE taxe taxe VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE rue rue VARCHAR(255) NOT NULL, CHANGE ville ville VARCHAR(255) NOT NULL, CHANGE code_postal code_postal VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE devis CHANGE total_ht total_ht NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL, CHANGE total_ttc total_ttc NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL, CHANGE total_tva total_tva NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL');
        $this->addSql('ALTER TABLE devis_ligne CHANGE description description VARCHAR(255) NOT NULL, CHANGE prix_unitaire_ht prix_unitaire_ht NUMERIC(10, 2) NOT NULL, CHANGE taxe taxe VARCHAR(255) NOT NULL, CHANGE ligne_totale_ht ligne_totale_ht NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE facture_ligne CHANGE description description VARCHAR(255) NOT NULL, CHANGE prix_unitaire_ht prix_unitaire_ht NUMERIC(10, 2) NOT NULL, CHANGE ligne_totale_ht ligne_totale_ht NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE prestation CHANGE prix_ht prix_ht NUMERIC(10, 2) NOT NULL, CHANGE taxe taxe VARCHAR(255) NOT NULL');
    }
}

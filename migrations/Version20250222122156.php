<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250222122156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facture_lignes (id INT AUTO_INCREMENT NOT NULL, facture_id_id INT DEFAULT NULL, organisation_id_id INT DEFAULT NULL, prestation_id_id INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, prix_unitaire_ht NUMERIC(10, 2) NOT NULL, taxe VARCHAR(255) NOT NULL, quantite INT NOT NULL, ligne_totale_ht NUMERIC(10, 2) DEFAULT NULL, ligne_totale_ttc NUMERIC(10, 2) NOT NULL, INDEX IDX_3A7FFFEDED7016E0 (facture_id_id), INDEX IDX_3A7FFFED6C6A4201 (organisation_id_id), INDEX IDX_3A7FFFEDBDCFD5D6 (prestation_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiements (id INT AUTO_INCREMENT NOT NULL, facture_id_id INT DEFAULT NULL, organisation_id_id INT DEFAULT NULL, date_paiement DATETIME NOT NULL, montant NUMERIC(10, 2) NOT NULL, moyen_paiement VARCHAR(255) NOT NULL, INDEX IDX_E1B02E12ED7016E0 (facture_id_id), INDEX IDX_E1B02E126C6A4201 (organisation_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestations (id INT AUTO_INCREMENT NOT NULL, organisation_id_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, prix_ht NUMERIC(10, 2) NOT NULL, taxe VARCHAR(255) DEFAULT NULL, INDEX IDX_B338D8D16C6A4201 (organisation_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facture_lignes ADD CONSTRAINT FK_3A7FFFEDED7016E0 FOREIGN KEY (facture_id_id) REFERENCES factures (id)');
        $this->addSql('ALTER TABLE facture_lignes ADD CONSTRAINT FK_3A7FFFED6C6A4201 FOREIGN KEY (organisation_id_id) REFERENCES organisation (id)');
        $this->addSql('ALTER TABLE facture_lignes ADD CONSTRAINT FK_3A7FFFEDBDCFD5D6 FOREIGN KEY (prestation_id_id) REFERENCES prestations (id)');
        $this->addSql('ALTER TABLE paiements ADD CONSTRAINT FK_E1B02E12ED7016E0 FOREIGN KEY (facture_id_id) REFERENCES factures (id)');
        $this->addSql('ALTER TABLE paiements ADD CONSTRAINT FK_E1B02E126C6A4201 FOREIGN KEY (organisation_id_id) REFERENCES organisation (id)');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT FK_B338D8D16C6A4201 FOREIGN KEY (organisation_id_id) REFERENCES organisation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE facture_lignes DROP FOREIGN KEY FK_3A7FFFEDED7016E0');
        $this->addSql('ALTER TABLE facture_lignes DROP FOREIGN KEY FK_3A7FFFED6C6A4201');
        $this->addSql('ALTER TABLE facture_lignes DROP FOREIGN KEY FK_3A7FFFEDBDCFD5D6');
        $this->addSql('ALTER TABLE paiements DROP FOREIGN KEY FK_E1B02E12ED7016E0');
        $this->addSql('ALTER TABLE paiements DROP FOREIGN KEY FK_E1B02E126C6A4201');
        $this->addSql('ALTER TABLE prestations DROP FOREIGN KEY FK_B338D8D16C6A4201');
        $this->addSql('DROP TABLE facture_lignes');
        $this->addSql('DROP TABLE paiements');
        $this->addSql('DROP TABLE prestations');
    }
}

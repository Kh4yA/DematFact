<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250225170746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52BA76ED395');
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B19EB6921');
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B9E6B1585');
        $this->addSql('ALTER TABLE devis_ligne DROP FOREIGN KEY FK_41D3C6A79E6B1585');
        $this->addSql('ALTER TABLE devis_ligne DROP FOREIGN KEY FK_41D3C6A741DEFADA');
        $this->addSql('ALTER TABLE devis_ligne DROP FOREIGN KEY FK_41D3C6A79E45C554');
        $this->addSql('DROP TABLE devis');
        $this->addSql('DROP TABLE devis_ligne');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE devis (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, user_id INT DEFAULT NULL, organisation_id INT DEFAULT NULL, numero VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_emission DATETIME NOT NULL, statut VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, total_ht NUMERIC(10, 2) NOT NULL, total_tva NUMERIC(10, 2) NOT NULL, total_ttc NUMERIC(10, 2) NOT NULL, remise VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8B27C52BA76ED395 (user_id), INDEX IDX_8B27C52B19EB6921 (client_id), INDEX IDX_8B27C52B9E6B1585 (organisation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE devis_ligne (id INT AUTO_INCREMENT NOT NULL, devis_id INT DEFAULT NULL, organisation_id INT DEFAULT NULL, prestation_id INT DEFAULT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prix_unitaire_ht NUMERIC(10, 2) NOT NULL, taxe NUMERIC(10, 2) NOT NULL, quantite INT NOT NULL, ligne_totale_ht NUMERIC(10, 2) NOT NULL, ligne_total_ttc NUMERIC(10, 2) NOT NULL, INDEX IDX_41D3C6A79E6B1585 (organisation_id), INDEX IDX_41D3C6A741DEFADA (devis_id), INDEX IDX_41D3C6A79E45C554 (prestation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B9E6B1585 FOREIGN KEY (organisation_id) REFERENCES organisation (id)');
        $this->addSql('ALTER TABLE devis_ligne ADD CONSTRAINT FK_41D3C6A79E6B1585 FOREIGN KEY (organisation_id) REFERENCES organisation (id)');
        $this->addSql('ALTER TABLE devis_ligne ADD CONSTRAINT FK_41D3C6A741DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id)');
        $this->addSql('ALTER TABLE devis_ligne ADD CONSTRAINT FK_41D3C6A79E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id)');
    }
}

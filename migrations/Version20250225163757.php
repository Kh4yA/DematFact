<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250225163757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devis_ligne DROP FOREIGN KEY FK_41D3C6A79E6B1585');
        $this->addSql('ALTER TABLE devis_ligne DROP FOREIGN KEY FK_41D3C6A77F2DEE08');
        $this->addSql('ALTER TABLE devis_ligne DROP FOREIGN KEY FK_41D3C6A79E45C554');
        $this->addSql('DROP TABLE devis_ligne');
        $this->addSql('ALTER TABLE facture CHANGE remise remise VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE devis_ligne (id INT AUTO_INCREMENT NOT NULL, facture_id INT DEFAULT NULL, organisation_id INT DEFAULT NULL, prestation_id INT DEFAULT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prix_unitaire_ht NUMERIC(10, 2) NOT NULL, taxe VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, quantite INT NOT NULL, ligne_total_ht NUMERIC(10, 2) NOT NULL, ligne_total_ttc NUMERIC(10, 2) NOT NULL, INDEX IDX_41D3C6A79E6B1585 (organisation_id), INDEX IDX_41D3C6A77F2DEE08 (facture_id), INDEX IDX_41D3C6A79E45C554 (prestation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE devis_ligne ADD CONSTRAINT FK_41D3C6A79E6B1585 FOREIGN KEY (organisation_id) REFERENCES organisation (id)');
        $this->addSql('ALTER TABLE devis_ligne ADD CONSTRAINT FK_41D3C6A77F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE devis_ligne ADD CONSTRAINT FK_41D3C6A79E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id)');
        $this->addSql('ALTER TABLE facture CHANGE remise remise NUMERIC(10, 2) DEFAULT NULL');
    }
}

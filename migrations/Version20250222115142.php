<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250222115142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, organisation_id_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', email VARCHAR(255) NOT NULL, rue VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, code_postal VARCHAR(255) NOT NULL, INDEX IDX_C82E746C6A4201 (organisation_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE factures (id INT AUTO_INCREMENT NOT NULL, client_id_id INT DEFAULT NULL, user_id_id INT DEFAULT NULL, organisation_id_id INT DEFAULT NULL, numero VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', statut VARCHAR(255) NOT NULL, total_ht NUMERIC(10, 2) NOT NULL, total_tva NUMERIC(10, 2) DEFAULT NULL, total_ttc NUMERIC(10, 2) NOT NULL, remise NUMERIC(10, 2) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_647590BDC2902E0 (client_id_id), INDEX IDX_647590B9D86650F (user_id_id), INDEX IDX_647590B6C6A4201 (organisation_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organisation (id INT AUTO_INCREMENT NOT NULL, designation_sociale VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, rue VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, code_postale VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', abonnement_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, organisation_id_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, phone_number VARCHAR(15) DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8D93D6496C6A4201 (organisation_id_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clients ADD CONSTRAINT FK_C82E746C6A4201 FOREIGN KEY (organisation_id_id) REFERENCES organisation (id)');
        $this->addSql('ALTER TABLE factures ADD CONSTRAINT FK_647590BDC2902E0 FOREIGN KEY (client_id_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE factures ADD CONSTRAINT FK_647590B9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE factures ADD CONSTRAINT FK_647590B6C6A4201 FOREIGN KEY (organisation_id_id) REFERENCES organisation (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496C6A4201 FOREIGN KEY (organisation_id_id) REFERENCES organisation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clients DROP FOREIGN KEY FK_C82E746C6A4201');
        $this->addSql('ALTER TABLE factures DROP FOREIGN KEY FK_647590BDC2902E0');
        $this->addSql('ALTER TABLE factures DROP FOREIGN KEY FK_647590B9D86650F');
        $this->addSql('ALTER TABLE factures DROP FOREIGN KEY FK_647590B6C6A4201');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496C6A4201');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE factures');
        $this->addSql('DROP TABLE organisation');
        $this->addSql('DROP TABLE user');
    }
}

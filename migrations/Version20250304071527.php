<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250304071527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devis CHANGE total_ht total_ht NUMERIC(10, 2) DEFAULT \'0\' NOT NULL, CHANGE total_ttc total_ttc NUMERIC(10, 2) DEFAULT \'0\' NOT NULL, CHANGE total_tva total_tva NUMERIC(10, 2) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE organisation_id organisation_id INT DEFAULT NULL, CHANGE email email VARCHAR(180) DEFAULT NULL, CHANGE is_email_auth_enabled is_email_auth_enabled TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devis CHANGE total_ht total_ht NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL, CHANGE total_ttc total_ttc NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL, CHANGE total_tva total_tva NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE organisation_id organisation_id INT NOT NULL, CHANGE email email VARCHAR(180) NOT NULL, CHANGE is_email_auth_enabled is_email_auth_enabled TINYINT(1) NOT NULL');
    }
}

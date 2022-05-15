<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220501195814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parse1 (id INT AUTO_INCREMENT NOT NULL, category_site_id INT NOT NULL, titre VARCHAR(255) NOT NULL, geographie VARCHAR(255) DEFAULT NULL, marque VARCHAR(255) DEFAULT NULL, modele VARCHAR(255) DEFAULT NULL, annee_modele DATETIME DEFAULT NULL, date_circulation DATETIME DEFAULT NULL, kilometrage INT NOT NULL, carburant VARCHAR(255) DEFAULT NULL, boite_vitesse VARCHAR(255) DEFAULT NULL, vehicule_type VARCHAR(255) DEFAULT NULL, couleur VARCHAR(255) DEFAULT NULL, portes VARCHAR(255) DEFAULT NULL, places INT NOT NULL, puissance_fiscale VARCHAR(255) DEFAULT NULL, puissance_din VARCHAR(255) DEFAULT NULL, permis TINYINT(1) NOT NULL, loalld TINYINT(1) NOT NULL, pieces_detachees VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, photos LONGTEXT DEFAULT NULL, INDEX IDX_C067D35931655638 (category_site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parse1 ADD CONSTRAINT FK_C067D35931655638 FOREIGN KEY (category_site_id) REFERENCES category_site (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE parse1');
    }
}

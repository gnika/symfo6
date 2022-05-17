<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220517145354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parse2_example (id INT AUTO_INCREMENT NOT NULL, category_site_id INT NOT NULL, titre VARCHAR(255) NOT NULL, ville VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, url_offre VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', details TINYINT(1) DEFAULT NULL, region VARCHAR(255) DEFAULT NULL, departement VARCHAR(255) DEFAULT NULL, date_publication DATETIME DEFAULT NULL, prix INT DEFAULT NULL, images LONGTEXT DEFAULT NULL, type_de_bien VARCHAR(255) DEFAULT NULL, type_de_vente VARCHAR(255) DEFAULT NULL, surface VARCHAR(255) DEFAULT NULL, surface_du_terrain VARCHAR(255) DEFAULT NULL, pieces VARCHAR(255) DEFAULT NULL, energie VARCHAR(255) DEFAULT NULL, ges VARCHAR(255) DEFAULT NULL, vente VARCHAR(255) DEFAULT NULL, etages VARCHAR(255) DEFAULT NULL, etage VARCHAR(255) DEFAULT NULL, parking VARCHAR(255) DEFAULT NULL, charges VARCHAR(255) DEFAULT NULL, meuble VARCHAR(255) DEFAULT NULL, reference VARCHAR(255) DEFAULT NULL, honoraires VARCHAR(255) DEFAULT NULL, chambres VARCHAR(255) DEFAULT NULL, INDEX IDX_F8F602B31655638 (category_site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parse2_example ADD CONSTRAINT FK_F8F602B31655638 FOREIGN KEY (category_site_id) REFERENCES category_site (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE parse2_example');
    }
}

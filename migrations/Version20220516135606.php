<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220516135606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parse2 (id INT AUTO_INCREMENT NOT NULL, category_site_id INT NOT NULL, titre VARCHAR(255) NOT NULL, ville VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, url_offre VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', details TINYINT(1) DEFAULT NULL, region VARCHAR(255) DEFAULT NULL, departement VARCHAR(255) DEFAULT NULL, date_publication DATETIME DEFAULT NULL, prix INT DEFAULT NULL, images LONGTEXT DEFAULT NULL, INDEX IDX_596E82E331655638 (category_site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parse2 ADD CONSTRAINT FK_596E82E331655638 FOREIGN KEY (category_site_id) REFERENCES category_site (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE parse2');
    }
}

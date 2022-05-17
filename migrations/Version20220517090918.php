<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220517090918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parse2 ADD type_de_bien VARCHAR(255) DEFAULT NULL, ADD type_de_vente VARCHAR(255) DEFAULT NULL, ADD surface VARCHAR(255) DEFAULT NULL, ADD surface_du_terrain VARCHAR(255) DEFAULT NULL, ADD pieces VARCHAR(255) DEFAULT NULL, ADD energie VARCHAR(255) DEFAULT NULL, ADD ges VARCHAR(255) DEFAULT NULL, ADD vente VARCHAR(255) DEFAULT NULL, ADD etages VARCHAR(255) DEFAULT NULL, ADD etage VARCHAR(255) DEFAULT NULL, ADD parking VARCHAR(255) DEFAULT NULL, ADD charges VARCHAR(255) DEFAULT NULL, ADD meuble VARCHAR(255) DEFAULT NULL, ADD reference VARCHAR(255) DEFAULT NULL, ADD honoraires VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parse2 DROP type_de_bien, DROP type_de_vente, DROP surface, DROP surface_du_terrain, DROP pieces, DROP energie, DROP ges, DROP vente, DROP etages, DROP etage, DROP parking, DROP charges, DROP meuble, DROP reference, DROP honoraires');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220515153250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parse1_example ADD CONSTRAINT FK_36025CEE31655638 FOREIGN KEY (category_site_id) REFERENCES category_site (id)');
        $this->addSql('ALTER TABLE parse1_example RENAME INDEX idx_c067d35931655638 TO IDX_36025CEE31655638');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parse1_example DROP FOREIGN KEY FK_36025CEE31655638');
        $this->addSql('ALTER TABLE parse1_example RENAME INDEX idx_36025cee31655638 TO IDX_C067D35931655638');
    }
}

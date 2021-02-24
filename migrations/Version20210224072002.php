<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210224072002 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE projet_bailleur (projet_id INT NOT NULL, bailleur_id INT NOT NULL, INDEX IDX_5D3B4C04C18272 (projet_id), INDEX IDX_5D3B4C0457B5D0A2 (bailleur_id), PRIMARY KEY(projet_id, bailleur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projet_bailleur ADD CONSTRAINT FK_5D3B4C04C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_bailleur ADD CONSTRAINT FK_5D3B4C0457B5D0A2 FOREIGN KEY (bailleur_id) REFERENCES bailleur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE projet_bailleur');
    }
}

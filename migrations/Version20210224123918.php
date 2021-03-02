<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210224123918 extends AbstractMigration
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
        $this->addSql('DROP TABLE bailleur_bailleur');
        $this->addSql('DROP INDEX IDX_50159CA957B5D0A2 ON projet');
        $this->addSql('ALTER TABLE projet DROP bailleur_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bailleur_bailleur (bailleur_source INT NOT NULL, bailleur_target INT NOT NULL, INDEX IDX_8078C37E93F6A448 (bailleur_target), INDEX IDX_8078C37E8A13F4C7 (bailleur_source), PRIMARY KEY(bailleur_source, bailleur_target)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bailleur_bailleur ADD CONSTRAINT FK_8078C37E8A13F4C7 FOREIGN KEY (bailleur_source) REFERENCES bailleur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bailleur_bailleur ADD CONSTRAINT FK_8078C37E93F6A448 FOREIGN KEY (bailleur_target) REFERENCES bailleur (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE projet_bailleur');
        $this->addSql('ALTER TABLE projet ADD bailleur_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_50159CA957B5D0A2 ON projet (bailleur_id)');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210224073235 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE bailleur_projet');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bailleur_projet (bailleur_id INT NOT NULL, projet_id INT NOT NULL, INDEX IDX_858C171DC18272 (projet_id), INDEX IDX_858C171D57B5D0A2 (bailleur_id), PRIMARY KEY(bailleur_id, projet_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bailleur_projet ADD CONSTRAINT FK_858C171D57B5D0A2 FOREIGN KEY (bailleur_id) REFERENCES bailleur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bailleur_projet ADD CONSTRAINT FK_858C171DC18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
    }
}

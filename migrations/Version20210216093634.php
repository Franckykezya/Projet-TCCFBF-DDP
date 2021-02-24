<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210216093634 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bailleur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bailleur_projet (bailleur_id INT NOT NULL, projet_id INT NOT NULL, INDEX IDX_858C171D57B5D0A2 (bailleur_id), INDEX IDX_858C171DC18272 (projet_id), PRIMARY KEY(bailleur_id, projet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bailleur_projet ADD CONSTRAINT FK_858C171D57B5D0A2 FOREIGN KEY (bailleur_id) REFERENCES bailleur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bailleur_projet ADD CONSTRAINT FK_858C171DC18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bailleur_projet DROP FOREIGN KEY FK_858C171D57B5D0A2');
        $this->addSql('DROP TABLE bailleur');
        $this->addSql('DROP TABLE bailleur_projet');
    }
}

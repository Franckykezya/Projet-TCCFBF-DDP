<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210216062347 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bailleur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projet ADD bailleur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA957B5D0A2 FOREIGN KEY (bailleur_id) REFERENCES bailleur (id)');
        $this->addSql('CREATE INDEX IDX_50159CA957B5D0A2 ON projet (bailleur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA957B5D0A2');
        $this->addSql('DROP TABLE bailleur');
        $this->addSql('DROP INDEX IDX_50159CA957B5D0A2 ON projet');
        $this->addSql('ALTER TABLE projet DROP bailleur_id');
    }
}

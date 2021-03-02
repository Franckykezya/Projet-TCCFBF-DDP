<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210301150446 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bailleur ADD siege VARCHAR(255) NOT NULL, ADD telephone INT DEFAULT NULL, ADD adresse_mail VARCHAR(255) DEFAULT NULL, ADD fax INT DEFAULT NULL');
        $this->addSql('ALTER TABLE taux_variable ADD valeur_calcul_element_don DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bailleur DROP siege, DROP telephone, DROP adresse_mail, DROP fax');
        $this->addSql('ALTER TABLE taux_variable DROP valeur_calcul_element_don');
    }
}

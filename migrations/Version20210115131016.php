<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210115131016 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE taux_fixe (id INT AUTO_INCREMENT NOT NULL, base VARCHAR(255) DEFAULT NULL, valeur DOUBLE PRECISION DEFAULT NULL, valeur_element_don DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taux_interet_type (id INT AUTO_INCREMENT NOT NULL, tauxfixe_id INT DEFAULT NULL, tauxvariable_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_65F34FFE451F643C (tauxfixe_id), UNIQUE INDEX UNIQ_65F34FFE57382588 (tauxvariable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taux_variable (id INT AUTO_INCREMENT NOT NULL, base VARCHAR(255) DEFAULT NULL, valeur DOUBLE PRECISION DEFAULT NULL, marge DOUBLE PRECISION DEFAULT NULL, total DOUBLE PRECISION DEFAULT NULL, valeur_element_don DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE taux_interet_type ADD CONSTRAINT FK_65F34FFE451F643C FOREIGN KEY (tauxfixe_id) REFERENCES taux_fixe (id)');
        $this->addSql('ALTER TABLE taux_interet_type ADD CONSTRAINT FK_65F34FFE57382588 FOREIGN KEY (tauxvariable_id) REFERENCES taux_variable (id)');
        $this->addSql('ALTER TABLE bailleur ADD tauxinteret_id INT DEFAULT NULL, DROP tauxinteret_description, DROP tauxinteret_valeur');
        $this->addSql('ALTER TABLE bailleur ADD CONSTRAINT FK_7ABB27F32BB7F5AA FOREIGN KEY (tauxinteret_id) REFERENCES taux_interet_type (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7ABB27F32BB7F5AA ON bailleur (tauxinteret_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE taux_interet_type DROP FOREIGN KEY FK_65F34FFE451F643C');
        $this->addSql('ALTER TABLE bailleur DROP FOREIGN KEY FK_7ABB27F32BB7F5AA');
        $this->addSql('ALTER TABLE taux_interet_type DROP FOREIGN KEY FK_65F34FFE57382588');
        $this->addSql('DROP TABLE taux_fixe');
        $this->addSql('DROP TABLE taux_interet_type');
        $this->addSql('DROP TABLE taux_variable');
        $this->addSql('DROP INDEX UNIQ_7ABB27F32BB7F5AA ON bailleur');
        $this->addSql('ALTER TABLE bailleur ADD tauxinteret_description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD tauxinteret_valeur DOUBLE PRECISION DEFAULT NULL, DROP tauxinteret_id');
    }
}

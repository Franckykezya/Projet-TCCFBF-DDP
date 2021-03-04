<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210303095710 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE taux_interet_type');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE taux_interet_type (id INT AUTO_INCREMENT NOT NULL, tauxfixe_id INT DEFAULT NULL, tauxvariable_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_65F34FFE451F643C (tauxfixe_id), UNIQUE INDEX UNIQ_65F34FFE57382588 (tauxvariable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE taux_interet_type ADD CONSTRAINT FK_65F34FFE451F643C FOREIGN KEY (tauxfixe_id) REFERENCES taux_fixe (id)');
        $this->addSql('ALTER TABLE taux_interet_type ADD CONSTRAINT FK_65F34FFE57382588 FOREIGN KEY (tauxvariable_id) REFERENCES taux_variable (id)');
    }
}

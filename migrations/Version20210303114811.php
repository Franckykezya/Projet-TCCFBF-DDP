<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210303114811 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE projet_taux_fixe');
        $this->addSql('DROP TABLE projet_taux_variable');
        $this->addSql('ALTER TABLE projet ADD tauxfixe_id INT DEFAULT NULL, ADD tauxvariable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9451F643C FOREIGN KEY (tauxfixe_id) REFERENCES taux_fixe (id)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA957382588 FOREIGN KEY (tauxvariable_id) REFERENCES taux_variable (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_50159CA9451F643C ON projet (tauxfixe_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_50159CA957382588 ON projet (tauxvariable_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE projet_taux_fixe (projet_id INT NOT NULL, taux_fixe_id INT NOT NULL, INDEX IDX_14EED7E581196C37 (taux_fixe_id), INDEX IDX_14EED7E5C18272 (projet_id), PRIMARY KEY(projet_id, taux_fixe_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE projet_taux_variable (projet_id INT NOT NULL, taux_variable_id INT NOT NULL, INDEX IDX_8562C8C34479521E (taux_variable_id), INDEX IDX_8562C8C3C18272 (projet_id), PRIMARY KEY(projet_id, taux_variable_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE projet_taux_fixe ADD CONSTRAINT FK_14EED7E581196C37 FOREIGN KEY (taux_fixe_id) REFERENCES taux_fixe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_taux_fixe ADD CONSTRAINT FK_14EED7E5C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_taux_variable ADD CONSTRAINT FK_8562C8C34479521E FOREIGN KEY (taux_variable_id) REFERENCES taux_variable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_taux_variable ADD CONSTRAINT FK_8562C8C3C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9451F643C');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA957382588');
        $this->addSql('DROP INDEX UNIQ_50159CA9451F643C ON projet');
        $this->addSql('DROP INDEX UNIQ_50159CA957382588 ON projet');
        $this->addSql('ALTER TABLE projet DROP tauxfixe_id, DROP tauxvariable_id');
    }
}

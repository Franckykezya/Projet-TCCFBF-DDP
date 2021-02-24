<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210215075852 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bailleur_secteur_intervention DROP FOREIGN KEY FK_2068572457B5D0A2');
        $this->addSql('ALTER TABLE bailleur_type_financement DROP FOREIGN KEY FK_B8B9BE2E57B5D0A2');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, tauxinteret_id INT DEFAULT NULL, nom VARCHAR(100) NOT NULL, part_finance INT NOT NULL, maturite_facilite INT NOT NULL, periode_grace INT DEFAULT NULL, differentiel_interet DOUBLE PRECISION DEFAULT NULL, frais_gestion DOUBLE PRECISION DEFAULT NULL, commission_engagement DOUBLE PRECISION DEFAULT NULL, commission_service DOUBLE PRECISION DEFAULT NULL, commission_initiale DOUBLE PRECISION DEFAULT NULL, commission_arrangement DOUBLE PRECISION DEFAULT NULL, commission_agent DOUBLE PRECISION DEFAULT NULL, maturite_lettre_credit INT DEFAULT NULL, frais_lies_lettre_credit DOUBLE PRECISION DEFAULT NULL, frais_lies_refinancement DOUBLE PRECISION DEFAULT NULL, frais_et_debours DOUBLE PRECISION DEFAULT NULL, prime_assurance_et_frais_garantie DOUBLE PRECISION DEFAULT NULL, prime_attenuation_risque_credit DOUBLE PRECISION DEFAULT NULL, elementdon DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_50159CA92BB7F5AA (tauxinteret_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet_secteur_intervention (projet_id INT NOT NULL, secteur_intervention_id INT NOT NULL, INDEX IDX_9AC9E525C18272 (projet_id), INDEX IDX_9AC9E525458ABAB5 (secteur_intervention_id), PRIMARY KEY(projet_id, secteur_intervention_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet_type_financement (projet_id INT NOT NULL, type_financement_id INT NOT NULL, INDEX IDX_3DE6A47C18272 (projet_id), INDEX IDX_3DE6A47F1F4C4E0 (type_financement_id), PRIMARY KEY(projet_id, type_financement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA92BB7F5AA FOREIGN KEY (tauxinteret_id) REFERENCES taux_interet_type (id)');
        $this->addSql('ALTER TABLE projet_secteur_intervention ADD CONSTRAINT FK_9AC9E525C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_secteur_intervention ADD CONSTRAINT FK_9AC9E525458ABAB5 FOREIGN KEY (secteur_intervention_id) REFERENCES secteur_intervention (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_type_financement ADD CONSTRAINT FK_3DE6A47C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_type_financement ADD CONSTRAINT FK_3DE6A47F1F4C4E0 FOREIGN KEY (type_financement_id) REFERENCES type_financement (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE bailleur');
        $this->addSql('DROP TABLE bailleur_secteur_intervention');
        $this->addSql('DROP TABLE bailleur_type_financement');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet_secteur_intervention DROP FOREIGN KEY FK_9AC9E525C18272');
        $this->addSql('ALTER TABLE projet_type_financement DROP FOREIGN KEY FK_3DE6A47C18272');
        $this->addSql('CREATE TABLE bailleur (id INT AUTO_INCREMENT NOT NULL, tauxinteret_id INT DEFAULT NULL, nom VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, part_finance INT NOT NULL, maturite_facilite INT NOT NULL, periode_grace INT DEFAULT NULL, differentiel_interet DOUBLE PRECISION DEFAULT NULL, frais_gestion DOUBLE PRECISION DEFAULT NULL, commission_engagement DOUBLE PRECISION DEFAULT NULL, commission_service DOUBLE PRECISION DEFAULT NULL, commission_initiale DOUBLE PRECISION DEFAULT NULL, commission_arrangement DOUBLE PRECISION DEFAULT NULL, commission_agent DOUBLE PRECISION DEFAULT NULL, maturite_lettre_credit INT DEFAULT NULL, frais_lies_lettre_credit DOUBLE PRECISION DEFAULT NULL, frais_lies_refinancement DOUBLE PRECISION DEFAULT NULL, frais_et_debours DOUBLE PRECISION DEFAULT NULL, prime_assurance_et_frais_garantie DOUBLE PRECISION DEFAULT NULL, prime_attenuation_risque_credit DOUBLE PRECISION DEFAULT NULL, elementdon DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_7ABB27F32BB7F5AA (tauxinteret_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bailleur_secteur_intervention (bailleur_id INT NOT NULL, secteur_intervention_id INT NOT NULL, INDEX IDX_20685724458ABAB5 (secteur_intervention_id), INDEX IDX_2068572457B5D0A2 (bailleur_id), PRIMARY KEY(bailleur_id, secteur_intervention_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bailleur_type_financement (bailleur_id INT NOT NULL, type_financement_id INT NOT NULL, INDEX IDX_B8B9BE2EF1F4C4E0 (type_financement_id), INDEX IDX_B8B9BE2E57B5D0A2 (bailleur_id), PRIMARY KEY(bailleur_id, type_financement_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bailleur ADD CONSTRAINT FK_7ABB27F32BB7F5AA FOREIGN KEY (tauxinteret_id) REFERENCES taux_interet_type (id)');
        $this->addSql('ALTER TABLE bailleur_secteur_intervention ADD CONSTRAINT FK_20685724458ABAB5 FOREIGN KEY (secteur_intervention_id) REFERENCES secteur_intervention (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bailleur_secteur_intervention ADD CONSTRAINT FK_2068572457B5D0A2 FOREIGN KEY (bailleur_id) REFERENCES bailleur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bailleur_type_financement ADD CONSTRAINT FK_B8B9BE2E57B5D0A2 FOREIGN KEY (bailleur_id) REFERENCES bailleur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bailleur_type_financement ADD CONSTRAINT FK_B8B9BE2EF1F4C4E0 FOREIGN KEY (type_financement_id) REFERENCES type_financement (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE projet_secteur_intervention');
        $this->addSql('DROP TABLE projet_type_financement');
    }
}

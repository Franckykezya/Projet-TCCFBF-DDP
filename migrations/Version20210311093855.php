<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210311093855 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bailleur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, siege VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, mail VARCHAR(255) DEFAULT NULL, fax VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, tauxfixe_id INT DEFAULT NULL, tauxvariable_id INT DEFAULT NULL, nom VARCHAR(100) NOT NULL, part_finance INT NOT NULL, maturite_facilite INT NOT NULL, periode_grace INT DEFAULT NULL, differentiel_interet DOUBLE PRECISION DEFAULT NULL, frais_gestion DOUBLE PRECISION DEFAULT NULL, commission_engagement DOUBLE PRECISION DEFAULT NULL, commission_service DOUBLE PRECISION DEFAULT NULL, commission_initiale DOUBLE PRECISION DEFAULT NULL, commission_arrangement DOUBLE PRECISION DEFAULT NULL, commission_agent DOUBLE PRECISION DEFAULT NULL, maturite_lettre_credit INT DEFAULT NULL, frais_lies_lettre_credit DOUBLE PRECISION DEFAULT NULL, frais_lies_refinancement DOUBLE PRECISION DEFAULT NULL, frais_et_debours DOUBLE PRECISION DEFAULT NULL, prime_assurance_et_frais_garantie DOUBLE PRECISION DEFAULT NULL, prime_attenuation_risque_credit DOUBLE PRECISION DEFAULT NULL, elementdon DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_50159CA9451F643C (tauxfixe_id), UNIQUE INDEX UNIQ_50159CA957382588 (tauxvariable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet_secteur_intervention (projet_id INT NOT NULL, secteur_intervention_id INT NOT NULL, INDEX IDX_9AC9E525C18272 (projet_id), INDEX IDX_9AC9E525458ABAB5 (secteur_intervention_id), PRIMARY KEY(projet_id, secteur_intervention_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet_type_financement (projet_id INT NOT NULL, type_financement_id INT NOT NULL, INDEX IDX_3DE6A47C18272 (projet_id), INDEX IDX_3DE6A47F1F4C4E0 (type_financement_id), PRIMARY KEY(projet_id, type_financement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet_bailleur (projet_id INT NOT NULL, bailleur_id INT NOT NULL, INDEX IDX_5D3B4C04C18272 (projet_id), INDEX IDX_5D3B4C0457B5D0A2 (bailleur_id), PRIMARY KEY(projet_id, bailleur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE secteur_intervention (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taux_fixe (id INT AUTO_INCREMENT NOT NULL, base VARCHAR(255) DEFAULT NULL, valeur DOUBLE PRECISION DEFAULT NULL, valeur_element_don DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taux_variable (id INT AUTO_INCREMENT NOT NULL, base VARCHAR(255) DEFAULT NULL, valeur DOUBLE PRECISION DEFAULT NULL, marge DOUBLE PRECISION DEFAULT NULL, total DOUBLE PRECISION DEFAULT NULL, valeur_element_don DOUBLE PRECISION DEFAULT NULL, valeur_calcul_element_don DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_financement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9451F643C FOREIGN KEY (tauxfixe_id) REFERENCES taux_fixe (id)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA957382588 FOREIGN KEY (tauxvariable_id) REFERENCES taux_variable (id)');
        $this->addSql('ALTER TABLE projet_secteur_intervention ADD CONSTRAINT FK_9AC9E525C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_secteur_intervention ADD CONSTRAINT FK_9AC9E525458ABAB5 FOREIGN KEY (secteur_intervention_id) REFERENCES secteur_intervention (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_type_financement ADD CONSTRAINT FK_3DE6A47C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_type_financement ADD CONSTRAINT FK_3DE6A47F1F4C4E0 FOREIGN KEY (type_financement_id) REFERENCES type_financement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_bailleur ADD CONSTRAINT FK_5D3B4C04C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_bailleur ADD CONSTRAINT FK_5D3B4C0457B5D0A2 FOREIGN KEY (bailleur_id) REFERENCES bailleur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet_bailleur DROP FOREIGN KEY FK_5D3B4C0457B5D0A2');
        $this->addSql('ALTER TABLE projet_secteur_intervention DROP FOREIGN KEY FK_9AC9E525C18272');
        $this->addSql('ALTER TABLE projet_type_financement DROP FOREIGN KEY FK_3DE6A47C18272');
        $this->addSql('ALTER TABLE projet_bailleur DROP FOREIGN KEY FK_5D3B4C04C18272');
        $this->addSql('ALTER TABLE projet_secteur_intervention DROP FOREIGN KEY FK_9AC9E525458ABAB5');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9451F643C');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA957382588');
        $this->addSql('ALTER TABLE projet_type_financement DROP FOREIGN KEY FK_3DE6A47F1F4C4E0');
        $this->addSql('DROP TABLE bailleur');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE projet_secteur_intervention');
        $this->addSql('DROP TABLE projet_type_financement');
        $this->addSql('DROP TABLE projet_bailleur');
        $this->addSql('DROP TABLE secteur_intervention');
        $this->addSql('DROP TABLE taux_fixe');
        $this->addSql('DROP TABLE taux_variable');
        $this->addSql('DROP TABLE type_financement');
        $this->addSql('DROP TABLE user');
    }
}

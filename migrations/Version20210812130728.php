<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210812130728 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet ADD description LONGTEXT NOT NULL, ADD signature DATE NOT NULL, ADD date_mise_vigueur DATE DEFAULT NULL, ADD date_limite_decaissement DATE DEFAULT NULL, ADD type VARCHAR(10) NOT NULL, ADD situation VARCHAR(10) NOT NULL, ADD mo_monnaie VARCHAR(10) NOT NULL, ADD mo_montant DOUBLE PRECISION DEFAULT NULL, ADD mo_equivalent_usd DOUBLE PRECISION DEFAULT NULL, ADD de_montant_accord DOUBLE PRECISION DEFAULT NULL, ADD de_equivalent_usd DOUBLE PRECISION DEFAULT NULL, ADD de_taux DOUBLE PRECISION DEFAULT NULL, ADD de_reste_decaisser DOUBLE PRECISION DEFAULT NULL, ADD de_rest_decaisser_usd DOUBLE PRECISION DEFAULT NULL, ADD de_montant_mga DOUBLE PRECISION DEFAULT NULL, ADD di_montant_usd DOUBLE PRECISION DEFAULT NULL, ADD di_date_notification DATE DEFAULT NULL, ADD di_nature_depenses LONGTEXT DEFAULT NULL, ADD di_situation VARCHAR(20) DEFAULT NULL, ADD pricipaux_problemes LONGTEXT DEFAULT NULL, ADD mesures_prises LONGTEXT DEFAULT NULL, ADD concessionalite VARCHAR(20) NOT NULL, ADD statut VARCHAR(10) NOT NULL, ADD observations LONGTEXT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_50159CA96C6E55B5 ON projet (nom)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D9BC15A96C6E55B5 ON secteur_intervention (nom)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_129088C76C6E55B5 ON type_financement (nom)');
        $this->addSql('ALTER TABLE user DROP role');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_50159CA96C6E55B5 ON projet');
        $this->addSql('ALTER TABLE projet DROP description, DROP signature, DROP date_mise_vigueur, DROP date_limite_decaissement, DROP type, DROP situation, DROP mo_monnaie, DROP mo_montant, DROP mo_equivalent_usd, DROP de_montant_accord, DROP de_equivalent_usd, DROP de_taux, DROP de_reste_decaisser, DROP de_rest_decaisser_usd, DROP de_montant_mga, DROP di_montant_usd, DROP di_date_notification, DROP di_nature_depenses, DROP di_situation, DROP pricipaux_problemes, DROP mesures_prises, DROP concessionalite, DROP statut, DROP observations');
        $this->addSql('DROP INDEX UNIQ_D9BC15A96C6E55B5 ON secteur_intervention');
        $this->addSql('DROP INDEX UNIQ_129088C76C6E55B5 ON type_financement');
        $this->addSql('ALTER TABLE user ADD role VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}

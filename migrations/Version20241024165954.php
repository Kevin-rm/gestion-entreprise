<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241024165954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE antecedent (id VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE bon_de_commande (id VARCHAR(255) NOT NULL, id_fournisseur VARCHAR(255) NOT NULL, date_heure TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2C3802E42E8C07C5 ON bon_de_commande (id_fournisseur)');
        $this->addSql('CREATE TABLE bon_de_reception (id VARCHAR(255) NOT NULL, id_bon_de_commande VARCHAR(255) NOT NULL, date_heure TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D9477C6BC566C16C ON bon_de_reception (id_bon_de_commande)');
        $this->addSql('CREATE TABLE chaine_approbation (id VARCHAR(255) NOT NULL, id_niveau_validation VARCHAR(255) NOT NULL, date_heure_validation TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, commentaire TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_48D25347B317B5B4 ON chaine_approbation (id_niveau_validation)');
        $this->addSql('CREATE TABLE demande_achat (id VARCHAR(255) NOT NULL, id_utilisateur VARCHAR(255) NOT NULL, fournisseur VARCHAR(255) NOT NULL, motif TEXT NOT NULL, date_heure TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status_validation VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D077077F50EAE44 ON demande_achat (id_utilisateur)');
        $this->addSql('CREATE INDEX IDX_D077077F369ECA32 ON demande_achat (fournisseur)');
        $this->addSql('CREATE TABLE departement (id VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE details_bon_de_commande (id VARCHAR(255) NOT NULL, id_produit VARCHAR(255) NOT NULL, id_bon_de_commande VARCHAR(255) NOT NULL, quantite DOUBLE PRECISION NOT NULL, prix_unitaire NUMERIC(10, 2) NOT NULL, tva NUMERIC(4, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C857EE8FF7384557 ON details_bon_de_commande (id_produit)');
        $this->addSql('CREATE INDEX IDX_C857EE8FC566C16C ON details_bon_de_commande (id_bon_de_commande)');
        $this->addSql('CREATE TABLE details_bon_de_reception (id VARCHAR(255) NOT NULL, id_produit VARCHAR(255) NOT NULL, id_bon_de_reception VARCHAR(255) NOT NULL, quantite DOUBLE PRECISION NOT NULL, prix_unitaire NUMERIC(10, 2) NOT NULL, tva NUMERIC(4, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3C3AB57F7384557 ON details_bon_de_reception (id_produit)');
        $this->addSql('CREATE INDEX IDX_3C3AB573ACD29BA ON details_bon_de_reception (id_bon_de_reception)');
        $this->addSql('CREATE TABLE details_demande_achat (id VARCHAR(255) NOT NULL, id_produit VARCHAR(255) NOT NULL, id_demande_achat VARCHAR(255) NOT NULL, cout_unitaire_estime NUMERIC(10, 2) NOT NULL, quantite DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_98E858A1F7384557 ON details_demande_achat (id_produit)');
        $this->addSql('CREATE INDEX IDX_98E858A16E5FD61A ON details_demande_achat (id_demande_achat)');
        $this->addSql('CREATE TABLE details_mouvement_stock (id VARCHAR(255) NOT NULL, id_produit VARCHAR(255) NOT NULL, id_mouvement VARCHAR(255) NOT NULL, quantite DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_858D2480F7384557 ON details_mouvement_stock (id_produit)');
        $this->addSql('CREATE INDEX IDX_858D2480DB644019 ON details_mouvement_stock (id_mouvement)');
        $this->addSql('CREATE TABLE mouvement_stock (id VARCHAR(255) NOT NULL, type_mouvement_stock VARCHAR(255) NOT NULL, date_heure TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE niveau_validation (id VARCHAR(255) NOT NULL, approbateur VARCHAR(255) NOT NULL, tache VARCHAR(255) DEFAULT NULL, ordre SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4220DDA3C8D047B7 ON niveau_validation (approbateur)');
        $this->addSql('CREATE TABLE produit (id VARCHAR(255) NOT NULL, id_unite VARCHAR(255) DEFAULT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_29A5EC27F3E18028 ON produit (id_unite)');
        $this->addSql('CREATE TABLE tiers (id VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tiers_antecedent (id_tiers VARCHAR(255) NOT NULL, id_antecedent VARCHAR(255) NOT NULL, PRIMARY KEY(id_tiers, id_antecedent))');
        $this->addSql('CREATE INDEX IDX_6B086220F8C27A92 ON tiers_antecedent (id_tiers)');
        $this->addSql('CREATE INDEX IDX_6B08622094EC3EAB ON tiers_antecedent (id_antecedent)');
        $this->addSql('CREATE TABLE unite (id VARCHAR(255) NOT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE utilisateur (id VARCHAR(255) NOT NULL, id_departement VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1D1C63B3D9649694 ON utilisateur (id_departement)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON utilisateur (email)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE bon_de_commande ADD CONSTRAINT FK_2C3802E42E8C07C5 FOREIGN KEY (id_fournisseur) REFERENCES tiers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bon_de_reception ADD CONSTRAINT FK_D9477C6BC566C16C FOREIGN KEY (id_bon_de_commande) REFERENCES bon_de_commande (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chaine_approbation ADD CONSTRAINT FK_48D25347B317B5B4 FOREIGN KEY (id_niveau_validation) REFERENCES niveau_validation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demande_achat ADD CONSTRAINT FK_D077077F50EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demande_achat ADD CONSTRAINT FK_D077077F369ECA32 FOREIGN KEY (fournisseur) REFERENCES tiers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE details_bon_de_commande ADD CONSTRAINT FK_C857EE8FF7384557 FOREIGN KEY (id_produit) REFERENCES produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE details_bon_de_commande ADD CONSTRAINT FK_C857EE8FC566C16C FOREIGN KEY (id_bon_de_commande) REFERENCES bon_de_commande (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE details_bon_de_reception ADD CONSTRAINT FK_3C3AB57F7384557 FOREIGN KEY (id_produit) REFERENCES produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE details_bon_de_reception ADD CONSTRAINT FK_3C3AB573ACD29BA FOREIGN KEY (id_bon_de_reception) REFERENCES bon_de_reception (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE details_demande_achat ADD CONSTRAINT FK_98E858A1F7384557 FOREIGN KEY (id_produit) REFERENCES produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE details_demande_achat ADD CONSTRAINT FK_98E858A16E5FD61A FOREIGN KEY (id_demande_achat) REFERENCES demande_achat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE details_mouvement_stock ADD CONSTRAINT FK_858D2480F7384557 FOREIGN KEY (id_produit) REFERENCES produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE details_mouvement_stock ADD CONSTRAINT FK_858D2480DB644019 FOREIGN KEY (id_mouvement) REFERENCES mouvement_stock (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE niveau_validation ADD CONSTRAINT FK_4220DDA3C8D047B7 FOREIGN KEY (approbateur) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27F3E18028 FOREIGN KEY (id_unite) REFERENCES unite (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tiers_antecedent ADD CONSTRAINT FK_6B086220F8C27A92 FOREIGN KEY (id_tiers) REFERENCES tiers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tiers_antecedent ADD CONSTRAINT FK_6B08622094EC3EAB FOREIGN KEY (id_antecedent) REFERENCES antecedent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3D9649694 FOREIGN KEY (id_departement) REFERENCES departement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE bon_de_commande DROP CONSTRAINT FK_2C3802E42E8C07C5');
        $this->addSql('ALTER TABLE bon_de_reception DROP CONSTRAINT FK_D9477C6BC566C16C');
        $this->addSql('ALTER TABLE chaine_approbation DROP CONSTRAINT FK_48D25347B317B5B4');
        $this->addSql('ALTER TABLE demande_achat DROP CONSTRAINT FK_D077077F50EAE44');
        $this->addSql('ALTER TABLE demande_achat DROP CONSTRAINT FK_D077077F369ECA32');
        $this->addSql('ALTER TABLE details_bon_de_commande DROP CONSTRAINT FK_C857EE8FF7384557');
        $this->addSql('ALTER TABLE details_bon_de_commande DROP CONSTRAINT FK_C857EE8FC566C16C');
        $this->addSql('ALTER TABLE details_bon_de_reception DROP CONSTRAINT FK_3C3AB57F7384557');
        $this->addSql('ALTER TABLE details_bon_de_reception DROP CONSTRAINT FK_3C3AB573ACD29BA');
        $this->addSql('ALTER TABLE details_demande_achat DROP CONSTRAINT FK_98E858A1F7384557');
        $this->addSql('ALTER TABLE details_demande_achat DROP CONSTRAINT FK_98E858A16E5FD61A');
        $this->addSql('ALTER TABLE details_mouvement_stock DROP CONSTRAINT FK_858D2480F7384557');
        $this->addSql('ALTER TABLE details_mouvement_stock DROP CONSTRAINT FK_858D2480DB644019');
        $this->addSql('ALTER TABLE niveau_validation DROP CONSTRAINT FK_4220DDA3C8D047B7');
        $this->addSql('ALTER TABLE produit DROP CONSTRAINT FK_29A5EC27F3E18028');
        $this->addSql('ALTER TABLE tiers_antecedent DROP CONSTRAINT FK_6B086220F8C27A92');
        $this->addSql('ALTER TABLE tiers_antecedent DROP CONSTRAINT FK_6B08622094EC3EAB');
        $this->addSql('ALTER TABLE utilisateur DROP CONSTRAINT FK_1D1C63B3D9649694');
        $this->addSql('DROP TABLE antecedent');
        $this->addSql('DROP TABLE bon_de_commande');
        $this->addSql('DROP TABLE bon_de_reception');
        $this->addSql('DROP TABLE chaine_approbation');
        $this->addSql('DROP TABLE demande_achat');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE details_bon_de_commande');
        $this->addSql('DROP TABLE details_bon_de_reception');
        $this->addSql('DROP TABLE details_demande_achat');
        $this->addSql('DROP TABLE details_mouvement_stock');
        $this->addSql('DROP TABLE mouvement_stock');
        $this->addSql('DROP TABLE niveau_validation');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE tiers');
        $this->addSql('DROP TABLE tiers_antecedent');
        $this->addSql('DROP TABLE unite');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

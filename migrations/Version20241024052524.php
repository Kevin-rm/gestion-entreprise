<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241024052524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE antecedent ADD date DATE NOT NULL');
        //$this->addSql('ALTER TABLE details_document_commercial ADD CONSTRAINT FK_DE4D5037D79058F8 FOREIGN KEY (document_commercial) REFERENCES abstract_document_commercial (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE details_mouvement_stock DROP CONSTRAINT fk_858d24808ed12402');
        $this->addSql('ALTER TABLE details_mouvement_stock DROP CONSTRAINT fk_858d2480f347efb');
        $this->addSql('DROP INDEX idx_858d2480f347efb');
        $this->addSql('DROP INDEX idx_858d24808ed12402');
        $this->addSql('ALTER TABLE details_mouvement_stock ADD id_mouvement VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE details_mouvement_stock DROP mouvement_stock_id');
        $this->addSql('ALTER TABLE details_mouvement_stock DROP prix_unitaire');
        $this->addSql('ALTER TABLE details_mouvement_stock ALTER quantite TYPE DOUBLE PRECISION');
        $this->addSql('ALTER TABLE details_mouvement_stock RENAME COLUMN produit_id TO id_produit');
        $this->addSql('ALTER TABLE details_mouvement_stock ADD CONSTRAINT FK_858D2480F7384557 FOREIGN KEY (id_produit) REFERENCES produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE details_mouvement_stock ADD CONSTRAINT FK_858D2480DB644019 FOREIGN KEY (id_mouvement) REFERENCES mouvement_stock (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_858D2480F7384557 ON details_mouvement_stock (id_produit)');
        $this->addSql('CREATE INDEX IDX_858D2480DB644019 ON details_mouvement_stock (id_mouvement)');
        $this->addSql('ALTER TABLE mouvement_stock RENAME COLUMN date_heur TO date_heure');
        $this->addSql('ALTER TABLE produit ADD prix_unitaire NUMERIC(10, 2) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE details_document_commercial DROP CONSTRAINT FK_DE4D5037D79058F8');
        $this->addSql('ALTER TABLE produit DROP prix_unitaire');
        $this->addSql('ALTER TABLE details_mouvement_stock DROP CONSTRAINT FK_858D2480F7384557');
        $this->addSql('ALTER TABLE details_mouvement_stock DROP CONSTRAINT FK_858D2480DB644019');
        $this->addSql('DROP INDEX IDX_858D2480F7384557');
        $this->addSql('DROP INDEX IDX_858D2480DB644019');
        $this->addSql('ALTER TABLE details_mouvement_stock ADD mouvement_stock_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE details_mouvement_stock ADD produit_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE details_mouvement_stock ADD prix_unitaire NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE details_mouvement_stock DROP id_produit');
        $this->addSql('ALTER TABLE details_mouvement_stock DROP id_mouvement');
        $this->addSql('ALTER TABLE details_mouvement_stock ALTER quantite TYPE NUMERIC(10, 2)');
        $this->addSql('ALTER TABLE details_mouvement_stock ADD CONSTRAINT fk_858d24808ed12402 FOREIGN KEY (mouvement_stock_id) REFERENCES mouvement_stock (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE details_mouvement_stock ADD CONSTRAINT fk_858d2480f347efb FOREIGN KEY (produit_id) REFERENCES produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_858d2480f347efb ON details_mouvement_stock (produit_id)');
        $this->addSql('CREATE INDEX idx_858d24808ed12402 ON details_mouvement_stock (mouvement_stock_id)');
        $this->addSql('ALTER TABLE antecedent DROP date');
        $this->addSql('ALTER TABLE mouvement_stock RENAME COLUMN date_heure TO date_heur');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210304084226 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, total DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_24CC0DF282EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF282EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664101F8D148');
        $this->addSql('DROP INDEX UNIQ_FE8664101F8D148 ON facture');
        $this->addSql('ALTER TABLE facture ADD date_facture DATE NOT NULL, ADD montant DOUBLE PRECISION NOT NULL, DROP datefacture, CHANGE montant_id commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE86641082EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FE86641082EA2E54 ON facture (commande_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE panier');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE86641082EA2E54');
        $this->addSql('DROP INDEX UNIQ_FE86641082EA2E54 ON facture');
        $this->addSql('ALTER TABLE facture ADD datefacture VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP date_facture, DROP montant, CHANGE commande_id montant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664101F8D148 FOREIGN KEY (montant_id) REFERENCES commande (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FE8664101F8D148 ON facture (montant_id)');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210310200907 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_panier (article_id INT NOT NULL, panier_id INT NOT NULL, INDEX IDX_4E0B9A727294869C (article_id), INDEX IDX_4E0B9A72F77D927C (panier_id), PRIMARY KEY(article_id, panier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_panier ADD CONSTRAINT FK_4E0B9A727294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_panier ADD CONSTRAINT FK_4E0B9A72F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66BE35FDA0');
        $this->addSql('DROP INDEX IDX_23A0E66BE35FDA0 ON article');
        $this->addSql('ALTER TABLE article DROP paniers_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE article_panier');
        $this->addSql('ALTER TABLE article ADD paniers_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66BE35FDA0 FOREIGN KEY (paniers_id) REFERENCES panier (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66BE35FDA0 ON article (paniers_id)');
    }
}

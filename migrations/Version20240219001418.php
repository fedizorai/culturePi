<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219001418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur (id_user INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id_user)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE reservheberg ADD nbr_personne INT NOT NULL, ADD duree INT NOT NULL, ADD type_paiement VARCHAR(255) NOT NULL, ADD id_user INT NOT NULL, ADD id_hebergement INT NOT NULL');
        $this->addSql('ALTER TABLE reservheberg ADD CONSTRAINT FK_5CF9C6346B3CA4B FOREIGN KEY (id_user) REFERENCES utilisateur (id_user)');
        $this->addSql('ALTER TABLE reservheberg ADD CONSTRAINT FK_5CF9C6345040106B FOREIGN KEY (id_hebergement) REFERENCES hebergement (id_hebergement)');
        $this->addSql('CREATE INDEX IDX_5CF9C6346B3CA4B ON reservheberg (id_user)');
        $this->addSql('CREATE INDEX IDX_5CF9C6345040106B ON reservheberg (id_hebergement)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('ALTER TABLE reservheberg DROP FOREIGN KEY FK_5CF9C6346B3CA4B');
        $this->addSql('ALTER TABLE reservheberg DROP FOREIGN KEY FK_5CF9C6345040106B');
        $this->addSql('DROP INDEX IDX_5CF9C6346B3CA4B ON reservheberg');
        $this->addSql('DROP INDEX IDX_5CF9C6345040106B ON reservheberg');
        $this->addSql('ALTER TABLE reservheberg DROP nbr_personne, DROP duree, DROP type_paiement, DROP id_user, DROP id_hebergement');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219000255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservheberg (id INT AUTO_INCREMENT NOT NULL, nbr_personne INT NOT NULL, duree INT NOT NULL, type_paiement VARCHAR(255) NOT NULL, id_user INT NOT NULL, id_hebergement INT NOT NULL, INDEX IDX_5CF9C6346B3CA4B (id_user), INDEX IDX_5CF9C6345040106B (id_hebergement), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE utilisateur (id_user INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id_user)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE reservheberg ADD CONSTRAINT FK_5CF9C6346B3CA4B FOREIGN KEY (id_user) REFERENCES utilisateur (id_user)');
        $this->addSql('ALTER TABLE reservheberg ADD CONSTRAINT FK_5CF9C6345040106B FOREIGN KEY (id_hebergement) REFERENCES hebergement (id_hebergement)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservheberg DROP FOREIGN KEY FK_5CF9C6346B3CA4B');
        $this->addSql('ALTER TABLE reservheberg DROP FOREIGN KEY FK_5CF9C6345040106B');
        $this->addSql('DROP TABLE reservheberg');
        $this->addSql('DROP TABLE utilisateur');
    }
}

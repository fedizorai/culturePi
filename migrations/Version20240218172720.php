<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218172720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hebergement MODIFY id-hebergement INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON hebergement');
        $this->addSql('ALTER TABLE hebergement CHANGE id-hebergement id_hebergement INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE hebergement ADD PRIMARY KEY (id_hebergement)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hebergement MODIFY id_hebergement INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON hebergement');
        $this->addSql('ALTER TABLE hebergement CHANGE id_hebergement id-hebergement INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE hebergement ADD PRIMARY KEY (id-hebergement)');
    }
}

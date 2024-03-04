<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240302221446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar ADD title VARCHAR(255) NOT NULL, ADD start DATETIME NOT NULL, ADD end DATETIME NOT NULL, ADD description LONGTEXT NOT NULL, ADD all_day TINYINT(1) NOT NULL, ADD background_color VARCHAR(255) NOT NULL, ADD border_color VARCHAR(255) NOT NULL, ADD text_color VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE categorie_event ADD nom VARCHAR(255) DEFAULT NULL, ADD description_categorie_event VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar DROP title, DROP start, DROP end, DROP description, DROP all_day, DROP background_color, DROP border_color, DROP text_color');
        $this->addSql('ALTER TABLE categorie_event DROP nom, DROP description_categorie_event');
    }
}

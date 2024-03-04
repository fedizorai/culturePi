<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303125655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, pub_id INT DEFAULT NULL, contenucom VARCHAR(255) NOT NULL, datecom DATE NOT NULL, name VARCHAR(20) NOT NULL, pubid INT NOT NULL, INDEX IDX_67F068BC83FDE077 (pub_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publication (id INT AUTO_INCREMENT NOT NULL, contenupub VARCHAR(255) NOT NULL, datepub DATE NOT NULL, username VARCHAR(20) NOT NULL, userid INT NOT NULL, likes INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC83FDE077 FOREIGN KEY (pub_id) REFERENCES publication (id)');
        $this->addSql('DROP TABLE pdf_generator_service');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pdf_generator_service (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC83FDE077');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE publication');
    }
}

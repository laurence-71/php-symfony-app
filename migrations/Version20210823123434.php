<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210823123434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bike_article (id INT AUTO_INCREMENT NOT NULL, repair_id INT DEFAULT NULL, main VARCHAR(255) DEFAULT NULL, brake VARCHAR(255) DEFAULT NULL, wheel VARCHAR(255) DEFAULT NULL, transmission VARCHAR(255) DEFAULT NULL, crank VARCHAR(255) DEFAULT NULL, security VARCHAR(255) DEFAULT NULL, comments LONGTEXT DEFAULT NULL, INDEX IDX_B886975B43833CFF (repair_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bike_article ADD CONSTRAINT FK_B886975B43833CFF FOREIGN KEY (repair_id) REFERENCES repair (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE bike_article');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210828064342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transformation (id INT AUTO_INCREMENT NOT NULL, recycling_id INT DEFAULT NULL, article_label VARCHAR(255) DEFAULT NULL, destination VARCHAR(255) DEFAULT NULL, quantity INT DEFAULT NULL, INDEX IDX_F2B21A85D08DEC6C (recycling_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trash (id INT AUTO_INCREMENT NOT NULL, recycling_id INT DEFAULT NULL, nature VARCHAR(255) DEFAULT NULL, weight DOUBLE PRECISION DEFAULT NULL, INDEX IDX_528BB4DD08DEC6C (recycling_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transformation ADD CONSTRAINT FK_F2B21A85D08DEC6C FOREIGN KEY (recycling_id) REFERENCES recycling (id)');
        $this->addSql('ALTER TABLE trash ADD CONSTRAINT FK_528BB4DD08DEC6C FOREIGN KEY (recycling_id) REFERENCES recycling (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE transformation');
        $this->addSql('DROP TABLE trash');
    }
}

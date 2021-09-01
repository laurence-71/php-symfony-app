<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210901132240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bike_stock (id INT AUTO_INCREMENT NOT NULL, deposit_date DATETIME DEFAULT NULL, img VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE operation ADD bike_stock_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D551F9198 FOREIGN KEY (bike_stock_id) REFERENCES bike_stock (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1981A66D551F9198 ON operation (bike_stock_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D551F9198');
        $this->addSql('DROP TABLE bike_stock');
        $this->addSql('DROP INDEX UNIQ_1981A66D551F9198 ON operation');
        $this->addSql('ALTER TABLE operation DROP bike_stock_id');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210821091320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bike (id INT AUTO_INCREMENT NOT NULL, source_id INT NOT NULL, serial_number VARCHAR(255) NOT NULL, brand VARCHAR(255) DEFAULT NULL, category VARCHAR(255) DEFAULT NULL, color VARCHAR(255) DEFAULT NULL, size VARCHAR(5) DEFAULT NULL, weight DOUBLE PRECISION DEFAULT NULL, INDEX IDX_4CBC3780953C1C61 (source_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operation (id INT AUTO_INCREMENT NOT NULL, bike_id INT DEFAULT NULL, reception_date DATETIME DEFAULT NULL, INDEX IDX_1981A66DD5A4816F (bike_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE source (id INT AUTO_INCREMENT NOT NULL, origin VARCHAR(255) NOT NULL, purpose VARCHAR(255) NOT NULL, deposit_date DATETIME DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, address LONGTEXT DEFAULT NULL, rgpd TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bike ADD CONSTRAINT FK_4CBC3780953C1C61 FOREIGN KEY (source_id) REFERENCES source (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DD5A4816F FOREIGN KEY (bike_id) REFERENCES bike (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66DD5A4816F');
        $this->addSql('ALTER TABLE bike DROP FOREIGN KEY FK_4CBC3780953C1C61');
        $this->addSql('DROP TABLE bike');
        $this->addSql('DROP TABLE operation');
        $this->addSql('DROP TABLE source');
    }
}

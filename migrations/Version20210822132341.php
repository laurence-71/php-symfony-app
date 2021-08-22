<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210822132341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE billing (id INT AUTO_INCREMENT NOT NULL, billing_date DATE DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operator (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operator_operation (operator_id INT NOT NULL, operation_id INT NOT NULL, INDEX IDX_DF5959AA584598A3 (operator_id), INDEX IDX_DF5959AA44AC3583 (operation_id), PRIMARY KEY(operator_id, operation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recycling (id INT AUTO_INCREMENT NOT NULL, recycling_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repair (id INT AUTO_INCREMENT NOT NULL, taking_care_date DATETIME NOT NULL, done_date DATETIME DEFAULT NULL, labor_cost DOUBLE PRECISION DEFAULT NULL, article_label VARCHAR(255) DEFAULT NULL, article_state VARCHAR(255) DEFAULT NULL, comments LONGTEXT DEFAULT NULL, validation TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE operator_operation ADD CONSTRAINT FK_DF5959AA584598A3 FOREIGN KEY (operator_id) REFERENCES operator (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE operator_operation ADD CONSTRAINT FK_DF5959AA44AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE operation ADD recycling_id INT DEFAULT NULL, ADD repair_id INT DEFAULT NULL, ADD billing_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DD08DEC6C FOREIGN KEY (recycling_id) REFERENCES recycling (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D43833CFF FOREIGN KEY (repair_id) REFERENCES repair (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D3B025C87 FOREIGN KEY (billing_id) REFERENCES billing (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1981A66DD08DEC6C ON operation (recycling_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1981A66D43833CFF ON operation (repair_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1981A66D3B025C87 ON operation (billing_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D3B025C87');
        $this->addSql('ALTER TABLE operator_operation DROP FOREIGN KEY FK_DF5959AA584598A3');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66DD08DEC6C');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D43833CFF');
        $this->addSql('DROP TABLE billing');
        $this->addSql('DROP TABLE operator');
        $this->addSql('DROP TABLE operator_operation');
        $this->addSql('DROP TABLE recycling');
        $this->addSql('DROP TABLE repair');
        $this->addSql('DROP INDEX UNIQ_1981A66DD08DEC6C ON operation');
        $this->addSql('DROP INDEX UNIQ_1981A66D43833CFF ON operation');
        $this->addSql('DROP INDEX UNIQ_1981A66D3B025C87 ON operation');
        $this->addSql('ALTER TABLE operation DROP recycling_id, DROP repair_id, DROP billing_id');
    }
}

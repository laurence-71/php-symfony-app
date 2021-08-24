<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210824084648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE new_stock (id INT AUTO_INCREMENT NOT NULL, requirement_id INT DEFAULT NULL, label VARCHAR(255) DEFAULT NULL, brand VARCHAR(255) DEFAULT NULL, unit_price DOUBLE PRECISION DEFAULT NULL, quantity INT DEFAULT NULL, INDEX IDX_B3A015BD7B576F77 (requirement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE requirement (id INT AUTO_INCREMENT NOT NULL, requirement_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE second_hand_stock (id INT AUTO_INCREMENT NOT NULL, requirement_id INT DEFAULT NULL, recycling_id INT DEFAULT NULL, label VARCHAR(255) DEFAULT NULL, brand VARCHAR(255) DEFAULT NULL, unit_price DOUBLE PRECISION DEFAULT NULL, quantity INT DEFAULT NULL, INDEX IDX_43A898A67B576F77 (requirement_id), INDEX IDX_43A898A6D08DEC6C (recycling_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE new_stock ADD CONSTRAINT FK_B3A015BD7B576F77 FOREIGN KEY (requirement_id) REFERENCES requirement (id)');
        $this->addSql('ALTER TABLE second_hand_stock ADD CONSTRAINT FK_43A898A67B576F77 FOREIGN KEY (requirement_id) REFERENCES requirement (id)');
        $this->addSql('ALTER TABLE second_hand_stock ADD CONSTRAINT FK_43A898A6D08DEC6C FOREIGN KEY (recycling_id) REFERENCES recycling (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE new_stock DROP FOREIGN KEY FK_B3A015BD7B576F77');
        $this->addSql('ALTER TABLE second_hand_stock DROP FOREIGN KEY FK_43A898A67B576F77');
        $this->addSql('DROP TABLE new_stock');
        $this->addSql('DROP TABLE requirement');
        $this->addSql('DROP TABLE second_hand_stock');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210910083358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operation ADD bikes_stock_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D95571ECC FOREIGN KEY (bikes_stock_id) REFERENCES bikes_stock (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1981A66D95571ECC ON operation (bikes_stock_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D95571ECC');
        $this->addSql('DROP INDEX UNIQ_1981A66D95571ECC ON operation');
        $this->addSql('ALTER TABLE operation DROP bikes_stock_id');
    }
}

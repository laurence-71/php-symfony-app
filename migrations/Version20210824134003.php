<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210824134003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE repair ADD requirement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE repair ADD CONSTRAINT FK_8EE434217B576F77 FOREIGN KEY (requirement_id) REFERENCES requirement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8EE434217B576F77 ON repair (requirement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE repair DROP FOREIGN KEY FK_8EE434217B576F77');
        $this->addSql('DROP INDEX UNIQ_8EE434217B576F77 ON repair');
        $this->addSql('ALTER TABLE repair DROP requirement_id');
    }
}

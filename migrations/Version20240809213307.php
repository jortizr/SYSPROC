<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240809213307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee ADD id_state_id INT NOT NULL');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A15503D054 FOREIGN KEY (id_state_id) REFERENCES state (id)');
        $this->addSql('CREATE INDEX IDX_5D9F75A15503D054 ON employee (id_state_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A15503D054');
        $this->addSql('DROP INDEX IDX_5D9F75A15503D054 ON employee');
        $this->addSql('ALTER TABLE employee DROP id_state_id');
    }
}

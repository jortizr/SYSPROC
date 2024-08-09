<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240809210444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nomina ADD id_employee_id INT NOT NULL');
        $this->addSql('ALTER TABLE nomina ADD CONSTRAINT FK_D7DFE78394113CAB FOREIGN KEY (id_employee_id) REFERENCES employee (id)');
        $this->addSql('CREATE INDEX IDX_D7DFE78394113CAB ON nomina (id_employee_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nomina DROP FOREIGN KEY FK_D7DFE78394113CAB');
        $this->addSql('DROP INDEX IDX_D7DFE78394113CAB ON nomina');
        $this->addSql('ALTER TABLE nomina DROP id_employee_id');
    }
}

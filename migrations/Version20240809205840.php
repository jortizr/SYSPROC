<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240809205840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nomina ADD type_hour_id INT NOT NULL');
        $this->addSql('ALTER TABLE nomina ADD CONSTRAINT FK_D7DFE7839DB2140C FOREIGN KEY (type_hour_id) REFERENCES type_hour (id)');
        $this->addSql('CREATE INDEX IDX_D7DFE7839DB2140C ON nomina (type_hour_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nomina DROP FOREIGN KEY FK_D7DFE7839DB2140C');
        $this->addSql('DROP INDEX IDX_D7DFE7839DB2140C ON nomina');
        $this->addSql('ALTER TABLE nomina DROP type_hour_id');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240809221952 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee ADD cod_job_title_id INT NOT NULL, ADD id_schedule_id INT NOT NULL');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A14702F281 FOREIGN KEY (cod_job_title_id) REFERENCES job_title (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1BC190F22 FOREIGN KEY (id_schedule_id) REFERENCES schedule (id)');
        $this->addSql('CREATE INDEX IDX_5D9F75A14702F281 ON employee (cod_job_title_id)');
        $this->addSql('CREATE INDEX IDX_5D9F75A1BC190F22 ON employee (id_schedule_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A14702F281');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1BC190F22');
        $this->addSql('DROP INDEX IDX_5D9F75A14702F281 ON employee');
        $this->addSql('DROP INDEX IDX_5D9F75A1BC190F22 ON employee');
        $this->addSql('ALTER TABLE employee DROP cod_job_title_id, DROP id_schedule_id');
    }
}
